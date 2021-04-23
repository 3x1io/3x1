<?php

return [
    'title' => 'Translations',

    'btn' => [
        're_scan' => 'Re-scan translations',
        'export' => 'Export',
        'import' => 'Import',
    ],

    'fields' => [
        'group' => 'Group',
        'default' => 'Default',
        'namespace' => 'Namespace',
        'english' => 'English',
        'current_value' => 'Current value',
        'imported_value' => 'Imported value',
        'select_language' => 'Select language',
        'created_at' => 'Created at',
    ],

    'import' => [
        'title' => 'Translations import',
        'notice' => 'You can import translations of a selected language from the .xslx file. Imported file must have identical structure as generated in Translations export.',
        'language_to_import' => 'Language to import',
        'do_not_override' => 'Do not override existing translations',
        'conflict_notice_we_have_found' => 'We have found',
        'conflict_notice_translations_to_be_imported' => 'translations in total to be imported. Please review',
        'conflict_notice_differ' => 'translations that differs before continuing.',
        'sucesfully_notice' => 'translations sucesfully imported',
        'sucesfully_notice_update' => 'translations sucesfully updated.',
        'choose_file' => 'Choose file',
        'upload_file' => 'Upload File',
    ],

    'export' => [
        'notice' => 'You can export translations of a selected language as .xslx file.',
        'language_to_export' => 'Language to export',
        'export_reference_language' => 'Export reference language - this is useful if you want to see the translation in the original language in a separate column, so you can easily compare.',
        'reference_langauge' => 'Reference language'
    ],

    'index' => [
        'title' => 'Translations list',
        'export' => 'Translations export',

        'all_groups' => 'All groups',
        'edit' => 'Edit translation',
        'default_text' => 'Default text',
        'translation' => 'translation',
        'translation_for_language' => 'Type a translation for :locale language.',

        'no_items' => 'Could not find any translations',
        'try_changing_items' => 'Try changing the filters or re-scan',
    ],
];
