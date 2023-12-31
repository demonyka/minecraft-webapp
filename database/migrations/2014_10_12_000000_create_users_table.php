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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unique();
            $table->string('user_username')->nullable();   
            $table->string('nickname')->unique();
            $table->string('email')->unique();
            $table->integer('balance')->default(0);
            $table->datetime('reg_date');
            $table->string('password');
            $table->string('referal')->nullable();
            $table->boolean('admin')->default(false);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
