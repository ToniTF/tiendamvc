<?php
namespace Formacom\controllers;
use Formacom\Core\Controller;
use Formacom\Models\Provider;
use Formacom\Models\Address;
use Formacom\Models\Phone;
use Formacom\Models\Customer;
use Formacom\Models\Product;
use Formacom\Models\Category;

class ApiController extends Controller {
    public function index(...$params) {
       
    }
    public function categories() {
        $categories = Category::all();
        $json=json_encode($categories);
        header('Content-Type: application/json');
        echo $json;
        exit();
    }
}
?>