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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');             // Назва зброї
        $table->text('description');        // ТТХ та опис
        $table->decimal('price', 10, 2);    // Вартість
        $table->string('image')->nullable();// Фото зброї
        
        // Прив'язка до типу (категорії)
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
