<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->ensureUserColumnExists();

            return $next($request);
        });
    }

    // Muestra todas las capacitaciones
    public function index()
    {
        $trainings = Training::with('user')->get();
        return view('training.index', compact('trainings'));
    }

    // Muestra el formulario de creación
    public function create()
    {
        abort_unless(Auth::check(), 403);

        return view('training.create');
    }

    // Guarda una nueva capacitación
    public function store(Request $request)
    {
        abort_unless(Auth::check(), 403);

        // Validación de los datos del formulario
        $request->validate([
            'title' => 'required|string|max:255',
            'provider' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Crea una nueva capacitación
        Training::create(array_merge(
            $request->only(['title', 'provider', 'description', 'link', 'start_date', 'end_date']),
            ['user_id' => Auth::id()]
        ));

        // Redirige con un mensaje de éxito
        return redirect()->route('training.index')->with('success', 'Capacitación registrada correctamente.');
    }

    // Muestra el formulario de edición para una capacitación específica
    public function edit($id)
    {
        $training = Training::findOrFail($id);
        $this->authorizeTraining($training);
        return view('training.edit', compact('training'));
    }

    // Actualiza una capacitación
    public function update(Request $request, $id)
    {
        $training = Training::findOrFail($id);
        $this->authorizeTraining($training);

        // Validación de los datos del formulario
        $request->validate([
            'title' => 'required|string|max:255',
            'provider' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Actualiza la capacitación
        $training->update($request->only(['title', 'provider', 'description', 'link', 'start_date', 'end_date']));

        // Redirige con un mensaje de éxito
        return redirect()->route('training.index')->with('success', 'Capacitación actualizada correctamente.');
    }

    // Elimina una capacitación
    public function destroy($id)
    {
        $training = Training::findOrFail($id);
        $this->authorizeTraining($training);
        $training->delete();

        // Redirige con un mensaje de éxito
        return redirect()->route('training.index')->with('success', 'Capacitación eliminada correctamente.');
    }
    protected function authorizeTraining(Training $training): void
    {
        abort_unless(Auth::check() && Auth::id() === $training->user_id, 403, 'No tienes permisos para modificar esta capacitación.');
    }

    protected function ensureUserColumnExists(): void
    {
        if (Schema::hasColumn('trainings', 'user_id')) {
            return;
        }

        Schema::table('trainings', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });
    }
}
