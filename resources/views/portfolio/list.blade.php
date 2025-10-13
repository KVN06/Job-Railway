@extends('layouts.home')

@section('content')
<div class="min-h-screen bg-blue-50 text-gray-900">

    <header class="relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="w-full h-80 sm:h-96 md:h-[34rem] bg-cover bg-center" style="background-image: url('{{ asset('images/hero.jpg') }}');"></div>
            <div class="absolute inset-0 bg-blue-200/30 backdrop-blur-sm"></div>
        </div>

        <div class="relative max-w-6xl mx-auto px-4 py-16 sm:py-24">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div class="space-y-6">
                    <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight">
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-400">Capturando Momentos,</span>
                        <span class="block text-gray-900">Creando Historias</span>
                    </h1>
                    <p class="text-black-700 max-w-lg">
                        Portafolios cuidadosamente presentados para mostrar tu trabajo — proyectos, PDFs y enlaces en un estilo profesional y elegante.
                    </p>

                    <div class="flex flex-wrap gap-3 mt-4">
                        <a href="{{ route('portfolio-form') }}"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-full text-white shadow-lg transform hover:-translate-y-0.5 bg-gradient-to-r from-blue-500 to-blue-600">
                            <i class="fas fa-plus"></i> Agregar Portafolio
                        </a>
                        <a id="btn-view-work" href="#mis-portafolios"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-full border border-blue-300 bg-white/40 backdrop-blur-sm text-blue-800 hover:bg-blue-100 transition">
                            Ver Mi Trabajo
                        </a>
                    </div>
                </div>

                <div class="hidden md:flex justify-end">
                    <div class="w-72 h-44 rounded-2xl overflow-hidden shadow-lg transform hover:scale-105 transition">
                        <img src="{{ asset('images/hero.jpg') }}" alt="destacado" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>

        <div class="h-12 md:h-20"></div>
    </header>

    <main class="px-4 pb-12">
        <div id="mis-portafolios" class="max-w-6xl mx-auto -mt-20">
            <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 border border-blue-100">
                <div class="bg-white/60 backdrop-blur-sm rounded-3xl p-6 md:p-8 border border-transparent shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-blue-900">Mis Portafolios</h2>
                            <p class="text-black-700 mt-1">Muestra tus proyectos y logros profesionales</p>
                        </div>
                        <div>
                            <a href="{{ route('portfolio-form') }}"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-400 to-blue-600 text-white px-4 py-2 rounded-lg shadow hover:scale-105 transition">
                                <i class="fas fa-plus"></i> Nuevo
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($portfolios as $portfolio)
                        <article
                            class="group bg-blue-50/70 backdrop-blur-sm rounded-2xl overflow-hidden shadow-lg transform hover:-translate-y-2 hover:shadow-2xl transition duration-200">
                            <div class="h-40 bg-cover bg-center"
                                style="background-image: url('{{ isset($portfolio->cover_image) ? asset('storage/'.$portfolio->cover_image) : asset('images/placeholder.jpg') }}');">
                                <div
                                    class="w-full h-full bg-gradient-to-t from-blue-900/30 to-transparent flex items-end p-4">
                                    <span class="bg-blue-100 text-blue-900 px-3 py-1 rounded-full text-sm font-semibold">{{ $portfolio->title }}</span>
                                </div>
                            </div>

                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-blue-900 mb-1">{{ $portfolio->title }}</h3>
                                <p class="text-gray-700 text-sm mb-3 line-clamp-3">{{ $portfolio->description }}</p>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        @if($portfolio->url_proyect)
                                        
                                        <a href="{{ $portfolio->url_proyect }}" target="_blank"
                                            class="text-blue-600 hover:text-blue-700 inline-flex items-center gap-2 text-sm">
                                            <i class="fas fa-globe"></i> Ver
                                        </a>
                                        @endif

                                        @if($portfolio->url_pdf)
                                        <a href="{{ asset('storage/'.$portfolio->url_pdf) }}" target="_blank"
                                            class="text-blue-500 hover:text-blue-700 inline-flex items-center gap-2 text-sm">
                                            <i class="fas fa-file-pdf"></i> PDF
                                        </a>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('edit-portfolio', $portfolio->id) }}"
                                            class="px-3 py-1 bg-blue-50 rounded-md text-sm hover:bg-blue-100 border border-blue-100">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('delete-portfolio', $portfolio->id) }}" method="POST"
                                            onsubmit="return confirm('¿Estás seguro de eliminar este portafolio?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 bg-red-100 rounded-md text-sm hover:bg-red-200 border border-red-100">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="mt-3 text-xs text-gray-500">
                                    {{ $portfolio->created_at ? $portfolio->created_at->format('d M, Y') : '' }}
                                </div>
                            </div>
                        </article>
                        @empty
                        <div class="col-span-full rounded-2xl p-12 bg-blue-50 text-center border border-blue-100">
                            <div
                                class="w-24 h-24 bg-blue-100 rounded-full mx-auto flex items-center justify-center mb-4">
                                <i class="fas fa-briefcase text-2xl text-blue-600"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-blue-900">No tienes portafolios aún</h3>
                            <p class="text-blue-700 mt-2">Comienza a mostrar tus proyectos y logros profesionales.</p>
                            <a href="{{ route('portfolio-form') }}"
                                class="mt-6 inline-flex items-center gap-2 bg-gradient-to-r from-blue-400 to-blue-600 text-white px-6 py-3 rounded-xl">
                                <i class="fas fa-plus"></i> Crear Primer Portafolio
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
