<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ShortLink;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shortlinks', function (Blueprint $table) {
            $table->id();
            $table->string('short_code')->unique();
            $table->string('short_url');
            $table->string('original_url');
            $table->unsignedBigInteger('clicks')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shortlinks');
    }
};
