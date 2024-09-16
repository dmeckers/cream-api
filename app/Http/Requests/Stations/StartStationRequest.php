<?php

declare(strict_types=1);

namespace App\Http\Requests\Stations;
use App\Models\RadioStation;
use App\Utils\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;

class StartStationRequest extends FormRequest
{
    public const STATION_ID_ROUTE_KEY = 'station_id';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            self::STATION_ID_ROUTE_KEY => [
                ValidationRuleHelper::REQUIRED,
                ValidationRuleHelper::INTEGER,
                ValidationRuleHelper::existsOnDatabase(RadioStation::TABLE, RadioStation::ID),
            ],
        ];
    }

    public function data(): array
    {
        return $this->validated();
    }

    private function getStationId(): int
    {
        return (int) $this->route(self::STATION_ID_ROUTE_KEY);
    }
}