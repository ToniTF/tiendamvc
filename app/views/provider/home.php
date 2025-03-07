<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js" defer></script>
    <script src="<?= base_url() ?>assets/js/tables.js" defer></script>
</head>

<body>
    <div class="container">
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <h1 class="navbar-text">
                    Listado Proveedores
                </h1>
                <div class="d-flex">
                    <a href="<?= base_url() ?>provider/newProvider" class="btn btn-primary me-2">Nuevo Proveedor</a>
                    <a href="<?= base_url() ?>admin/home" class="btn btn-primary">Inicio</a>
                </div>
            </div>
        </nav>
        <table class="table table-dark table-striped" id="providers_table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Operaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($providers as $provider) { ?>
                    <tr>
                        <th scope="row"><?= $provider->provider_id ?></th>
                        <td><?= $provider->name ?></td>
                        <td>
                            <a href="<?= base_url() ?>provider/editProvider/<?= $provider->provider_id ?>">
                                <i class="fa-solid fa-user-pen"></i>
                            </a>
                            <a href="<?= base_url() ?>provider/deleteProvider/<?= $provider->provider_id ?>" onclick="return confirm('¿Está seguro de que desea eliminar este proveedor?')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <a href="<?= base_url() ?>provider/show/<?= $provider->provider_id ?>">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>