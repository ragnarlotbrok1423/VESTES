<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user']['id'];

function getCartItems($userId) {
    $apiUrl = "http://localhost/ApiRest/Cart/getByUser/$userId";
    $response = file_get_contents($apiUrl);

    if ($response === false) {
        echo "Error al obtener los datos del carrito.";
        return [];
    }

    return json_decode($response, true);
}

$cartItems = getCartItems($userId);

function getAddress($userId) {
    $apiUrl = "http://localhost/ApiRest/Address/getActiveAddress/$userId";
    $response = file_get_contents($apiUrl);

    if ($response === false) {
        echo "Error al obtener la direccion de envio.";
        return [];
    }

    return json_decode($response, true);
}

$address = getAddress($userId);


if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $messageType = $_SESSION['message_type'];
    echo "<div class='alert alert-{$messageType}'>
            {$message}
          </div>";
    
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>


<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="styles.css" rel="stylesheet">
    <script src="cartAddFunctionality.js">

    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.4/dist/flowbite.min.js"></script>
    <title>Cart</title>
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
<body>

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
    <form action="checkout.php" method="POST">
        <button 
            type="submit" 
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded <?php echo empty($cartItems) ? 'opacity-50 cursor-not-allowed' : ''; ?>" 
            <?php echo empty($cartItems) ? 'disabled' : ''; ?>
        >
            Proceder al pago
        </button>
        <?php if (empty($cartItems)): ?>
            <p class="text-red-500 mt-2 text-sm">El carrito está vacío. Agrega productos para continuar.</p>
        <?php endif; ?>
    </form>
</div>
</div>
</body>
</html>
