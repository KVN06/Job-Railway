@extends('layouts.home')

@section('content')
@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Carbon;

    $totalTrainings = $trainings->count();
    $upcomingTrainings = $trainings->filter(fn ($training) => $training->start_date && Carbon::parse($training->start_date)->isFuture())->count();
    $activeTrainings = $trainings->filter(function ($training) {
        if (! $training->start_date) {
            return false;
        }

        $start = Carbon::parse($training->start_date);
        $end = $training->end_date ? Carbon::parse($training->end_date) : null;

        return $end
            ? Carbon::now()->between($start, $end)
            : $start->isPast();
    })->count();

    $recentTrainings = $trainings->sortByDesc('created_at')->take(3);
@endphp

<main class="container mx-auto px-4 py-10 space-y-12">

    @if(session('success'))
        <x-alert variant="success" icon="fas fa-check-circle" class="animate-fade-in-up">
            {{ session('success') }}
        </x-alert>
    @endif

    <!-- HERO PRINCIPAL -->
    <section class="animate-fade-in-up">
        <x-card variant="gradient" class="relative overflow-hidden">
            <div class="absolute -top-16 -right-10 w-72 h-72 bg-white/10 blur-3xl rounded-full"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 blur-3xl rounded-full"></div>

            <div class="relative z-10 flex flex-col lg:flex-row items-center lg:items-start gap-10">
                <div class="flex-1 text-center lg:text-left space-y-6">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 border border-white/30 text-white/90 text-sm uppercase tracking-wide">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Biblioteca de capacitación
                    </div>
                    <div class="space-y-4">
                        <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight">
                            Impulsa el talento con entrenamientos actualizados
                        </h1>
                        <p class="text-white/80 text-lg max-w-3xl">
                            Registra tus programas internos, comparte cursos externos y mantén un histórico centralizado de todas las formaciones disponibles para el equipo.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 sm:items-center sm:justify-start justify-center">
                        <x-button
                            href="{{ route('training.create') }}"
                            variant="primary"
                            size="lg"
                            icon="fas fa-plus-circle"
                            class="bg-white text-blue-700 hover:bg-gray-100 shadow-xl"
                        >
                            Nueva capacitación
                        </x-button>
                    </div>
                </div>

                <div class="w-full max-w-sm">
                    <div class="bg-white/10 border border-white/20 rounded-3xl p-7 backdrop-blur space-y-5 text-white">
                        <p class="text-white/70 text-sm uppercase tracking-widest">Resumen de tu catálogo</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-white/70">Capacitaciones registradas</p>
                                <p class="text-3xl font-bold">{{ number_format($totalTrainings) }}</p>
                            </div>
                            <span class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-white/15"><i class="fas fa-layer-group"></i></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-white/70">Próximas a iniciar</p>
                                <p class="text-3xl font-bold">{{ $upcomingTrainings }}</p>
                            </div>
                            <span class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-white/15"><i class="fas fa-calendar"></i></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-white/70">En curso / recientes</p>
                                <p class="text-3xl font-bold">{{ $activeTrainings }}</p>
                            </div>
                            <span class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-white/15"><i class="fas fa-bolt"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>
    </section>

    <!-- LISTADO DE CAPACITACIONES -->
    <section class="space-y-6" id="training-insights">
        <div class="grid grid-cols-1 gap-6 animate-slide-in">
            @forelse($trainings as $item)
                @php
                    $startDate = $item->start_date ? Carbon::parse($item->start_date)->format('d/m/Y') : null;
                    $endDate = $item->end_date ? Carbon::parse($item->end_date)->format('d/m/Y') : null;
                    $isUpcoming = $item->start_date ? Carbon::parse($item->start_date)->isFuture() : false;
                    $isFinished = $item->end_date ? Carbon::parse($item->end_date)->isPast() : false;
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

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm text-gray-600">
                                <div class="flex items-center gap-2 px-3 py-2 rounded-xl bg-gray-100">
                                    <i class="fas fa-calendar-plus text-green-600"></i>
                                    <span>{{ $startDate ? 'Inicio ' . $startDate : 'Inicio flexible' }}</span>
                                </div>
                                <div class="flex items-center gap-2 px-3 py-2 rounded-xl bg-gray-100">
                                    <i class="fas fa-calendar-check text-indigo-600"></i>
                                    <span>{{ $endDate ? 'Finaliza ' . $endDate : 'Sin fecha de cierre' }}</span>
                                </div>
                                <div class="flex items-center gap-2 px-3 py-2 rounded-xl bg-gray-100">
                                    <i class="fas fa-clock text-gray-500"></i>
                                    <span>Creada {{ Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                </div>
                            </div>

                            @if($item->description)
                                <p class="text-gray-600 leading-relaxed">
                                    {{ Str::limit(strip_tags($item->description), 220) }}
                                </p>
                            @endif

                            @if($item->link)
                                <div class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-semibold">
                                    <i class="fas fa-link"></i>
                                    {{ Str::limit($item->link, 60) }}
                                </div>
                            @endif
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

                                @if($item->link)
                                    <x-button
                                        href="{{ $item->link }}"
                                        target="_blank"
                                        rel="noopener"
                                        variant="primary"
                                        icon="fas fa-arrow-up-right-from-square"
                                        class="w-full"
                                    >
                                        Abrir enlace
                                    </x-button>
                                @endif
                            </div>

                            <div class="space-y-3">
                                <div class="flex flex-col gap-2">
                                    <x-button
                                        href="{{ route('training.edit', $item->id) }}"
                                        variant="secondary"
                                        size="sm"
                                        icon="fas fa-edit"
                                        class="w-full"
                                    >
                                        Editar capacitación
                                    </x-button>
                                    <form action="{{ route('training.destroy', $item->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro que deseas eliminar esta capacitación?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-button
                                            type="submit"
                                            variant="danger"
                                            size="sm"
                                            icon="fas fa-trash"
                                            class="w-full"
                                        >
                                            Eliminar
                                        </x-button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-card>
            @empty
                <x-card class="text-center py-12 animate-fade-in-up">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-graduation-cap text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Sin capacitaciones por ahora</h3>
                    <p class="text-gray-600 mb-6">Comienza a registrar talleres, webinars o formaciones internas para compartir con tu equipo.</p>
                    <x-button href="{{ route('training.create') }}" variant="primary" icon="fas fa-plus" size="lg">
                        Agregar primera capacitación
                    </x-button>
                </x-card>
            @endforelse
        </div>
    </section>

</main>
@endsection
