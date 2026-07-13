<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been added.
    |
    | Additional module paths are added here so each module's controllers can
    | call view() without any namespace prefix.
    |
    */

    'paths' => array_filter([
        realpath(__DIR__ . '/../resources/views'),

        // Purchase & Requisition module views
        realpath(__DIR__ . '/../../Purchase-and-Requisition/resources/views'),

        // Goods Receipt & Invoice Matching module views
        realpath(__DIR__ . '/../../Goods-Receipt-Invoice-Matching/resources/views'),

        // Supplier Management module views
        realpath(__DIR__ . '/../../Supplier-Management/resources/views'),
    ]),

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

];
