<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class subcategory extends Model
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;

    protected $fillable = [
        'subcategory',
    ]; 
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function book()
    {
        return $this->hasMany(book::class);
    }

}
    
    
