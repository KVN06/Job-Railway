@extends('layouts.home')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header mejorado con animaciones -->
    <div class="mb-8 animate-fade-in-up">
        <div class="bg-white rounded-xl shadow-soft p-8 mb-6 border border-gray-200">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-center md:text-left">
                    <h1 class="text-3xl md:text-4xl font-bold mb-3">
                        <span class="bg-gradient-to-r from-blue-800 to-gray-700 bg-clip-text text-transparent">
                            <i class="fas fa-graduation-cap mr-3"></i>
                            Capacitaciones
                        </span>
                    </h1>
                    <p class="text-gray-600 text-lg">Explora oportunidades de formación y desarrollo profesional</p>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-xl mb-6 shadow-soft animate-slide-in">
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

                <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 hover-lift">
                    <div class="flex flex-col md:flex-row">
                        <!-- Contenido principal -->
                        <div class="flex-1 p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h2 class="text-2xl font-bold text-gray-900 mb-3 group">
                                        <span class="group inline-flex items-center">
                                            {{ $item->title }}
                                            @if($item->link)
                                                <i class="fas fa-external-link-alt ml-2 text-blue-700 opacity-0 group-hover:opacity-100 transition-all duration-200 transform translate-x-0 group-hover:translate-x-1"></i>
                                            @endif
                                        </span>
                                    </h2>

                                    <div class="flex items-center mb-4 group cursor-pointer">
                                        <div class="w-14 h-14 gradient-primary rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas fa-building text-white text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-gray-800 font-semibold text-lg">{{ $item->provider ?? 'Proveedor no especificado' }}</p>
                                            <p class="text-sm text-gray-500 flex items-center">
                                                <i class="fas fa-graduation-cap text-blue-600 mr-1"></i>
                                                Programa de capacitación
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="ml-4">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-blue-600 text-white">
                                        <i class="fas fa-graduation-cap mr-2"></i>
                                        {{ $isFinished ? 'Finalizada' : ($isUpcoming ? 'Próxima' : 'En curso') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Descripción -->
                            @if($item->description)
                                <div class="mb-4">
                                    <p class="text-gray-700 leading-relaxed">{{ \Illuminate\Support\Str::limit($item->description, 200) }}</p>
                                </div>
                            @endif

                            <div class="flex flex-wrap items-center gap-4 mb-4">
                                @if($item->start_date)
                                    <div class="flex items-center text-gray-700 bg-blue-50 px-3 py-2 rounded-lg">
                                        <i class="fas fa-play-circle text-blue-600 mr-2"></i>
                                        <span class="font-medium">Inicio: {{ $startDate }}</span>
                                    </div>
                                @endif
                                @if($item->end_date)
                                    <div class="flex items-center text-gray-700 bg-blue-50 px-3 py-2 rounded-lg">
                                        <i class="fas fa-stop-circle text-blue-600 mr-2"></i>
                                        <span class="font-medium">Fin: {{ $endDate }}</span>
                                    </div>
                                @endif
                                <div class="flex items-center text-gray-600 bg-blue-50 px-3 py-2 rounded-lg">
                                    <i class="fas fa-clock text-blue-600 mr-2"></i>
                                    <span class="text-sm">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar con información y acciones -->
                        <div class="md:w-72 bg-gradient-to-br from-gray-50 to-blue-50 p-6 flex flex-col justify-between border-l border-gray-100">
                            <div class="space-y-4">
                                <!-- Información de estado -->
                                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                                    <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide font-semibold">Estado del Programa</p>
                                    <p class="text-2xl font-bold text-gray-900 mb-2">
                                        {{ $isFinished ? 'Finalizada' : ($isUpcoming ? 'Próxima' : 'Activa') }}
                                    </p>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <i class="fas fa-lightbulb mr-1"></i>
                                        {{ $isUpcoming ? 'Planificar participación' : 'Repasar contenidos' }}
                                    </div>
                                </div>

                                <!-- Información adicional -->
                                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                                    <p class="text-xs text-gray-500 mb-2 uppercase tracking-wide font-semibold">Disponibilidad</p>
                                    <div class="flex items-center text-sm text-gray-700 mb-1">
                                        <i class="fas fa-link text-blue-600 mr-2 w-4"></i>
                                        <span>{{ $item->link ? 'Enlace disponible' : 'Sin enlace' }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-700">
                                        <i class="fas fa-calendar text-blue-600 mr-2 w-4"></i>
                                        <span>{{ $isUpcoming ? 'Inicia pronto' : ($isFinished ? 'Completada' : 'En progreso') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones de acción -->
                            <div class="text-right flex flex-col items-end space-y-3 mt-4">
                                @if($item->link)
                                    <a href="{{ $item->link }}"
                                       target="_blank" rel="noopener noreferrer"
                                       class="btn-primary text-white px-6 py-3 rounded-xl hover-lift transition-all duration-300 text-sm font-medium shadow-soft w-full flex items-center justify-center group">
                                        <i class="fas fa-external-link-alt mr-2 group-hover:scale-110 transition-transform"></i>
                                        Ver Capacitación
                                    </a>
                                @else
                                    <span class="text-blue-600 text-sm w-full text-center py-3 bg-blue-50 rounded-xl">
                                        <i class="fas fa-ban mr-1"></i>
                                        Sin enlace disponible
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-soft p-12 text-center border border-gray-200 animate-fade-in-up">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-graduation-cap text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">No hay capacitaciones disponibles</h3>
                    <p class="text-gray-600">Actualmente no hay capacitaciones publicadas.</p>
                </div>
            @endforelse
            
            @if(method_exists($trainings, 'links'))
                <div class="mt-8 flex justify-center animate-fade-in-up">
                    <div class="bg-white rounded-xl shadow-soft p-4">
                        {{ $trainings->links('pagination::tailwind') }}
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>

<style>
    /* Animaciones */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-slide-in {
        animation: slideIn 0.6s ease-out;
    }

    /* Hover effects */
    .hover-lift {
        transition: all 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-2px);
    }

    .shadow-soft {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    }
</style>
@endsection