<?php

declare(strict_types=1);

namespace App\Utils;

use App\Enums\RegexEnum;
use App\Models\Users\User\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;

final class ValidationRuleHelper
{
    // Email
    public const EMAIL                 = [self::STRING, 'email:strict,dns'];
    public const EMAIL_NOT_YOPA        = [...self::EMAIL, self::REGEX . RegexEnum::EXCLUDE_YOPA_EMAIL];
    public const EMAIL_YOPA            = [self::REGEX . RegexEnum::INCLUDES_YOPA_EMAIL];
    public const EMAIL_UNIQUE          = [...self::EMAIL, self::UNIQUE . ':' . User::TABLE . ',' . User::EMAIL];
    public const EMAIL_UNIQUE_NOT_YOPA = [...self::EMAIL_UNIQUE, self::REGEX . RegexEnum::EXCLUDE_YOPA_EMAIL];

    // General
    public const NAME              = [self::STRING, 'min:2', 'max:255', self::REGEX . RegexEnum::NAME];
    public const PHONE             = [self::STRING, 'min:8', self::REGEX . RegexEnum::PHONE];
    public const PASSWORD          = [self::STRING, 'min:8', self::REGEX . RegexEnum::PASSWORD];
    public const POSTCODE          = [self::STRING, 'min:5', 'max:7', self::REGEX . RegexEnum::POSTCODE];
    public const POSTCODE_WITH_TBC = [self::STRING, 'min:5', 'max:7', self::REGEX . RegexEnum::POSTCODE_WITH_TBC];
    public const OUTCODE           = [self::STRING, 'min:2', 'max:4', self::REGEX . RegexEnum::OUTCODE];

    // Formats
    public const DATETIME_FORMAT = ['date_format:Y-m-d H:i:s'];
    public const DATE_FORMAT     = ['date_format:Y-m-d'];

    // Keys
    public const REQUIRED             = 'required';
    public const REQUIRED_IF          = 'required_if';
    public const REQUIRED_WITH        = 'required_with';
    public const REQUIRED_WITHOUT_ALL = 'required_without_all';
    public const SOMETIMES            = 'sometimes';
    public const NULLABLE             = 'nullable';
    public const EXISTS               = 'exists';
    public const STRING               = 'string';
    public const ARRAY                = 'array';
    public const JSON                 = 'json';
    public const BOOLEAN              = 'boolean';
    public const INTEGER              = 'integer';
    public const UNIQUE               = 'unique';
    public const IN                   = 'in:';
    public const REGEX                = 'regex:';
    public const DATE                 = 'date';
    public const NUMERIC              = 'numeric';

    // Geography
    public const LATITUDE  = [self::REGEX . RegexEnum::LATITUDE];
    public const LONGITUDE = [self::REGEX . RegexEnum::LONGITUDE];

    // Files
    public const FILE      = 'file';
    public const PICTURES  = ['jpg', 'jpeg', 'bmp', 'png', 'gif'];
    public const DOCUMENTS = ['webp', 'pdf', 'doc', 'docx'];

    private const FIELDS = 'fields';

    /* @see https://laravel.com/docs/9.x/validation#rule-exists */
    public static function existsOnDatabase(string $table, string $column): Exists
    {
        return Rule::exists($table, $column);
    }

    /* @see https://laravel.com/docs/9.x/validation#rule-unique */
    public static function uniqueOnDatabase(string $table, string $column): Unique
    {
        return Rule::unique($table, $column);
    }

    public function uniqueOnDatabaseWhere(string $table, string $column, array $whereArguments): Unique
    {
        return Rule::unique($table, $column)
            ->where(fn(Builder $query) => $query->where(...$whereArguments));
    }

    public function uniqueOnDatabaseMultipleWhere(string $table, string $column, array $whereArguments): Unique
    {
        return Rule::unique($table, $column)
            ->where(function (Builder $query) use ($whereArguments) {
                foreach ($whereArguments as $whereArgument) {
                    $query->where(...$whereArgument);
                }
                return $query;
            });
    }

    /* @see https://laravel.com/docs/9.x/validation#rule-required-if */
    public static function requiredIfOther(string $anotherField, string|int $value): string
    {
        return self::REQUIRED_IF . ':' . implode(',', [$anotherField, $value]);
    }

    /* @see https://laravel.com/docs/9.x/validation#rule-required-with */
    public static function requiredWith(array $anotherFields): string
    {
        return self::REQUIRED_WITH . ':' . implode(',', $anotherFields);
    }

    public static function getFieldsRules(): array
    {
        return [
            self::FIELDS => [self::SOMETIMES, self::ARRAY],
            implode('.', [self::FIELDS, '*']) => [self::STRING],
        ];
    }

    /* @see https://laravel.com/docs/9.x/validation#rule-after-or-equal */
    public static function afterOrEqual(string $date): string
    {
        return 'after_or_equal:' . $date;
    }

    public static function min(int $min): string
    {
        return 'min:' . $min;
    }

    public static function max(int|float $max): string
    {
        return 'max:' . $max;
    }

    public static function mimes(array $fileTypes): string
    {
        return 'mimes:' . implode(',', $fileTypes);
    }

    public static function enum(string $fullyQualifiedClassNamespace): Enum
    {
        return new Enum($fullyQualifiedClassNamespace);
    }

    public static function requiredWithoutAll(array $fields): string
    {
        return 'required_without_all:' . implode(',', $fields);
    }

    public static function decimalPlaces(int $from, int $to): string
    {
        return "decimal:$from,$to";
    }
}
