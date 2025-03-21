<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ajouter la colonne 'nom' si elle n'existe pas
            if (!Schema::hasColumn('users', 'nom')) {
                $table->string('nom')->nullable(); 
            }

            // Ajouter la colonne 'prenom' si elle n'existe pas
            if (!Schema::hasColumn('users', 'prenom')) {
                $table->string('prenom')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Supprimer les colonnes 'nom' et 'prenom'
            $table->dropColumn(['nom', 'prenom']); 
        });
    }
};