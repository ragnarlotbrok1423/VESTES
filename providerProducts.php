<?php
session_start();
if (!isset($_SESSION['provider'])) {
    header('Location: providerLogin.php');
    exit;
}


if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $messageType = $_SESSION['message_type'];
    echo "<div class='alert alert-{$messageType}'>
            {$message}
          </div>";

    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}

function getProducts()
{
    $id = $_SESSION['provider']['idProvider'];
    $apiUrl = "http://localhost/ApiRest/Products/getByProvider/$id";
    $response = file_get_contents($apiUrl);

    if ($response === false) {
        echo "Error al obtener los datos del carrito.";
        return [];
    }

    return json_decode($response, true);
}

$products = getProducts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
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

        .order-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
        }
    </style>
</head>

<body class=" w-screen bg-[#f0f0f0]">
    <div class="flex gap-3">
        <?php include 'providerSide.php'; ?>

        <section class="dark:bg-gray-900 p-3 w-full gap-6">
            <div class="container mx-auto p-4">
                <div class="px-2">
                    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div class="container mx-auto p-4">
                            <h1 class="text-2xl font-bold mb-4">Products</h1>
                            <div class="order-grid">
                                <?php if (!empty($products)): ?>
                                    <?php foreach ($products as $product): ?>
                                        <?php
                                        $imageUrl = $product['image_url'];
                                        ?>
                                        <div class="bg-white rounded-lg shadow-md p-6">
                                            <div class="flex items-center mb-4">
                                                <img src="http://localhost/ApiRest/<?php echo $imageUrl; ?>" alt="Product"
                                                    class="w-20 h-20 object-cover rounded mr-4">
                                                <div>
                                                    <h2 class="text-xl font-semibold"><?php echo $product['name']; ?>
                                                    </h2>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-gray-700"><span class="font-semibold">Stock:</span>
                                                    <?php echo $product['stock']; ?></p>
                                                <p class="text-gray-700"><span class="font-semibold">Provider:</span>
                                                    <?php echo $product['provider']; ?></p>
                                                <p class="text-gray-700"><span class="font-semibold">Price:</span>
                                                    $<?php echo $product['price']; ?></p>
                                            </div>

                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-gray-700">You have no products .</p>
                                <?php endif; ?>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </section>
    </div>

</body>

</html>