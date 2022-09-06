<?php

declare(strict_types=1);

namespace App\Enums;

enum ChefSocialEnum: string
{
    case CHEF_SOCIAL_TWITTER = "twitter";
    case CHEF_SOCIAL_FACEBOOK = "facebook";
    case CHEF_SOCIAL_LINKEDIN = "linkedin";
    case CHEF_SOCIAL_INSTAGRAM = "instagram";
    case CHEF_SOCIAL_OTHER = "other";

    public function label(): string {
        return self::getSocial($this);
    }

    public static function getSocial(self $value): string
    {
        return match($value)
        {
            self::CHEF_SOCIAL_TWITTER => "twitter",
            self::CHEF_SOCIAL_FACEBOOK => "facebook",
            self::CHEF_SOCIAL_LINKEDIN => "linkedin",
            self::CHEF_SOCIAL_INSTAGRAM => "instagram",
            self::CHEF_SOCIAL_OTHER => "other"
        };
    }
}
