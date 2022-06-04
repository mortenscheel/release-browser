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
        Schema::create('releases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repo_id')->constrained()->cascadeOnDelete();
            $table->string('version')->index();
            $table->unsignedTinyInteger('major')->virtualAs("CAST(SUBSTRING_INDEX(CONCAT(`version`,'.0'),'.',1) AS UNSIGNED)")->index();
            $table->unsignedInteger('numeric_version')->virtualAs("INET_ATON(SUBSTRING_INDEX(CONCAT(`version`,'.0.0.0'),'.',4))")->index();
            $table->string('tag');
            $table->text('body')->fulltext();
            $table->string('github_url');
            $table->timestamp('published_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('releases');
    }
};
