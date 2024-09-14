<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\RadioStationPlaylistPivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RadioStationPlaylist extends Model
{
    use HasFactory;

    public const TABLE = 'playlists';
    public const NAME  = 'name';

    public const STATION_ID = 'station_id';

    protected $table = self::TABLE;

    protected $fillable = [
        self::NAME,
        self::STATION_ID,
    ];

    public function station(): BelongsTo
    {
        return $this->belongsTo(RadioStation::class, self::STATION_ID);
    }

    public function tracks(): BelongsToMany
    {
        return $this->belongsToMany(Track::class, RadioStationPlaylistPivot::TABLE);
    }
}
