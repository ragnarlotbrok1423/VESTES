<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user']['id'];

function getCartItems($userId) {
    $apiUrl = "http://localhost/apirest/Cart/getByUser/$userId";
    $response = file_get_contents($apiUrl);

    if ($response === false) {
        echo "Error al obtener los datos del carrito.";
        return [];
    }

    return json_decode($response, true);
}

$cartItems = getCartItems($userId);

function getAddress($userId) {
    $apiUrl = "http://localhost/apirest/Address/getActiveAddress/$userId";
    $response = file_get_contents($apiUrl);

    if ($response === false) {
        echo "Error al obtener la direccion de envio.";
        return [];
    }

    return json_decode($response, true);
}

$address = getAddress($userId);
?>


<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="styles.css" rel="stylesheet">
    <script src="cartAddFunctionality.js" />

    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.4/dist/flowbite.min.js"></script>
    <title>Cart</title>
</head>
<body>
<!-- Navbar -->

<?php include 'navbar.php'; ?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Tu Carrito de Compras</h1>

    <!-- Lista de productos -->
    <div class="space-y-4 bg-white p-4 rounded-lg shadow">
         <?php if (!empty($cartItems)): ?>
            <?php $total = 0; ?>
            <?php foreach ($cartItems as $item): ?>
                <?php
                $imageUrl = $item['product_image'];
                if (empty($imageUrl)) {
                    $imageUrl = '/uploads/mati.png';
                }
                $itemTotal = $item['product_price'] * $item['quantity'];
                $total += $itemTotal;
                ?>

      <div class="flex items-center space-x-4 border-b pb-4">


            <img src="http://localhost/ApiRest/<?php echo $imageUrl; ?>"  class="w-20 h-20 object-cover rounded-md">
            <div class="flex-grow">
                <h2 class="font-semibold"><?php echo htmlspecialchars($item['product_name']); ?></h2>
                <p class="text-gray-600">$<?php echo htmlspecialchars($item['product_price']); ?></p>
            </div>


          <!-- increment & decrease Buttons -->
          <div class="flex items-center space-x-2">


              <Form action="changeQuantityProduct.php" method="POST" style="display:inline;" >
              <button class="px-2 py-1 bg-gray-200 rounded decrement-btn" data-id="<?php echo $item['product_id']; ?>">

                  <!--Obtenemos el valor del usuario -->
                  <input type="hidden" name="user_id" value="<?php
                  echo $userId;
                  ?>" >

                    <!--Obtenemos el valor del producto -->
                  <input type="hidden" name="product_id" value="<?php
                  echo $item['product_id'];
                  ?>">

                    <!--Obtenemos la cantidad que queremos cambiar-->
                  <input type="hidden" name="quantity" value="<?php
                  echo $item['quantity'] -1 ;
                  ?>">



                  -</button>
                </Form>

              <span id="quantity-<?php echo $item['product_id']; ?>"><?php echo htmlspecialchars($item['quantity']); ?></span>

              <Form action="changeQuantityProduct.php" method="POST" style="display:inline;" >
              <button class="px-2 py-1 bg-gray-200 rounded increment-btn" data-id="<?php echo $item['product_id']; ?>">

                  <!--Obtenemos el valor del usuario -->
                  <input type="hidden" name="user_id" value="<?php
                  echo $userId;
                  ?>" >

                  <!--Obtenemos el valor del producto -->
                  <input type="hidden" name="product_id" value="<?php
                  echo $item['product_id'];
                  ?>">

                  <!--Obtenemos la cantidad que queremos cambiar-->
                  <input type="hidden" name="quantity" value="<?php
                  echo $item['quantity'] + 1;
                  ?>">

                  +</button>
                </Form>
          </div>


            <p class="font-semibold">$<?php echo number_format($itemTotal, 2); ?></p>
             <form action="delete_cart_item.php" method="POST" style="display: inline;">
            <button type="submit" class="text-red-500 hover:text-red-700">
                <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            </form>

        </div>
        <?php endforeach; ?>
        <?php else: ?>
            <p>Tu carrito está vacío.</p>
        <?php endif; ?>

    </div>

    <!-- Resumen del carrito -->
    <div class="mt-8 bg-white p-4 rounded-lg shadow">
        <div class="flex justify-between mb-2">
            <span>Subtotal:</span>
            <span>$<?php echo number_format($total ?? 0, 2); ?></span>
        </div>
        <div class="flex justify-between mb-2">
            <span>Envío:</span>
            <span>Gratis</span>
        </div>
        <div class="flex justify-between font-bold">
            <span>Total:</span>
            <span>$<?php echo number_format($total ?? 0, 2); ?></span>
        </div>
    </div>

    <!-- Botón de pago -->
    <div class="mt-8">
        <button class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Proceder al pago
        </button>
    </div>
</div>
</body>
</html>
