<?php
namespace Formacom\controllers;
use Formacom\Core\Controller;
use Formacom\Models\Customer;
use Formacom\Models\Address;
use Formacom\Models\Category;
use Formacom\Models\Provider;
use Formacom\Models\Product;

class ApiController extends Controller{
    public function index(...$params){
        
    }

    public function categories() {
        $categories = Category::all();
        $json = json_encode($categories);
        header('Content-Type: application/json');
        echo $json;
        exit();
    }
    
    public function providers() {
        $providers = Provider::all();
        $json = json_encode($providers);
        header('Content-Type: application/json');
        echo $json;
        exit();
    }
    
    /**
     * Devuelve todos los productos con sus categorías y proveedores
     */
    public function products() {
        $products = Product::with(['category', 'provider'])->get();
        $json = json_encode($products);
        header('Content-Type: application/json');
        echo $json;
        exit();
    }
    
    public function newproduct(){
        // Leer el contenido JSON enviado
        $jsonData = file_get_contents('php://input');
        // Decodificar el JSON
        $data = json_decode($jsonData, true);
        
        // Verificar si se pudo decodificar correctamente
        if ($data === null) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'JSON inválido']);
            exit();
        }
        
        try {
            // Registrar los datos recibidos para depuración
            error_log("Datos recibidos en newproduct: " . print_r($data, true));
            
            // Crear y guardar el nuevo producto
            $product = new Product();
            $product->name = $data['name'];
            $product->description = $data['description'];
            $product->category_id = $data['category_id'];
            $product->provider_id = $data['provider_id'];
            $product->stock = $data['stock'];
            $product->price = $data['price'];
            $product->cost = $data['cost'] ?? 0; // Añadido campo cost
            $product->vat_type = $data['vat_type'] ?? 21; // Añadido campo vat_type
            $product->save();
            
            // Devolver todos los productos actualizados con sus relaciones
            $products = Product::with(['category', 'provider'])->get();
            
            // Enviar respuesta
            header('Content-Type: application/json');
            echo json_encode($products);
        } catch (\Exception $e) {
            // En caso de error, devolver mensaje de error
            error_log("Error en newproduct: " . $e->getMessage());
            http_response_code(500); // Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Error al guardar: ' . $e->getMessage()]);
        }
        exit();
    }
    
    /**
     * Elimina un producto por su ID
     */
    public function deleteproduct(...$params) {
        if (isset($params[0])) {
            $productId = $params[0];
            $product = Product::find($productId);
            
            if ($product) {
                $product->delete();
                
                // Devolver todos los productos actualizados
                $products = Product::with(['category', 'provider'])->get();
                
                $response = [
                    'success' => true, 
                    'message' => 'Producto eliminado correctamente',
                    'products' => $products
                ];
            } else {
                $response = ['success' => false, 'message' => 'Producto no encontrado'];
            }
            
            $json = json_encode($response);
            header('Content-Type: application/json');
            echo $json;
            exit();
        }
        
        // Si no se proporciona ID, devolver error
        $response = ['success' => false, 'message' => 'ID de producto no especificado'];
        $json = json_encode($response);
        header('Content-Type: application/json');
        http_response_code(400);
        echo $json;
        exit();
    }
    
    /**
     * Actualiza un producto existente
     */
    public function updateproduct(...$params) {
        if (!isset($params[0])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID de producto no especificado']);
            exit();
        }
        
        $productId = $params[0];
        $product = Product::find($productId);
        
        if (!$product) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
            exit();
        }
        
        // Leer el contenido JSON enviado
        $jsonData = file_get_contents('php://input');
        // Decodificar el JSON
        $data = json_decode($jsonData, true);
        
        // Verificar si se pudo decodificar correctamente
        if ($data === null) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'JSON inválido']);
            exit();
        }
        
        try {
            // Actualizar el producto
            $product->name = $data['name'];
            $product->description = $data['description'];
            $product->category_id = $data['category_id'];
            $product->provider_id = $data['provider_id'];
            $product->stock = $data['stock'];
            $product->price = $data['price'];
            $product->cost = $data['cost'] ?? $product->cost; // Añadido campo cost
            $product->vat_type = $data['vat_type'] ?? $product->vat_type; // Añadido campo vat_type
            $product->save();
            
            // Obtener todos los productos actualizados
            $products = Product::with(['category', 'provider'])->get();
            
            // Enviar respuesta
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true, 
                'message' => 'Producto actualizado correctamente',
                'products' => $products
            ]);
        } catch (\Exception $e) {
            // En caso de error, devolver mensaje de error
            error_log("Error en updateproduct: " . $e->getMessage());
            http_response_code(500); // Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Error al actualizar: ' . $e->getMessage()]);
        }
        exit();
    }
}
?>