<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Autogenerate image srcSet Files',
    'description' => 'ViewHelper for generate image srcSet Tags and files',
    'category' => 'fe',
    'shy' => 0,
    'version' => '1.0.1',
    'module' => '',
    'state' => 'beta',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearcacheonload' => 1,
    'author' => 'André Flemming',
    'author_email' => 'daslampe@lano-crew.org',
    'author_company' => '',
    'constraints' => [
        'depends' => [
            'php' => '5.6-7.0.9999',
            'typo3' => '7.6.0 - 8.7.999',
        ],
        'conflicts' => [],
         'suggests' => [
            'af_lightbox' => '1.0.0',
         ],
    ],
];
?>
