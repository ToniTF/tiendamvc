<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Proveedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <h1 class="navbar-text">
                    Detalle Proveedor
                </h1>
                <div class="d-flex">
                    <a href="<?= base_url() ?>provider/newProvider" class="btn btn-primary me-2">Nuevo Proveedor</a>
                    <a href="<?= base_url() ?>provider" class="btn btn-primary me-2">Listado Proveedores</a>
                    <a href="<?= base_url() ?>admin/home" class="btn btn-primary">Inicio</a>
                </div>
            </div>
        </nav>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <?= $provider->name ?>
                </h2>

            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseAddresses" aria-expanded="false" aria-controls="collapseAddresses">
                        Direcciones
                    </button>
                </h2>
                <div id="collapseAddresses" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Street</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Zip</th>
                                    <th scope="col">Country</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($provider->addresses as $key => $address) { ?>
                                    <tr>
                                        <th scope="row"><?= $address->address_id ?></th>
                                        <td><?= $address->street ?></td>
                                        <td><?= $address->city ?></td>
                                        <td><?= $address->zip_code ?></td>
                                        <td><?= $address->country ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapsePhones" aria-expanded="false" aria-controls="collapsePhones">
                        Teléfonos
                    </button>
                </h2>
                <div id="collapsePhones" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($provider->phones as $key => $phone) { ?>
                                    <tr>
                                        <th scope="row"><?= $phone->phone_id ?></th>
                                        <td><?= $phone->number ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseWeb" aria-expanded="false" aria-controls="collapseWeb">
                        Web
                    </button>
                </h2>
                <div id="collapseWeb" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Web</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row"><?= $provider->provider_id ?></th>
                                    <td><?= $provider->web ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>