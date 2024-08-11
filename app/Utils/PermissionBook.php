<?php

declare(strict_types=1);

namespace App\Utils;

use App\Policies\TrackPolicy;

class PermissionBook
{
    public const CREATE_TRACK_GATE   = 'track_create';
    public const UPDATE_TRACK_GATE   = 'track_update';
    public const DELETE_TRACK_GATE   = 'track_delete';
    public const VIEW_ALL_TRACK_GATE = 'track_view_all';

    public const CREATE_TRACK_PERMISSION   = 'track.create';
    public const UPDATE_TRACK_PERMISSION   = 'track.update';
    public const DELETE_TRACK_PERMISSION   = 'track.delete';
    public const VIEW_ALL_TRACK_PERMISSION = 'track.view-all';

    public const PERMISSIONS = [
        self::CREATE_TRACK_PERMISSION,
        self::UPDATE_TRACK_PERMISSION,
        self::DELETE_TRACK_PERMISSION,
        self::VIEW_ALL_TRACK_PERMISSION,
    ];

    public const GATES = [
        self::CREATE_TRACK_GATE,
        self::UPDATE_TRACK_GATE,
        self::DELETE_TRACK_GATE,
        self::VIEW_ALL_TRACK_GATE,
    ];

    public const GATE_TO_PERMISSION = [
        self::CREATE_TRACK_GATE => self::CREATE_TRACK_PERMISSION,
        self::UPDATE_TRACK_GATE => self::UPDATE_TRACK_PERMISSION,
        self::DELETE_TRACK_GATE => self::DELETE_TRACK_PERMISSION,
        self::VIEW_ALL_TRACK_GATE => self::VIEW_ALL_TRACK_PERMISSION,
    ];

    public const GATE_TO_POLICY = [
        self::CREATE_TRACK_GATE => [TrackPolicy::class, 'create'],
        self::UPDATE_TRACK_GATE => [TrackPolicy::class, 'update'],
        self::DELETE_TRACK_GATE => [TrackPolicy::class, 'delete'],
        self::VIEW_ALL_TRACK_GATE => [TrackPolicy::class, 'viewAll'],
    ];
}