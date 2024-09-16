<?php

declare(strict_types=1);

use App\Models\TelegramUser;
use App\Models\Track;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private const STATION_TABLE       = 'stations';
    private const STATION_NAME        = 'name';
    private const STATION_URL         = 'url';
    private const TELEGRAM_USER_ID    = 'telegram_user_id';
    private const STATION_MOUNT_POINT = 'mount_point';
    private const STATION_DESCRIPTION = 'description';
    private const STATION_GENRE       = 'genre';
    private const STATOIN_IS_LIVE     = 'is_live';

    private const PLAYLISTS_TABLE            = 'playlists';
    private const PLAYLIST_TRACK_PIVOT_TABLE = 'playlist_track';
    private const PLAYLIST_NAME              = 'name';
    private const STATION_ID                 = 'station_id';

    private const BAD_IDEA_BUT_OK_FOR_NOW = 'current_playlist_id';

    public function up(): void
    {
        Schema::create(self::STATION_TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(self::STATION_NAME);
            $table->string(self::STATION_URL)->nullable();
            $table->string(self::STATION_MOUNT_POINT)->nullable();
            $table->string(self::STATION_DESCRIPTION)->nullable();
            $table->string(self::STATION_GENRE)->nullable();
            $table->boolean(self::STATOIN_IS_LIVE)->default(false);

            $table->foreignId(self::TELEGRAM_USER_ID)
                ->constrained(TelegramUser::TABLE)
                ->cascadeOnDelete();

            $table->timestamps();
        });


        Schema::create(self::PLAYLISTS_TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(self::PLAYLIST_NAME);
            $table->foreignId(self::STATION_ID)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create(self::PLAYLIST_TRACK_PIVOT_TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId(self::PLAYLISTS_TABLE)->constrained()->cascadeOnDelete();
            $table->foreignId(Track::TABLE)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::table(self::STATION_TABLE, function (Blueprint $table) {
            $table->foreignId(self::BAD_IDEA_BUT_OK_FOR_NOW)
                ->nullable()
                ->constrained(self::PLAYLISTS_TABLE)
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::PLAYLIST_TRACK_PIVOT_TABLE);
        Schema::dropIfExists(self::TABLE);
        Schema::dropIfExists(self::TABLE);
    }
};
