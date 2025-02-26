<?php
namespace Formacom\controllers;
use Formacom\Core\Controller;
use Formacom\Models\Category;

class CategoryController extends Controller {
    public function index(...$params) {
        $categories = Category::all();
        $this->view('home', ['categories' => $categories]); // Asegúrate de que la vista home esté en la carpeta category
    }

    public function show(...$params) {
        if (isset($params[0])) {
            $category = Category::find($params[0]);
            if ($category) {
                $this->view('detail', ['category' => $category]); // Asegúrate de que la vista detail esté en la carpeta category
                exit();
            }
            header("Location: " . base_url() . "category");
        }
    }

    public function newCategory() {
        $this->view("create"); // Asegúrate de que la vista create esté en la carpeta category
    }

    public function storeNewCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? null;
            $description = $_POST['description'] ?? null;

            if ($name && $description) {
                $category = new Category();
                $category->name = $name;
                $category->description = $description;
                $category->save();
            
                header("Location: " . base_url() . "category");
            } else {
                echo "Por favor, complete todos los campos.";
            }
        }
    }

    public function deleteCategory(...$params) {
        if (isset($params[0])) {
            $category = Category::find($params[0]);
            if ($category) {
                // Eliminar la categoría
                $category->delete();
            }
        }
        header("Location: " . base_url() . "category");
    }
}
?>