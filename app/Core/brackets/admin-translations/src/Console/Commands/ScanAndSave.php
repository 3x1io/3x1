<?php

namespace Brackets\AdminTranslations\Console\Commands;

use Brackets\AdminTranslations\Translation;
use Brackets\AdminTranslations\TranslationsScanner;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputArgument;

class ScanAndSave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'admin-translations:scan-and-save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scans all PHP files, extract translations and stores them into the database';

    protected function getArguments()
    {
        return [
            ['paths', InputArgument::IS_ARRAY, 'Array of paths to scan.', (array) config('admin-translations.scanned_directories')],
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $scanner = app(TranslationsScanner::class);
        collect($this->argument('paths'))->each(function ($path) use ($scanner) {
            $scanner->addScannedPath($path);
        });

        list($trans, $__) = $scanner->getAllViewFilesWithTranslations();

        /** @var Collection $trans */
        /** @var Collection $__ */

        DB::transaction(function () use ($trans, $__) {
            Translation::query()
                ->whereNull('deleted_at')
                ->update([
                    'deleted_at' => Carbon::now()
                ]);

            $trans->each(function ($trans) {
                list($group, $key) = explode('.', $trans, 2);
                $namespaceAndGroup = explode('::', $group, 2);
                if (count($namespaceAndGroup) === 1) {
                    $namespace = '*';
                    $group = $namespaceAndGroup[0];
                } else {
                    list($namespace, $group) = $namespaceAndGroup;
                }
                $this->createOrUpdate($namespace, $group, $key);
            });

            $__->each(function ($default) {
                $this->createOrUpdate('*', '*', $default);
            });

            $this->info(($trans->count() + $__->count()).' translations saved');
        });
    }

    /**
     * @param $namespace
     * @param $group
     * @param $key
     */
    protected function createOrUpdate($namespace, $group, $key): void
    {
        /** @var Translation $translation */
        $translation = Translation::withTrashed()
            ->where('namespace', $namespace)
            ->where('group', $group)
            ->where('key', $key)
            ->first();

        $defaultLocale = config('app.locale');

        if ($translation) {
            if (!$this->isCurrentTransForTranslationArray($translation, $defaultLocale)) {
                $translation->restore();
            }
        } else {
            $translation = Translation::make([
                'namespace' => $namespace,
                'group' => $group,
                'key' => $key,
                'text' => [],
            ]);

            if (!$this->isCurrentTransForTranslationArray($translation, $defaultLocale)) {
                $translation->save();
            }
        }
    }

    /**
     * @param Translation $translation
     * @param $locale
     * @return bool
     */
    private function isCurrentTransForTranslationArray(Translation $translation, $locale): bool
    {
        if ($translation->group === '*') {
            return is_array(__($translation->key, [], $locale));
        }

        if ($translation->namespace === '*') {
            return is_array(trans($translation->group.'.'.$translation->key, [], $locale));
        }

        return is_array(trans($translation->namespace . '::' . $translation->group . '.' . $translation->key, [], $locale));
    }
}
