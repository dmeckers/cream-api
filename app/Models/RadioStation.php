<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\TelegramUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Builder
 */
class RadioStation extends Model
{
    use HasFactory;

    public const TABLE = 'stations';

    public const ID               = 'id';
    public const STATION_NAME     = 'name';
    public const STATION_URL      = 'url';
    public const TELEGRAM_USER_ID = 'telegram_user_id';
    public const MOUNT_POINT      = 'mount_point';
    public const DESCRIPTION      = 'description';
    public const GENRE            = 'genre';
    public const IS_LIVE          = 'is_live';

    protected $table = self::TABLE;

    protected $fillable = [
        self::STATION_NAME,
        self::STATION_URL,
        self::TELEGRAM_USER_ID,
        self::MOUNT_POINT,
        self::DESCRIPTION,
        self::GENRE,
        self::IS_LIVE,
    ];

    protected $casts = [
        self::IS_LIVE => 'boolean',
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

    public function getId(): int
    {
        return $this->getAttribute(self::ID);
    }

    public function getName(): string
    {
        return $this->getAttribute(self::STATION_NAME);
    }

    public function getUrl(): string
    {
        return $this->getAttribute(self::STATION_URL);
    }

    public function getTelegramUserId(): int
    {
        return $this->getAttribute(self::TELEGRAM_USER_ID);
    }

    public function getMountPoint(): string
    {
        return $this->getAttribute(self::MOUNT_POINT);
    }

    public function getDescription(): string
    {
        return 'No description';
        // return $this->getAttribute(self::DESCRIPTION) ?? '';
    }

    public function getGenre(): string
    {
        return $this->getAttribute(self::GENRE) ?? 'No genre';
    }


}