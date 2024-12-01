<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

function getCostumers($endpoint)
{
    $apiUrl = "http://localhost/ApiRest/costumer/$endpoint";
    $response = file_get_contents($apiUrl);

    if ($response == false) {
        echo 'Error al obtener los usuario';
        return [];
    }
    return json_decode($response, true);
}

// Debugging: Print session data
error_log(print_r($_SESSION, true));

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    if (empty($name)) {
        $costumers = getCostumers("getall");
    } else {
        $costumers = getCostumers("getbyname/$name");
    }
} else {
    $costumers = getCostumers("getall");
}



// Get debug data

?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.4/dist/flowbite.min.js"></script>
    <title>Document</title>
</head>

<body class=" w-screen bg-[#f0f0f0]">
    <div class="flex gap-6">
        <!-- Sidebar -->
        <aside class="w-64 bg-principalColor text-white p-6 min-h-screen">
            <div class="pb-12 mt-3">
                <a class="text-4xl text-white font-gokhan" href="login.php">VESTES</a>
            </div>
            <div class="pb-12">
                <h1><?php echo htmlspecialchars($_SESSION['user']['name']) ?></h1>
                <h1><?php echo htmlspecialchars($_SESSION['user']['email']) ?></h1>
            </div>
            <nav>
                <ul class="space-y-2">
                    <li><a href="adminView.php" class="block py-2 px-4 hover:bg-pointColor rounded">Usuarios</a></li>
                    <li><a href="productsAdmin.php" class="block py-2 px-4 hover:bg-pointColor rounded">Productos</a>
                    </li>

                </ul>
            </nav>
        </aside>

        <section class="dark:bg-gray-900 p-3 w-full gap-6">
            <div class="px-4">
                <!-- Start coding here -->
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div
                        class="flex md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 gap-2">
                        <div class="w-full">
                            <form class="flex items-center" method="GET">
                                <label for="simple-search" class="sr-only">Search</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="simple-search" name="name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Search">
                                </div>
                                <button type="submit"
                                    class="bg-principalColor px-2 py-1 text-white font-ubuntu text-xl rounded-md">Buscar</button>
                            </form>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Name</th>
                                    <th scope="col" class="px-4 py-3">Password</th>
                                    <th scope="col" class="px-4 py-3">Email</th>
                                    <th scope="col" class="px-4 py-3">Cellphone</th>
                                    <th scope="col" class="px-4 py-3">Actions</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($costumers)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No results found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($costumers as $user): ?>
                                        <tr class="border-b dark:border-gray-700">
                                            <th scope="row"
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <?php echo htmlspecialchars($user['name']) ?>
                                            </th>
                                            <td class="px-4 py-3"><?php echo htmlspecialchars($user['password']) ?></td>
                                            <td class="px-4 py-3"><?php echo htmlspecialchars($user['email']) ?></td>
                                            <td class="px-4 py-3"><?php echo htmlspecialchars($user['cellphone']) ?></td>
                                            <td class="px-4 py-3 flex items-center justify-end gap-3">
                                                <button class="bg-blue-500 rounded-lg p-2 font-sf text-white">editar</button>
                                                <button
                                                    class="bg-pointColor rounded-lg p-2 font-sf text-white">inhabilitar</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>


</body>

</html>