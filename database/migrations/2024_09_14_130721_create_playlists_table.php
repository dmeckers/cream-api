<?php

declare(strict_types=1);

use App\Models\Track;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const TABLE = 'playlists';
    private const NAME  = 'name';

    private const PLAYLIST_TRACK_PIVOT_TABLE = 'playlist_track';

    private const STATION_ID = 'station_id';

    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(self::NAME);
            $table->foreignId(self::STATION_ID)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create(self::PLAYLIST_TRACK_PIVOT_TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId(self::TABLE)->constrained()->cascadeOnDelete();
            $table->foreignId(Track::TABLE)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::PLAYLIST_TRACK_PIVOT_TABLE);
        Schema::dropIfExists(self::TABLE);
    }
};
