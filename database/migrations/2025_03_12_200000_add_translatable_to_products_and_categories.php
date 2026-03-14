<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected string $fallbackLocale = 'en';

    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            $this->upMysql();
        } else {
            $this->upGeneric();
        }
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            $this->downMysql();
        } else {
            $this->downGeneric();
        }
    }

    private function upMysql(): void
    {
        // Products
        DB::statement('ALTER TABLE products ADD COLUMN name_new JSON NULL AFTER category_id');
        DB::statement('ALTER TABLE products ADD COLUMN description_new JSON NULL AFTER slug');
        DB::statement("UPDATE products SET name_new = JSON_OBJECT(?, name), description_new = CASE WHEN description IS NULL THEN NULL ELSE JSON_OBJECT(?, description) END", [$this->fallbackLocale, $this->fallbackLocale]);
        DB::statement('ALTER TABLE products DROP COLUMN name, DROP COLUMN description');
        DB::statement('ALTER TABLE products CHANGE name_new name JSON NOT NULL');
        DB::statement('ALTER TABLE products CHANGE description_new description JSON NULL');

        // Categories
        DB::statement('ALTER TABLE categories ADD COLUMN name_new JSON NULL AFTER id');
        DB::statement('ALTER TABLE categories ADD COLUMN description_new JSON NULL AFTER slug');
        DB::statement("UPDATE categories SET name_new = JSON_OBJECT(?, name), description_new = CASE WHEN description IS NULL THEN NULL ELSE JSON_OBJECT(?, description) END", [$this->fallbackLocale, $this->fallbackLocale]);
        DB::statement('ALTER TABLE categories DROP COLUMN name, DROP COLUMN description');
        DB::statement('ALTER TABLE categories CHANGE name_new name JSON NOT NULL');
        DB::statement('ALTER TABLE categories CHANGE description_new description JSON NULL');
    }

    private function downMysql(): void
    {
        // Products: JSON -> varchar/text
        DB::statement('ALTER TABLE products ADD COLUMN name_old VARCHAR(255) NULL AFTER category_id');
        DB::statement('ALTER TABLE products ADD COLUMN description_old TEXT NULL AFTER slug');
        DB::statement("UPDATE products SET name_old = JSON_UNQUOTE(JSON_EXTRACT(name, CONCAT('$.', ?))), description_old = JSON_UNQUOTE(JSON_EXTRACT(description, CONCAT('$.', ?)))", [$this->fallbackLocale, $this->fallbackLocale]);
        DB::statement('ALTER TABLE products DROP COLUMN name, DROP COLUMN description');
        DB::statement('ALTER TABLE products CHANGE name_old name VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE products CHANGE description_old description TEXT NULL');

        DB::statement('ALTER TABLE categories ADD COLUMN name_old VARCHAR(255) NULL AFTER id');
        DB::statement('ALTER TABLE categories ADD COLUMN description_old TEXT NULL AFTER slug');
        DB::statement("UPDATE categories SET name_old = JSON_UNQUOTE(JSON_EXTRACT(name, CONCAT('$.', ?))), description_old = JSON_UNQUOTE(JSON_EXTRACT(description, CONCAT('$.', ?)))", [$this->fallbackLocale, $this->fallbackLocale]);
        DB::statement('ALTER TABLE categories DROP COLUMN name, DROP COLUMN description');
        DB::statement('ALTER TABLE categories CHANGE name_old name VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE categories CHANGE description_old description TEXT NULL');
    }

    private function upGeneric(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('name_new')->nullable()->after('category_id');
            $table->json('description_new')->nullable()->after('slug');
        });
        foreach (DB::table('products')->get() as $row) {
            $name = is_string($row->name) ? $row->name : '';
            $desc = is_string($row->description) ? $row->description : null;
            DB::table('products')->where('id', $row->id)->update([
                'name_new' => json_encode([$this->fallbackLocale => $name]),
                'description_new' => $desc !== null ? json_encode([$this->fallbackLocale => $desc]) : null,
            ]);
        }
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['name', 'description']);
        });
        Schema::table('products', function (Blueprint $table) {
            $table->json('name')->nullable(false)->after('category_id');
            $table->json('description')->nullable()->after('slug');
        });
        foreach (DB::table('products')->get() as $row) {
            DB::table('products')->where('id', $row->id)->update([
                'name' => $row->name_new,
                'description' => $row->description_new,
            ]);
        }
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['name_new', 'description_new']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->json('name_new')->nullable()->after('id');
            $table->json('description_new')->nullable()->after('slug');
        });
        foreach (DB::table('categories')->get() as $row) {
            $name = is_string($row->name) ? $row->name : '';
            $desc = is_string($row->description) ? $row->description : null;
            DB::table('categories')->where('id', $row->id)->update([
                'name_new' => json_encode([$this->fallbackLocale => $name]),
                'description_new' => $desc !== null ? json_encode([$this->fallbackLocale => $desc]) : null,
            ]);
        }
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['name', 'description']);
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->json('name')->nullable(false)->after('id');
            $table->json('description')->nullable()->after('slug');
        });
        foreach (DB::table('categories')->get() as $row) {
            DB::table('categories')->where('id', $row->id)->update([
                'name' => $row->name_new,
                'description' => $row->description_new,
            ]);
        }
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['name_new', 'description_new']);
        });
    }

    private function downGeneric(): void
    {
        $fallback = $this->fallbackLocale;
        Schema::table('products', function (Blueprint $table) {
            $table->string('name_old')->nullable()->after('category_id');
            $table->text('description_old')->nullable()->after('slug');
        });
        foreach (DB::table('products')->get() as $row) {
            $name = $row->name ? (json_decode($row->name, true)[$fallback] ?? '') : '';
            $desc = $row->description ? (json_decode($row->description, true)[$fallback] ?? null) : null;
            DB::table('products')->where('id', $row->id)->update(['name_old' => $name, 'description_old' => $desc]);
        }
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['name', 'description']);
        });
        Schema::table('products', function (Blueprint $table) {
            $table->string('name')->nullable(false)->after('category_id');
            $table->text('description')->nullable()->after('slug');
        });
        foreach (DB::table('products')->get() as $row) {
            DB::table('products')->where('id', $row->id)->update(['name' => $row->name_old, 'description' => $row->description_old]);
        }
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['name_old', 'description_old']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('name_old')->nullable()->after('id');
            $table->text('description_old')->nullable()->after('slug');
        });
        foreach (DB::table('categories')->get() as $row) {
            $name = $row->name ? (json_decode($row->name, true)[$fallback] ?? '') : '';
            $desc = $row->description ? (json_decode($row->description, true)[$fallback] ?? null) : null;
            DB::table('categories')->where('id', $row->id)->update(['name_old' => $name, 'description_old' => $desc]);
        }
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['name', 'description']);
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name')->nullable(false)->after('id');
            $table->text('description')->nullable()->after('slug');
        });
        foreach (DB::table('categories')->get() as $row) {
            DB::table('categories')->where('id', $row->id)->update(['name' => $row->name_old, 'description' => $row->description_old]);
        }
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['name_old', 'description_old']);
        });
    }
};
