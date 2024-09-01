<?php

declare(strict_types=1);

namespace App\Http\Requests\Tracks;

use App\Models\Track;
use App\Utils\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;

class DeleteTrackRequest extends FormRequest
{
    private const TRACK_ID_ROUTE_KEY = 'track_id';

    public function rules(): array
    {
        return [
            self::TRACK_ID_ROUTE_KEY => [
                ValidationRuleHelper::REQUIRED,
                ValidationRuleHelper::INTEGER,
                ValidationRuleHelper::existsOnDatabase(Track::TABLE, Track::ID)
            ]
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([self::TRACK_ID_ROUTE_KEY => $this->getTrackId()]);
    }

    public function getTrackId(): int
    {
        return (int) $this->route(self::TRACK_ID_ROUTE_KEY);
    }
}