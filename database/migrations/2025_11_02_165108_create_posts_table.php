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
        Schema::create("posts", function (Blueprint $table) {
            $table->id();
            $table->boolean("show_on_feed")->default(0);
            $table->boolean("allow_comments")->default(0);

            $table->string("title");
            $table->text("markdown");
            $table->text("html");
            $table->string("slug")->unique();

            $table->string("thumbnail")->nullable();

            $table->bigInteger("views_all_time")->default(0);
            $table->bigInteger("views_last_24")->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("posts");
    }
};
