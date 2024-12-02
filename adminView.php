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

$userData = $_SESSION['user_data'] ?? null;
unset($_SESSION['user_data']);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (empty($id)) {
        header('Location: adminView.php=error');
    } else {
        $editCostumers = getCostumers("getbyid/$id");
    }
}



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
    <div class="flex gap-3">
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

                    </li>

                </ul>
            </nav>
        </aside>

        <section class="dark:bg-gray-900 p-3 w-full gap-6">
            <div class="px-2">
                <!-- Start coding here -->
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div
                        class="flex md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 gap-2">
                        <div class="w-full">
                            <form class="flex items-center justify-between  " method="GET">
                                <label for="simple-search" class="sr-only">Search</label>
                                <div class=" w-1/2">

                                    <input type="text" id="simple-search" name="name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Search by name">
                                </div>
                                <div class="flex gap-3">
                                    <button type="submit"
                                        class="bg-principalColor px-2 py-1 text-white font-sf text-xl rounded-md">Buscar</button>
                                    <button class=" bg-darkColor text-xl text-white font-sf px-2 py-1 rounded-md"
                                        name="edit" data-modal-target="addUserModal" data-modal-toggle="addUserModal"
                                        type="button">Añadir
                                        Usuario</button>
                                </div>

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


                                                <button class="bg-blue-500 rounded-lg p-2 font-sf text-white"
                                                    name="editUserModal" data-modal-target="<?php echo $user['id']; ?>"
                                                    data-modal-toggle="<?php echo $user['id'] ?>" type="submit">
                                                    editar
                                                </button>


                                                <button class=" bg-pointColor rounded-lg p-2 font-sf text-white">
                                                    inhabilitar
                                                </button>
                                            </td>

                                            <!-- Modal -->

                                            <div id="<?php echo $user['id'] ?>" tabindex="-1" aria-hidden="true"
                                                class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-900 ">
                                                <div class="relative w-full max-w-md max-h-full">
                                                    <!-- Modal content -->
                                                    <div class="relative bg-white rounded-lg shadow ">
                                                        <!-- Modal header -->
                                                        <div
                                                            class="flex items-start justify-between p-4 border-b rounded-t-lg bg-principalColor">
                                                            <h3 class="text-xl font-semibold text-white">
                                                                Editar Usuario
                                                            </h3>
                                                            <button type="button"
                                                                class="text-white bg-transparent hover:bg-complementary hover:text-white rounded-lg text-sm p-2 ml-auto inline-flex items-center"
                                                                data-modal-hide="<?php echo $user['id'] ?>">
                                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd"
                                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                                <span class="sr-only">Cerrar modal</span>
                                                            </button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <div class="p-6 space-y-6">
                                                            <form action="editCostumers.php" method="POST">
                                                                <input type="hidden" id="id" name="id"
                                                                    value="<?php echo $user['id'] ?>">
                                                                <div class="mb-4">
                                                                    <label for="userName"
                                                                        class="block mb-2 text-sm font-medium text-darkColor">Name</label>
                                                                    <input type="text" id="name" name="name"
                                                                        value="<?php echo htmlspecialchars($user['name']) ?>"
                                                                        class="bg-bodyColor border border-gray-300 text-darkColor text-sm rounded-lg focus:ring-principalColor focus:border-principalColor block w-full p-2.5"
                                                                        required>
                                                                </div>
                                                                <div class="mb-4">
                                                                    <label for="userEmail"
                                                                        class="block mb-2 text-sm font-medium text-darkColor">Email</label>
                                                                    <input type="email" id="email" name="email"
                                                                        value="<?php echo htmlspecialchars($user['email']) ?>"
                                                                        class="bg-bodyColor border border-gray-300 text-darkColor text-sm rounded-lg focus:ring-principalColor focus:border-principalColor block w-full p-2.5"
                                                                        required>
                                                                </div>
                                                                <div class="mb-4">
                                                                    <label for="Password"
                                                                        class="block mb-2 text-sm font-medium text-darkColor">Password</label>
                                                                    <input type="text" id="password" name="password"
                                                                        value="<?php echo htmlspecialchars($user['password']) ?>"
                                                                        class="bg-bodyColor border border-gray-300 text-darkColor text-sm rounded-lg focus:ring-principalColor focus:border-principalColor block w-full p-2.5"
                                                                        required>
                                                                </div>
                                                                <div class="mb-4">
                                                                    <label for="cellphone"
                                                                        class="block mb-2 text-sm font-medium text-darkColor">CellPhone</label>
                                                                    <input type="text" id="cellphone" name="cellphone"
                                                                        value="<?php echo htmlspecialchars($user['cellphone']) ?>"
                                                                        class="bg-bodyColor border border-gray-300 text-darkColor text-sm rounded-lg focus:ring-principalColor focus:border-principalColor block w-full p-2.5"
                                                                        required>
                                                                </div>
                                                                <div
                                                                    class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                                                                    <button type="submit"
                                                                        class="text-white bg-principalColor hover:bg-complementary focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Guardar
                                                                        cambios</button>
                                                                    <button data-modal-hide="editUserModal" type="button"
                                                                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancelar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- Modal footer -->

                                                    </div>
                                                </div>
                                            </div>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal -->

        <div id="addUserModal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-900 ">
            <div class="relative w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow ">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t-lg bg-principalColor">
                        <h3 class="text-xl font-semibold text-white">
                            CrearUsuario
                        </h3>
                        <button type="button"
                            class="text-white bg-transparent hover:bg-complementary hover:text-white rounded-lg text-sm p-2 ml-auto inline-flex items-center"
                            data-modal-hide="addUserModal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Cerrar modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        <form method="POST" action="addUser.php">

                            <div class="mb-4">
                                <label for="userName" class="block mb-2 text-sm font-medium text-darkColor">Name</label>
                                <input type="text" id="name" name="name"
                                    class="bg-bodyColor border border-gray-300 text-darkColor text-sm rounded-lg focus:ring-principalColor focus:border-principalColor block w-full p-2.5"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label for="userEmail"
                                    class="block mb-2 text-sm font-medium text-darkColor">Email</label>
                                <input type="email" id="email" name="email"
                                    class="bg-bodyColor border border-gray-300 text-darkColor text-sm rounded-lg focus:ring-principalColor focus:border-principalColor block w-full p-2.5"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label for="Password"
                                    class="block mb-2 text-sm font-medium text-darkColor">Password</label>
                                <input type="text" id="password" name="password"
                                    class="bg-bodyColor border border-gray-300 text-darkColor text-sm rounded-lg focus:ring-principalColor focus:border-principalColor block w-full p-2.5"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label for="cellphone"
                                    class="block mb-2 text-sm font-medium text-darkColor">CellPhone</label>
                                <input type="text" id="cellphone" name="cellphone"
                                    class="bg-bodyColor border border-gray-300 text-darkColor text-sm rounded-lg focus:ring-principalColor focus:border-principalColor block w-full p-2.5"
                                    required>
                            </div>
                            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                                <button type="submit"
                                    class="text-white bg-principalColor hover:bg-complementary focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Guardar</button>
                                <button data-modal-hide="editUserModal" type="button"
                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancelar</button>
                            </div>
                        </form>
                    </div>
                    <!-- Modal footer -->

                </div>
            </div>
        </div>


</body>

</html>