<?php
// filepath: /c:/xampp/htdocs/tiendamvc/app/controllers/OrderController.php
namespace Formacom\controllers;

use Formacom\Core\Controller;
use Formacom\Models\Order;
use Formacom\Models\Product;
use Formacom\Models\Customer;
use Illuminate\Database\Capsule\Manager as DB;

class OrderController extends Controller
{
    public function index(...$params)
    {
        try {
            $orders = Order::with(['customer', 'products'])->get();
            $this->view('/home', ['orders' => $orders]);
        } catch (\Exception $e) {
            // Log error o mostrar mensaje amigable
            echo "Ha ocurrido un error al cargar las órdenes. Por favor, inténtelo de nuevo más tarde.";
            // Si estás en desarrollo, puedes mostrar más detalles:
            if (getenv('APP_ENV') === 'development') {
                echo "<br>Error: " . $e->getMessage();
            }
        }
    }

    public function show(...$params)
    {
        if (isset($params[0])) {
            $order = Order::with(['customer', 'products'])->find($params[0]);
            if ($order) {
                $this->view('/detail', ['order' => $order]);
                exit();
            }
            header("Location: " . base_url() . "order");
        }
    }

    public function newOrder()
    {
        $products = Product::all();
        $customers = Customer::all();
        $this->view("/create", [
            'products' => $products,
            'customers' => $customers
        ]);
    }

    public function storeNewOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customer_id = $_POST['customer_id'] ?? null;
            $discount = $_POST['discount'] ?? 0;
            $date = $_POST['date'] ?? date('Y-m-d');
            $products = $_POST['products'] ?? [];
            $quantities = $_POST['quantities'] ?? [];
            $prices = $_POST['prices'] ?? [];
            
            if ($customer_id && !empty($products)) {
                try {
                    // Iniciar transacción
                    DB::beginTransaction();
                    
                    // Crear la orden
                    $order = new Order();
                    $order->customer_id = $customer_id;
                    $order->date = $date;
                    $order->discount = $discount;
                    $order->save();
                    
                    // Asociar productos a la orden y reducir stock
                    for ($i = 0; $i < count($products); $i++) {
                        if (isset($products[$i]) && isset($quantities[$i]) && isset($prices[$i])) {
                            $product_id = $products[$i];
                            $quantity = $quantities[$i];
                            $price = $prices[$i];
                            
                            if ($product_id && $quantity > 0 && $price > 0) {
                                // Obtener el producto para actualizar su stock
                                $product = Product::find($product_id);
                                if ($product) {
                                    // Verificar si hay suficiente stock
                                    if ($product->stock < $quantity) {
                                        throw new \Exception("Stock insuficiente para el producto: " . $product->name);
                                    }
                                    
                                    // Reducir stock
                                    $product->stock -= $quantity;
                                    $product->save();
                                    
                                    // Usar attach para asociar cada producto con su cantidad y precio
                                    $order->products()->attach($product_id, [
                                        'quantity' => $quantity,
                                        'price' => $price,
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'updated_at' => date('Y-m-d H:i:s')
                                    ]);
                                }
                            }
                        }
                    }
                    
                    // Confirmar transacción
                    DB::commit();
                    
                    header("Location: " . base_url() . "order");
                    exit();
                } catch (\Exception $e) {
                    // Revertir transacción en caso de error
                    DB::rollBack();
                    echo "Error al guardar la orden: " . $e->getMessage();
                }
            } else {
                echo "Por favor, complete todos los campos correctamente y añada al menos un producto.";
            }
        }
    }

    public function editOrder(...$params)
    {
        if (isset($params[0])) {
            $order = Order::with(['products'])->find($params[0]);
            if ($order) {
                $products = Product::all();
                $customers = Customer::all();
                $this->view('/edit', [
                    'order' => $order,
                    'products' => $products,
                    'customers' => $customers
                ]);
                exit();
            }
            header("Location:" . base_url() . "order");
        }
    }

    public function updateOrder(...$params)
    {
        if (isset($params[0]) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $order = Order::find($params[0]);
            if ($order) {
                try {
                    // Iniciar transacción
                    DB::beginTransaction();
                    
                    // Restaurar el stock de los productos actuales antes de la actualización
                    $currentProducts = $order->products;
                    foreach ($currentProducts as $currentProduct) {
                        $currentProduct->stock += $currentProduct->pivot->quantity;
                        $currentProduct->save();
                    }
                    
                    // Actualizar datos de la orden
                    $order->customer_id = $_POST['customer_id'] ?? $order->customer_id;
                    $order->date = $_POST['date'] ?? $order->date;
                    $order->discount = $_POST['discount'] ?? $order->discount;
                    $order->save();
                    
                    // Eliminar productos existentes
                    $order->products()->detach();
                    
                    // Re-asociar productos y reducir stock
                    $products = $_POST['products'] ?? [];
                    $quantities = $_POST['quantities'] ?? [];
                    $prices = $_POST['prices'] ?? [];
                    
                    for ($i = 0; $i < count($products); $i++) {
                        if (isset($products[$i]) && isset($quantities[$i]) && isset($prices[$i])) {
                            $product_id = $products[$i];
                            $quantity = $quantities[$i];
                            $price = $prices[$i];
                            
                            if ($product_id && $quantity > 0 && $price > 0) {
                                // Obtener el producto para actualizar su stock
                                $product = Product::find($product_id);
                                if ($product) {
                                    // Verificar si hay suficiente stock
                                    if ($product->stock < $quantity) {
                                        throw new \Exception("Stock insuficiente para el producto: " . $product->name);
                                    }
                                    
                                    // Reducir stock
                                    $product->stock -= $quantity;
                                    $product->save();
                                    
                                    $order->products()->attach($product_id, [
                                        'quantity' => $quantity,
                                        'price' => $price,
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'updated_at' => date('Y-m-d H:i:s')
                                    ]);
                                }
                            }
                        }
                    }
                    
                    // Confirmar transacción
                    DB::commit();
                    
                    header("Location: " . base_url() . "order/show/" . $order->order_id);
                    exit();
                } catch (\Exception $e) {
                    // Revertir transacción en caso de error
                    DB::rollBack();
                    echo "Error al actualizar la orden: " . $e->getMessage();
                }
            }
        }
        header("Location: " . base_url() . "order");
    }

    public function deleteOrder(...$params)
    {
        if (isset($params[0])) {
            $order = Order::with('products')->find($params[0]);
            if ($order) {
                try {
                    // Iniciar transacción
                    DB::beginTransaction();
                    
                    // Restaurar el stock de los productos
                    foreach ($order->products as $product) {
                        $product->stock += $product->pivot->quantity;
                        $product->save();
                    }
                    
                    // Eliminar la relación con productos
                    $order->products()->detach();
                    
                    // Eliminar la orden
                    $order->delete();
                    
                    // Confirmar transacción
                    DB::commit();
                } catch (\Exception $e) {
                    // Revertir transacción en caso de error
                    DB::rollBack();
                    echo "Error al eliminar la orden: " . $e->getMessage();
                }
            }
        }
        header("Location: " . base_url() . "order");
    }
}
?>