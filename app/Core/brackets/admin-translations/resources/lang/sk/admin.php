<?php

return [
    'title' => 'Preklady',

    'btn' => [
        're_scan' => 'Preskenovať preklady',
        'export' => 'Exportovať',
        'import' => 'Importovať',
    ],

    'fields' => [
        'group' => 'Skupina',
        'default' => 'Prednastavené',
        'english' => 'English',
        'current_value' => 'Aktuálna hodnota',
        'imported_value' => 'Importovaná hodnota',
        'select_language' => 'Vybrať jazyk',
        'created_at' => 'Vytvorené',
    ],

    'import' => [
        'title' => 'Import prekladov',
        'notice' => 'Môžeš importovať preklady vybraného jazyka z .xslx súboru. Importovaný súbor musí mať rovnakú štruktúru ako súbor vygenerovaný v exporte prekladov.',
        'language_to_import' => 'Jazyk na importovanie',
        'do_not_override' => 'Neprepisovať existujúce preklady',
        'conflict_notice_we_have_found' => 'Našli sme',
        'conflict_notice_translations_to_be_imported' => 'prekladov na importovanie. Prosím preskúmaj ich',
        'conflict_notice_differ' => 'preklady, ktoré sa líšia pred pokračovaním.',
        'sucesfully_notice' => 'prekladov úspešne importovaných',
        'sucesfully_notice_update' => 'prekladov úspešne aktualizovaných.',
        'choose_file' => 'Vybrať súbor',
        'upload_file' => 'Nahrať súbor',
    ],

    'export' => [
        'notice' => 'Môžeš exportovať preklady vybraného jazyka ako .xslx súbor.',
        'language_to_export' => 'Jazyk na importovanie',
        'export_reference_language' => 'Exportovať povôdný jazyk - užitočné ak chceš vidieť preklad v pôvodnom jazyku v rozdielnom stĺpci, preklady si môžeš jednoducho porovnať.',
        'reference_langauge' => 'Pôvodný jazyk'
    ],

    'index' => [
        'title' => 'Zoznam prekladov',
        'export' => 'Exportovať preklady',

        'all_groups' => 'Všetky skupiny',
        'edit' => 'Upraviť preklad',
        'default_text' => 'Prednastavený text',
        'translation' => 'preklad',
        'translation_for_language' => 'Zadaj preklad pre :locale jazyk.',

        'no_items' => 'Nenašli sa žiadne preklady',
        'try_changing_items' => 'Skúste zmeniť filter alebo preskenujte preklady.',
    ],
];
