<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('taks_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('department_id');
            $table->integer('status')->nullable()->default(0);
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->string('reject_msg')->nullable();
            $table->integer('attempts')->nullable()->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('processes');
    }
};
