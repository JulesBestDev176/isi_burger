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
            $table->dropColumn('mode_paiement');
        });

        
        Schema::table('commandes', function (Blueprint $table) {
            $table->enum('mode_paiement', ['espèces', 'carte bancaire', 'mobile money'])->default('espèces');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn('mode_paiement');
        });

        
        Schema::table('commandes', function (Blueprint $table) {
            $table->enum('mode_paiement', ['espèces', 'carte bancaire', 'virement'])->default('espèces');
        });
    }
};
