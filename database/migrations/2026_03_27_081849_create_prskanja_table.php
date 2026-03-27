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
        Schema::create('prskanja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kultura_id')->constrained('kulture')->cascadeOnDelete();
            $table->date('datum_tretiranja');
            $table->decimal('tretirana_povrsina_ha', 8, 2);
            $table->string('trgovacki_naziv_sredstva');
            $table->decimal('kolicina_sredstva_l_ha', 8, 3);
            $table->time('vrijeme_od')->nullable();
            $table->time('vrijeme_do')->nullable();
            $table->decimal('kolicina_vode_l_ha', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prskanja');
    }
};
