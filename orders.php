<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user']['id'];
function getOrders($userId) {
    $apiUrl = "http://localhost/ApiRest/OrderDetails/getCostumerOrders/$userId";
    $response = file_get_contents($apiUrl);

    if ($response === false) {
        echo "Error al obtener los datos del carrito.";
        return [];
    }

    return json_decode($response, true);
}

$orders = getOrders($userId);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Orders</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <style>
        .order-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Your Orders</h1>
        <div class="order-grid">
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <?php
                $imageUrl = $order['product_image'];
                ?>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <img src="http://localhost/ApiRest/<?php echo $imageUrl; ?>" alt="Product" class="w-20 h-20 object-cover rounded mr-4">
                            <div>
                                <h2 class="text-xl font-semibold">Order #<?php echo $order['orderId']; ?></h2>
                                <p class="text-gray-600"><?php echo $order['product_name']; ?></p>
                            </div>
                        </div>
                        <div class="mb-4">
                            <p class="text-gray-700"><span class="font-semibold">Date:</span> <?php echo $order['dateOrder']; ?></p>
                            <p class="text-gray-700"><span class="font-semibold">Quantity:</span> <?php echo $order['quantity']; ?></p>
                            <p class="text-gray-700"><span class="font-semibold">Total:</span> $<?php echo $order['subtotal']; ?></p>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold bg-yellow-200 text-green-800">
                                <?php echo $order['state']; ?>
                            </span>
                           </div>
                    </div> 
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-700">You have no orders yet.</p>
            <?php endif; ?>

        </div>
    </div>
</body>
</html>
