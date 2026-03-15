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
        DB::statement('ALTER TABLE posts ADD COLUMN title_new JSON NULL AFTER id');
        DB::statement('ALTER TABLE posts ADD COLUMN excerpt_new JSON NULL AFTER slug');
        DB::statement('ALTER TABLE posts ADD COLUMN body_new JSON NULL AFTER excerpt_new');
        DB::statement('ALTER TABLE posts ADD COLUMN meta_title_new JSON NULL AFTER published_at');
        DB::statement('ALTER TABLE posts ADD COLUMN meta_description_new JSON NULL AFTER meta_title_new');

        DB::statement(
            "UPDATE posts SET title_new = JSON_OBJECT(?, COALESCE(title, '')), excerpt_new = CASE WHEN excerpt IS NULL THEN NULL ELSE JSON_OBJECT(?, excerpt) END, body_new = CASE WHEN body IS NULL THEN NULL ELSE JSON_OBJECT(?, body) END, meta_title_new = CASE WHEN meta_title IS NULL THEN NULL ELSE JSON_OBJECT(?, meta_title) END, meta_description_new = CASE WHEN meta_description IS NULL THEN NULL ELSE JSON_OBJECT(?, meta_description) END",
            [$this->fallbackLocale, $this->fallbackLocale, $this->fallbackLocale, $this->fallbackLocale, $this->fallbackLocale]
        );

        DB::statement('ALTER TABLE posts DROP COLUMN title, DROP COLUMN excerpt, DROP COLUMN body, DROP COLUMN meta_title, DROP COLUMN meta_description');
        DB::statement('ALTER TABLE posts CHANGE title_new title JSON NOT NULL');
        DB::statement('ALTER TABLE posts CHANGE excerpt_new excerpt JSON NULL');
        DB::statement('ALTER TABLE posts CHANGE body_new body JSON NULL');
        DB::statement('ALTER TABLE posts CHANGE meta_title_new meta_title JSON NULL');
        DB::statement('ALTER TABLE posts CHANGE meta_description_new meta_description JSON NULL');
    }

    private function downMysql(): void
    {
        DB::statement('ALTER TABLE posts ADD COLUMN title_old VARCHAR(255) NULL AFTER id');
        DB::statement('ALTER TABLE posts ADD COLUMN excerpt_old TEXT NULL AFTER slug');
        DB::statement('ALTER TABLE posts ADD COLUMN body_old LONGTEXT NULL AFTER excerpt_old');
        DB::statement('ALTER TABLE posts ADD COLUMN meta_title_old VARCHAR(255) NULL AFTER published_at');
        DB::statement('ALTER TABLE posts ADD COLUMN meta_description_old VARCHAR(500) NULL AFTER meta_title_old');

        DB::statement(
            "UPDATE posts SET title_old = JSON_UNQUOTE(JSON_EXTRACT(title, CONCAT('$.', ?))), excerpt_old = JSON_UNQUOTE(JSON_EXTRACT(excerpt, CONCAT('$.', ?))), body_old = JSON_UNQUOTE(JSON_EXTRACT(body, CONCAT('$.', ?))), meta_title_old = JSON_UNQUOTE(JSON_EXTRACT(meta_title, CONCAT('$.', ?))), meta_description_old = JSON_UNQUOTE(JSON_EXTRACT(meta_description, CONCAT('$.', ?)))",
            [$this->fallbackLocale, $this->fallbackLocale, $this->fallbackLocale, $this->fallbackLocale, $this->fallbackLocale]
        );

        DB::statement('ALTER TABLE posts DROP COLUMN title, DROP COLUMN excerpt, DROP COLUMN body, DROP COLUMN meta_title, DROP COLUMN meta_description');
        DB::statement('ALTER TABLE posts CHANGE title_old title VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE posts CHANGE excerpt_old excerpt TEXT NULL');
        DB::statement('ALTER TABLE posts CHANGE body_old body LONGTEXT NULL');
        DB::statement('ALTER TABLE posts CHANGE meta_title_old meta_title VARCHAR(255) NULL');
        DB::statement('ALTER TABLE posts CHANGE meta_description_old meta_description VARCHAR(500) NULL');
    }

    private function upGeneric(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->json('title_new')->nullable()->after('id');
            $table->json('excerpt_new')->nullable()->after('slug');
            $table->json('body_new')->nullable()->after('excerpt_new');
            $table->json('meta_title_new')->nullable()->after('published_at');
            $table->json('meta_description_new')->nullable()->after('meta_title_new');
        });

        foreach (DB::table('posts')->get() as $row) {
            $title = is_string($row->title ?? null) ? $row->title : '';
            $excerpt = $row->excerpt ?? null;
            $body = $row->body ?? null;
            $metaTitle = $row->meta_title ?? null;
            $metaDesc = $row->meta_description ?? null;
            DB::table('posts')->where('id', $row->id)->update([
                'title_new' => json_encode([$this->fallbackLocale => $title]),
                'excerpt_new' => $excerpt !== null ? json_encode([$this->fallbackLocale => $excerpt]) : null,
                'body_new' => $body !== null ? json_encode([$this->fallbackLocale => $body]) : null,
                'meta_title_new' => $metaTitle !== null ? json_encode([$this->fallbackLocale => $metaTitle]) : null,
                'meta_description_new' => $metaDesc !== null ? json_encode([$this->fallbackLocale => $metaDesc]) : null,
            ]);
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['title', 'excerpt', 'body', 'meta_title', 'meta_description']);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->json('title')->nullable(false)->after('id');
            $table->json('excerpt')->nullable()->after('slug');
            $table->json('body')->nullable()->after('excerpt');
            $table->json('meta_title')->nullable()->after('published_at');
            $table->json('meta_description')->nullable()->after('meta_title');
        });

        foreach (DB::table('posts')->get() as $row) {
            DB::table('posts')->where('id', $row->id)->update([
                'title' => $row->title_new,
                'excerpt' => $row->excerpt_new,
                'body' => $row->body_new,
                'meta_title' => $row->meta_title_new,
                'meta_description' => $row->meta_description_new,
            ]);
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['title_new', 'excerpt_new', 'body_new', 'meta_title_new', 'meta_description_new']);
        });
    }

    private function downGeneric(): void
    {
        $fallback = $this->fallbackLocale;
        Schema::table('posts', function (Blueprint $table) {
            $table->string('title_old')->nullable()->after('id');
            $table->text('excerpt_old')->nullable()->after('slug');
            $table->longText('body_old')->nullable()->after('excerpt_old');
            $table->string('meta_title_old')->nullable()->after('published_at');
            $table->string('meta_description_old', 500)->nullable()->after('meta_title_old');
        });

        foreach (DB::table('posts')->get() as $row) {
            $get = function ($val) use ($fallback) {
                if (!$val) {
                    return null;
                }
                $dec = json_decode($val, true);
                return is_array($dec) ? ($dec[$fallback] ?? null) : null;
            };
            DB::table('posts')->where('id', $row->id)->update([
                'title_old' => $get($row->title) ?? '',
                'excerpt_old' => $get($row->excerpt),
                'body_old' => $get($row->body),
                'meta_title_old' => $get($row->meta_title),
                'meta_description_old' => $get($row->meta_description),
            ]);
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['title', 'excerpt', 'body', 'meta_title', 'meta_description']);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('title')->nullable(false)->after('id');
            $table->text('excerpt')->nullable()->after('slug');
            $table->longText('body')->nullable()->after('excerpt');
            $table->string('meta_title')->nullable()->after('published_at');
            $table->string('meta_description', 500)->nullable()->after('meta_title');
        });

        foreach (DB::table('posts')->get() as $row) {
            DB::table('posts')->where('id', $row->id)->update([
                'title' => $row->title_old,
                'excerpt' => $row->excerpt_old,
                'body' => $row->body_old,
                'meta_title' => $row->meta_title_old,
                'meta_description' => $row->meta_description_old,
            ]);
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['title_old', 'excerpt_old', 'body_old', 'meta_title_old', 'meta_description_old']);
        });
    }
};
