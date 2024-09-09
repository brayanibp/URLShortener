<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // adding uuid extension for postgress if dont exits
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');

        // creates the short urls table
        Schema::create('shortened_urls', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('original_url');
            $table->string('short_url');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });

        // giving uuid generation to id column
        DB::statement('ALTER TABLE shortened_urls ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shortened_urls');
    }
};
