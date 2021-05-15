<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use Translatable;

    protected $guarded =[];
    public $translatedAttributes = ['name','description'];
    protected $appends = ['image_path','profit','profit_percent'];

    public function category(){

        return $this->belongsTo(Category::class);
    } // end of category
    public function getImagePathAttribute(){
        return asset('uploads/product_images/'.$this->image);
    }// end of ImagePath attribute
    public function getProfitAttribute(){

        $profit = $this->sale_price - $this->purchase_price ;
        return $profit;
    }// end of Profit attribute
    public function getProfitPercentAttribute(){

        $profit_percent = $this->profit * 100 / $this->purchase_price;
        return number_format($profit_percent,2);
    }// end of Profit percent attribute
    public function orders(){
        return $this->belongsToMany(Order::class,'product_order');
    }
}
