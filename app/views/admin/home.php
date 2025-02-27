<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        
        .dashboard-container {
            min-height: 100vh;
            padding: 2rem;
        }
        
        .btn-dashboard {
            height: 180px;
            margin-bottom: 20px;
            font-size: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: transform 0.3s ease;
        }
        
        .btn-dashboard:hover {
            transform: scale(1.05);
        }
        
        .btn-dashboard i {
            font-size: 4rem;
            margin-bottom: 15px;
        }
        
        .col-dashboard {
            display: flex;
        }
        
        .welcome-header {
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container-fluid dashboard-container">
        <div class="row welcome-header">
            <div class="col-12">
                <h1 class="text-center mb-4"><?php echo $data['mensaje'] ?></h1>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 col-lg-3 col-dashboard">
                <a href="<?=base_url()?>login" class="btn btn-primary btn-dashboard w-100">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </a>
            </div>
            
            <div class="col-md-6 col-lg-3 col-dashboard">
                <a href="<?=base_url()?>customer" class="btn btn-success btn-dashboard w-100">
                    <i class="fas fa-users"></i>
                    Clientes
                </a>
            </div>
            
            <div class="col-md-6 col-lg-3 col-dashboard">
                <a href="<?=base_url()?>provider" class="btn btn-warning btn-dashboard w-100">
                    <i class="fas fa-truck"></i>
                    Proveedores
                </a>
            </div>
            
            <div class="col-md-6 col-lg-3 col-dashboard">
                <a href="<?=base_url()?>product" class="btn btn-danger btn-dashboard w-100">
                    <i class="fas fa-box-open"></i>
                    Productos
                </a>
            </div>
            
            <div class="col-md-6 col-lg-3 col-dashboard mt-4">
                <a href="<?=base_url()?>category" class="btn btn-info btn-dashboard w-100">
                    <i class="fas fa-tags"></i>
                    Categorías
                </a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous"></script>
</body>
</html>