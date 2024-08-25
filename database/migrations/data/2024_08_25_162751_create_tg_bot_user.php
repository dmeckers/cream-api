<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

return new class extends Migration {
    private const NAME  = 'tg-master';
    private const EMAIL = 'gombovombo@gmail.com';

    private const PASSWORD = '$2y$12$2N4pllgcrHex8rM3xWSxSuVBH8YvYQJ/AS2J539EDBjRp1jE6wD2G';

    private const PERMISSION_TG_MASTER = 'tg-master';
    private const WEB_GUARD            = 'web';

    public function up(): void
    {
        $tgBot = User::create([
            User::NAME => self::NAME,
            User::EMAIL => self::EMAIL,
            User::PASSWORD => self::PASSWORD,
        ]);

        $tgBot->givePermissionTo(
            Permission::findOrCreate(
                self::PERMISSION_TG_MASTER,
                self::WEB_GUARD
            )
        );
    }

    public function down(): void
    {
        User::where(User::EMAIL, self::EMAIL)->delete();

        Permission::findByName(self::PERMISSION_TG_MASTER, self::WEB_GUARD)->delete();
    }
};
