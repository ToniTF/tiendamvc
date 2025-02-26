<?php
namespace Formacom\controllers;

use Formacom\Core\Controller;
use Formacom\Models\Address;
use Formacom\Models\Phone;
use Formacom\Models\Provider;

class ProviderController extends Controller {
    public function index(...$params) {
        $providers = Provider::all();
        $this->view('/home', ['providers' => $providers]); // Asegúrate de que la vista home esté en la carpeta provider
    }

    public function show(...$params) {
        if (isset($params[0])) {
            $provider = Provider::find($params[0]);
            if ($provider) {
                $this->view('/detail', ['provider' => $provider]); // Asegúrate de que la vista detail esté en la carpeta provider
                exit();
            }
            header("Location: " . base_url() . "provider");
        }
    }

    public function newProvider() {
        $this->view("/create"); // Asegúrate de que la vista create esté en la carpeta provider
    }

    public function storeNewProvider() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? null;
            $web = $_POST['web'] ?? null;
            $street = $_POST['street'] ?? null;
            $city = $_POST['city'] ?? null;
            $zip_code = $_POST['zip_code'] ?? null;
            $country = $_POST['country'] ?? null;
            $phone_number = $_POST['phone_number'] ?? null;

            if ($name && $street && $city && $zip_code && $country && $phone_number) {
                $provider = new Provider();
                $provider->name = $name;
                $provider->web = $web;
                $provider->save();

                $address = new Address();
                $address->provider_id = $provider->provider_id; // Asegúrate de que la clave foránea sea correcta
                $address->street = $street;
                $address->city = $city;
                $address->zip_code = $zip_code;
                $address->country = $country;
                $address->save();

                $phone = new Phone();
                $phone->provider_id = $provider->provider_id; // Asegúrate de que la clave foránea sea correcta
                $phone->number = $phone_number;
                $phone->save();

                header("Location: " . base_url() . "provider");
            } else {
                echo "Por favor, complete todos los campos.";
            }
        }
    }
}
?>