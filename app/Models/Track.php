<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    public const TABLE = 'tracks';

    public const ID       = 'id';
    public const NAME     = 'name';
    public const ARTIST   = 'artist';
    public const ALBUM    = 'album';
    public const GENRE    = 'genre';
    public const YEAR     = 'year';
    public const LENGTH   = 'length';
    public const PLAYS    = 'plays';
    public const RATING   = 'rating';
    public const FILE_URL = 'file_url';

    protected $fillable = [
        self::NAME,
        self::ARTIST,
        self::ALBUM,
        self::GENRE,
        self::YEAR,
        self::LENGTH,
        self::PLAYS,
        self::RATING,
        self::FILE_URL,
    ];

    protected $casts = [
        self::FILE_URL => 'string',
        self::NAME => 'string',
        self::ARTIST => 'string',
        self::ALBUM => 'string',
        self::GENRE => 'string',
        self::YEAR => 'integer',
        self::LENGTH => 'integer',
        self::PLAYS => 'integer',
        self::RATING => 'integer',
    ];

    public function getName(): string
    {
        return $this->getAttribute(self::NAME);
    }

    public function getArtist(): string
    {
        return $this->getAttribute(self::ARTIST);
    }

    public function getAlbum(): string
    {
        return $this->getAttribute(self::ALBUM);
    }

    public function getGenre(): string
    {
        return $this->getAttribute(self::GENRE);
    }

    public function getYear(): int
    {
        return $this->getAttribute(self::YEAR);
    }

    public function getLength(): int
    {
        return $this->getAttribute(self::LENGTH);
    }

    public function getPlays(): int
    {
        return $this->getAttribute(self::PLAYS);
    }

    public function getRating(): int
    {
        return $this->getAttribute(self::RATING);
    }

    public function getFileUrl(): string
    {
        return $this->getAttribute(self::FILE_URL);
    }

    public function getId(): int
    {
        return $this->getAttribute(self::ID);
    }
}