<?php

declare(strict_types=1);

use App\Models\TelegramUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private const TABLE            = 'stations';
    private const STATION_NAME     = 'name';
    private const STATION_URL      = 'url';
    private const TELEGRAM_USER_ID = 'telegram_user_id';


    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(self::STATION_NAME);
            $table->string(self::STATION_URL);

            $table->foreignId(self::TELEGRAM_USER_ID)
                ->constrained(TelegramUser::TABLE)
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
};
