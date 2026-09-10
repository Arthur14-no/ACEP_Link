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
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->text('contenu');
        $table->foreignId('expediteur_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('salon_id')->nullable()->constrained('salons')->onDelete('cascade');
        $table->foreignId('destinataire_id')->nullable()->constrained('users')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
