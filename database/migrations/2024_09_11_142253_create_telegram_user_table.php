<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private const TABLE = 'telegram_user';

    private const ID               = 'id';
    private const NAME             = 'name';
    private const USERNAME         = 'username';
    private const TELEGRAM_USER_ID = 'telegram_user_id';

    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(self::TELEGRAM_USER_ID)->unique();
            $table->string(self::NAME);
            $table->string(self::USERNAME);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
};
