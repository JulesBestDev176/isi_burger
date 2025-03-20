<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        Schema::table('commandes', function (Blueprint $table) {
            
            $table->dropColumn('statut');
        });

        
        Schema::table('commandes', function (Blueprint $table) {
            $table->enum('statut', ['en attente', 'en préparation', 'prête', 'payée', 'annulé'])
                  ->default('en attente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn('statut');
        });

       
        Schema::table('commandes', function (Blueprint $table) {
            $table->enum('statut', ['en attente', 'en préparation', 'prête', 'payée'])
                  ->default('en attente');
        });
    }
};
