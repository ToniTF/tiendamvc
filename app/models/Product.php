<?php
namespace Formacom\Models;
use Illuminate\Database\Eloquent\Model;
class Product extends Model{
    protected $table="product";
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'name', 
        'description', 
        'price',
        'cost',  // Asegúrate que esté incluido aquí
        'vat_type',
        'stock',
        'category_id',
        'provider_id',
        'image'
    ];
    //category_id
    public function category(){
        return $this->belongsTo('Formacom\Models\Category','category_id');
    }
    //provider_id
    public function provider(){
        return $this->belongsTo('Formacom\Models\Provider','provider_id');
    }
    
}

?>