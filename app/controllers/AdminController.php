<?php
namespace Formacom\controllers;
use Formacom\Core\Controller;

class AdminController extends Controller {
    public function index(...$params) {
        // Puedes pasar datos si es necesario, por ejemplo:
        $data = ["mensaje" => "Bienvenido a la página principal."];
        $this->view("home", $data); // buscará el archivo: ./app/views/admin/home.php
    }
}
?>