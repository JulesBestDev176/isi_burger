<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'statut',
        'total',
        'date_commande',
        'date_paiement',
        'paiement_montant',
        'mode_paiement',
        'numero_paiement',
        'type'
    ];

    protected $casts = [
        'date_commande' => 'datetime',
        'date_paiement' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function burgers()
    {
        return $this->belongsToMany(Burger::class, 'commandes_burgers')
                   ->withPivot('quantite')
                   ->withTimestamps();
    }

   
}
