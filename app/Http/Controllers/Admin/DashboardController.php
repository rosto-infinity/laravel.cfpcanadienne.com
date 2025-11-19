<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partenaire;
use App\Models\User;

class DashboardController extends Controller
{
    public function superadmin()
    {
        $stats = [
            'users_total' => User::count(),
            'partenaires_total' => Partenaire::count(),
            'partenaires_attente' => Partenaire::enAttente()->count(),
            'partenaires_approuves' => Partenaire::approuves()->count(),
        ];

        $partenaires_recents = Partenaire::with('user')
            ->enAttente()
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'partenaires_recents'));
    }
}
