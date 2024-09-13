<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin Builder
 */
class TelegramUser extends Authenticatable
{

    use HasFactory, Notifiable, HasApiTokens, HasPermissions, HasRoles;

    public const ID               = 'id';
    public const TABLE            = 'telegram_user';
    public const NAME             = 'name';
    public const USERNAME         = 'username';
    public const TELEGRAM_USER_ID = 'telegram_user_id';

    protected $table = self::TABLE;

    protected $fillable = [
        self::ID,
        self::NAME,
        self::USERNAME,
        self::TELEGRAM_USER_ID,
    ];
}
