<?php
// filepath: /c:/xampp/htdocs/tiendamvc/app/models/Order.php
namespace Formacom\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';
    protected $table = 'order'; // Especifica el nombre exacto de la tabla
    public $timestamps = true;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'customer_id', 'date', 'discount'
    ];

    // Relación con Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relación muchos a muchos con Product
    public function products()
    {
        return $this->belongsToMany(
            Product::class, 
            'order_has_product', // Nombre de la tabla pivote (nota: tiene un error ortográfico "oreder")
            'order_id', // Clave foránea en la tabla pivote que apunta a esta tabla (orden)
            'product_id' // Clave foránea en la tabla pivote que apunta a la tabla relacionada (producto)
        )->withPivot('quantity', 'price', 'created_at', 'updated_at'); // Columnas adicionales en la tabla pivote
    }

    // Método para calcular el total de la orden
    public function getTotal()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->pivot->price * $product->pivot->quantity;
        }
        
        // Aplicar descuento si existe
        if ($this->discount > 0) {
            $total = $total * (1 - ($this->discount / 100));
        }
        
        return $total;
    }
}
?>