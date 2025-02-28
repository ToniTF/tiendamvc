<?php
// filepath: /c:/xampp/htdocs/tiendamvc/app/views/order/edit.php
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Orden #<?= $order->order_id ?></title>
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
                    Editar Orden #<?= $order->order_id ?>
                </h1>
                <div class="d-flex">
                    <a href="<?= base_url() ?>order/show/<?= $order->order_id ?>" class="btn btn-primary me-2">Ver Detalles</a>
                    <a href="<?= base_url() ?>order" class="btn btn-primary me-2">Listado Órdenes</a>
                    <a href="<?= base_url() ?>admin/home" class="btn btn-primary">Inicio</a>
                </div>
            </div>
        </nav>

        <div class="card mt-4">
            <div class="card-body">
                <form action="<?= base_url() ?>order/updateOrder/<?= $order->order_id ?>" method="post">
                    
                    <!-- Datos básicos de la orden -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Cliente</label>
                                <select class="form-select" id="customer_id" name="customer_id" required>
                                    <option value="">Seleccione un cliente</option>
                                    <?php foreach ($customers as $customer): ?>
                                    <option value="<?= $customer->customer_id ?>" <?= ($order->customer_id == $customer->customer_id) ? 'selected' : '' ?>>
                                        <?= $customer->name ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="date" name="date" value="<?= date('Y-m-d', strtotime($order->date)) ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="discount" class="form-label">Descuento (%)</label>
                                <input type="number" class="form-control" id="discount" name="discount" min="0" max="100" step="0.01" value="<?= $order->discount ?>" onchange="calculateTotal()">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Productos -->
                    <h4>Productos</h4>
                    <div id="products-container">
                        <?php if (count($order->products) > 0): ?>
                            <?php foreach ($order->products as $index => $product): ?>
                            <div class="product-row row mb-3 align-items-end">
                                <div class="col-md-4">
                                    <label for="products[<?= $index ?>]" class="form-label">Producto</label>
                                    <select class="form-select product-select" name="products[]" required onchange="updatePrice(this)">
                                        <option value="">Seleccione un producto</option>
                                        <?php foreach ($products as $p): ?>
                                        <option value="<?= $p->product_id ?>" 
                                                data-price="<?= $p->price ?>"
                                                <?= ($product->product_id == $p->product_id) ? 'selected' : '' ?>>
                                            <?= $p->name ?> - €<?= number_format($p->price, 2) ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <label for="quantities[<?= $index ?>]" class="form-label">Cantidad</label>
                                    <input type="number" class="form-control quantity-input" name="quantities[]" min="1" value="<?= $product->pivot->quantity ?>" required onchange="calculateSubtotal(this)">
                                </div>
                                
                                <div class="col-md-2">
                                    <label for="prices[<?= $index ?>]" class="form-label">Precio (€)</label>
                                    <input type="number" class="form-control price-input" name="prices[]" step="0.01" min="0" value="<?= $product->pivot->price ?>" required onchange="calculateSubtotal(this)">
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Subtotal (€)</label>
                                    <input type="text" class="form-control subtotal-input" value="<?= number_format($product->pivot->quantity * $product->pivot->price, 2) ?>" readonly>
                                </div>
                                
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger remove-product" onclick="removeProductRow(this)" <?= ($index === 0 && count($order->products) === 1) ? 'disabled' : '' ?>>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
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
                                    <input type="number" class="form-control quantity-input" name="quantities[]" value="1" min="1" required onchange="calculateSubtotal(this)">
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
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <button type="button" class="btn btn-success mb-3" onclick="addProductRow()">
                            <i class="fas fa-plus"></i> Añadir Producto
                        </button>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <!-- Campo oculto para detectar productos eliminados -->
                            <input type="hidden" name="original_products_count" value="<?= count($order->products) ?>">
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">Subtotal:</span>
                                <input type="text" class="form-control" id="subtotal" value="0.00" readonly>
                                <span class="input-group-text">€</span>
                            </div>
                            
                            <div class="input-group mt-2">
                                <span class="input-group-text">Descuento:</span>
                                <input type="text" class="form-control" id="discount-amount" value="0.00" readonly>
                                <span class="input-group-text">€</span>
                            </div>
                            
                            <div class="input-group mt-2">
                                <span class="input-group-text fw-bold">Total:</span>
                                <input type="text" class="form-control fw-bold" id="total" value="<?= number_format($order->getTotal(), 2) ?>" readonly>
                                <span class="input-group-text fw-bold">€</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url() ?>order" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Ejecutar al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            // Primero asegurarse de que cada subtotal esté calculado correctamente
            document.querySelectorAll('.product-row').forEach(row => {
                const priceInput = row.querySelector('.price-input');
                const quantityInput = row.querySelector('.quantity-input');
                const subtotalInput = row.querySelector('.subtotal-input');
                
                const price = parseFloat(priceInput.value) || 0;
                const quantity = parseInt(quantityInput.value) || 0;
                const subtotal = price * quantity;
                
                subtotalInput.value = subtotal.toFixed(2);
            });
            
            // Luego calcular el total general
            calculateTotal();
            
            // Añadir evento para cuando se modifique manualmente el precio o la cantidad
            document.querySelectorAll('.price-input, .quantity-input').forEach(input => {
                input.addEventListener('input', function() {
                    calculateSubtotal(this);
                });
            });
        });
        
        // Actualizar precio al seleccionar un producto
        function updatePrice(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const price = selectedOption.getAttribute('data-price') || 0;
            
            const productRow = selectElement.closest('.product-row');
            productRow.querySelector('.price-input').value = parseFloat(price).toFixed(2);
            calculateSubtotal(selectElement);
        }
        
        // Calcular subtotal por fila
        function calculateSubtotal(element) {
            const productRow = element.closest('.product-row');
            const price = parseFloat(productRow.querySelector('.price-input').value) || 0;
            const quantity = parseInt(productRow.querySelector('.quantity-input').value) || 0;
            const subtotal = price * quantity;
            
            productRow.querySelector('.subtotal-input').value = subtotal.toFixed(2);
            calculateTotal();
        }
        
        // Calcular el total general
        function calculateTotal() {
            let subtotal = 0;
            document.querySelectorAll('.subtotal-input').forEach(input => {
                subtotal += parseFloat(input.value) || 0;
            });
            
            const discountPercent = parseFloat(document.getElementById('discount').value) || 0;
            const discountAmount = subtotal * (discountPercent / 100);
            const total = subtotal - discountAmount;
            
            document.getElementById('subtotal').value = subtotal.toFixed(2);
            document.getElementById('discount-amount').value = discountAmount.toFixed(2);
            document.getElementById('total').value = total.toFixed(2);
        }
        
        // Añadir nueva fila de producto
        function addProductRow() {
            const container = document.getElementById('products-container');
            const productRows = container.querySelectorAll('.product-row');
            const newIndex = productRows.length;
            
            const newRow = document.createElement('div');
            newRow.classList.add('product-row', 'row', 'mb-3', 'align-items-end');
            newRow.innerHTML = `
                <div class="col-md-4">
                    <label for="products[${newIndex}]" class="form-label">Producto</label>
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
                    <label for="quantities[${newIndex}]" class="form-label">Cantidad</label>
                    <input type="number" class="form-control quantity-input" name="quantities[]" min="1" value="1" required onchange="calculateSubtotal(this)">
                </div>
                
                <div class="col-md-2">
                    <label for="prices[${newIndex}]" class="form-label">Precio (€)</label>
                    <input type="number" class="form-control price-input" name="prices[]" step="0.01" min="0" value="0.00" required onchange="calculateSubtotal(this)">
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Subtotal (€)</label>
                    <input type="text" class="form-control subtotal-input" value="0.00" readonly>
                </div>
                
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove-product" onclick="removeProductRow(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            
            container.appendChild(newRow);
            
            // Añadir eventos a los campos nuevos
            const newInputs = newRow.querySelectorAll('.price-input, .quantity-input');
            newInputs.forEach(input => {
                input.addEventListener('input', function() {
                    calculateSubtotal(this);
                });
            });
            
            // Habilitar el botón de eliminar en la primera fila si ahora hay más de una fila
            if (productRows.length === 1) {
                const firstRowButton = productRows[0].querySelector('.remove-product');
                if (firstRowButton) {
                    firstRowButton.disabled = false;
                }
            }
        }
        
        // Eliminar fila de producto
        function removeProductRow(button) {
            const productRows = document.querySelectorAll('.product-row');
            
            // No permitir eliminar la última fila
            if (productRows.length <= 1) {
                return;
            }
            
            const productRow = button.closest('.product-row');
            productRow.remove();
            calculateTotal();
            
            // Si solo queda una fila, desactivar su botón de eliminar
            if (document.querySelectorAll('.product-row').length === 1) {
                const lastRowButton = document.querySelector('.product-row .remove-product');
                if (lastRowButton) {
                    lastRowButton.disabled = true;
                }
            }
        }
    </script>
</body>

</html>