<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\TelegramUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RadioStation extends Model
{
    use HasFactory;

    public const TABLE            = 'stations';
    public const STATION_NAME     = 'name';
    public const STATION_URL      = 'url';
    public const TELEGRAM_USER_ID = 'telegram_user_id';

    protected $table = self::TABLE;

    protected $fillable = [
        self::STATION_NAME,
        self::STATION_URL,
        self::TELEGRAM_USER_ID,
    ];

    public function relatedOwner(): ?TelegramUser
    {
        return $this->owner()->first();
    }

    /**
     * @return Collection|RadioStationPlaylist[]
     */
    public function relatedPlaylists(): Collection
    {
        return $this->playlists()->get();
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(TelegramUser::class, self::TELEGRAM_USER_ID);
    }

    public function playlists(): HasMany
    {
        return $this->hasMany(RadioStationPlaylist::class, RadioStationPlaylist::STATION_ID);
    }
}
