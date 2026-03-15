<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Migration file restored for rollback only; table was created by original migration.
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
