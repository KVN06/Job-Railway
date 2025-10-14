@extends('layouts.home')
@php
    use Carbon\Carbon;
@endphp

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header mejorado -->
    <div class="mb-8 animate-fade-in-up">
        <div class="bg-white rounded-2xl shadow-soft p-8 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-graduation-cap text-blue-800 mr-3"></i>
                        Capacitaciones
                    </h1>
                    <p class="text-gray-600">Explora oportunidades de formación y desarrollo profesional</p>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-xl mb-6 shadow-soft animate-slide-in">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- LISTADO DE CAPACITACIONES -->
    <section class="space-y-6" id="training-insights">
        <div class="grid grid-cols-1 gap-6 animate-slide-in">
            @forelse($trainings as $item)
                @php
                    $startDate = $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') : null;
                    $endDate = $item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') : null;
                    $isUpcoming = $item->start_date ? \Carbon\Carbon::parse($item->start_date)->isFuture() : false;
                    $isFinished = $item->end_date ? \Carbon\Carbon::parse($item->end_date)->isPast() : false;
                @endphp

                <x-card variant="enhanced" hover class="overflow-hidden">
                    <div class="flex flex-col md:flex-row">
                        <div class="flex-1 p-6 space-y-5">
                            <div class="flex items-start justify-between gap-4">
                                <div class="space-y-3">
                                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold">
                                        <i class="fas fa-building"></i>
                                        {{ $item->provider ?? 'Proveedor no especificado' }}
                                    </div>
                                    <h2 class="text-2xl font-bold text-gray-900">
                                        {{ $item->title }}
                                    </h2>
                                </div>

                                <x-badge
                                    :variant="$isFinished ? 'secondary' : ($isUpcoming ? 'warning' : 'success')"
                                    size="sm"
                                    icon="fas fa-graduation-cap"
                                >
                                    {{ $isFinished ? 'Finalizada' : ($isUpcoming ? 'Próxima' : 'En curso') }}
                                </x-badge>
                            </div>
                        </div>

                        <!-- Descripción -->
                        @if($item->description)
                            <div class="mb-4">
                                <p class="text-gray-700">{{ Str::limit($item->description, 150) }}</p>
                            </div>
                        @endif

                        <div class="flex flex-wrap items-center gap-4 mb-4 text-sm text-gray-600">
                                @if($item->start_date)
                                <div class="flex items-center">
                                    <i class="fas fa-play-circle text-green-600 mr-1"></i>
                                    <span>Inicio: {{ $startDate }}</span>
                                </div>
                            @endif
                            @if($item->end_date)
                                <div class="flex items-center">
                                    <i class="fas fa-stop-circle text-red-600 mr-1"></i>
                                    <span>Fin: {{ $endDate }}</span>
                                </div>
                            @endif
                            <div class="flex items-center">
                                <i class="fas fa-clock text-gray-600 mr-1"></i>
                                <span>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="md:w-72 bg-gradient-to-br from-gray-50 to-blue-50 p-6 border-t md:border-t-0 md:border-l border-gray-100 flex flex-col justify-between gap-6">
                            <div class="space-y-4">
                                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Estado</p>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ $isFinished ? 'Finalizada' : ($isUpcoming ? 'Inicia pronto' : 'Activa ahora') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                        <i class="fas fa-lightbulb"></i>
                                        Ideal para {{ $isUpcoming ? 'planificar participación' : 'repasar contenidos' }}
                                    </p>
                                </div>

                    <div class="text-right flex flex-col items-end">
                        <!-- Solo el botón Ver que redirige al enlace -->
                        @if($item->link)
                            <div class="flex space-x-2 mb-3">
                                <a href="{{ $item->link }}"
                                   target="_blank"
                                  class="btn-primary text-white px-6 py-2 rounded-xl hover-lift transition-all duration-300 text-sm font-medium shadow-soft">
                                    <i class="fas fa-external-link-alt mr-1"></i>
                                    Ver Capacitación
                                </a>
                            </div>
                        @else
                            <span class="text-gray-500 text-sm">Sin enlace disponible</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="card-enhanced p-12 text-center animate-fade-in-up">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-graduation-cap text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">No hay capacitaciones disponibles</h3>
                <p class="text-gray-600">Actualmente no hay capacitaciones publicadas.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
