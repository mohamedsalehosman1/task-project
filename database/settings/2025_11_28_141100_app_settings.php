<?php

use App\Settings\AppSettings;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('app.name', 'My App');
        $this->migrator->add('app.logo', null);
        $this->migrator->add('app.favicon', null);
        $this->migrator->add('app.loginLogo', null);
        $this->migrator->add('app.loginBackground', null);
    }
};
