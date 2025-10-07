@extends('layouts.new-user')

@section('content')

    {{-- Mensajes de error --}}
    @if ($errors->any())
        <div class="mb-6 max-w-md mx-auto">
            <x-alert type="error">
                <div>
                    <p class="font-semibold mb-2">¡Oops! Algo salió mal.</p>
                    <ul class="space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-center">
                                <i class="fas fa-dot-circle mr-2 text-xs"></i>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </x-alert>
        </div>
    @endif

    <div class="max-w-md mx-auto animate-fade-in-up">
        <x-card variant="enhanced" hover padding="p-8">
            <!-- Header del formulario -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-4 animate-pulse-slow shadow-lg">
                    <i class="fas fa-lock text-3xl text-white"></i>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">
                    <span class="bg-gradient-to-r from-blue-800 to-gray-700 bg-clip-text text-transparent">
                        Iniciar Sesión
                    </span>
                </h1>
                <p class="text-gray-600 text-lg">Accede a tu cuenta para continuar</p>
            </div>

            <form action="{{ route('inicia-sesion') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email con componente -->
                <x-input
                    label="Correo Electrónico"
                    name="email"
                    type="email"
                    icon="fas fa-envelope"
                    placeholder="ejemplo@correo.com"
                    :value="old('email')"
                    :error="$errors->first('email')"
                    required
                />

                <!-- Password con componente -->
                <div>
                    <label for="passwordInput" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-key text-blue-600 mr-1"></i>
                        Contraseña
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            id="passwordInput"
                            name="password"
                            placeholder="********"
                            required
                            class="form-input-enhanced w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 pr-12"
                        >
                        <button type="button" id="togglePassword" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-600 focus:outline-none transition-colors">
                            <i id="eyeIcon" class="fas fa-eye text-lg"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Botón con componente -->
                <x-button
                    type="submit"
                    variant="primary"
                    size="lg"
                    icon="fas fa-sign-in-alt"
                    class="w-full"
                >
                    INICIAR SESIÓN
                </x-button>
                <div class="text-center space-y-3">
                    <a href="#" class="block text-blue-600 hover:text-blue-700 text-sm transition-colors">
                        <i class="fas fa-key mr-1"></i>
                        ¿Olvidaste tu contraseña?
                    </a>

                    <div class="divider-gradient my-4"></div>

                    <p class="text-gray-600">
                        ¿No tienes cuenta?
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-medium transition-colors">
                            <i class="fas fa-user-plus mr-1"></i>
                            Regístrate aquí
                        </a>
                    </p>
                </div>
            </form>
        </x-card>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#passwordInput');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'password') {
                eyeIcon.className = 'fas fa-eye';
            } else {
                eyeIcon.className = 'fas fa-eye-slash';
            }
        });
    </script>
@endsection
