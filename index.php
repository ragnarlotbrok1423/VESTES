<?php
session_start();

function getProductsFromAPI($endpoint)
{
    $apiUrl = "http://localhost/ApiRest/products/$endpoint";
    $response = file_get_contents($apiUrl);


    if ($response === false) {
        echo "Error al obtener los productos de la API";
        return [];
    }

    return json_decode($response, true);
}


if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $products = getProductsFromAPI("getByCategoryIndex/$category");
} else {

    $products = getProductsFromAPI("getAll");
}
?>


<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="styles.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.4/dist/flowbite.min.js"></script>
    <style>
        
        .search-results {
            position: absolute;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 100%;
            max-width: 600px;
            z-index: 10;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .search-results.hidden {
            display: none;
        }

        .search-item {
            padding: 10px;
            cursor: pointer;
        }

        .search-item:hover {
            background-color: #f0f0f0;
        }
    </style>
    <title>VESTES</title>
</head>

<body class="bg-[#f0f0f0]">

<!-- Navbar -->
   <?php include 'navbar.php'; ?>

    <!-- zona de categorias -->
    <img src="svg/hero%20section.svg" class="pt-16 px-10" />


    <div class="items-center flex flex-wrap gap-2 justify-center pt-24 ">


        <form method="get">
            <button
                class="toggle-btn px-4 py-2 rounded-full border border-purple-500 text-purple-500 font-medium hover:bg-purple-100 focus:bg-purple-500 focus:text-white"
                type="submit" name="category" value="3">
                Shirts
            </button>
            <button
                type="submit" name="category" value="4"
                class="toggle-btn px-4 py-2 rounded-full border border-purple-500 text-purple-500 font-medium hover:bg-purple-100 focus:bg-purple-500 focus:text-white">

                Pants
            </button>
            <button
                type="submit" name="category" value="5"
                class="toggle-btn px-4 py-2 rounded-full border border-purple-500 text-purple-500 font-medium hover:bg-purple-100 focus:bg-purple-500 focus:text-white">
                Jeans
            </button>
            <button
                type="submit" name="category" value="5"
                class="toggle-btn px-4 py-2 rounded-full border border-purple-500 text-purple-500 font-medium hover:bg-purple-100 focus:bg-purple-500 focus:text-white">
                Jerseys
            </button>
            <button
                type="submit" name="category" value="6"
                class="toggle-btn px-4 py-2 rounded-full border border-purple-500 text-purple-500 font-medium hover:bg-purple-100 focus:bg-purple-500 focus:text-white">
                Coats
            </button>
            <button
                type="submit" name="category" value="7"
                class="toggle-btn px-4 py-2 rounded-full border border-purple-500 text-purple-500 font-medium hover:bg-purple-100 focus:bg-purple-500 focus:text-white">
                Tops
            </button>
            <button
                type="submit" name="category" value="8"
                class="toggle-btn px-4 py-2 rounded-full border border-purple-500 text-purple-500 font-medium hover:bg-purple-100 focus:bg-purple-500 focus:text-white">
                Legins
            </button>

        </form>


    </div>




    <div class="flex flex-wrap justify-center gap-3 pt-16 pb-12 w-full">
        <?php
        if (!empty($products)) {
            foreach ($products as $product) {
                $imageUrl = $product['image_url'];
                if (empty($imageUrl)) {
                    $imageUrl = '/uploads/mati.png';
                }
                ?>
             
                <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="productDetail.php?id=<?php echo $product['idProducts']; ?>">
                        <img class="p-8 rounded-t-lg w-[336px]" src="http://localhost/ApiRest/<?php echo $imageUrl; ?>" alt="" />
                    </a>
                    <div class="px-5 pb-5">
                        <a href="#">
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </h5>
                        </a>
                        <div class="flex items-center mt-2.5 mb-5">
                 
                        </div>
                        <div class="flex items-center justify-between">
                            <form action="buyProduct.php" method="POST">
                                <?php if (isset($_SESSION['user']['id'])): ?>
                                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['id']; ?>">
                                <?php endif; ?>
                                <input type="hidden" name="product_id" value="<?php echo $product['idProducts']; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <span class="text-3xl font-bold text-gray-900 dark:text-white">
                                $<?php echo $product['price']; ?>
                            </span>
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Add to cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
            }
        } else {
            echo "No hay productos disponibles.";
        }
            ?>



                </div>





    </div>
        <form id="redirectForm" method="POST" action="productDetail.php" style="display: none;">
        <input type="hidden" name="productId" id="productId">
    </form>
   <script>
        const searchBar = document.getElementById('searchBar');
        const searchResults = document.getElementById('searchResults');
        const redirectForm = document.getElementById('redirectForm');
        const productIdInput = document.getElementById('productId');

        searchBar.addEventListener('input', async (e) => {
            const query = e.target.value.trim();

            if (query.length > 0) {
                try {
                    const response = await fetch(`http://localhost/apirest/Products/search/${encodeURIComponent(query)}`);
                    const results = await response.json();

                   
                    searchResults.innerHTML = '';

                    if (results.length > 0) {
                        results.forEach(product => {
                            const item = document.createElement('div');
                            item.className = 'search-item';
                            item.textContent = product.name;

                          
                            item.addEventListener('click', () => {
                                productIdInput.value = product.idProducts;
                                redirectForm.submit();
                            });

                            searchResults.appendChild(item);
                        });

                        searchResults.classList.remove('hidden');
                    } else {
                        searchResults.innerHTML = '<div class="search-item">No se encontraron resultados</div>';
                        searchResults.classList.remove('hidden');
                    }
                } catch (error) {
                    console.error('Error al buscar productos:', error);
                }
            } else {
                searchResults.classList.add('hidden');
            }
        });

        document.addEventListener('click', (e) => {
            if (!searchBar.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
    </script>
</body>

</html>