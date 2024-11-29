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

<nav class="bg-white shadow-sm px-4 py-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <!-- Logo -->
        <div class="flex-shrink-0">
            <a href="index.php">
                <span class="text-4xl font-gokhan text-darkColor">VESTES</span>
            </a>

        </div>

        <!-- Barra de búsqueda -->
        <div class="flex-1 max-w-3xl mx-8 ">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 58 58" fill="none">
                        <path d="M26.0033 31.9967C20.3483 26.3417 20.3483 17.1583 26.0033 11.4792C31.6583 5.82416 40.8417 5.82416 46.5208 11.4792C52.1758 17.1342 52.1758 26.3175 46.5208 31.9967C40.8658 37.6517 31.6825 37.6517 26.0033 31.9967Z" stroke="#6F6B6B" stroke-width="5.16667" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M25.375 32.625L7.25 50.75" stroke="#6F6B6B" stroke-width="5.16667" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <input
                    type="text"
                    placeholder="Search Dress..."
                    class="w-full pl-14 pr-4 py-2 rounded-[47px] bg-[#ccc6c6] text-[#6F6B6B] border-none focus:outline-none font-ubuntu focus:ring-2 focus:ring-gray-200"
                >
            </div>
        </div>

        <!-- Iconos de la derecha -->
        <div class="flex items-center space-x-4">
            <button class="text-[#1a2e1a] hover:text-gray-700 bg-darkColor rounded-full p-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="28" viewBox="0 0 37 38" fill="none">
                    <path d="M4.29665 4.01501C4.44242 3.97197 4.59524 3.95809 4.74638 3.97417C4.89751 3.99024 5.04399 4.03596 5.17744 4.1087C5.31089 4.18144 5.42869 4.27977 5.52411 4.39808C5.61952 4.51639 5.69067 4.65235 5.73349 4.79818L6.58141 7.66876H29.1745C32.0112 7.66876 34.1772 10.3158 33.3602 13.08L30.8087 21.7133C30.266 23.5541 28.5409 24.7812 26.6231 24.7812H12.5076C10.5897 24.7812 8.86616 23.5541 8.32195 21.7133L3.51657 5.45338C3.42953 5.1594 3.46281 4.84289 3.6091 4.57344C3.75539 4.304 4.0027 4.10214 4.29665 4.01501ZM9.63545 30.5625C9.63545 29.6425 10.0009 28.7602 10.6514 28.1097C11.3019 27.4592 12.1842 27.0937 13.1042 27.0937C14.0242 27.0937 14.9065 27.4592 15.557 28.1097C16.2075 28.7602 16.5729 29.6425 16.5729 30.5625C16.5729 31.4825 16.2075 32.3648 15.557 33.0153C14.9065 33.6658 14.0242 34.0312 13.1042 34.0312C12.1842 34.0312 11.3019 33.6658 10.6514 33.0153C10.0009 32.3648 9.63545 31.4825 9.63545 30.5625ZM21.9688 30.5625C21.9688 30.107 22.0585 29.6559 22.2328 29.2351C22.4071 28.8142 22.6627 28.4318 22.9848 28.1097C23.3069 27.7876 23.6893 27.5321 24.1101 27.3578C24.531 27.1835 24.982 27.0937 25.4375 27.0937C25.8931 27.0937 26.3441 27.1835 26.765 27.3578C27.1858 27.5321 27.5682 27.7876 27.8903 28.1097C28.2124 28.4318 28.4679 28.8142 28.6422 29.2351C28.8166 29.6559 28.9063 30.107 28.9063 30.5625C28.9063 31.4825 28.5408 32.3648 27.8903 33.0153C27.2398 33.6658 26.3575 34.0312 25.4375 34.0312C24.5176 34.0312 23.6353 33.6658 22.9848 33.0153C22.3342 32.3648 21.9688 31.4825 21.9688 30.5625Z" fill="#E6E6E6"/>
                </svg>
            </button>
            <button class="text-[#1a2e1a] hover:text-gray-700 bg-darkColor p-1 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="28" viewBox="0 0 37 38" fill="none">
                    <path d="M18.5 3.58334C20.0246 3.58334 21.5149 4.03543 22.7826 4.88243C24.0502 5.72943 25.0382 6.93331 25.6216 8.34182C26.205 9.75034 26.3577 11.3002 26.0603 12.7955C25.7628 14.2908 25.0287 15.6643 23.9507 16.7423C22.8726 17.8203 21.4991 18.5545 20.0039 18.8519C18.5086 19.1493 16.9587 18.9967 15.5502 18.4132C14.1417 17.8298 12.9378 16.8418 12.0908 15.5742C11.2438 14.3066 10.7917 12.8162 10.7917 11.2917L10.7994 10.9571C10.8856 8.97262 11.7346 7.098 13.1693 5.72419C14.604 4.35039 16.5137 3.58346 18.5 3.58334ZM21.5834 22.0833C23.6278 22.0833 25.5884 22.8955 27.034 24.3411C28.4796 25.7867 29.2917 27.7473 29.2917 29.7917V31.3333C29.2917 32.1511 28.9669 32.9353 28.3886 33.5136C27.8104 34.0918 27.0261 34.4167 26.2084 34.4167H10.7917C9.97396 34.4167 9.1897 34.0918 8.61146 33.5136C8.03322 32.9353 7.70837 32.1511 7.70837 31.3333V29.7917C7.70837 27.7473 8.5205 25.7867 9.96609 24.3411C11.4117 22.8955 13.3723 22.0833 15.4167 22.0833H21.5834Z" fill="#E6E6E6"/>
                </svg>
            </button>
        </div>
    </div>
</nav>
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
