<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.4/dist/flowbite.min.js"></script>
    <title>Document</title>
</head>

<body>
    <!-- Registro -->
    <div class="min-h-screen flex items-center justify-center bg-principalColor">
        <div class="flex w-full max-w-6xl mx-4">
            <!-- Lado izquierdo - Ilustración -->
            <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-12">
                <div class="relative">
                    <div class="absolute inset-0 bg-principalColor  rounded-3xl"></div>
                    <img src="svg/ilustracion.png" alt="Ilustración" class="relative z-10 opacity-75">
                </div>
            </div>

            <!-- Lado derecho - Formulario -->
            <div class="w-full lg:w-1/2 bg-white rounded-3xl p-8 shadow-xl">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 font-gokhan">VESTES</h2>
                </div>

                <!-- Formulario que se enviará a signup.php -->
                <form id="signup-form" method="POST" action="signup.php" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre Completo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Please enter your name">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter your email">
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone number</label>
                            <input type="tel" name="cellphone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter your phone number">
                        </div>

                        <!-- Contraseña -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter your password">
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm password</label>
                            <input type="password" name="confirm-password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Confirm your password">
                        </div>
                    </div>

                    <!-- Botón de registro -->
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center space-x-2">
                        <span>Sign Up</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <p class="text-center text-sm text-gray-600">
                        Already have an account?
                        <a href="login.php" class="text-blue-600 hover:underline">Sign in</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <script>
        function validatePasswords(event) {
            const password = document.querySelector('input[name="password"]').value;
            const confirmPassword = document.querySelector('input[name="confirm-password"]').value;
            if (password !== confirmPassword) {
                alert("Las contraseñas no coinciden.");
                event.preventDefault();
                return false;
            }


            if (password.length < 6) {
                alert("La contraseña debe tener al menos 6 caracteres.");
                event.preventDefault();
                return false;
            }

            return true;
        }
        document.getElementById('signup-form').addEventListener('submit', validatePasswords);
    </script>
</body>

</html>