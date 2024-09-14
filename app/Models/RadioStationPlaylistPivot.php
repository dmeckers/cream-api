<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RadioStationPlaylistPivot extends Pivot
{
    use HasFactory;

    public const TABLE = 'playlist_track';

    protected $table = self::TABLE;
}
