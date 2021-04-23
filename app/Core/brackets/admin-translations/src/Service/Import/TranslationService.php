<?php

namespace Brackets\AdminTranslations\Service\Import;

use Brackets\AdminTranslations\Imports\TranslationsImport;
use Brackets\AdminTranslations\Repositories\TranslationRepository;
use Brackets\AdminTranslations\Translation;
use Exception;
use Illuminate\Support\Collection;

class TranslationService
{
    /**
     * @var TranslationRepository
     */
    protected $translationRepository;

    /**
     * TranslationService constructor.
     *
     * @param TranslationRepository $translationRepository
     */
    public function __construct(
        TranslationRepository $translationRepository
    ) {
        $this->translationRepository = $translationRepository;
    }

    /**
     * @param Collection $filteredCollection
     * @param $language
     */
    public function saveCollection(Collection $filteredCollection, $language): void
    {
        $filteredCollection->each(function ($item) use ($language) {
            $this->translationRepository->createOrUpdate($item['namespace'], $item['group'], $item['default'],
                $language, $item[$language]);
        });
    }

    /**
     * @param $row
     * @return string
     */
    public function buildKeyForArray($row): string
    {
        return $row['namespace'] . '.' . $row['group'] . '.' . $row['default'];
    }

    /**
     * @param $row
     * @param $array
     * @return bool
     */
    public function rowExistsInArray($row, $array): bool
    {
        return array_key_exists($this->buildKeyForArray($row), $array);
    }

    /**
     * @param $row
     * @param $array
     * @param $choosenLanguage
     * @return bool
     */
    public function rowValueEqualsValueInArray($row, $array, $choosenLanguage): bool
    {
        if (!empty($array[$this->buildKeyForArray($row)]['text'])) {
            if (isset($array[$this->buildKeyForArray($row)]['text'][$choosenLanguage])) {
                return $this->rowExistsInArray($row,
                        $array) && (string)$row[$choosenLanguage] === (string)$array[$this->buildKeyForArray($row)]['text'][$choosenLanguage];
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $chosenLanguage
     * @return array
     */
    public function getAllTranslationsForGivenLang($chosenLanguage): array
    {
        return Translation::all()->filter(static function ($translation) use ($chosenLanguage) {
            if (isset($translation->text->{$chosenLanguage})) {
                return array_key_exists($chosenLanguage,
                        $translation->text) && (string)$translation->text->{$chosenLanguage} !== '';
            }
            return true;
        })->keyBy(static function ($translation) {
            return $translation->namespace . '.' . $translation->group . '.' . $translation->key;
        })->toArray();
    }

    /**
     * @param $chosenLanguage
     * @param $existingTranslations
     * @param $collectionToUpdate
     * @return array
     */
    public function checkAndUpdateTranslations($chosenLanguage, $existingTranslations, $collectionToUpdate): array
    {
        $numberOfImportedTranslations = 0;
        $numberOfUpdatedTranslations = 0;

        $collectionToUpdate->map(function ($item) use (
            $chosenLanguage,
            $existingTranslations,
            &
            $numberOfUpdatedTranslations,
            &$numberOfImportedTranslations
        ) {
            if (isset($existingTranslations[$this->buildKeyForArray($item)]['id'])) {
                $id = $existingTranslations[$this->buildKeyForArray($item)]['id'];
                $existingTranslationInDatabase = Translation::find($id);
                $textArray = $existingTranslationInDatabase->text;
                if (isset($textArray[$chosenLanguage])) {
                    if ($textArray[$chosenLanguage] !== $item[$chosenLanguage]) {
                        $numberOfUpdatedTranslations++;
                        $textArray[$chosenLanguage] = $item[$chosenLanguage];
                        $existingTranslationInDatabase->update(['text' => $textArray]);
                    }
                } else {
                    $numberOfUpdatedTranslations++;
                    $textArray[$chosenLanguage] = $item[$chosenLanguage];
                    $existingTranslationInDatabase->update(['text' => $textArray]);
                }
            } else {
                $numberOfImportedTranslations++;
                $this->translationRepository->createOrUpdate($item['namespace'], $item['group'], $item['default'],
                    $chosenLanguage, $item[$chosenLanguage]);
            }
        });

        return [
            'numberOfImportedTranslations' => $numberOfImportedTranslations,
            'numberOfUpdatedTranslations' => $numberOfUpdatedTranslations
        ];
    }

    /**
     * @param $collectionFromImportedFile
     * @param $existingTranslations
     * @param $chosenLanguage
     * @return mixed
     */
    public function getCollectionWithConflicts($collectionFromImportedFile, $existingTranslations, $chosenLanguage)
    {
        return $collectionFromImportedFile->map(function ($row) use ($existingTranslations, $chosenLanguage) {
            $row['has_conflict'] = false;
            if (!$this->rowValueEqualsValueInArray($row, $existingTranslations, $chosenLanguage)) {
                $row['has_conflict'] = true;
                if (isset($existingTranslations[$this->buildKeyForArray($row)])) {
                    if (isset($existingTranslations[$this->buildKeyForArray($row)]['text'][$chosenLanguage])) {
                        $row['current_value'] = (string)$existingTranslations[$this->buildKeyForArray($row)]['text'][$chosenLanguage];
                    } else {
                        $row['has_conflict'] = false;
                        $row['current_value'] = '';
                    }
                } else {
                    $row['current_value'] = '';
                    $row['has_conflict'] = false;
                }
            }
            return $row;
        });
    }

    /**
     * @param $collectionWithConflicts
     * @return mixed
     */
    public function getNumberOfConflicts($collectionWithConflicts)
    {
        return $collectionWithConflicts->filter(static function ($row) {
            return $row['has_conflict'];
        })->count();
    }

    /**
     * @param $collectionFromImportedFile
     * @param $existingTranslations
     * @return mixed
     */
    public function getFilteredExistingTranslations($collectionFromImportedFile, $existingTranslations)
    {
        return $collectionFromImportedFile->reject(function ($row) use ($existingTranslations) {
            // filter out rows representing translations existing in the database (treat deleted_at as non-existing)
            return $this->rowExistsInArray($row, $existingTranslations);
        });
    }

    /**
     * @param $collectionToImport
     * @param $chosenLanguage
     * @return bool
     */
    public function validImportFile($collectionToImport, $chosenLanguage): bool
    {
        $requiredHeaders = ['namespace', 'group', 'default', $chosenLanguage];

        foreach ($requiredHeaders as $item) {
            if (!isset($collectionToImport->first()[$item])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $file
     * @param $chosenLanguage
     * @return mixed
     */
    public function getCollectionFromImportedFile($file, $chosenLanguage)
    {
        if ($file->getClientOriginalExtension() !== 'xlsx') {
            abort(409, 'Unsupported file type');
        }

        try {
            $collectionFromImportedFile = (new TranslationsImport())->toCollection($file)->first();

            if (!$this->validImportFile($collectionFromImportedFile, $chosenLanguage)) {
                abort(409, 'Wrong syntax in your import');
            }

            return $collectionFromImportedFile;
        } catch (Exception $e) {
            abort(409, 'Unsupported file type');
        }
    }
}
