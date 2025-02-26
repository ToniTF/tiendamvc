<?php
namespace Formacom\controllers;
use Formacom\Core\Controller;
use Formacom\Models\Customer;
use Formacom\Models\Address;
use Formacom\Models\Phone;

class CustomerController extends Controller{
    public function index(...$params){
        $customers = Customer::all();
        $this->view('/home', $customers); // Asegúrate de que la vista home esté en la carpeta customer
    }

    public function show(...$params){
        if(isset($params[0])) {
            $customer = Customer::find($params[0]);
            if($customer){
                $this->view('/detail', $customer); // Asegúrate de que la vista detail esté en la carpeta customer
                exit();
            }
            header("Location:".base_url()."customer");
        }
    }

    public function newCustomer() {
        $this->view("/create"); // Asegúrate de que la vista create esté en la carpeta customer
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
}
?>