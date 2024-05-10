<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;
    
    protected $fillable = [
        'title',
        'author',
        'description',
        'image',
        'price',
        'category_id', 
        'subcategory_id',
        
    ]; 
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function subcategory(){
        return $this->belongsTo(subcategory::class);
    }
    public function favorites()
    {
        return $this->hasMany(favorite::class);
    }
    public function ratings()
    {
        return $this->hasMany(ratings::class);
    }
}
