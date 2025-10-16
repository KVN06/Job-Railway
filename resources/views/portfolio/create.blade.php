@extends('layouts.home')

@section('content')
<form id="portfolioForm" action="{{ route('agg-portfolio') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <main class="min-h-screen bg-blue-50 text-gray-900 py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <header class="mb-8 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-blue-900">Agregar Portafolio</h1>
                <p class="text-black-700 mt-2">Muestra tu trabajo con estilo — agrega imágenes, enlace y un PDF opcional.</p>
            </header>

            <section class="bg-white shadow-lg rounded-2xl p-8 border border-blue-100">
                <div class="space-y-6">
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-blue-100 shadow-md">
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-black-900">Título del Portafolio</label>
                                <input type="text" id="title" name="title" required
                                    class="mt-2 block w-full rounded-xl ring-1 ring-gray-200 text-gray-900 px-4 py-2 focus:ring-2 focus:ring-blue-400 transition"
                                    value="{{ old('title') }}">
                                <p class="text-red-600 text-sm mt-1 hidden" id="err-title"></p>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-black-900">Descripción</label>
                                <textarea id="description" name="description" required rows="5"
                                    class="mt-2 block w-full rounded-xl ring-1 ring-gray-200 text-gray-900 px-4 py-2 focus:ring-2 focus:ring-blue-400 transition">{{ old('description') }}</textarea>
                                <p class="text-red-600 text-sm mt-1 hidden" id="err-description"></p>
                            </div>

                            <div>
                                <label for="url_proyect" class="block text-sm font-medium text-black-900">URL del Proyecto</label>
                                <input type="url" id="url_proyect" name="url_proyect"
                                    class="mt-2 block w-full rounded-xl ring-1 ring-gray-200 text-gray-900 px-4 py-2 focus:ring-2 focus:ring-blue-400 transition"
                                    value="{{ old('url_proyect') }}">
                                <p class="text-red-600 text-sm mt-1 hidden" id="err-url_proyect"></p>
                            </div>

                            <div>
                                <label for="cover_image" class="block text-sm font-medium text-black-900">Imagen de Portada (opcional)</label>

                                <div class="mt-2 flex items-start gap-4">
                                    <div class="w-40 h-28 rounded-md overflow-hidden bg-gray-100 flex items-center justify-center border">
                                        <img id="cover-preview" src="{{ asset('images/placeholder.jpg') }}" alt="preview" class="w-full h-full object-cover hidden">
                                        <span id="cover-placeholder" class="text-sm text-gray-500 px-2">Previsualización</span>
                                    </div>

                                    <div class="flex-1">
                                        <input type="file" id="cover_image" name="cover_image" accept="image/*"
                                            class="mt-2 block w-full text-sm text-blue-800" />
                                        <p class="text-sm text-gray-600 mt-1">Tamaño máximo recomendado: 4MB.</p>
                                        <p class="text-red-600 text-sm mt-1 hidden" id="err-cover_image"></p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="url_pdf" class="block text-sm font-medium text-black-900">Archivo PDF (opcional)</label>
                                <div class="mt-2 flex items-center space-x-3">
                                    <label for="url_pdf"
                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-400 to-blue-600 text-white rounded-lg cursor-pointer shadow-sm hover:brightness-110 transition">
                                        <i class="fas fa-upload mr-2"></i> Seleccionar PDF
                                    </label>
                                    <span id="pdf-name" class="text-sm text-black-700">Ningún archivo seleccionado</span>
                                </div>
                                <input type="file" id="url_pdf" name="url_pdf" accept="application/pdf" class="hidden">
                                <p class="text-sm text-gray-600 mt-1">Tamaño máximo recomendado: 2MB.</p>
                                <p class="text-red-600 text-sm mt-1 hidden" id="err-url_pdf"></p>
                            </div>

                            <div>
                                <p id="form-error" class="text-red-600 text-sm hidden mb-2"></p>
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center gap-2 bg-gradient-to-r from-blue-400 to-blue-600 text-white font-semibold px-6 py-3 rounded-2xl shadow-lg hover:scale-[1.02] transition"
                                    id="submitBtn">
                                    Agregar Portafolio
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</form>

<script>
    (function(){
        const MAX_IMAGE_BYTES = 4 * 1024 * 1024; // 4MB
        const MAX_PDF_BYTES = 2 * 1024 * 1024; // 2MB

        // Elements
        const inputPdf = document.getElementById('url_pdf');
        const pdfName = document.getElementById('pdf-name');
        const coverInput = document.getElementById('cover_image');
        const coverPreview = document.getElementById('cover-preview');
        const coverPlaceholder = document.getElementById('cover-placeholder');
        const form = document.getElementById('portfolioForm');
        const submitButton = document.getElementById('submitBtn');

        // Error fields
        const errCover = document.getElementById('err-cover_image');
        const errPdf = document.getElementById('err-url_pdf');
        const errTitle = document.getElementById('err-title');
        const errDescription = document.getElementById('err-description');
        const errUrlProject = document.getElementById('err-url_proyect');
        const formError = document.getElementById('form-error');

        // Mostrar nombre del PDF seleccionado
        if (inputPdf) {
            inputPdf.addEventListener('change', function(){
                const file = this.files && this.files[0];
                pdfName.textContent = file ? file.name : 'Ningún archivo seleccionado';
            });
        }

        
                // Mostrar preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    coverPreview.src = e.target.result;
                    coverPreview.classList.remove('hidden');
                    coverPlaceholder.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            });
        }

        // Envío AJAX con manejo de errores de validación
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            // limpiar errores previos
            [errCover, errPdf, errTitle, errDescription, errUrlProject, formError].forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });

            // Validación cliente para PDF
            const pdfFile = inputPdf.files && inputPdf.files[0];
            if (pdfFile) {
                if (pdfFile.size > MAX_PDF_BYTES) {
                    errPdf.textContent = 'El PDF supera el tamaño máximo de 2MB.';
                    errPdf.classList.remove('hidden');
                    return;
                }
                if (pdfFile.type !== 'application/pdf') {
                    errPdf.textContent = 'El archivo debe ser un PDF.';
                    errPdf.classList.remove('hidden');
                    return;
                }
            }

            // Deshabilitar botón
            submitButton.disabled = true;
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Procesando...';

            const formData = new FormData(this);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                    // NOTAR: no establecer Content-Type aquí para que el browser ponga multipart/form-data correctamente.
                }
            })
            .then(async response => {
                const contentType = response.headers.get('content-type') || '';
                let data = null;
                if (contentType.includes('application/json')) {
                    data = await response.json();
                } else {
                    // si no es JSON, leer texto para debug
                    const txt = await response.text();
                    throw new Error('Respuesta inesperada del servidor: ' + txt);
                }

                if (response.ok) {
                    if (data.success) {
                        // éxito — redirigir o mostrar mensaje
                        window.location.href = '{{ route("portfolios.index") }}';
                        return;
                    } else {
                        // El backend devolvió JSON pero con success=false
                        throw new Error(data.message || 'Error al crear el portafolio');
                    }
                } else if (response.status === 422) {
                    // Errores de validación de Laravel
                    const errors = data.errors || {};
                    // Mostrar errores inline
                    if (errors.title) { errTitle.textContent = errors.title.join(' '); errTitle.classList.remove('hidden'); }
                    if (errors.description) { errDescription.textContent = errors.description.join(' '); errDescription.classList.remove('hidden'); }
                    if (errors.url_proyect) { errUrlProject.textContent = errors.url_proyect.join(' '); errUrlProject.classList.remove('hidden'); }
                    if (errors.cover_image) { errCover.textContent = errors.cover_image.join(' '); errCover.classList.remove('hidden'); }
                    if (errors.url_pdf) { errPdf.textContent = errors.url_pdf.join(' '); errPdf.classList.remove('hidden'); }
                    formError.textContent = data.message || 'Corrige los campos marcados.';
                    formError.classList.remove('hidden');
                } else {
                    // Otros errores HTTP
                    throw new Error(data.message || 'Error en el servidor (código ' + response.status + ')');
                }
            })
            .catch(error => {
                console.error(error);
                formError.textContent = error.message || 'Error al enviar el formulario.';
                formError.classList.remove('hidden');
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            });
        });
    })();
</script>
@endsection
