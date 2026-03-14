<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('page_name'); // display name e.g. "Terms & Conditions"
            $table->string('page_slug', 100)->unique(); // URL slug e.g. "terms"
            $table->longText('page_content_en')->nullable();
            $table->longText('page_content_ar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};
