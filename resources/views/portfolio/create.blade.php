@extends('layouts.home')

@section('content')
<form action="{{ route('agg-portfolio') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <main class="min-h-screen bg-blue-50 text-gray-900 py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <header class="mb-8 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-blue-900">Agregar Portafolio</h1>
                <p class="text-black-700 mt-2">Muestra tu trabajo con estilo — agrega imágenes, enlace y un PDF opcional.</p>
            </header>

            <section class="bg-white shadow-lg rounded-2xl p-8 border border-blue-100">
                <div class="space-y-6">
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-blue-100 shadow-md">
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-black-900">Título del Portafolio</label>
                                <input type="text" id="title" name="title" required
                                    class="mt-2 block w-full rounded-xl bg-blue-50 ring-1 ring-blue-200 text-gray-900 px-4 py-2 focus:ring-2 focus:ring-blue-400 transition"
                                    value="{{ old('title') }}">
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-black-900">Descripción</label>
                                <textarea id="description" name="description" required rows="5"
                                    class="mt-2 block w-full rounded-xl bg-blue-50 ring-1 ring-blue-200 text-gray-900 px-4 py-2 focus:ring-2 focus:ring-blue-400 transition">{{ old('description') }}</textarea>
                            </div>

                            <div>
                                <label for="url_proyect" class="block text-sm font-medium text-black-900">URL del Proyecto</label>
                                <input type="url" id="url_proyect" name="url_proyect"
                                    class="mt-2 block w-full rounded-xl bg-blue-50 ring-1 ring-blue-200 text-gray-900 px-4 py-2 focus:ring-2 focus:ring-blue-400 transition"
                                    value="{{ old('url_proyect') }}">
                            </div>

                            <div>
                                <label for="cover_image" class="block text-sm font-medium text-b-900">Imagen de Portada (opcional)</label>
                                <input type="file" id="cover_image" name="cover_image" accept="image/*"
                                    class="mt-2 block w-full text-sm text-blue-800" />
                            </div>

                            <div>
                                <label for="url_pdf" class="block text-sm font-medium text-black-900">Archivo PDF (opcional)</label>
                                <div class="mt-2 flex items-center space-x-3">
                                    <label for="url_pdf"
                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-400 to-blue-600 text-white rounded-lg cursor-pointer shadow-sm hover:brightness-110 transition">
                                        <i class="fas fa-upload mr-2"></i> Seleccionar PDF
                                    </label>
                                    <span id="pdf-name" class="text-sm text-black-700">Ningún archivo seleccionado</span>
                                </div>
                                <input type="file" id="url_pdf" name="url_pdf" accept="application/pdf" class="hidden">
                            </div>

                            <div>
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center gap-2 bg-gradient-to-r from-blue-400 to-blue-600 text-white font-semibold px-6 py-3 rounded-2xl shadow-lg hover:scale-[1.02] transition">
                                    Agregar Portafolio
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</form>

<script>
    (function(){
        const input = document.getElementById('url_pdf');
        const name = document.getElementById('pdf-name');
        if (!input) return;
        input.addEventListener('change', function(){
            const file = this.files && this.files[0];
            name.textContent = file ? file.name : 'Ningún archivo seleccionado';
        });
    })();
</script>
@endsection
