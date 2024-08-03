<?php
    return [
        'organization' => env('AZURE_DEVOPS_ORGANIZATION'),
        'project' => env('AZURE_DEVOPS_PROJECT'),
        'pat' => env('AZURE_DEVOPS_PAT'),
        'webhook_secret' => env('AZURE_DEVOPS_WEBHOOK_SECRET'),
        'area_path' => env('AZURE_DEVOPS_AREA_PATH'),
        'app'=>[
            'page_title'=>env('AZURE_DEVOPS_APP_PAGE_TITLE','AzTicketing'),
        ],
        'enable_views'=>env('AZURE_DEVOPS_ENABLE_VIEWS',true),
        'routes'=>[
            'prefix'=>env('AZURE_DEVOPS_ROUTES_PREFIX','azticketing'),
            'middleware'=>env('AZURE_DEVOPS_ROUTES_MIDDLEWARE','web'),
        ],
    ];
