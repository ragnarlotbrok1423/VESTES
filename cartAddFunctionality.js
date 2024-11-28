
    document.addEventListener('DOMContentLoaded', () => {
    // Maneja el evento click para los botones de incremento y decremento
    document.querySelectorAll('.increment-btn, .decrement-btn').forEach(button => {
        button.addEventListener('click', (e) => {
            const isIncrement = e.target.classList.contains('increment-btn');
            const productId = e.target.getAttribute('data-id');
            const quantityElement = document.getElementById(`quantity-${productId}`);
            let currentQuantity = parseInt(quantityElement.textContent);

            // Actualiza la cantidad según el botón presionado
            if (isIncrement) {
                currentQuantity++;
            } else if (currentQuantity > 1) {
                currentQuantity--; // Evita que baje de 1
            }

            // Actualiza la interfaz
            quantityElement.textContent = currentQuantity;

            // Opcional: Enviar los cambios al servidor
            updateQuantityOnServer(productId, currentQuantity);
        });
    });
});

    // Función para enviar los cambios al servidor
    function updateQuantityOnServer(productId, newQuantity) {
    fetch('update_cart_quantity.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ product_id: productId, quantity: newQuantity })
    })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Error al actualizar la cantidad.');
            }
        })
        .catch(error => console.error('Error:', error));
}


    // JavaScript to show the spinner when a button is clicked
    document.addEventListener('DOMContentLoaded', function () {
        const spinner = document.getElementById('spinner');
        const buttons = document.querySelectorAll('.decrement-btn, .increment-btn, .delete-btn');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                spinner.classList.remove('hidden');
            });
        });
    });
