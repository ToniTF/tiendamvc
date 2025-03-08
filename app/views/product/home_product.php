<?php
// filepath: /c:/xampp/htdocs/tiendamvc/app/views/product/home_product.php
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
       
   
    <style>
        /* Estilo para la tabla con scroll */
        .table-container {
            max-height: 500px;
            overflow-y: auto;
            overflow-x: auto;
        }
        
        .table-container table {
            width: 100%;
            min-width: 800px; /* Asegura que la tabla tenga un ancho mínimo */
        }
        
        /* Mantiene fijo el encabezado mientras se hace scroll */
        .table-container thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 1;
        }
        
        /* Mejora la visualización en pantallas pequeñas */
        @media (max-width: 768px) {
            .table-container {
                max-height: 400px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <h1 class="navbar-text">
                    Productos
                </h1>
                <a href="<?= base_url() ?>admin/home" class="btn btn-primary">Inicio</a>
            </div>
        </nav>
        
        <div class="card mt-4 mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Nuevo Producto</h5>
            </div>
            <div class="card-body">
                <form id="form">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" placeholder="Nombre del producto" required>
                        </div>
                        <div class="col-md-6">
                            <label for="description" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="description" placeholder="Descripción del producto">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="category" class="form-label">Categoría</label>
                            <select id="category" class="form-select" required>
                                <option value="">Selecciona una categoría...</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="provider" class="form-label">Proveedor</label>
                            <select id="provider" class="form-select" required>
                                <option value="">Selecciona un proveedor...</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" min="0" class="form-control" id="stock" placeholder="Cantidad en stock" required>
                        </div>
                        <div class="col-md-3">
                            <label for="cost" class="form-label">Coste</label>
                            <div class="input-group">
                                <span class="input-group-text">€</span>
                                <input type="number" min="0" step="0.01" class="form-control" id="cost" placeholder="Coste" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="vat_type" class="form-label">IVA</label>
                            <select class="form-select" id="vat_type" required>
                                <option value="0">0%</option>
                                <option value="4">4%</option>
                                <option value="10">10%</option>
                                <option value="21" selected>21%</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="price" class="form-label">Precio</label>
                            <div class="input-group">
                                <span class="input-group-text">€</span>
                                <input type="number" min="0" step="0.01" class="form-control" id="price" placeholder="Precio" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Guardar Producto</button>
                </form>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Listado de Productos</h5>
                <span class="badge bg-primary" id="product-count">0 productos</span>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-striped table-hover" id="products_table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Categoría</th>
                                <th scope="col">Proveedor</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Coste</th> <!-- Nueva columna -->
                                <th scope="col">IVA</th>    <!-- Nueva columna -->
                                <th scope="col">Precio</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="products">
                            <!-- Aquí se cargarán los productos dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>assets/js/product.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof loadProducts === 'function') {
                loadProducts();
            } else {
                console.error('La función loadProducts no está disponible.');
            }
        });
    </script>
</body>

</html>