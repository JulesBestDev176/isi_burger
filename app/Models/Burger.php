<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Burger extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prix', 'quantite', 'description', 'image'];

    
    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commandes_burgers')
                    ->withPivot('quantite')  
                    ->withTimestamps();     
    }
}
