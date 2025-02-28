<?php
// filepath: /c:/xampp/htdocs/tiendamvc/app/views/order/create.php
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Orden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <h1 class="navbar-text">
                    Nueva Orden
                </h1>
                <div class="d-flex">
                    <a href="<?= base_url() ?>order" class="btn btn-primary me-2">Listado Órdenes</a>
                    <a href="<?= base_url() ?>admin/home" class="btn btn-primary">Inicio</a>
                </div>
            </div>
        </nav>

        <div class="card mt-4">
            <div class="card-body">
                <form action="<?= base_url() ?>order/storeNewOrder" method="post">
                    
                    <!-- Datos básicos de la orden -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Cliente</label>
                                <select class="form-select" id="customer_id" name="customer_id" required>
                                    <option value="">Seleccione un cliente</option>
                                    <?php foreach ($customers as $customer): ?>
                                    <option value="<?= $customer->customer_id ?>">
                                        <?= $customer->name ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="date" name="date" value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="discount" class="form-label">Descuento (%)</label>
                                <input type="number" class="form-control" id="discount" name="discount" min="0" max="100" step="0.01" value="0">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Productos -->
                    <h4>Productos</h4>
                    <div id="products-container">
                        <div class="product-row row mb-3 align-items-end">
                            <div class="col-md-4">
                                <label for="products[0]" class="form-label">Producto</label>
                                <select class="form-select product-select" name="products[]" required onchange="updatePrice(this)">
                                    <option value="">Seleccione un producto</option>
                                    <?php foreach ($products as $product): ?>
                                    <option value="<?= $product->product_id ?>" data-price="<?= $product->price ?>">
                                        <?= $product->name ?> - €<?= number_format($product->price, 2) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-2">
                                <label for="quantities[0]" class="form-label">Cantidad</label>
                                <input type="number" class="form-control quantity-input" name="quantities[]" min="1" value="1" required onchange="calculateSubtotal(this)">
                            </div>
                            
                            <div class="col-md-2">
                                <label for="prices[0]" class="form-label">Precio (€)</label>
                                <input type="number" class="form-control price-input" name="prices[]" step="0.01" min="0" value="0.00" required onchange="calculateSubtotal(this)">
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label">Subtotal (€)</label>
                                <input type="text" class="form-control subtotal-input" value="0.00" readonly>
                            </div>
                            
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger remove-product" onclick="removeProductRow(this)" disabled>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-3 mb-4">
                        <button type="button" class="btn btn-secondary" onclick="addProductRow()">
                            <i class="fas fa-plus"></i> Añadir Producto
                        </button>
                        
                        <div class="text-end">
                            <p class="mb-0"><strong>Total: </strong><span id="order-total">€0.00</span></p>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Crear Orden</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let productRowCount = 1;
        
        function addProductRow() {
            const container = document.getElementById('products-container');
            const newRow = container.querySelector('.product-row').cloneNode(true);
            
            // Resetear valores
            newRow.querySelector('.product-select').value = '';
            newRow.querySelector('.quantity-input').value = '1';
            newRow.querySelector('.price-input').value = '0.00';
            newRow.querySelector('.subtotal-input').value = '0.00';
            
            // Habilitar el botón de eliminar
            newRow.querySelector('.remove-product').disabled = false;
            
            // Añadir la nueva fila
            container.appendChild(newRow);
            
            // Incrementar contador
            productRowCount++;
            
            // Recalcular total
            calculateTotal();
        }
        
        function removeProductRow(button) {
            const row = button.closest('.product-row');
            if (document.querySelectorAll('.product-row').length > 1) {
                row.remove();
                calculateTotal();
            }
        }
        
        function updatePrice(select) {
            const row = select.closest('.product-row');
            const priceInput = row.querySelector('.price-input');
            const selectedOption = select.options[select.selectedIndex];
            const price = selectedOption.getAttribute('data-price') || 0;
            
            priceInput.value = parseFloat(price).toFixed(2);
            calculateSubtotal(priceInput);
        }
        
        function calculateSubtotal(input) {
            const row = input.closest('.product-row');
            const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const subtotal = quantity * price;
            
            row.querySelector('.subtotal-input').value = subtotal.toFixed(2);
            calculateTotal();
        }
        
        function calculateTotal() {
            let total = 0;
            const subtotals = document.querySelectorAll('.subtotal-input');
            
            subtotals.forEach(function(input) {
                total += parseFloat(input.value) || 0;
            });
            
            // Aplicar descuento si existe
            const discount = parseFloat(document.getElementById('discount').value) || 0;
            if (discount > 0) {
                total = total * (1 - (discount / 100));
            }
            
            document.getElementById('order-total').textContent = '€' + total.toFixed(2);
        }
        
        // Inicializar cálculos
        document.getElementById('discount').addEventListener('input', calculateTotal);
        
        // Iniciar con una fila de producto
        document.addEventListener('DOMContentLoaded', function() {
            const productSelects = document.querySelectorAll('.product-select');
            productSelects.forEach(function(select) {
                select.dispatchEvent(new Event('change'));
            });
        });
    </script>
</body>

</html>