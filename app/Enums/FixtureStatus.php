<?php

namespace App\Enums;

enum FixtureStatus: string
{
    case Scheduled = 'scheduled';
    case Live = 'live';
    case Finished = 'finished';
    case Postponed = 'postponed';

    public static function values(): array
    {
        return array_map(static fn (self $c) => $c->value, self::cases());
    }
}
