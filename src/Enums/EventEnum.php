<?php

declare(strict_types=1);

namespace App\Enums;

enum EventEnum: string
{
    case EVENT_BIRTHDAY_PARTIES = "event_birthday_parties";
    case EVENT_PRIVATE_PARTIES = "event_private_parties";
    case EVENT_CUSTOM_PARTIES = "event_custom_parties";
    case EVENT_UNKNOWN_PARTIES = "event_unknown_parties";

    public function label(): string {
        return self::getEventType($this);
    }

    public static function getEventType(self $value): string
    {
        return match($value)
        {
            self::EVENT_BIRTHDAY_PARTIES => "event_birthday_parties",
            self::EVENT_PRIVATE_PARTIES => "event_private_parties",
            self::EVENT_CUSTOM_PARTIES => "event_custom_parties",
            self::EVENT_UNKNOWN_PARTIES => "event_unknown_parties",
        };
    }
}
