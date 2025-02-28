<?php
// filepath: /c:/xampp/htdocs/tiendamvc/app/views/order/detail.php
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Orden #<?= $order->order_id ?></title>
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
                    Detalle de Orden #<?= $order->order_id ?>
                </h1>
                <div class="d-flex">
                    <a href="<?= base_url() ?>order/editOrder/<?= $order->order_id ?>" class="btn btn-primary me-2">Editar</a>
                    <a href="<?= base_url() ?>order" class="btn btn-primary me-2">Listado Órdenes</a>
                    <a href="<?= base_url() ?>admin/home" class="btn btn-primary">Inicio</a>
                </div>
            </div>
        </nav>

        <div class="card mt-4">
            <div class="card-header">
                <h4>Información de la Orden</h4>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <p><strong>ID:</strong> <?= $order->order_id ?></p>
                        <p><strong>Fecha:</strong> <?= date('d/m/Y', strtotime($order->date)) ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Cliente:</strong> <?= $order->customer ? $order->customer->name : 'N/A' ?></p>
                        <p><strong>Descuento:</strong> <?= $order->discount ?>%</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Creado:</strong> <?= date('d/m/Y H:i', strtotime($order->created_at)) ?></p>
                        <p><strong>Actualizado:</strong> <?= date('d/m/Y H:i', strtotime($order->updated_at)) ?></p>
                    </div>
                </div>

                <h5 class="mt-4 mb-3">Productos</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($order->products) > 0): ?>
                                <?php foreach ($order->products as $product): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if(!empty($product->image_url)): ?>
                                            <img src="<?= $product->image_url ?>" alt="<?= $product->name ?>" class="img-thumbnail me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                            <?php endif; ?>
                                            <div>
                                                <strong><?= $product->name ?></strong>
                                                <?php if(!empty($product->sku)): ?>
                                                <div><small class="text-muted">SKU: <?= $product->sku ?></small></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center"><?= $product->pivot->quantity ?></td>
                                    <td class="text-end">€<?= number_format($product->pivot->price, 2) ?></td>
                                    <td class="text-end">€<?= number_format($product->pivot->quantity * $product->pivot->price, 2) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No hay productos asociados a esta orden.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end">Subtotal:</td>
                                <td class="text-end">€<?= number_format($order->getTotal() / (1 - ($order->discount / 100)), 2) ?></td>
                            </tr>
                            <?php if ($order->discount > 0): ?>
                            <tr>
                                <td colspan="3" class="text-end">Descuento (<?= $order->discount ?>%):</td>
                                <td class="text-end">-€<?= number_format(($order->getTotal() / (1 - ($order->discount / 100))) * ($order->discount / 100), 2) ?></td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total:</td>
                                <td class="text-end fw-bold">€<?= number_format($order->getTotal(), 2) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <?php if ($order->customer): ?>
                <div class="mt-4">
                    <h5>Información del Cliente</h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Nombre:</strong> <?= $order->customer->name ?></p>
                                    
                                    <?php if ($order->customer->phones && count($order->customer->phones) > 0): ?>
                                    <p><strong>Teléfono:</strong> <?= $order->customer->phones[0]->number ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="col-md-6">
                                    <?php if ($order->customer->addresses && count($order->customer->addresses) > 0): ?>
                                    <p><strong>Dirección:</strong> <?= $order->customer->addresses[0]->street ?></p>
                                    
                                    <?php if (!empty($order->customer->addresses[0]->city)): ?>
                                    <p><strong>Ciudad:</strong> <?= $order->customer->addresses[0]->city ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($order->customer->addresses[0]->zip_code)): ?>
                                    <p><strong>Código Postal:</strong> <?= $order->customer->addresses[0]->zip_code ?></p>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>