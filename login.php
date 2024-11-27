<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.4/dist/flowbite.min.js"></script>
    <title>Login</title>
</head>
<body>
<div class="min-h-screen flex items-center justify-center bg-principalColor">
    <div class="w-full max-w-md mx-4">
        <div class="bg-white rounded-3xl p-8 shadow-xl">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 font-gokhan">VESTES</h2>
            </div>

            <form class="space-y-6" action="loginValidation.php" method="POST">
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter your email" id="email" name="email" required>
                </div>

                <!-- Contraseña -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter your password" id="password" name="password" required>
                </div>

                <!-- Botón de login -->
                <button type="submit" class="w-full bg-darkColor   text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                    Login
                </button>

                <p class="text-center text-sm text-gray-600">
                    Don't have an account?
                    <a href="#" class="text-blue-600 hover:underline">Sign up</a>
                </p>
            </form>
        </div>
    </div>
</div>
</body>
</html>
