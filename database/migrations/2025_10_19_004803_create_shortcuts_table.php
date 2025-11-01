<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("shortcuts", function (Blueprint $table) {
            $table->id();
            $table->string("scrape_id")->nullable();
            $table->string("icon")->nullable();
            $table->text("markdown")->nullable();
            $table->text("html")->nullable();
            $table->string("name")->nullable();
            $table->string("short")->nullable();
            $table->string("link")->nullable();
            $table->bigInteger("downloads_all_time")->default(0);
            $table->bigInteger("views_all_time")->default(0);
            $table->bigInteger("downloads_last_24")->default(0);
            $table->bigInteger("views_last_24")->default(0);
            $table->string("slug")->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("shortcuts");
    }
};
