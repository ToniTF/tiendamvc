<?php
// filepath: /c:/xampp/htdocs/tiendamvc/app/views/product/edit.php
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
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
                    Editar Producto
                </h1>
                <div>
                    <a href="<?= base_url() ?>product" class="btn btn-secondary me-2">Volver</a>
                    <a href="<?= base_url() ?>admin/home" class="btn btn-primary">Inicio</a>
                </div>
            </div>
        </nav>
        
        <div class="card mt-4 mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Editar Producto: <?= $product->name ?></h5>
            </div>
            <div class="card-body">
                <form id="editForm">
                    <input type="hidden" id="product_id" value="<?= $product->product_id ?>">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" value="<?= $product->name ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="description" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="description" value="<?= $product->description ?>">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="category" class="form-label">Categoría</label>
                            <select id="category" class="form-select" required>
                                <option value="">Selecciona una categoría...</option>
                                <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->category_id ?>" <?= $product->category_id == $category->category_id ? 'selected' : '' ?>>
                                    <?= $category->name ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="provider" class="form-label">Proveedor</label>
                            <select id="provider" class="form-select" required>
                                <option value="">Selecciona un proveedor...</option>
                                <?php foreach ($providers as $provider): ?>
                                <option value="<?= $provider->provider_id ?>" <?= $product->provider_id == $provider->provider_id ? 'selected' : '' ?>>
                                    <?= $provider->name ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" min="0" class="form-control" id="stock" value="<?= $product->stock ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label for="cost" class="form-label">Coste</label>
                            <div class="input-group">
                                <span class="input-group-text">€</span>
                                <input type="number" min="0" step="0.01" class="form-control" id="cost" value="<?= $product->cost ?? '0.00' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="vat_type" class="form-label">Tipo de IVA</label>
                            <select id="vat_type" class="form-select" required>
                                <option value="0" <?= ($product->vat_type ?? 21) == 0 ? 'selected' : '' ?>>0%</option>
                                <option value="4" <?= ($product->vat_type ?? 21) == 4 ? 'selected' : '' ?>>4%</option>
                                <option value="10" <?= ($product->vat_type ?? 21) == 10 ? 'selected' : '' ?>>10%</option>
                                <option value="21" <?= ($product->vat_type ?? 21) == 21 ? 'selected' : '' ?>>21%</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="price" class="form-label">Precio</label>
                            <div class="input-group">
                                <span class="input-group-text">€</span>
                                <input type="number" min="0" step="0.01" class="form-control" id="price" value="<?= $product->price ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Panel de información de márgenes (opcional) -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Información de márgenes</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p class="mb-1">Precio sin IVA: <span id="price-display">€<?= number_format($product->price ?? 0, 2) ?></span></p>
                                        </div>
                                        <div class="col-md-4">
                                            <?php 
                                            $price = $product->price ?? 0;
                                            $cost = $product->cost ?? 0;
                                            $margin = $price - $cost;
                                            ?>
                                            <p class="mb-1">Margen: <span id="margin-display">€<?= number_format($margin, 2) ?></span></p>
                                        </div>
                                        <div class="col-md-4">
                                            <?php 
                                            $marginPercent = ($cost > 0) ? ($margin / $cost) * 100 : 0;
                                            ?>
                                            <p class="mb-1">Margen %: <span id="margin-percent-display"><?= number_format($marginPercent, 2) ?>%</span></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <?php
                                            $vatType = $product->vat_type ?? 21;
                                            $vatAmount = $price * ($vatType / 100);
                                            ?>
                                            <p class="mb-1">IVA (<?= $vatType ?>%): <span id="vat-amount-display">€<?= number_format($vatAmount, 2) ?></span></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-1">Precio con IVA: <span id="price-with-vat-display">€<?= number_format($price + $vatAmount, 2) ?></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Actualizar Producto</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous"></script>
    <script>
    // Modifica esta parte de la función updateCalculations:
    function updateCalculations() {
        const price = parseFloat(document.getElementById("price").value) || 0;
        const cost = parseFloat(document.getElementById("cost").value) || 0;
        const vatType = parseInt(document.getElementById("vat_type").value) || 21;
        
        // Calcular valores
        const margin = price - cost;
        // Evitar división por cero
        const marginPercent = cost > 0 ? (margin / cost) * 100 : 0;
        const vatAmount = price * (vatType / 100);
        const priceWithVat = price + vatAmount;
        
        // Actualizar visualización
        document.getElementById("price-display").textContent = `€${price.toFixed(2)}`;
        document.getElementById("margin-display").textContent = `€${margin.toFixed(2)}`;
        document.getElementById("margin-percent-display").textContent = `${marginPercent.toFixed(2)}%`;
        document.getElementById("vat-amount-display").textContent = `€${vatAmount.toFixed(2)}`;
        document.getElementById("price-with-vat-display").textContent = `€${priceWithVat.toFixed(2)}`;
    }
    
    // Escuchar cambios en los campos relevantes para recalcular
    document.getElementById("price").addEventListener("input", updateCalculations);
    document.getElementById("cost").addEventListener("input", updateCalculations);
    document.getElementById("vat_type").addEventListener("change", updateCalculations);
    
    // Manejar envío del formulario
    document.getElementById("editForm").addEventListener("submit", function(e) {
        e.preventDefault();
        
        const productId = document.getElementById("product_id").value;
        
        let product = {
            'product_id': productId,
            'name': document.getElementById("name").value,
            'description': document.getElementById("description").value,
            'category_id': document.getElementById("category").value,
            'provider_id': document.getElementById("provider").value,
            'stock': document.getElementById("stock").value,
            'price': document.getElementById("price").value,
            'cost': document.getElementById("cost").value,
            'vat_type': document.getElementById("vat_type").value
        };
        
        fetch(`${window.location.origin}/tiendamvc/api/updateproduct/${productId}`, {
            method: 'PUT',
            body: JSON.stringify(product),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            alert('Producto actualizado correctamente');
            window.location.href = `${window.location.origin}/tiendamvc/product`;
        })
        .catch(error => {
            console.error("Error al actualizar producto:", error);
            alert('Error al actualizar el producto');
        });
    });
    </script>
</body>

</html>