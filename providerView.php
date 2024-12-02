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

$providers = getProviders();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $cellphone = $_POST['cellphone'];
    $password = $_POST['password'];
    $description = $_POST['description'];

    $data = [
        'name' => $name,
        'password' => $password,
        'desc' => $description,
        'cellphone' => $cellphone

    ];

    $apiUrl = "http://localhost/ApiRest/Provider/create";
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($data)
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($apiUrl, false, $context);
    if ($result === false) {
        echo "Error al crear el proveedor";
    } else {
        header('Location: providerView.php');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $cellphone = $_POST['cellphone'];
    $desc = $_POST['description'];

    $data = [
        'idProvider' => $id,
        'name' => $name,
        'password' => $password,
        'desc' => $desc,
        'cellphone' => $cellphone

    ];

    $apiUrl = "http://localhost/ApiRest/Provider/update";
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($data)
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($apiUrl, false, $context);

    if ($result === false) {
        echo "Error updating provider";
    } else {
        header('Location: providerView.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Providers Management</title>
    <link href="styles.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</head>

<body class=" w-screen bg-[#f0f0f0]">
    <div class="flex gap-3">
        <?php include 'sidebar.php'; ?>

        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Providers Management</h1>

            <!-- Add Provider Form -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-2">Add New Provider</h2>
                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="provider-name">
                            Provider Name
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="name" name="name" type="text" placeholder="Enter provider name" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="provider-phone">
                            Password
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" name="password" type="tel" placeholder="Enter provider phone" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                            Description
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="description" name="description" type="text" placeholder="Enter provider phone" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="provider-phone">
                            Phone
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="cellphone" name="cellphone" type="tel" placeholder="Enter provider phone" required>
                    </div>

                    <div class="flex items-center justify-between">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                            Add Provider
                        </button>
                    </div>
                </form>
            </div>

            <!-- Providers Table -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-2">Providers List</h2>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Provider Name</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Phone</th>
                                <th scope="col" class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($providers as $provider): ?>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        <?php echo $provider['name']; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $provider['email']; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $provider['cellphone']; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button class="font-medium text-blue-600 hover:underline mr-2"
                                            onclick="openEditModal('<?php echo $provider['idProvider']; ?>', '<?php echo $provider['name']; ?>', '<?php echo $provider['password']; ?>', '<?php echo $provider['cellphone']; ?>','<?php echo $provider['desc']; ?>')">
                                            Edit
                                        </button>
                                        <button class="font-medium text-red-600 hover:underline">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Edit Provider Modal (Hidden by default) -->
            <div id="editProviderModal"
                class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                <div class="p-6 w-full max-w-md h-16 bg-white rounded-md shadow-md">
                    <h3 class="text-lg font-semibold mb-4">Edit Provider</h3>
                    <form method="POST" action="">
                        <input type="hidden" id="edit-provider-id" name="id">

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-provider-name">Provider
                                Name</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="edit-provider-name" name="name" type="text" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2"
                                for="edit-provider-passwork">Password</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="edit-provider-password" name="password" type="password" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2"
                                for="edit-provider-phone">Phone</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="edit-provider-phone" name="cellphone" type="tel" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-description">
                                Description
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="edit-description" name="description" type="text"
                                placeholder="Enter provider Description" required>
                        </div>

                        <div class="flex items-center justify-between">
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="submit" name="edit">
                                Update Provider
                            </button>
                            <button
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="button" onclick="closeEditModal()">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        function openEditModal(id, name, email, phone, desc) {
            const modal = document.getElementById('editProviderModal');
            document.getElementById('edit-provider-id').value = id;
            document.getElementById('edit-provider-name').value = name;
            document.getElementById('edit-provider-password').value = password;

            document.getElementById('edit-provider-phone').value = phone;
            document.getElementById('edit-description').value = desc;
            modal.classList.remove('hidden');
        }

        function closeEditModal() {
            const modal = document.getElementById('editProviderModal');
            modal.classList.add('hidden');
        }
    </script>
</body>

</html>