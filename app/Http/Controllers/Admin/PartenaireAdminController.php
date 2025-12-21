<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partenaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartenaireAdminController extends Controller
{
    /**
     * Afficher tous les partenaires (tous statuts)
     */
    public function index(Request $request)
    {
        $statut = $request->get('statut', 'all');   
        $query = Partenaire::with('user')->latest();
        
        if ($statut !== 'all') {
            $query->where('statut', $statut);
        }
        
        $partenaires = $query->paginate(15);
        
        // Statistiques
        $stats = [
            'total' => Partenaire::count(),
            'en_attente' => Partenaire::enAttente()->count(),
            'approuves' => Partenaire::approuves()->count(),
            'rejetes' => Partenaire::rejetes()->count(),
        ];
        
        return view('admin.partenaires.index', compact('partenaires', 'stats', 'statut'));
    }

    /**
     * Afficher un partenaire spécifique
     */
    public function show(Partenaire $partenaire)
    {
        $partenaire->load('user');
        return view('admin.partenaires.show', compact('partenaire'));
    }

    /**
     * Approuver un partenaire
     */
    public function approuver(Partenaire $partenaire)
    {
        $partenaire->update(['statut' => 'approuve']);
        
        // TODO: Envoyer une notification email à l'utilisateur
        
        return redirect()
            ->back()
            ->with('success', "Le partenaire '{$partenaire->nom}' a été approuvé avec succès.");
    }

    /**
     * Rejeter un partenaire
     */
    public function rejeter(Request $request, Partenaire $partenaire)
    {
        $request->validate([
            'raison' => 'nullable|string|max:500'
        ]);
        
        $partenaire->update(['statut' => 'rejete']);
        
        // TODO: Envoyer une notification email avec la raison du rejet
        
        return redirect()
            ->back()
            ->with('success', "Le partenaire '{$partenaire->nom}' a été rejeté.");
    }

    /**
     * Supprimer un partenaire
     */
    public function destroy(Partenaire $partenaire)
    {
        // Supprimer le logo
        if ($partenaire->logo) {
            Storage::disk('public')->delete($partenaire->logo);
        }
        
        $nom = $partenaire->nom;
        $partenaire->delete();
        
        return redirect()
            ->route('superadmin.partenaires.index')
            ->with('success', "Le partenaire '{$nom}' a été supprimé définitivement.");
    }
}
