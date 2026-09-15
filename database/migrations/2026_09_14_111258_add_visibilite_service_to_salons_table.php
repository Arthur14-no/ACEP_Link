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
    Schema::table('salons', function (Blueprint $table) {
        $table->enum('visibilite', ['public', 'public_lecture_seule', 'prive'])->default('public')->after('nom');
        $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('set null')->after('visibilite');
    });
}

public function down(): void
{
    Schema::table('salons', function (Blueprint $table) {
        $table->dropForeign(['service_id']);
        $table->dropColumn(['visibilite', 'service_id']);
    });
}
};
