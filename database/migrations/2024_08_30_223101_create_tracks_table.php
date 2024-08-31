<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private const NAME     = 'name';
    private const ARTIST   = 'artist';
    private const ALBUM    = 'album';
    private const GENRE    = 'genre';
    private const YEAR     = 'year';
    private const LENGTH   = 'length';
    private const PLAYS    = 'plays';
    private const RATING   = 'rating';
    private const FILE_URL = 'file_url';

    private const TABLE = 'tracks';

    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(self::NAME);
            $table->string(self::ARTIST);
            $table->string(self::ALBUM)->nullable();
            $table->string(self::GENRE)->nullable();
            $table->integer(self::YEAR)->nullable();
            $table->integer(self::LENGTH)->nullable();
            $table->integer(self::PLAYS)->default(0);
            $table->integer(self::RATING)->default(0);
            $table->string(self::FILE_URL)->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
};
