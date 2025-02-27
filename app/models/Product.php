<?php
namespace Formacom\Models;
use Illuminate\Database\Eloquent\Model;
class Product extends Model{
    protected $table="product";
    protected $primaryKey = 'product_id';
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