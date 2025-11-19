<?php

namespace App\Http\Controllers;

use App\Models\Partenaire;
use App\Http\Requests\PartenaireRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartenaireController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Afficher la liste des partenaires approuvés
     */
    public function index()
    {
        $partenaires = Partenaire::with('user')
            ->approuves()
            ->latest()
            ->paginate(12);

        return view('partenaires.index', compact('partenaires'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('partenaires.create');
    }

    /**
     * Enregistrer un nouveau partenaire
     */
    public function store(PartenaireRequest $request)
    {
        $validated = $request->validated();

        // Gérer l'upload du logo
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('partenaires', 'public');
        }

        // Ajouter l'utilisateur connecté
        $validated['user_id'] = auth()->id();
        $validated['statut'] = 'en_attente';

        $partenaire = Partenaire::create($validated);

        return redirect()
            ->route('partenaires.mes-partenaires')
            ->with('success', 'Votre demande de partenariat a été soumise avec succès ! Elle sera examinée prochainement.');
    }

    /**
     * Afficher un partenaire spécifique
     */
    public function show(Partenaire $partenaire)
    {
        // Seuls les partenaires approuvés sont visibles publiquement
        if ($partenaire->statut !== 'approuve' && $partenaire->user_id !== auth()->id()) {
            abort(404);
        }

        return view('partenaires.show', compact('partenaire'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Partenaire $partenaire)
    {
        // Vérifier que l'utilisateur est propriétaire
        if ($partenaire->user_id !== auth()->id()) {
            abort(403, 'Action non autorisée.');
        }

        return view('partenaires.edit', compact('partenaire'));
    }

    /**
     * Mettre à jour un partenaire
     */
    public function update(PartenaireRequest $request, Partenaire $partenaire)
    {
        // Vérifier que l'utilisateur est propriétaire
        if ($partenaire->user_id !== auth()->id()) {
            abort(403, 'Action non autorisée.');
        }

        $validated = $request->validated();

        // Gérer l'upload du nouveau logo
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo
            if ($partenaire->logo) {
                Storage::disk('public')->delete($partenaire->logo);
            }
            $validated['logo'] = $request->file('logo')->store('partenaires', 'public');
        }

        // Remettre en attente après modification
        $validated['statut'] = 'en_attente';

        $partenaire->update($validated);

        return redirect()
            ->route('partenaires.mes-partenaires')
            ->with('success', 'Votre partenariat a été mis à jour et soumis pour réexamen.');
    }

    /**
     * Supprimer un partenaire
     */
    public function destroy(Partenaire $partenaire)
    {
        // Vérifier que l'utilisateur est propriétaire
        if ($partenaire->user_id !== auth()->id()) {
            abort(403, 'Action non autorisée.');
        }

        // Supprimer le logo
        if ($partenaire->logo) {
            Storage::disk('public')->delete($partenaire->logo);
        }

        $partenaire->delete();

        return redirect()
            ->route('partenaires.mes-partenaires')
            ->with('success', 'Votre partenariat a été supprimé avec succès.');
    }

    /**
     * Afficher les partenaires de l'utilisateur connecté
     */
    public function mesPartenaires()
    {
        $partenaires = Partenaire::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('partenaires.mes-partenaires', compact('partenaires'));
    }
}