<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repos', function (Blueprint $table) {
            $table->id();
            $table->string('owner')->index();
            $table->string('name')->index();
            $table->string('full_name')->index();
            $table->string('description')->nullable();
            $table->string('github_url');
            $table->string('homepage_url')->nullable();
            $table->string('owner_avatar_url')->nullable();
            $table->unsignedInteger('stars');
            $table->string('language')->nullable();
            $table->timestamp('published_at');
            $table->unique(['owner', 'name']);
            $table->timestamps();
        });
    }
};
