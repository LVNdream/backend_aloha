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
        Schema::create('user_infor', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('majoring_id');
            $table->string('fullname');
            $table->string('birthday');
            $table->string('gender');
            $table->string('phone');
            $table->longText('avata');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infor');
    }
};
