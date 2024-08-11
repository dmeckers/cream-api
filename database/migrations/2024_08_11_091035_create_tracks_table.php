<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const TABLE = 'tracks';

    private const NAME     = 'name';
    private const ARTIST   = 'artist';
    private const ALBUM    = 'album';
    private const GENRE    = 'genre';
    private const YEAR     = 'year';
    private const LENGTH   = 'length';
    private const PLAYS    = 'plays';
    private const RATING   = 'rating';
    private const FILE_URL = 'file_url';

    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string(self::FILE_URL);
            $table->string(self::NAME)->nullable();
            $table->string(self::ARTIST)->nullable();
            $table->string(self::ALBUM)->nullable();
            $table->string(self::GENRE)->nullable();
            $table->integer(self::YEAR)->nullable();
            $table->integer(self::LENGTH)->nullable();
            $table->integer(self::PLAYS)->nullable();
            $table->integer(self::RATING)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
};
