<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ExternalAgent extends Authenticatable
{
    use HasFactory, HasApiTokens, HasPermissions;

    public const TABLE    = 'external_agents';
    public const NAME     = 'name';
    public const EMAIL    = 'email';
    public const PASSWORD = 'password';

    protected $table = self::TABLE;

    protected $fillable = [
        self::NAME,
        self::EMAIL,
        self::PASSWORD,
    ];

    protected $hidden = [
        self::PASSWORD,
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        self::PASSWORD => 'hashed',
    ];
}
