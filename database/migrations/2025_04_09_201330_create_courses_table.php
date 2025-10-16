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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('copon_id')->nullable()->constrained('discounts','id')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories','id')->cascadeOnDelete();
            $table->string('title');
            $table->enum('is_paid',['paid','un_paid'])->default('un_paid');
            $table->decimal('price',10,2)->require()->default(0.00);
            $table->text('desc');
            $table->string('video');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
