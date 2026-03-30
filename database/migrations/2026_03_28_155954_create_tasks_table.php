<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('title'); // Task title
            $table->date('due_date'); // Deadline
            $table->enum('priority', ['low', 'medium', 'high']); // Priority level
            $table->enum('status', ['pending', 'in_progress', 'done'])->default('pending'); // Status with default
            $table->timestamps(); // Creates created_at and updated_at
            
            // Business rule: Cannot have duplicate title for same due date
            $table->unique(['title', 'due_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};