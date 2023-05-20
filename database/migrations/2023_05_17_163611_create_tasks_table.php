<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title');
            $table->text('note')->nullable();
            $table->timestamp('starts_at')->nullable()->index();
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamp('published_at')->nullable();

            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('department_id')
                ->references('id')->on('departments')
                ->nullOnDelete();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
