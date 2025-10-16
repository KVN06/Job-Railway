@extends('layouts.home')

@section('content')
    <form action="{{ route('update-portfolio', $portfolio->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <main class="min-h-screen bg-white text-gray-900 py-12 px-4">
            <div class="max-w-3xl mx-auto">
                <header class="text-center mb-8">
                    <h1 class="text-3xl font-extrabold text-gray-900">Editar Portafolio</h1>
                    <p class="text-gray-600 mt-2">Actualiza los datos de tu portafolio.</p>
                </header>

                <section class="bg-white rounded-2xl shadow p-8 border border-gray-100">
                    <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-transparent shadow-md">
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Título del Portafolio</label>
                                <input type="text" id="title" name="title" required
                                       value="{{ old('title', $portfolio->title) }}"
                                       class="mt-2 block w-full rounded-xl bg-white/40 ring-1 ring-gray-200 text-gray-900 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition">
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                                <textarea id="description" name="description" rows="5" required
                                          class="mt-2 block w-full rounded-xl bg-white/40 ring-1 ring-gray-200 text-gray-900 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition">{{ old('description', $portfolio->description) }}</textarea>
                            </div>

                            <div>
                                <label for="url_proyect" class="block text-sm font-medium text-gray-700">URL del Portafolio</label>
                                <input type="text" id="url_proyect" name="url_proyect"
                                       value="{{ old('url_proyect', $portfolio->url_proyect) }}"
                                       class="mt-2 block w-full rounded-xl bg-white/40 ring-1 ring-gray-200 text-gray-900 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition">
                            </div>

                            <div>
                                <label for="cover_image" class="block text-sm font-medium text-gray-700">Imagen de Portada (opcional)</label>
                                <input type="file" id="cover_image" name="cover_image" accept="image/*" class="mt-2 block w-full text-sm text-gray-700" />
                                @if(isset($portfolio->cover_image) && $portfolio->cover_image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/portfolios/' . $portfolio->cover_image) }}" alt="cover" class="w-48 h-28 object-cover rounded-md shadow-sm">
                                    </div>
                                @endif
                            </div>

                            <div class="mt-4">
                                <label for="url_pdf" class="block text-sm font-medium text-gray-700">Archivo PDF (opcional)</label>
                                <input type="file" id="url_pdf" name="url_pdf" accept="application/pdf" class="mt-2 block w-full text-sm text-gray-700" />
                                @if(isset($portfolio->url_pdf) && $portfolio->url_pdf)
                                    <div class="text-sm text-gray-700 mt-2">
                                        PDF actual:
                                        <a href="{{ asset('storage/portfolios/' . $portfolio->url_pdf) }}" target="_blank" class="text-yellow-600 hover:underline ml-2">
                                            Ver PDF
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <button type="submit" class="w-full inline-flex justify-center items-center gap-2 bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 font-semibold px-6 py-3 rounded-2xl shadow-lg hover:brightness-95 transition">
                                    Actualizar Portafolio
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </form>

    <script>
        // Limpia espacios al enviar (solo UI helper)
        (function(){
            const form = document.querySelector('form[action*="update-portfolio"]');
            if (!form) return;
            form.addEventListener('submit', function(){
                const els = form.querySelectorAll('input[type="text"], textarea');
                els.forEach(el => el.value = el.value.trim());
            });
        })();
    </script>
@endsection
