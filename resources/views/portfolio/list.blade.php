@extends('layouts.home')

@section('title', 'Job Opportunity — Portafolios y Oportunidades en Popayán')
@section('meta_description', 'Job Opportunity: plataforma de portafolios para conectar talento local en Popayán con empleos, trabajos por horas, verificación y sistema de calificaciones.')

@section('content')
@php /* ya no usamos Storage para construir URLs públicas estáticas */ @endphp

{{-- ====================================================
   VISTA: list.blade.php
   Propósito: Listado de Portafolios para "Job Opportunity"
   ==================================================== --}}

<div class="min-h-screen text-gray-900">

    {{-- HERO / PRESENTACIÓN --}}
    <header class="relative overflow-hidden" aria-label="Hero Job Opportunity - Portafolios Popayán">
        <div class="absolute inset-0">
            <div class="w-full h-80 sm:h-96 md:h-[34rem] bg-cover bg-center"
                 style="background-image: url('{{ asset('images/hero-job-opportunity.jpg') }}');"
                 role="img" aria-hidden="true"></div>
        </div>

        <div class="relative max-w-6xl mx-auto px-4 py-16 sm:py-24">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div class="space-y-6">
                    <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight">
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-400">
                            Job Opportunity — Portafolios
                        </span>
                        <span class="block text-gray-900">Conectando talento de Popayán con oportunidades</span>
                    </h1>

                    <p class="text-black-700 max-w-lg">
                        Muestra tus <strong>proyectos</strong>, <strong>portafolios</strong>, <strong>PDFs</strong> y <strong>habilidades</strong>.
                        Job Opportunity ayuda a que empresas vean tu <strong>perfil</strong> verificado y tus <strong>calificaciones</strong>.
                    </p>

                    <div class="flex flex-wrap gap-3 mt-4">
                        <a href="{{ route('portfolio-form') }}"
                           class="inline-flex items-center gap-2 px-5 py-3 rounded-full text-white shadow-lg transform hover:-translate-y-0.5 bg-gradient-to-r from-blue-500 to-blue-600"
                           aria-label="Agregar portafolio Job Opportunity">
                            <i class="fas fa-plus" aria-hidden="true"></i> Agregar Portafolio
                        </a>

                        <a id="btn-view-work" href="#mis-portafolios"
                           class="inline-flex items-center gap-2 px-5 py-3 rounded-full border border-blue-300 bg-white/40 backdrop-blur-sm text-blue-800 hover:bg-blue-100 transition"
                           aria-label="Ver portafolios">
                            Ver Mis Portafolios
                        </a>
                    </div>
                </div>

                <div class="hidden md:flex justify-end">
                    <div class="w-72 h-44 rounded-2xl overflow-hidden shadow-lg transform hover:scale-105 transition">
                        <img src="https://media.sproutsocial.com/uploads/2022/06/profile-picture.jpeg" alt="Perfil destacado Job Opportunity" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>

        <div class="h-12 md:h-20"></div>
    </header>

    {{-- MAIN: listados de portafolios --}}
    <main class="px-4 pb-12" role="main">
        <div id="mis-portafolios" class="max-w-6xl mx-auto -mt-20">
            <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 border border-blue-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-blue-900">Mis Portafolios</h2>
                        <p class="text-black-700 mt-1">Presenta tus proyectos, demuestra tus habilidades y sube PDFs para que empresas en Popayán te encuentren.</p>
                    </div>

                    <div>
                        <a href="{{ route('portfolio-form') }}"
                           class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-400 to-blue-600 text-white px-4 py-2 rounded-lg shadow hover:scale-105 transition"
                           aria-label="Nuevo portafolio">
                            <i class="fas fa-plus" aria-hidden="true"></i> Nuevo
                        </a>
                    </div>
                </div>

                {{-- GRID de tarjetas --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" aria-live="polite">
                    @forelse($portfolios as $portfolio)
                        @php
                            // Busca imagen en public/images/portfolios/
                            $coverPath = public_path('images/portfolios/' . ($portfolio->cover_image ?? ''));
                            $hasCover = $portfolio->cover_image && file_exists($coverPath);
                            $coverUrl = $hasCover ? asset('images/portfolios/' . $portfolio->cover_image) : asset('images/placeholder-portfolio.jpg');

                            // Busca PDF en public/files/portfolios/
                            $pdfPath = public_path('files/portfolios/' . ($portfolio->url_pdf ?? ''));
                            $hasPdf = $portfolio->url_pdf && file_exists($pdfPath);
                            $pdfUrl = $hasPdf ? asset('files/portfolios/' . $portfolio->url_pdf) : null;
                        @endphp

                        <article class="group bg-blue-50/70 backdrop-blur-sm rounded-2xl overflow-hidden shadow-lg transform hover:-translate-y-2 hover:shadow-2xl transition duration-200"
                                 aria-labelledby="portfolio-title-{{ $portfolio->id }}">
                            <div class="h-40 bg-cover bg-center" style="background-image: url('{{ $coverUrl }}');" role="img" aria-label="Portada del proyecto {{ $portfolio->title }}"></div>

                            <div class="p-4">
                                <h3 id="portfolio-title-{{ $portfolio->id }}" class="text-lg font-semibold text-blue-900 mb-1">{{ $portfolio->title }}</h3>
                                <p class="text-gray-700 text-sm mb-3 line-clamp-3">{{ $portfolio->description }}</p>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        @if($portfolio->url_proyect)
                                            <a href="{{ $portfolio->url_proyect }}" target="_blank" rel="noopener noreferrer"
                                               class="text-blue-600 hover:text-blue-700 inline-flex items-center gap-2 text-sm"
                                               aria-label="Ver proyecto {{ $portfolio->title }}">
                                                <i class="fas fa-globe" aria-hidden="true"></i> Ver Proyecto
                                            </a>
                                        @endif

                                        @if($pdfUrl)
                                            <a href="{{ $pdfUrl }}" target="_blank" rel="noopener noreferrer"
                                               class="text-blue-600 hover:text-blue-700 inline-flex items-center gap-2 text-sm font-medium"
                                               aria-label="Descargar PDF del portafolio {{ $portfolio->title }}">
                                                <i class="fas fa-file-pdf" aria-hidden="true"></i> Descargar PDF
                                            </a>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('edit-portfolio', $portfolio->id) }}"
                                           class="px-3 py-1 bg-blue-50 rounded-md text-sm hover:bg-blue-100 border border-blue-100"
                                           aria-label="Editar portafolio {{ $portfolio->title }}">
                                            <i class="fas fa-edit" aria-hidden="true"></i>
                                        </a>

                                        <form action="{{ route('delete-portfolio', $portfolio->id) }}" method="POST"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este portafolio?')"
                                              class="inline" aria-label="Eliminar portafolio {{ $portfolio->title }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1 bg-red-100 rounded-md text-sm hover:bg-red-200 border border-red-100">
                                                <i class="fas fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="mt-3 text-xs text-gray-500 flex items-center justify-between">
                                    <div>
                                        {{ $portfolio->created_at ? $portfolio->created_at->format('d M, Y') : '' }}
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if(isset($portfolio->rating))
                                            <span class="text-yellow-500" aria-label="Calificación {{ $portfolio->rating }}">
                                                <i class="fas fa-star" aria-hidden="true"></i> {{ number_format($portfolio->rating, 1) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full rounded-2xl p-12 bg-blue-50 text-center border border-blue-100">
                            <div class="w-24 h-24 bg-blue-100 rounded-full mx-auto flex items-center justify-center mb-4">
                                <i class="fas fa-briefcase text-2xl text-blue-600" aria-hidden="true"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-blue-900">No tienes portafolios aún</h3>
                            <p class="text-blue-700 mt-2">Crea tu portafolio para mostrar tus proyectos, habilidades y archivos PDF. Aumenta tu visibilidad ante empresas en Popayán.</p>
                            <a href="{{ route('portfolio-form') }}"
                               class="mt-6 inline-flex items-center gap-2 bg-gradient-to-r from-blue-400 to-blue-600 text-white px-6 py-3 rounded-xl"
                               aria-label="Crear primer portafolio">
                                <i class="fas fa-plus" aria-hidden="true"></i> Crear Primer Portafolio
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
