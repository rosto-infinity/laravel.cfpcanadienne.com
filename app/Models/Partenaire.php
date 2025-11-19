<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Partenaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom',
        'logo',
        'siteweb',
        'statut',
        'description',
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes pour filtrer par statut
    public function scopeApprouves($query)
    {
        return $query->where('statut', 'approuve');
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeRejetes($query)
    {
        return $query->where('statut', 'rejete');
    }

    // Accesseur pour l'URL du logo
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return Storage::url($this->logo);
        }
        return null;
    }

    // Vérifier si le partenaire est approuvé
    public function isApprouve()
    {
        return $this->statut === 'approuve';
    }

    // Vérifier si le partenaire est en attente
    public function isEnAttente()
    {
        return $this->statut === 'en_attente';
    }

    // Vérifier si le partenaire est rejeté
    public function isRejete()
    {
        return $this->statut === 'rejete';
    }

    // Badge de statut avec couleur
    public function getBadgeStatutAttribute()
    {
        return match($this->statut) {
            'approuve' => [
                'text' => 'Approuvé',
                'class' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
            ],
            'en_attente' => [
                'text' => 'En attente',
                'class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300'
            ],
            'rejete' => [
                'text' => 'Rejeté',
                'class' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
            ],
            default => [
                'text' => 'Inconnu',
                'class' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300'
            ]
        };
    }
}