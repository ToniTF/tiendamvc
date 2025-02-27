<?php
// filepath: /c:/xampp/htdocs/tiendamvc/app/views/customer/edit.php
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
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
                    Editar Cliente
                </h1>
                <div class="d-flex">
                    <a href="<?= base_url() ?>customer/show/<?= $data->customer_id ?>" class="btn btn-primary me-2">Ver Cliente</a>
                    <a href="<?= base_url() ?>customer" class="btn btn-primary me-2">Listado Clientes</a>
                    <a href="<?= base_url() ?>admin/home" class="btn btn-primary">Inicio</a>
                </div>
            </div>
        </nav>

        <form action="<?= base_url() ?>customer/updateCustomer/<?= $data->customer_id ?>" method="post">
            <!-- Información básica del cliente -->
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $data->name ?>" required>
            </div>

            <!-- Direcciones -->
            <h3>Direcciones</h3>
            <div class="addresses-container">
                <?php foreach ($data->addresses as $clave=> $address): ?>
                    <div class="card mb-3 address-card">
                        <div class="card-body">
                            <div class="mb-2 d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Dirección <?= $clave+1 ?></h5>
                                <div class="form-check">
                                    <input class="form-check-input delete-address" type="checkbox" name="delete_addresses[]" value="<?= $address->address_id ?>" id="delete-address-<?= $address->address_id ?>">
                                    <label class="form-check-label text-danger" for="delete-address-<?= $address->address_id ?>">
                                        Eliminar
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="street-<?= $address->address_id ?>" class="form-label">Calle</label>
                                    <input type="text" class="form-control" id="street-<?= $address->address_id ?>" name="addresses[<?= $address->address_id ?>][street]" value="<?= $address->street ?>" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="city-<?= $address->address_id ?>" class="form-label">Ciudad</label>
                                    <input type="text" class="form-control" id="city-<?= $address->address_id ?>" name="addresses[<?= $address->address_id ?>][city]" value="<?= $address->city ?>" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="zipcode-<?= $address->address_id ?>" class="form-label">Código Postal</label>
                                    <input type="text" class="form-control" id="zipcode-<?= $address->address_id ?>" name="addresses[<?= $address->address_id ?>][zip_code]" value="<?= $address->zip_code ?>" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="country-<?= $address->address_id ?>" class="form-label">País</label>
                                    <input type="text" class="form-control" id="country-<?= $address->address_id ?>" name="addresses[<?= $address->address_id ?>][country]" value="<?= $address->country ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- Nueva dirección template -->
                <div id="new-address-template" class="card mb-3 address-card d-none">
                    <div class="card-body">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Nueva Dirección</h5>
                            <button type="button" class="btn btn-sm btn-danger remove-address">Eliminar</button>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Calle</label>
                                <input type="text" class="form-control" name="new_addresses[0][street]">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Ciudad</label>
                                <input type="text" class="form-control" name="new_addresses[0][city]">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Código Postal</label>
                                <input type="text" class="form-control" name="new_addresses[0][zip_code]">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">País</label>
                                <input type="text" class="form-control" name="new_addresses[0][country]">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenedor para nuevas direcciones -->
                <div id="new-addresses-container"></div>

                <button type="button" class="btn btn-secondary mb-3" id="add-address">
                    <i class="fas fa-plus"></i> Añadir Dirección
                </button>
            </div>

            <!-- Teléfonos -->
            <h3>Teléfonos</h3>
            <div class="phones-container">
                <?php foreach ($data->phones as $clave=>$phone): ?>
                    <div class="card mb-3 phone-card">
                        <div class="card-body">
                            <div class="mb-2 d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Teléfono <?= $clave+1 ?></h5>
                                <div class="form-check">
                                    <input class="form-check-input delete-phone" type="checkbox" name="delete_phones[]" value="<?= $phone->phone_id ?>" id="delete-phone-<?= $phone->phone_id ?>">
                                    <label class="form-check-label text-danger" for="delete-phone-<?= $phone->phone_id ?>">
                                        Eliminar
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="number-<?= $phone->phone_id ?>" class="form-label">Número</label>
                                    <input type="text" class="form-control" id="number-<?= $phone->phone_id ?>" name="phones[<?= $phone->phone_id ?>][number]" value="<?= $phone->number ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- Nueva teléfono template -->
                <div id="new-phone-template" class="card mb-3 phone-card d-none">
                    <div class="card-body">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Nuevo Teléfono</h5>
                            <button type="button" class="btn btn-sm btn-danger remove-phone">Eliminar</button>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="form-label">Número</label>
                                <input type="text" class="form-control" name="new_phones[0][number]">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenedor para nuevos teléfonos -->
                <div id="new-phones-container"></div>

                <button type="button" class="btn btn-secondary mb-3" id="add-phone">
                    <i class="fas fa-plus"></i> Añadir Teléfono
                </button>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Guardar Cambios</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variables para contar nuevos elementos
            let newAddressCount = 0;
            let newPhoneCount = 0;
            
            // Función para añadir nueva dirección
            document.getElementById('add-address').addEventListener('click', function() {
                const template = document.getElementById('new-address-template');
                const container = document.getElementById('new-addresses-container');
                
                // Clonar la plantilla
                const newAddress = template.cloneNode(true);
                newAddress.classList.remove('d-none');
                newAddress.id = '';
                
                // Actualizar los nombres de los campos
                const inputs = newAddress.querySelectorAll('input');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name', name.replace('[0]', '[' + newAddressCount + ']'));
                    }
                });
                
                // Añadir evento para eliminar
                const removeBtn = newAddress.querySelector('.remove-address');
                removeBtn.addEventListener('click', function() {
                    newAddress.remove();
                });
                
                // Añadir al contenedor
                container.appendChild(newAddress);
                newAddressCount++;
            });
            
            // Función para añadir nuevo teléfono
            document.getElementById('add-phone').addEventListener('click', function() {
                const template = document.getElementById('new-phone-template');
                const container = document.getElementById('new-phones-container');
                
                // Clonar la plantilla
                const newPhone = template.cloneNode(true);
                newPhone.classList.remove('d-none');
                newPhone.id = '';
                
                // Actualizar los nombres de los campos
                const inputs = newPhone.querySelectorAll('input');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name', name.replace('[0]', '[' + newPhoneCount + ']'));
                    }
                });
                
                // Añadir evento para eliminar
                const removeBtn = newPhone.querySelector('.remove-phone');
                removeBtn.addEventListener('click', function() {
                    newPhone.remove();
                });
                
                // Añadir al contenedor
                container.appendChild(newPhone);
                newPhoneCount++;
            });
        });
    </script>
</body>

</html>