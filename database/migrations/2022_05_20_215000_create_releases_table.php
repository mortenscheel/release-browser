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
            $table->string('major')->virtualAs("SUBSTRING(version, 1, LOCATE('.', version) - 1)")->index();
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
