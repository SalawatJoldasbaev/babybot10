<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('baby_grafts', function (Blueprint $table) {
            $table->id();
            $table->dateTime('datetime');
            $table->foreignId('baby_id')->constrained('babies');
            $table->foreignId('graft_id')->constrained('grafts');
            $table->string('description')->nullable();
            $table->boolean('message_sent')->default(false);
            $table->string('graft_status')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baby_grafts');
    }
};
