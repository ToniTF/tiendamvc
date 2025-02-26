<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <h1 class="navbar-text">
                    Nuevo Cliente
                </h1>
                <a href="<?= base_url() ?>customer" class="btn btn-primary">Listado Clientes</a>
                <a href="<?= base_url() ?>admin/home" class="btn btn-primary">Inicio</a>
            </div>
        </nav>
        <form action="<?= base_url() ?>customer/storeNewCustomer" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="street" class="form-label">Calle</label>
                <input type="text" class="form-control" id="street" name="street" required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">Ciudad</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="mb-3">
                <label for="zip_code" class="form-label">Código Postal</label>
                <input type="text" class="form-control" id="zip_code" name="zip_code" required>
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">País</label>
                <input type="text" class="form-control" id="country" name="country" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</body>

</html>