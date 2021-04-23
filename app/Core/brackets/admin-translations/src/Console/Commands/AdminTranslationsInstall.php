<?php

namespace Brackets\AdminTranslations\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AdminTranslationsInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin-translations:install {--dont-install-admin-ui}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install a brackets/admin-translations package';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Installing package brackets/admin-translations');

        if (!$this->option('dont-install-admin-ui')) {
            $this->call('admin-ui:install');
        }

        $this->call('vendor:publish', [
            '--provider' => "Brackets\\AdminTranslations\\AdminTranslationsServiceProvider",
        ]);

        $this->call('vendor:publish', [
            '--provider' => "Brackets\\Translatable\\TranslatableServiceProvider",
            '--tag' => 'config'
        ]);

        $this->frontendAdjustments();

        $this->strReplaceInFile(
            resource_path('views/admin/layout/sidebar.blade.php'),
            '|url\(\'admin\/translations\'\)|',
            '{{-- Do not delete me :) I\'m also used for auto-generation menu items --}}',
            '<li class="nav-item"><a class="nav-link" href="{{ url(\'admin/translations\') }}"><i class="nav-icon icon-location-pin"></i> {{ __(\'Translations\') }}</a></li>
            {{-- Do not delete me :) I\'m also used for auto-generation menu items --}}'
        );

        $this->call('migrate');

        $this->info('Package brackets/admin-translations installed');
    }

    /**
     * @param $fileName
     * @param $ifExistsRegex
     * @param $find
     * @param $replaceWith
     * @return bool|int|void
     */
    private function strReplaceInFile($fileName, $ifExistsRegex, $find, $replaceWith)
    {
        $content = File::get($fileName);
        if (preg_match($ifExistsRegex, $content)) {
            return;
        }

        return File::put($fileName, str_replace($find, $replaceWith, $content));
    }

    /**
     * Add admin translations assets to webpack mix
     */
    private function frontendAdjustments(): void
    {
        // webpack
        $this->strReplaceInFile(
            'webpack.mix.js',
            '|vendor/brackets/admin-translations|',
            '// Do not delete this comment, it\'s used for auto-generation :)',
            'path.resolve(__dirname, \'vendor/brackets/admin-translations/resources/assets/js\'),
				// Do not delete this comment, it\'s used for auto-generation :)'
        );

        $this->info('Admin Translation assets registered');
    }
}
