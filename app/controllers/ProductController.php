<?php
namespace Formacom\controllers;
use Formacom\Core\Controller;
use Formacom\Models\Category;
use Formacom\Models\Provider;
use Formacom\Models\Address;
use Formacom\Models\Product;
use Formacom\Models\Customer;


class ProductController extends Controller{
    public function index(...$params){
        $this->view('home_product');
    }
   
    public function edit(...$params) {
        if (!isset($params[0])) {
            header("Location: " . base_url() . "product");
            exit();
        }
        
        $productId = $params[0];
        $product = Product::with(['category', 'provider'])->find($productId);
        
        if (!$product) {
            header("Location: " . base_url() . "product");
            exit();
        }
        
        // Cargar categorías y proveedores para los selectores
        $categories = Category::all();
        $providers = Provider::all();
        
        $data = [
            'product' => $product,
            'categories' => $categories,
            'providers' => $providers
        ];
        
        $this->view('/edit', $data);
    }
}
?>