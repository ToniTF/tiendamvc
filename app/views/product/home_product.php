<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/product.js" defer></script>
</head>

<body>
    <div class="container">
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <h1 class="navbar-text">
                    Listado Productos
                </h1>
                <a href="<?= base_url() ?>product/newProduct" class="btn btn-primary">Nuevo Producto</a>
                <a href="<?= base_url() ?>admin/home" class="btn btn-primary">Inicio</a>
            </div>
        </nav>
        <form id="form">
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Product name" required>
                </div>
                <div class="form-group col-12">
                    <label for="street">Description</label>
                    <input type="text" class="form-control" id="description" placeholder="Product Description">
                </div>
            </div>
            <div class="form-group">
                <label for="inputAddress">Categoria</label>
                <select id="category" required>
                    <option selected>Selecciona...</option>

                </select>
            </div>
            <div class="form-group">
                <label for="">Provider</label>
                <select id="provider" required>
                    <option selected>Selecciona...</option>

                </select>
            </div>
            <div class="row">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="stock">Stock</label>
                    <input type="number" min="0" class="form-control" id="stock" placeholder="Stock">
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="price">Price</label>
                    <input type="number" min="0" class="form-control" id="price" placeholder="Price">
                </div>
            </div>


            <button type="submit" class="btn col-12 btn-primary">Save</button>
        </form>
        <hr>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Proveedor</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Precio</th>
                </tr>
            <tbody id="products">


            </tbody>
            </thead>
        </table>
    </div>
</body>

</html>