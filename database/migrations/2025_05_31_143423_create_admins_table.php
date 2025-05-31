<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('usr_admin')->unique();
            $table->string('pass_admin');
            $table->string('notlp_admin')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
