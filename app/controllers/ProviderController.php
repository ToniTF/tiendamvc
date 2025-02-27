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
            $provider = Provider::with(['addresses', 'phones'])->find($params[0]);
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

    public function editProvider(...$params) {
        if(isset($params[0])) {
            $provider = Provider::with(['addresses', 'phones'])->find($params[0]);
            if($provider){
                $this->view('/edit', ['provider' => $provider]);
                exit();
            }
            header("Location:".base_url()."provider");
        }
    }

    public function updateProvider(...$params) {
        if(isset($params[0]) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $provider = Provider::find($params[0]);
            if($provider){
                // Actualizar datos básicos del proveedor
                $provider->name = $_POST['name'] ?? $provider->name;
                $provider->web = $_POST['web'] ?? $provider->web;
                $provider->save();
                
                // Actualizar direcciones existentes
                if(isset($_POST['addresses']) && is_array($_POST['addresses'])) {
                    foreach($_POST['addresses'] as $address_id => $address_data) {
                        $address = Address::find($address_id);
                        if($address && $address->provider_id == $provider->provider_id) {
                            $address->street = $address_data['street'] ?? $address->street;
                            $address->city = $address_data['city'] ?? $address->city;
                            $address->zip_code = $address_data['zip_code'] ?? $address->zip_code;
                            $address->country = $address_data['country'] ?? $address->country;
                            $address->save();
                        }
                    }
                }
                
                // Añadir nuevas direcciones
                if(isset($_POST['new_addresses']) && is_array($_POST['new_addresses'])) {
                    foreach($_POST['new_addresses'] as $new_address) {
                        if(!empty($new_address['street']) && !empty($new_address['city']) && 
                           !empty($new_address['zip_code']) && !empty($new_address['country'])) {
                            
                            $address = new Address();
                            $address->provider_id = $provider->provider_id;
                            $address->street = $new_address['street'];
                            $address->city = $new_address['city'];
                            $address->zip_code = $new_address['zip_code'];
                            $address->country = $new_address['country'];
                            $address->save();
                        }
                    }
                }
                
                // Eliminar direcciones marcadas
                if(isset($_POST['delete_addresses']) && is_array($_POST['delete_addresses'])) {
                    foreach($_POST['delete_addresses'] as $address_id) {
                        $address = Address::find($address_id);
                        if($address && $address->provider_id == $provider->provider_id) {
                            $address->delete();
                        }
                    }
                }
                
                // Actualizar teléfonos existentes
                if(isset($_POST['phones']) && is_array($_POST['phones'])) {
                    foreach($_POST['phones'] as $phone_id => $phone_data) {
                        $phone = Phone::find($phone_id);
                        if($phone && $phone->provider_id == $provider->provider_id) {
                            $phone->number = $phone_data['number'] ?? $phone->number;
                            $phone->save();
                        }
                    }
                }
                
                // Añadir nuevos teléfonos
                if(isset($_POST['new_phones']) && is_array($_POST['new_phones'])) {
                    foreach($_POST['new_phones'] as $new_phone) {
                        if(!empty($new_phone['number'])) {
                            $phone = new Phone();
                            $phone->provider_id = $provider->provider_id;
                            $phone->number = $new_phone['number'];
                            $phone->save();
                        }
                    }
                }
                
                // Eliminar teléfonos marcados
                if(isset($_POST['delete_phones']) && is_array($_POST['delete_phones'])) {
                    foreach($_POST['delete_phones'] as $phone_id) {
                        $phone = Phone::find($phone_id);
                        if($phone && $phone->provider_id == $provider->provider_id) {
                            $phone->delete();
                        }
                    }
                }
                
                header("Location: " . base_url() . "provider/show/" . $provider->provider_id);
                exit();
            }
        }
        header("Location: " . base_url() . "provider");
    }

    public function deleteProvider(...$params) {
        if (isset($params[0])) {
            $provider = Provider::find($params[0]);
            if ($provider) {
                // Eliminar direcciones asociadas
                $provider->addresses()->delete();
                // Eliminar teléfonos asociados
                $provider->phones()->delete();
                // Eliminar el proveedor
                $provider->delete();
            }
        }
        header("Location: " . base_url() . "provider");
    }
    
    // Métodos auxiliares para añadir/eliminar direcciones y teléfonos de forma individual
    public function addAddress(...$params) {
        if(isset($params[0]) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $provider = Provider::find($params[0]);
            if($provider) {
                $street = $_POST['street'] ?? null;
                $city = $_POST['city'] ?? null;
                $zip_code = $_POST['zip_code'] ?? null;
                $country = $_POST['country'] ?? null;
                
                if($street && $city && $zip_code && $country) {
                    $address = new Address();
                    $address->provider_id = $provider->provider_id;
                    $address->street = $street;
                    $address->city = $city;
                    $address->zip_code = $zip_code;
                    $address->country = $country;
                    $address->save();
                }
                
                header("Location: " . base_url() . "provider/editProvider/" . $provider->provider_id);
                exit();
            }
        }
        header("Location: " . base_url() . "provider");
    }
    
    public function deleteAddress(...$params) {
        if(isset($params[0])) {
            $address = Address::find($params[0]);
            if($address) {
                $provider_id = $address->provider_id;
                $address->delete();
                header("Location: " . base_url() . "provider/editProvider/" . $provider_id);
                exit();
            }
        }
        header("Location: " . base_url() . "provider");
    }
    
    public function addPhone(...$params) {
        if(isset($params[0]) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $provider = Provider::find($params[0]);
            if($provider) {
                $number = $_POST['number'] ?? null;
                
                if($number) {
                    $phone = new Phone();
                    $phone->provider_id = $provider->provider_id;
                    $phone->number = $number;
                    $phone->save();
                }
                
                header("Location: " . base_url() . "provider/editProvider/" . $provider->provider_id);
                exit();
            }
        }
        header("Location: " . base_url() . "provider");
    }
    
    public function deletePhone(...$params) {
        if(isset($params[0])) {
            $phone = Phone::find($params[0]);
            if($phone) {
                $provider_id = $phone->provider_id;
                $phone->delete();
                header("Location: " . base_url() . "provider/editProvider/" . $provider_id);
                exit();
            }
        }
        header("Location: " . base_url() . "provider");
    }
}
?>