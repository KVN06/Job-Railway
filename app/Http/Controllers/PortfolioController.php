<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PortfolioController extends Controller
{
    public function __construct()
    {
        // Asegurar que solo usuarios autenticados accedan a estas rutas
        $this->middleware('auth');
    }

    // Mostrar formulario para crear un nuevo portafolio
    public function create()
    {
        return view('portfolio.create');
    }

    // Guardar un nuevo portafolio en la base de datos
    public function store(Request $request)
    {
        // ✅ Validación de campos (incluye cover_image)
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url_proyect' => 'required|url',
            'url_pdf' => 'nullable|file|mimes:pdf|max:2048',
            'cover_image' => 'nullable|image|max:4096', // <= 4MB
        ]);

        // ✅ Verificar usuario autenticado
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // ✅ Verificar que tenga perfil desempleado
        if (!$user->unemployed) {
            return redirect()
                ->route('unemployed-form')
                ->with('error', 'Por favor completa tu perfil de desempleado antes de agregar un portafolio.');
        }

        // ✅ Crear nuevo portafolio
        $portfolio = new Portfolio();
        $portfolio->unemployed_id = $user->unemployed->id;
        $portfolio->title = $request->title;
        $portfolio->description = $request->description;
        $portfolio->url_proyect = $request->url_proyect;

        // ✅ Guardar PDF (si se subió)
        if ($request->hasFile('url_pdf') && $request->file('url_pdf')->isValid()) {
            $file = $request->file('url_pdf');
            $nombreArchivo = 'pdf_' . time() . '.' . $file->guessExtension();
            $file->storeAs('public/portfolios', $nombreArchivo);
            $portfolio->url_pdf = $nombreArchivo;
        }

        // ✅ Guardar imagen de portada (si se subió)
        if ($request->hasFile('cover_image')) {
            $img = $request->file('cover_image');
            if (!$img->isValid()) {
                Log::error('Error al subir la imagen: ' . $img->getError());
                return back()->with('error', 'Error al subir la imagen. Intenta con otra.');
            }
            $nombreImg = 'cover_' . time() . '.' . $img->guessExtension();
            $img->storeAs('public/portfolios', $nombreImg);
            $portfolio->cover_image = $nombreImg;
        }

        $portfolio->save();

        // ✅ Si la petición viene por AJAX, devolver JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'portfolio' => $portfolio,
                'message' => 'Portafolio creado exitosamente',
                'cover_image_url' => $portfolio->cover_image
                    ? Storage::url('portfolios/' . $portfolio->cover_image)
                    : asset('images/placeholder.jpg'),
                'pdf_url' => $portfolio->url_pdf
                    ? Storage::url('portfolios/' . $portfolio->url_pdf)
                    : null,
            ]);
        }

        return redirect()->route('portfolios.index')->with('success', 'Portafolio creado exitosamente.');
    }

    // Mostrar todos los portafolios del usuario desempleado actual
    public function list()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->unemployed) {
            return redirect()
                ->route('unemployed-form')
                ->with('error', 'Por favor completa tu perfil de desempleado para ver tus portafolios.');
        }

        $portfolios = Portfolio::where('unemployed_id', $user->unemployed->id)->get();
        return view('portfolio.list', compact('portfolios'));
    }

    // Mostrar formulario para editar un portafolio existente
    public function edit($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return view('portfolio.edit', compact('portfolio'));
    }

    // Actualizar los datos de un portafolio existente
    public function update(Request $request, $id)
    {
        // ✅ Validar campos requeridos
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url_proyect' => 'required|url',
            'url_pdf' => 'nullable|file|mimes:pdf|max:2048',
            'cover_image' => 'nullable|image|max:4096',
        ]);

        $portfolio = Portfolio::findOrFail($id);

        $portfolio->title = $request->title;
        $portfolio->description = $request->description;
        $portfolio->url_proyect = $request->url_proyect;

        // ✅ Si suben un nuevo PDF, eliminar el anterior y guardar el nuevo
        if ($request->hasFile('url_pdf')) {
            if ($portfolio->url_pdf && Storage::exists('public/portfolios/' . $portfolio->url_pdf)) {
                Storage::delete('public/portfolios/' . $portfolio->url_pdf);
            }
            $file = $request->file('url_pdf');
            $nombreArchivo = 'pdf_' . time() . '.' . $file->guessExtension();
            $file->storeAs('public/portfolios', $nombreArchivo);
            $portfolio->url_pdf = $nombreArchivo;
        }

        // ✅ Si suben una nueva imagen de portada, eliminar la anterior
        if ($request->hasFile('cover_image')) {
            if ($portfolio->cover_image && Storage::exists('public/portfolios/' . $portfolio->cover_image)) {
                Storage::delete('public/portfolios/' . $portfolio->cover_image);
            }

            $img = $request->file('cover_image');
            if (!$img->isValid()) {
                Log::error('Error al actualizar la imagen: ' . $img->getError());
                return back()->with('error', 'Error al actualizar la imagen.');
            }
            $nombreImg = 'cover_' . time() . '.' . $img->guessExtension();
            $img->storeAs('public/portfolios', $nombreImg);
            $portfolio->cover_image = $nombreImg;
        }

        $portfolio->save();

        return redirect()->route('portfolios.index')->with('success', 'Portafolio actualizado correctamente.');
    }

    // Eliminar un portafolio
    public function destroy($id)
    {
        $portfolio = Portfolio::findOrFail($id);

        // ✅ Eliminar archivos asociados
        if ($portfolio->cover_image && Storage::exists('public/portfolios/' . $portfolio->cover_image)) {
            Storage::delete('public/portfolios/' . $portfolio->cover_image);
        }

        if ($portfolio->url_pdf && Storage::exists('public/portfolios/' . $portfolio->url_pdf)) {
            Storage::delete('public/portfolios/' . $portfolio->url_pdf);
        }

        $portfolio->delete();

        return redirect()->route('portfolios.index')->with('success', 'Portafolio eliminado correctamente.');
    }
}
