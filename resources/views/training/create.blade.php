
@extends('layouts.home')

@section('content')
<main class="max-w-3xl mx-auto py-12 px-6">

    <!-- Sección del formulario para registrar una nueva capacitación -->
    <section class="bg-gradient-to-br from-white to-slate-50 rounded-2xl shadow-lg p-8 mb-12 border border-gray-100">
        <h2 class="text-3xl font-extrabold mb-6 text-center text-sky-700 tracking-tight">Registrar Capacitación</h2>

        <form action="{{ route('training.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <!-- Campo: Título -->
            <div>
                <label class="block text-sm font-semibold mb-2 text-gray-700 uppercase">Título</label>
                <input type="text" name="title" class="w-full bg-white border border-gray-200 rounded-lg p-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-300 transition" required>
            </div>

            <!-- Campo: Proveedor -->
            <div>
                <label class="block text-sm font-semibold mb-2 text-gray-700 uppercase">Proveedor</label>
                <input type="text" name="provider" class="w-full bg-white border border-gray-200 rounded-lg p-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-300 transition">
            </div>

            <!-- Campo: Descripción -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold mb-2 text-gray-700 uppercase">Descripción</label>
                <textarea name="description" rows="4" class="w-full bg-white border border-gray-200 rounded-lg p-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-300 transition"></textarea>
            </div>

            <!-- Campo: Enlace -->
            <div>
                <label class="block text-sm font-semibold mb-2 text-gray-700 uppercase">Enlace</label>
                <input type="url" name="link" class="w-full bg-white border border-gray-200 rounded-lg p-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-300 transition">
            </div>

            <!-- Campo: Fecha de inicio -->
            <div>
                <label class="block text-sm font-semibold mb-2 text-gray-700 uppercase">Fecha de Inicio</label>
                <input type="date" name="start_date" class="w-full bg-white border border-gray-200 rounded-lg p-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-300 transition">
            </div>

            <!-- Campo: Fecha de fin -->
            <div>
                <label class="block text-sm font-semibold mb-2 text-gray-700 uppercase">Fecha de Fin</label>
                <input type="date" name="end_date" class="w-full bg-white border border-gray-200 rounded-lg p-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-300 transition">
            </div>

            <!-- Botón para enviar el formulario -->
            <div class="md:col-span-2 text-center">
                <button type="submit" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-sky-600 to-sky-500 text-white px-6 py-3 rounded-full hover:scale-105 transform transition shadow-md">
                    Guardar Capacitación
                </button>
            </div>
        </form>
    </section>

</main>
@endsection
