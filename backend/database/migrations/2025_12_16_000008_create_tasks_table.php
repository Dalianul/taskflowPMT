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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('column_id')->constrained('columns')->onDelete('cascade');
            $table->foreignId('board_id')->constrained('boards')->onDelete('cascade'); // denormalized
            $table->string('title', 500);
            $table->text('description')->nullable();
            $table->integer('position')->default(0);
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->nullable();
            $table->timestamp('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->timestamps();

            $table->index('column_id');
            $table->index('board_id');
            $table->index(['column_id', 'position']);
            $table->index('due_date');
            $table->index('priority');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
