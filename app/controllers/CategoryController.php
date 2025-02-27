<?php
namespace Formacom\controllers;
use Formacom\Core\Controller;
use Formacom\Models\Category;

class CategoryController extends Controller {
    public function index(...$params) {
        $categories = Category::all();
        $this->view('/home', ['categories' => $categories]);
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
        $this->view('/create');
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

    public function editCategory(...$params) {
        if (isset($params[0])) {
            $category = Category::find($params[0]);
            if ($category) {
                $this->view('/edit', ['category' => $category]);
                exit();
            }
        }
        header("Location: " . base_url() . "category");
    }

    public function updateCategory(...$params) {
        if (isset($params[0]) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $category = Category::find($params[0]);
            if ($category) {
                $name = $_POST['name'] ?? null;
                $description = $_POST['description'] ?? null;

                if ($name && $description) {
                    $category->name = $name;
                    $category->description = $description;
                    $category->save();
                    
                    header("Location: " . base_url() . "category");
                    exit();
                } else {
                    echo "Por favor, complete todos los campos.";
                }
            }
        }
        header("Location: " . base_url() . "category");
    }

    public function deleteCategory(...$params) {
        if (isset($params[0])) {
            $category = Category::find($params[0]);
            if ($category) {
                $category->delete();
            }
        }
        header("Location: " . base_url() . "category");
    }
}
?>