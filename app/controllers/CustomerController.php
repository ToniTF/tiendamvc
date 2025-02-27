<?php
namespace Formacom\controllers;
use Formacom\Core\Controller;
use Formacom\Models\Customer;
use Formacom\Models\Address;
use Formacom\Models\Phone;

class CustomerController extends Controller{
    public function index(...$params){
        $customers = Customer::all();
        $this->view('/home', $customers);
    }

    public function show(...$params){
        if(isset($params[0])) {
            $customer = Customer::find($params[0]);
            if($customer){
                $this->view('/detail', $customer);
                exit();
            }
            header("Location:".base_url()."customer");
        }
    }

    public function newCustomer() {
        $this->view("/create");
    }

    public function storeNewCustomer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? null;
            $street = $_POST['street'] ?? null;
            $city = $_POST['city'] ?? null;
            $zip_code = $_POST['zip_code'] ?? null;
            $country = $_POST['country'] ?? null;
            $phone_number = $_POST['phone_number'] ?? null;

            if ($name && $street && $city && $zip_code && $country && $phone_number) {
                $customer = new Customer();
                $customer->name = $name;
                $customer->save();

                $address = new Address();
                $address->customer_id = $customer->customer_id;
                $address->street = $street;
                $address->city = $city;
                $address->zip_code = $zip_code;
                $address->country = $country;
                $address->save();

                $phone = new Phone();
                $phone->customer_id = $customer->customer_id;
                $phone->number = $phone_number;
                $phone->save();

                header("Location: " . base_url() . "customer");
            } else {
                echo "Por favor, complete todos los campos.";
            }
        }
    }

    public function editCustomer(...$params) {
        if(isset($params[0])) {
            $customer = Customer::with(['addresses', 'phones'])->find($params[0]);
            if($customer){
                $this->view('/edit', $customer);
                exit();
            }
            header("Location:".base_url()."customer");
        }
    }

    public function updateCustomer(...$params) {
        if(isset($params[0]) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $customer = Customer::find($params[0]);
            if($customer){
                // Actualizar datos básicos del cliente
                $customer->name = $_POST['name'] ?? $customer->name;
                $customer->save();
                
                // Actualizar direcciones existentes
                if(isset($_POST['addresses']) && is_array($_POST['addresses'])) {
                    foreach($_POST['addresses'] as $address_id => $address_data) {
                        $address = Address::find($address_id);
                        if($address && $address->customer_id == $customer->customer_id) {
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
                            $address->customer_id = $customer->customer_id;
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
                        if($address && $address->customer_id == $customer->customer_id) {
                            $address->delete();
                        }
                    }
                }
                
                // Actualizar teléfonos existentes
                if(isset($_POST['phones']) && is_array($_POST['phones'])) {
                    foreach($_POST['phones'] as $phone_id => $phone_data) {
                        $phone = Phone::find($phone_id);
                        if($phone && $phone->customer_id == $customer->customer_id) {
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
                            $phone->customer_id = $customer->customer_id;
                            $phone->number = $new_phone['number'];
                            $phone->save();
                        }
                    }
                }
                
                // Eliminar teléfonos marcados
                if(isset($_POST['delete_phones']) && is_array($_POST['delete_phones'])) {
                    foreach($_POST['delete_phones'] as $phone_id) {
                        $phone = Phone::find($phone_id);
                        if($phone && $phone->customer_id == $customer->customer_id) {
                            $phone->delete();
                        }
                    }
                }
                
                header("Location: " . base_url() . "customer/show/" . $customer->customer_id);
                exit();
            }
        }
        header("Location: " . base_url() . "customer");
    }

    public function deleteCustomer(...$params) {
        if (isset($params[0])) {
            $customer = Customer::find($params[0]);
            if ($customer) {
                // Eliminar direcciones asociadas
                $customer->addresses()->delete();
                // Eliminar teléfonos asociados
                $customer->phones()->delete();
                // Eliminar el cliente
                $customer->delete();
            }
        }
        header("Location: " . base_url() . "customer");
    }
    
    // Métodos auxiliares para añadir/eliminar direcciones y teléfonos de forma individual
    public function addAddress(...$params) {
        if(isset($params[0]) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $customer = Customer::find($params[0]);
            if($customer) {
                $street = $_POST['street'] ?? null;
                $city = $_POST['city'] ?? null;
                $zip_code = $_POST['zip_code'] ?? null;
                $country = $_POST['country'] ?? null;
                
                if($street && $city && $zip_code && $country) {
                    $address = new Address();
                    $address->customer_id = $customer->customer_id;
                    $address->street = $street;
                    $address->city = $city;
                    $address->zip_code = $zip_code;
                    $address->country = $country;
                    $address->save();
                }
                
                header("Location: " . base_url() . "customer/editCustomer/" . $customer->customer_id);
                exit();
            }
        }
        header("Location: " . base_url() . "customer");
    }
    
    public function deleteAddress(...$params) {
        if(isset($params[0])) {
            $address = Address::find($params[0]);
            if($address) {
                $customer_id = $address->customer_id;
                $address->delete();
                header("Location: " . base_url() . "customer/editCustomer/" . $customer_id);
                exit();
            }
        }
        header("Location: " . base_url() . "customer");
    }
    
    public function addPhone(...$params) {
        if(isset($params[0]) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $customer = Customer::find($params[0]);
            if($customer) {
                $number = $_POST['number'] ?? null;
                
                if($number) {
                    $phone = new Phone();
                    $phone->customer_id = $customer->customer_id;
                    $phone->number = $number;
                    $phone->save();
                }
                
                header("Location: " . base_url() . "customer/editCustomer/" . $customer->customer_id);
                exit();
            }
        }
        header("Location: " . base_url() . "customer");
    }
    
    public function deletePhone(...$params) {
        if(isset($params[0])) {
            $phone = Phone::find($params[0]);
            if($phone) {
                $customer_id = $phone->customer_id;
                $phone->delete();
                header("Location: " . base_url() . "customer/editCustomer/" . $customer_id);
                exit();
            }
        }
        header("Location: " . base_url() . "customer");
    }
}
?>