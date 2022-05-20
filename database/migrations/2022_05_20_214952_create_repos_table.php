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
            $table->string('repository')->index();
            $table->unsignedTinyInteger('order')->nullable();
            $table->index(['owner', 'repository']);
            $table->timestamps();
        });
    }
};
