<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AppSettings extends Settings
{
    public string $name;
    public ?string $logo;
    public ?string $favicon;
    public ?string $loginLogo;
    public ?string $loginBackground;

    public static function group(): string
    {
        return 'app';
    }
}
