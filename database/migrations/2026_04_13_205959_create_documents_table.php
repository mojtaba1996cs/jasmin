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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            

    $table->string('title');
    $table->string('file_path');
    $table->foreignId('from_office_id')->constrained('offices');
    $table->foreignId('to_office_id')->constrained('offices');
    $table->foreignId('created_by')->constrained('users');
    $table->string('status')->default('pending');
    $table->string('doc_number')->nullable();
    $table->text('description')->nullable();
    
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
