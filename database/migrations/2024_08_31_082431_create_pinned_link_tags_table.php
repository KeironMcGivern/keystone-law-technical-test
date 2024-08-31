<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pinned_link_tags', function (Blueprint $table) {
            $table->bigInteger('pinned_link_id')->unsigned();
            $table->bigInteger('tag_id')->unsigned();
            $table->primary(['pinned_link_id', 'tag_id']);
            $table->nullableTimestamps();
        });

        Schema::table('pinned_link_tags', function (Blueprint $table) {
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->foreign('pinned_link_id')->references('id')->on('pinned_links');
        });
    }
};
