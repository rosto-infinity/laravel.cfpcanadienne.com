<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\Partenaire;

describe('Partenaire pages publiques', function () {
    it('affiche la liste des partenaires approuvés', function () {
        Partenaire::factory()->approuve()->count(3)->create();

        $response = $this->get('/partenaires');

        $response->assertStatus(200);
    });

    it('affiche la page d\'accueil avec les partenaires', function () {
        Partenaire::factory()->approuve()->count(3)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
    });

    it('affiche les détails d\'un partenaire approuvé', function () {
        $partenaire = Partenaire::factory()->approuve()->create();

        $response = $this->get("/partenaires/{$partenaire->id}");

        $response->assertStatus(200);
        $response->assertSee($partenaire->nom);
    });

    it('retourne 404 pour un partenaire non approuvé', function () {
        $partenaire = Partenaire::factory()->create(['statut' => 'en_attente']);

        $response = $this->get("/partenaires/{$partenaire->id}");

        $response->assertStatus(404);
    });
});

describe('Partenaire CRUD utilisateur authentifié', function () {
    it('affiche le formulaire de création', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/partenaires/create');

        $response->assertStatus(200);
    });

    it('affiche la liste de mes partenaires', function () {
        $user = User::factory()->create();
        Partenaire::factory()->count(2)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/mes-partenaires');

        $response->assertStatus(200);
    });

    it('redirige vers login si non authentifié pour la création', function () {
        $response = $this->get('/partenaires/create');

        $response->assertRedirect('/login');
    });

    it('redirige vers login si non authentifié pour mes-partenaires', function () {
        $response = $this->get('/mes-partenaires');

        $response->assertRedirect('/login');
    });
});

describe('Workflow SuperAdmin', function () {
    it('affiche le dashboard superadmin', function () {
        $superadmin = User::factory()->create(['role' => 'superadmin']);

        $response = $this->actingAs($superadmin)->get('/superadmin/dashboard');

        $response->assertStatus(200);
    });

    it('affiche la liste des partenaires pour le superadmin', function () {
        $superadmin = User::factory()->create(['role' => 'superadmin']);
        Partenaire::factory()->count(3)->create();

        $response = $this->actingAs($superadmin)->get('/superadmin/partenaires');

        $response->assertStatus(200);
    });

    it('approuve un partenaire', function () {
        $superadmin = User::factory()->create(['role' => 'superadmin']);
        $partenaire = Partenaire::factory()->create(['statut' => 'en_attente']);

        $response = $this->actingAs($superadmin)
            ->patch("/superadmin/partenaires/{$partenaire->id}/approuver");

        $response->assertSessionHas('success');
        $this->assertEquals('approuve', $partenaire->fresh()->statut);
    });

    it('rejette un partenaire', function () {
        $superadmin = User::factory()->create(['role' => 'superadmin']);
        $partenaire = Partenaire::factory()->create(['statut' => 'en_attente']);

        $response = $this->actingAs($superadmin)
            ->patch("/superadmin/partenaires/{$partenaire->id}/rejeter");

        $response->assertSessionHas('success');
        $this->assertEquals('rejete', $partenaire->fresh()->statut);
    });

    it('supprime un partenaire en tant que superadmin', function () {
        $superadmin = User::factory()->create(['role' => 'superadmin']);
        $partenaire = Partenaire::factory()->create();

        $response = $this->actingAs($superadmin)
            ->delete("/superadmin/partenaires/{$partenaire->id}");

        $response->assertSessionHas('success');
        $this->assertModelMissing($partenaire);
    });

    it('bloque l\'accès superadmin pour un utilisateur normal', function () {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/superadmin/dashboard');

        $response->assertStatus(403);
    });
});
