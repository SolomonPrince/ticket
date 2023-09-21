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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->enum('status', ['Active', 'Resolved'])->default('Active');
            $table->text('message');
            $table->text('comment')->nullable();
            $table->foreignId('user_id')->nullable()->constrained(table: 'users', indexName: 'ticket_user_id');
            $table->foreignId('responsible_id')->nullable()->constrained(table: 'users', indexName: 'responsible_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
