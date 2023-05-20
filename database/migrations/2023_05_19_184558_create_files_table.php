<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('size')->nullable();
            $table->string('extension')->nullable();
            $table->string('path')->nullable();

            $table->string('filable_type')->nullable()->index();
            $table->unsignedBigInteger('filable_id')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
