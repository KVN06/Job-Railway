@extends('layouts.home')

@section('content')

@if(auth()->user()->type === 'company')

    {{-- Home para empresa --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto mt-6 px-4 animate-fade-in-up">
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        </div>
    @endif

    <main class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Hero Section Mejorado -->
        <x-card variant="gradient" class="mb-10 overflow-hidden relative">
            @php
                $authUser = auth()->user();
                $company = $authUser?->company;
            @endphp

            @if ($company)
            <!-- Estadísticas Mejoradas con datos dinámicos -->
            <section class="mb-12">
                <div class="mb-8 text-center">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                        <i class="fas fa-chart-bar mr-2 text-blue-600"></i>
                        Resumen de Actividad
                    </h2>
                    <p class="text-gray-600">Tu desempeño en tiempo real</p>
                </div>

                @php
                    $totalOffers = $company->jobOffers()->count();
                    $activeOffers = $company->jobOffers()->where('status', 'active')->count();
                    $applicationsCount = $company->jobOffers()->withCount('jobApplications')->get()->sum('job_applications_count');
                    $activityRate = $totalOffers > 0 ? round(($activeOffers / $totalOffers) * 100) : 0;
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-in-up">
                    <!-- Ofertas Activas -->
                    <x-card hover class="transform hover:scale-105 transition-all duration-300">
                        <div class="text-center">
                            <div class="w-18 h-18 bg-gradient-to-br from-blue-900 to-blue-800 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-briefcase text-3xl text-white"></i>
                            </div>
                            <div class="text-5xl font-bold bg-gradient-to-r from-blue-900 to-blue-700 bg-clip-text text-transparent mb-2">
                                {{ $activeOffers }}
                            </div>
                            <div class="text-gray-600 font-semibold mb-3">Ofertas Activas</div>
                            <x-badge variant="success" icon="fas fa-check-circle" size="sm">
                                Publicadas
                            </x-badge>
                        </div>
                    </x-card>

                    <!-- Aplicaciones Recibidas -->
                    <x-card hover class="transform hover:scale-105 transition-all duration-300">
                        <div class="text-center">
                            <div class="w-18 h-18 bg-gradient-to-br from-indigo-900 to-indigo-800 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-users text-3xl text-white"></i>
                            </div>
                            <div class="text-5xl font-bold bg-gradient-to-r from-indigo-900 to-indigo-700 bg-clip-text text-transparent mb-2">
                                {{ $applicationsCount }}
                            </div>
                            <div class="text-gray-600 font-semibold mb-3">Postulaciones Totales</div>
                            <x-badge variant="primary" icon="fas fa-user-plus" size="sm">
                                Candidatos
                            </x-badge>
                        </div>
                    </x-card>

                    <!-- Total de Ofertas -->
                    <x-card hover class="transform hover:scale-105 transition-all duration-300">
                        <div class="text-center">
                            <div class="w-18 h-18 bg-gradient-to-br from-slate-700 to-slate-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-file-alt text-3xl text-white"></i>
                            </div>
                            <div class="text-5xl font-bold bg-gradient-to-r from-slate-700 to-slate-600 bg-clip-text text-transparent mb-2">
                                {{ $totalOffers }}
                            </div>
                            <div class="text-gray-600 font-semibold mb-3">Total de Ofertas</div>
                            <x-badge variant="success" icon="fas fa-chart-line" size="sm">
                                Historial
                            </x-badge>
                        </div>
                    </x-card>

                    <!-- Tasa de Actividad -->
                    <x-card hover class="transform hover:scale-105 transition-all duration-300">
                        <div class="text-center">
                            <div class="w-18 h-18 bg-gradient-to-br from-gray-700 to-gray-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-percentage text-3xl text-white"></i>
                            </div>
                            <div class="text-5xl font-bold bg-gradient-to-r from-gray-700 to-gray-600 bg-clip-text text-transparent mb-2">
                                {{ $activityRate }}%
                            </div>
                            <div class="text-gray-600 font-semibold mb-3">Tasa de Actividad</div>
                            <x-badge variant="{{ $activityRate >= 70 ? 'success' : ($activityRate >= 40 ? 'warning' : 'danger') }}" icon="fas fa-chart-pie" size="sm">
                                {{ $activityRate >= 70 ? 'Excelente' : ($activityRate >= 40 ? 'Buena' : 'Mejorable') }}
                            </x-badge>
                        </div>
                    </x-card>
                </div>
            </section>
            @else
            <section class="mb-12">
                <div class="max-w-3xl mx-auto">
                    <x-alert variant="info" icon="fas fa-info-circle">
                        Completa el registro de tu empresa para visualizar estadísticas de ofertas y postulaciones.
                        <a href="{{ route('company-form') }}" class="underline font-semibold">Ir al formulario de empresa</a>.
                    </x-alert>
                </div>
            </section>
            @endif
                        </div>
                        <div class="text-5xl font-bold bg-gradient-to-r from-indigo-900 to-indigo-700 bg-clip-text text-transparent mb-2">
                            {{ auth()->user()->company->jobOffers()->withCount('jobApplications')->get()->sum('job_applications_count') ?? 0 }}
                        </div>
                        <div class="text-gray-600 font-semibold mb-3">Postulaciones Totales</div>
                        <x-badge variant="primary" icon="fas fa-user-plus" size="sm">
                            Candidatos
                        </x-badge>
                    </div>
                </x-card>

                <!-- Total de Ofertas -->
                <x-card hover class="transform hover:scale-105 transition-all duration-300">
                    <div class="text-center">
                        <div class="w-18 h-18 bg-gradient-to-br from-slate-700 to-slate-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                            <i class="fas fa-file-alt text-3xl text-white"></i>
                        </div>
                        <div class="text-5xl font-bold bg-gradient-to-r from-slate-700 to-slate-600 bg-clip-text text-transparent mb-2">
                            {{ auth()->user()->company->jobOffers()->count() ?? 0 }}
                        </div>
                        <div class="text-gray-600 font-semibold mb-3">Total de Ofertas</div>
                        <x-badge variant="success" icon="fas fa-chart-line" size="sm">
                            Historial
                        </x-badge>
                    </div>
                </x-card>

                <!-- Tasa de Actividad -->
                <x-card hover class="transform hover:scale-105 transition-all duration-300">
                    <div class="text-center">
                        <div class="w-18 h-18 bg-gradient-to-br from-gray-700 to-gray-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                            <i class="fas fa-percentage text-3xl text-white"></i>
                        </div>
                        @php
                            $totalOffers = auth()->user()->company->jobOffers()->count();
                            $activeOffers = auth()->user()->company->jobOffers()->where('status', 'active')->count();
                            $activityRate = $totalOffers > 0 ? round(($activeOffers / $totalOffers) * 100) : 0;
                        @endphp
                        <div class="text-5xl font-bold bg-gradient-to-r from-gray-700 to-gray-600 bg-clip-text text-transparent mb-2">
                            {{ $activityRate }}%
                        </div>
                        <div class="text-gray-600 font-semibold mb-3">Tasa de Actividad</div>
                        <x-badge variant="{{ $activityRate >= 70 ? 'success' : ($activityRate >= 40 ? 'warning' : 'danger') }}" icon="fas fa-chart-pie" size="sm">
                            {{ $activityRate >= 70 ? 'Excelente' : ($activityRate >= 40 ? 'Buena' : 'Mejorable') }}
                        </x-badge>
                    </div>
                </x-card>
            </div>
        </section>

        <!-- Acciones Rápidas Mejoradas -->
        <section class="mb-12">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    <span class="bg-gradient-to-r from-blue-800 to-purple-700 bg-clip-text text-transparent">
                        <i class="fas fa-bolt mr-2"></i>Acciones Rápidas
                    </span>
                </h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto leading-relaxed">
                    Gestiona tus procesos de reclutamiento de forma eficiente y profesional
                </p>
                <div class="w-32 h-1.5 bg-gradient-to-r from-blue-800 to-purple-700 mx-auto mt-5 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Publicar Oferta -->
                <x-card variant="enhanced" hover class="group cursor-pointer transform transition-all duration-500 hover:scale-105 hover:shadow-2xl animate-fade-in-up">
                    <a href="{{ route('job-offers.create') }}" class="block">
                        <div class="text-center relative">
                            <!-- Badge flotante -->
                            <div class="absolute -top-3 -right-3 z-10">
                                <x-badge variant="success" icon="fas fa-star" size="sm">
                                    Popular
                                </x-badge>
                            </div>

                            <div class="w-24 h-24 bg-gradient-to-br from-blue-900 to-blue-800 rounded-3xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                                <i class="fas fa-file-medical text-4xl text-white"></i>
                            </div>
                            <h3 class="font-bold text-xl mb-3 text-gray-800 group-hover:text-blue-900 transition-colors">
                                Publicar Oferta
                            </h3>
                            <p class="text-sm text-gray-600 mb-5 leading-relaxed px-2">
                                Crea y publica una nueva oferta laboral en minutos
                            </p>
                            <div class="flex items-center justify-center text-blue-900 font-semibold group-hover:translate-x-2 transition-transform duration-300">
                                <span>Crear ahora</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </a>
                </x-card>

                <!-- Gestionar Postulaciones -->
                <x-card variant="enhanced" hover class="group cursor-pointer transform transition-all duration-500 hover:scale-105 hover:shadow-2xl animate-fade-in-up" style="animation-delay: 0.1s;">
                    <a href="{{ \Illuminate\Support\Facades\Route::has('job-applications.index-company') ? route('job-applications.index-company') : route('job-offers.index') }}" class="block">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-indigo-900 to-indigo-800 rounded-3xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                                <i class="fas fa-clipboard-check text-4xl text-white"></i>
                            </div>
                            <h3 class="font-bold text-xl mb-3 text-gray-800 group-hover:text-indigo-900 transition-colors">
                                Gestionar Postulaciones
                            </h3>
                            <p class="text-sm text-gray-600 mb-5 leading-relaxed px-2">
                                Revisa y actualiza las postulaciones recibidas
                            </p>
                            <div class="flex items-center justify-center text-indigo-900 font-semibold group-hover:translate-x-2 transition-transform duration-300">
                                <span>Ver postulaciones</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </a>
                </x-card>

                <!-- Ver Ofertas Publicadas -->
                <x-card variant="enhanced" hover class="group cursor-pointer transform transition-all duration-500 hover:scale-105 hover:shadow-2xl animate-fade-in-up" style="animation-delay: 0.2s;">
                    <a href="{{ route('job-offers.index') }}" class="block">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-slate-700 to-slate-600 rounded-3xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                                <i class="fas fa-list-ul text-4xl text-white"></i>
                            </div>
                            <h3 class="font-bold text-xl mb-3 text-gray-800 group-hover:text-slate-700 transition-colors">
                                Mis Ofertas
                            </h3>
                            <p class="text-sm text-gray-600 mb-5 leading-relaxed px-2">
                                Administra todas tus ofertas laborales publicadas
                            </p>
                            <div class="flex items-center justify-center text-slate-700 font-semibold group-hover:translate-x-2 transition-transform duration-300">
                                <span>Ver ofertas</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </a>
                </x-card>

                <!-- Perfil de Empresa -->
                <x-card variant="default" class="opacity-75 hover:opacity-90 transition-opacity animate-fade-in-up" style="animation-delay: 0.3s;">
                    <div class="text-center h-full flex flex-col justify-between">
                        <div>
                            <div class="w-24 h-24 bg-gradient-to-br from-gray-600 to-gray-500 rounded-3xl flex items-center justify-center mb-6 mx-auto shadow-lg">
                                <i class="fas fa-building text-4xl text-white"></i>
                            </div>
                            <h3 class="font-bold text-xl mb-3 text-gray-600">
                                Perfil de Empresa
                            </h3>
                            <p class="text-sm text-gray-500 mb-5 px-2">
                                Gestiona la información de tu empresa
                            </p>
                        </div>
                        <x-badge variant="default" icon="fas fa-clock">
                            Próximamente
                        </x-badge>
                    </div>
                </x-card>
            </div>
        </section>

        <!-- Tips y Recomendaciones -->
        <section class="mb-12 animate-fade-in-up" style="animation-delay: 0.4s;">
            <x-card variant="enhanced" class="border-l-4 border-blue-600">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-lightbulb text-2xl text-blue-600"></i>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-xl font-bold text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-star text-yellow-500 mr-2"></i>
                            Consejos para atraer mejores candidatos
                        </h3>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mr-3 mt-1 flex-shrink-0"></i>
                                <span><strong>Descripciones claras:</strong> Detalla responsabilidades y requisitos específicos</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mr-3 mt-1 flex-shrink-0"></i>
                                <span><strong>Salario competitivo:</strong> Ofrece rangos salariales atractivos y beneficios</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mr-3 mt-1 flex-shrink-0"></i>
                                <span><strong>Respuesta rápida:</strong> Responde a las aplicaciones en menos de 48 horas</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </x-card>
        </section>

    </main>
@elseif(auth()->user()->type === 'unemployed')

    {{-- Home para desempleado mejorado --}}
    <main class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Hero Section Mejorado -->
        <x-card variant="gradient" class="mb-10 overflow-hidden relative">
            <!-- Elementos decorativos animados -->
            <div class="absolute top-0 right-0 w-72 h-72 bg-white opacity-5 rounded-full -mr-36 -mt-36 animate-pulse-slow"></div>
            <div class="absolute bottom-0 left-0 w-56 h-56 bg-white opacity-5 rounded-full -ml-28 -mb-28 animate-pulse-slow" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 right-1/4 w-80 h-80 bg-white opacity-3 rounded-full blur-3xl"></div>

            <div class="max-w-4xl mx-auto text-center relative z-10 py-4">
                <!-- Saludo personalizado -->
                <div class="mb-4 opacity-90">
                    <p class="text-lg md:text-xl font-medium">
                        <i class="fas fa-hand-wave mr-2"></i>
                        Hola, <span class="font-bold">{{ auth()->user()->name }}</span>
                    </p>
                </div>

                <!-- Icono animado -->
                <div class="mb-8">
                    <i class="fas fa-rocket text-8xl text-white animate-bounce-slow inline-block"></i>
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-5 leading-tight">
                    Tu Próxima Oportunidad Laboral
                </h1>
                <p class="text-xl md:text-2xl mb-10 opacity-90 leading-relaxed max-w-3xl mx-auto">
                    Conectamos talento con empresas líderes. Encuentra el trabajo de tus sueños
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <x-button
                        href="{{ route('job-offers.index') }}"
                        variant="primary"
                        size="lg"
                        icon="fas fa-search"
                        class="transform hover:scale-105 transition-transform duration-300 shadow-xl bg-white text-blue-800 hover:bg-gray-100"
                    >
                        Explorar Empleos
                    </x-button>
                    <x-button
                        href="{{ route('training.index') }}"
                        variant="primary"
                        size="lg"
                        icon="fas fa-graduation-cap"
                        class="bg-white bg-opacity-20 backdrop-blur-sm border-2 border-white text-white hover:bg-white hover:text-blue-800 transform hover:scale-105 transition-all duration-300"
                    >
                        Ver Capacitaciones
                    </x-button>
                </div>
            </div>
        </x-card>

        <!-- Estadísticas de la Plataforma -->
        <section class="mb-12">
            <div class="mb-8 text-center">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-chart-line mr-2 text-blue-600"></i>
                    La Plataforma en Números
                </h2>
                <p class="text-gray-600">Tu puerta al éxito profesional</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in-up">
                <!-- Empleos Disponibles -->
                <x-card hover class="transform hover:scale-105 transition-all duration-300">
                    <div class="text-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-900 to-blue-800 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <i class="fas fa-briefcase text-2xl text-white"></i>
                        </div>
                        @php
                            $totalJobs = \App\Models\JobOffer::where('status', 'active')->count();
                        @endphp
                        <div class="text-5xl font-bold bg-gradient-to-r from-blue-900 to-blue-700 bg-clip-text text-transparent mb-2">
                            {{ number_format($totalJobs) }}{{ $totalJobs > 100 ? '+' : '' }}
                        </div>
                        <div class="text-gray-600 font-semibold mb-3">Empleos Disponibles</div>
                        <x-badge variant="success" icon="fas fa-plus-circle" size="sm">
                            Activos ahora
                        </x-badge>
                    </div>
                </x-card>

                <!-- Empresas Registradas -->
                <x-card hover class="transform hover:scale-105 transition-all duration-300">
                    <div class="text-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-indigo-900 to-indigo-800 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <i class="fas fa-building text-2xl text-white"></i>
                        </div>
                        @php
                            $totalCompanies = \App\Models\Company::count();
                        @endphp
                        <div class="text-5xl font-bold bg-gradient-to-r from-indigo-900 to-indigo-700 bg-clip-text text-transparent mb-2">
                            {{ number_format($totalCompanies) }}{{ $totalCompanies > 50 ? '+' : '' }}
                        </div>
                        <div class="text-gray-600 font-semibold mb-3">Empresas Confiables</div>
                        <x-badge variant="primary" icon="fas fa-shield-check" size="sm">
                            Verificadas
                        </x-badge>
                    </div>
                </x-card>

                <!-- Tus Postulaciones -->
                <x-card hover class="transform hover:scale-105 transition-all duration-300">
                    <div class="text-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-slate-700 to-slate-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <i class="fas fa-file-import text-2xl text-white"></i>
                        </div>
                        @php
                            $myApplications = auth()->user()->unemployed->jobApplications()->count() ?? 0;
                        @endphp
                        <div class="text-5xl font-bold bg-gradient-to-r from-slate-700 to-slate-600 bg-clip-text text-transparent mb-2">
                            {{ $myApplications }}
                        </div>
                        <div class="text-gray-600 font-semibold mb-3">Mis Postulaciones</div>
                        <x-badge variant="success" icon="fas fa-paper-plane" size="sm">
                            Enviadas
                        </x-badge>
                    </div>
                </x-card>
            </div>
        </section>

        <!-- Acciones Rápidas para Desempleados -->
        <section class="mb-12">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    <span class="bg-gradient-to-r from-blue-800 to-purple-700 bg-clip-text text-transparent">
                        <i class="fas fa-rocket mr-2"></i>Impulsa Tu Carrera
                    </span>
                </h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto leading-relaxed">
                    Herramientas y recursos para encontrar tu empleo ideal
                </p>
                <div class="w-32 h-1.5 bg-gradient-to-r from-blue-800 to-purple-700 mx-auto mt-5 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Buscar Empleos -->
                <x-card variant="enhanced" hover class="group cursor-pointer transform transition-all duration-500 hover:scale-105 hover:shadow-2xl animate-fade-in-up">
                    <a href="{{ route('job-offers.index') }}" class="block">
                        <div class="text-center relative">
                            <!-- Badge flotante -->
                            <div class="absolute -top-3 -right-3 z-10">
                                <x-badge variant="success" icon="fas fa-fire" size="sm">
                                    Nuevos
                                </x-badge>
                            </div>

                            <div class="w-24 h-24 bg-gradient-to-br from-blue-900 to-blue-800 rounded-3xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                                <i class="fas fa-search text-4xl text-white"></i>
                            </div>
                            <h3 class="font-bold text-xl mb-3 text-gray-800 group-hover:text-blue-900 transition-colors">
                                Buscar Empleos
                            </h3>
                            <p class="text-sm text-gray-600 mb-5 leading-relaxed px-2">
                                Explora miles de oportunidades laborales disponibles
                            </p>
                            <div class="flex items-center justify-center text-blue-900 font-semibold group-hover:translate-x-2 transition-transform duration-300">
                                <span>Explorar ahora</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </a>
                </x-card>

                <!-- Portafolio -->
                <x-card variant="enhanced" hover class="group cursor-pointer transform transition-all duration-500 hover:scale-105 hover:shadow-2xl animate-fade-in-up" style="animation-delay: 0.1s;">
                    <a href="{{ route('portfolios.index') }}" class="block">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-indigo-900 to-indigo-800 rounded-3xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                                <i class="fas fa-briefcase text-4xl text-white"></i>
                            </div>
                            <h3 class="font-bold text-xl mb-3 text-gray-800 group-hover:text-indigo-900 transition-colors">
                                Mi Portafolio
                            </h3>
                            <p class="text-sm text-gray-600 mb-5 leading-relaxed px-2">
                                Gestiona tus proyectos, experiencia y logros profesionales
                            </p>
                            <div class="flex items-center justify-center text-indigo-900 font-semibold group-hover:translate-x-2 transition-transform duration-300">
                                <span>Ver portafolio</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </a>
                </x-card>

                <!-- Capacitaciones -->
                <x-card variant="enhanced" hover class="group cursor-pointer transform transition-all duration-500 hover:scale-105 hover:shadow-2xl animate-fade-in-up" style="animation-delay: 0.2s;">
                    <a href="{{ route('training.index') }}" class="block">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-slate-700 to-slate-600 rounded-3xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                                <i class="fas fa-graduation-cap text-4xl text-white"></i>
                            </div>
                            <h3 class="font-bold text-xl mb-3 text-gray-800 group-hover:text-slate-700 transition-colors">
                                Capacitaciones
                            </h3>
                            <p class="text-sm text-gray-600 mb-5 leading-relaxed px-2">
                                Mejora tus habilidades con cursos y formaciones
                            </p>
                            <div class="flex items-center justify-center text-slate-700 font-semibold group-hover:translate-x-2 transition-transform duration-300">
                                <span>Ver cursos</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </a>
                </x-card>
            </div>
        </section>

        <!-- Sección de Estado de Aplicaciones -->
        @if(auth()->user()->unemployed && auth()->user()->unemployed->jobApplications()->count() > 0)
        <section class="mb-12 animate-fade-in-up" style="animation-delay: 0.3s;">
            <x-card variant="enhanced" class="border-l-4 border-green-600">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-clipboard-list text-2xl text-green-600"></i>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-xl font-bold text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-chart-pie text-blue-600 mr-2"></i>
                            Estado de Tus Postulaciones
                        </h3>
                        @php
                            $applications = auth()->user()->unemployed->jobApplications;
                            $pending = $applications->where('status', 'pending')->count();
                            $reviewed = $applications->where('status', 'reviewed')->count();
                            $accepted = $applications->where('status', 'accepted')->count();
                            $rejected = $applications->where('status', 'rejected')->count();
                        @endphp
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                            <div class="text-center p-3 bg-yellow-50 rounded-lg">
                                <div class="text-2xl font-bold text-yellow-700">{{ $pending }}</div>
                                <div class="text-xs text-gray-600">Pendientes</div>
                            </div>
                            <div class="text-center p-3 bg-blue-50 rounded-lg">
                                <div class="text-2xl font-bold text-blue-700">{{ $reviewed }}</div>
                                <div class="text-xs text-gray-600">En Revisión</div>
                            </div>
                            <div class="text-center p-3 bg-green-50 rounded-lg">
                                <div class="text-2xl font-bold text-green-700">{{ $accepted }}</div>
                                <div class="text-xs text-gray-600">Aceptadas</div>
                            </div>
                            <div class="text-center p-3 bg-red-50 rounded-lg">
                                <div class="text-2xl font-bold text-red-700">{{ $rejected }}</div>
                                <div class="text-xs text-gray-600">Rechazadas</div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>
        </section>
        @endif

        <!-- Tips para Candidatos -->
        <section class="mb-12 animate-fade-in-up" style="animation-delay: 0.4s;">
            <x-card variant="enhanced" class="border-l-4 border-purple-600">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-lightbulb text-2xl text-purple-600"></i>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-xl font-bold text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-star text-yellow-500 mr-2"></i>
                            Consejos para Destacar en tu Búsqueda
                        </h3>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-purple-600 mr-3 mt-1 flex-shrink-0"></i>
                                <span><strong>Perfil completo:</strong> Asegúrate de tener tu portafolio actualizado con proyectos recientes</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-purple-600 mr-3 mt-1 flex-shrink-0"></i>
                                <span><strong>Personaliza aplicaciones:</strong> Adapta tu CV y carta a cada oferta específica</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-purple-600 mr-3 mt-1 flex-shrink-0"></i>
                                <span><strong>Capacítate continuamente:</strong> Aprovecha las formaciones disponibles para mejorar habilidades</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-purple-600 mr-3 mt-1 flex-shrink-0"></i>
                                <span><strong>Sé proactivo:</strong> Aplica regularmente y mantén un seguimiento de tus postulaciones</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </x-card>
        </section>

    </main>

@else

    <p class="text-center text-red-600 mt-20 font-semibold">Tipo de usuario desconocido.</p>

@endif

@endsection
