<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: loginAdmin.php');
    exit;
}
function getProviders()
{
    $apiUrl = "http://localhost/ApiRest/Provider/getAll";
    $response = file_get_contents($apiUrl);
    if ($response === false) {
        echo "Error al obtener los proveedores de la API";
        return [];
    }
    return json_decode($response, true);
}

function getCategories()
{
    $apiUrl = "http://localhost/ApiRest/Categories/getAll";
    $response = file_get_contents($apiUrl);
    if ($response === false) {
        echo "Error al obtener las categorías de la API";
        return [];
    }
    return json_decode($response, true);
}

$categories = getCategories();
$providers = getProviders();


if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-{$_SESSION['message_type']}'>
            {$_SESSION['message']}
          </div>";
    unset($_SESSION['message'], $_SESSION['message_type']);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.4/dist/flowbite.min.js"></script>
    <style>
        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body class=" w-screen bg-[#f0f0f0]">
    <div class="flex gap-3">
        <?php include 'sidebar.php'; ?>

        <section class="dark:bg-gray-900 p-3 w-full gap-6">
            <div class="container mx-auto p-4">
                <div class="px-2">
                    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">Add New Product
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Fill in the form to add a
                                new product.</p>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700">
                            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method='POST' id="productForm"
                                enctype="multipart/form-data">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="product-name">
                                        Product Name
                                    </label>
                                    <input
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="name" name="name" type="text" placeholder="Enter product name" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="product-code">
                                        Product Code
                                    </label>
                                    <input
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="code" name="code" type="text" placeholder="Enter product code" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="stock">
                                        Stock
                                    </label>
                                    <input
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="stock" name="stock" type="number" placeholder="Enter stock quantity"
                                        required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="provider">
                                        Provider
                                    </label>
                                    <select id="provider" name="provider"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        required>
                                        <option value="">Select a provider</option>
                                        <?php foreach ($providers as $provider): ?>
                                            <option value="<?= $provider['idProvider'] ?>">
                                                <?= htmlspecialchars($provider['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="category">
                                        Category
                                    </label>
                                    <select id="categoryId" name="categoryId"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        required>
                                        <option value="">Select a category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category['idCategories'] ?>">
                                                <?= htmlspecialchars($category['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="genre">
                                        Genre
                                    </label>
                                    <select
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="genre" name="genre" required>
                                        <option value="">Select a genre</option>
                                        <option value="1">Men</option>
                                        <option value="2">Women</option>
                                        <option value="3">Unisex</option>
                                        <option value="4">39 tipos de Gay</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="price">
                                        Price
                                    </label>
                                    <input
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="price" name="price" type="number" step="0.01" placeholder="Enter price"
                                        required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                                        Brief Description
                                    </label>
                                    <textarea
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="description" name="description" rows="3"
                                        placeholder="Enter brief description" required></textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="product-image">
                                        Product Image
                                    </label>
                                    <input
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                        type="file" id="image" name="image" accept="image/*" required>
                                </div>
                                <div class="flex items-center justify-between">
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                        type="submit">
                                        Create Product
                                    </button>
                                </div>
                            </form>


                        </div>
        </section>
    </div>
    <script>
        document.getElementById('productForm').addEventListener('submit', async function (event) {
            event.preventDefault(); // Evita el envío directo del formulario.

            const formData = new FormData(this);

            try {
                const response = await fetch('http://localhost/ApiRest/Products/create', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    // Muestra el mensaje de éxito
                    alert(data.message || 'Producto creado exitosamente');
                    window.location.href = '/addProduct.php'; // Redirige si es necesario
                } else {
                    // Maneja errores
                    alert(data.message || 'Error al crear el producto');
                }
            } catch (error) {
                console.error('Error en la solicitud:', error);
                alert('Error inesperado');
            }
        });
    </script>
</body>

</html>