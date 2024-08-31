<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pinned_links', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('guid', 36);
            $table->text('url');
            $table->string('title', 255);
            $table->text('comments');
            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }
};
