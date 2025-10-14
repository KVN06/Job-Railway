@extends('admin.layout')

@section('title', 'Gestión de Capacitaciones')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Capacitaciones</h1>
    <a href="{{ route('admin.trainings.create') }}" 
       class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors">
        🎓 Nueva Capacitación
    </a>
</div>

<!-- Estadísticas -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg">
                <span class="text-purple-600">🎓</span>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Total</p>
                <p class="text-lg font-semibold text-gray-900">{{ $trainings->total() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
                <span class="text-blue-600">🔗</span>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Con Enlace</p>
                <p class="text-lg font-semibold text-gray-900">{{ $trainings->whereNotNull('link')->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
                <span class="text-green-600">📅</span>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Activas</p>
                <p class="text-lg font-semibold text-gray-900">{{ $trainings->filter(function($training) {
                    return $training->end_date && now()->lte(\Carbon\Carbon::parse($training->end_date));
                })->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
                <span class="text-yellow-600">🏢</span>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Proveedores</p>
                <p class="text-lg font-semibold text-gray-900">{{ $trainings->unique('provider')->count() }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proveedor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fechas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enlace</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Creación</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($trainings as $training)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <span class="text-purple-600">🎓</span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $training->title }}</div>
                                <div class="text-sm text-gray-500 truncate max-w-xs">
                                    {{ Str::limit($training->description, 50) }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $training->provider ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm space-y-1">
                            @if($training->start_date)
                                <div class="text-green-600">Inicio: {{ \Carbon\Carbon::parse($training->start_date)->format('d/m/Y') }}</div>
                            @endif
                            @if($training->end_date)
                                <div class="text-red-600">Fin: {{ \Carbon\Carbon::parse($training->end_date)->format('d/m/Y') }}</div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($training->link)
                            <a href="{{ $training->link }}" target="_blank" 
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                🔗 Ver enlace
                            </a>
                        @else
                            <span class="text-gray-400 text-sm">Sin enlace</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $now = now();
                            $startDate = $training->start_date ? \Carbon\Carbon::parse($training->start_date) : null;
                            $endDate = $training->end_date ? \Carbon\Carbon::parse($training->end_date) : null;
                            
                            $status = 'gray';
                            $statusText = 'Sin fecha';
                            
                            if ($startDate && $endDate) {
                                if ($now->between($startDate, $endDate)) {
                                    $status = 'green';
                                    $statusText = 'En curso';
                                } elseif ($now->lt($startDate)) {
                                    $status = 'blue';
                                    $statusText = 'Próxima';
                                } else {
                                    $status = 'gray';
                                    $statusText = 'Finalizada';
                                }
                            } elseif ($startDate && $now->lt($startDate)) {
                                $status = 'blue';
                                $statusText = 'Próxima';
                            } elseif ($endDate && $now->gt($endDate)) {
                                $status = 'gray';
                                $statusText = 'Finalizada';
                            }
                        @endphp
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-{{ $status }}-100 text-{{ $status }}-800">
                            {{ $statusText }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $training->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $training->created_at->format('H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.trainings.show', $training->id) }}" 
                               class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs hover:bg-blue-200 transition-colors"
                               title="Ver detalles">
                                👁️ Ver
                            </a>
                            <a href="{{ route('admin.trainings.edit', $training->id) }}" 
                               class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs hover:bg-indigo-200 transition-colors"
                               title="Editar">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('admin.trainings.destroy', $training->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs hover:bg-red-200 transition-colors"
                                        onclick="return confirm('¿Estás seguro de eliminar esta capacitación?')"
                                        title="Eliminar">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Paginación -->
@if($trainings->hasPages())
<div class="mt-6 bg-white rounded-lg shadow px-6 py-4">
    <div class="flex items-center justify-between">
        <div class="text-sm text-gray-700">
            Mostrando 
            <span class="font-medium">{{ $trainings->firstItem() }}</span>
            a 
            <span class="font-medium">{{ $trainings->lastItem() }}</span>
            de 
            <span class="font-medium">{{ $trainings->total() }}</span>
            resultados
        </div>
        <div class="flex space-x-2">
            {{ $trainings->links() }}
        </div>
    </div>
</div>
@endif
@endsection