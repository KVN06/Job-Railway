@extends('layouts.new-user') 
<!-- Usa una plantilla base llamada 'new-user' -->

@section('content')
<form action="{{ route('agg-company') }}" method="POST" class="relative">
    @csrf

    <div class="decorative-pattern fixed inset-0 pointer-events-none"></div>

    <main class="container mx-auto py-12 px-6">
        <section class="relative gradient-primary text-white rounded-2xl p-8 mb-10 overflow-hidden animate-fade-in-up">
            <div class="absolute top-0 right-0 w-48 h-48 bg-white opacity-5 rounded-full -mr-24 -mt-24"></div>
            <div class="absolute bottom-0 left-0 w-36 h-36 bg-white opacity-5 rounded-full -ml-18 -mb-18"></div>

            <div class="max-w-2xl mx-auto text-center relative z-10">
                <div class="mb-4">
                    <i class="fas fa-building text-4xl mb-3 opacity-90"></i>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold mb-3 leading-tight">Registrar nueva empresa</h1>
                <p class="text-base md:text-lg opacity-90 leading-relaxed">Completa la información para que tu organización pueda gestionar ofertas y procesos de selección.</p>
            </div>
        </section>

        <section class="max-w-3xl mx-auto">
            <div class="card-enhanced rounded-2xl bg-white shadow-xl shadow-blue-200/50 border border-slate-200/70 p-8 space-y-8 animate-slide-in">
                <header class="flex items-center gap-4">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl gradient-primary text-white text-2xl shadow-lg shadow-blue-500/40">
                        <i class="fas fa-id-badge"></i>
                    </span>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">Datos principales</h2>
                        <p class="text-sm text-slate-500">Estos campos nos ayudan a identificar y presentar tu empresa dentro de la plataforma.</p>
                    </div>
                </header>

                <div class="grid grid-cols-1 gap-6">
                    <div class="space-y-2">
                        <label for="company_name" class="text-sm font-medium text-slate-600">Nombre de la empresa</label>
                        <input
                            type="text"
                            id="company_name"
                            name="company_name"
                            value="{{ old('company_name') }}"
                            class="input-field"
                            placeholder="Ej. Industrias Innovadoras S.A.S."
                            required
                        >
                        @error('company_name')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="description" class="text-sm font-medium text-slate-600">Descripción</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="input-field resize-none"
                            placeholder="Describe el propósito, productos o servicios que ofrece tu empresa"
                            required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-slate-500 flex items-center gap-2"><i class="fas fa-shield-alt text-blue-500"></i> Recuerda verificar la información antes de enviarla.</p>
                    <button
                        type="submit"
                        class="btn-primary inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/30 hover-lift"
                    >
                        <i class="fas fa-paper-plane"></i>
                        Registrar empresa
                    </button>
                </div>
            </div>
        </section>
    </main>
</form>
@endsection
