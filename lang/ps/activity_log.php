<?php

return [
    'title' => 'د فعالیت لاگ',
    'description' => 'د ټولو د سیسټم فعالیتونو او د کاروونکي اقدامات وګورئ',
    'navigation_label' => 'د فعالیت لاگ',
    
    'columns' => [
        'user' => 'کاروونکی',
        'model' => 'موډل',
        'event' => 'پیښه',
        'description' => 'توضیح',
        'date_time' => 'نیټه او وخت',
        'has_record' => 'سند لري',
    ],
    
    'events' => [
        'created' => 'جوړ شوی',
        'updated' => 'تازه شوی',
        'deleted' => 'پاک شوی',
        'restored' => 'بیا رغول شوی',
    ],
    
    'filters' => [
        'event_type' => 'د پیښې ډول',
        'model_type' => 'د موډل ډول',
        'date_range' => 'د نیټې محدودیت',
        'from' => 'له',
        'to' => 'تر',
        'select_event_type' => 'د پیښې ډول وټاکئ',
        'select_model_type' => 'د موډل ډول وټاکئ',
    ],
    
    'tooltips' => [
        'user' => 'هغه کاروونکی چې عمل ترسره کړی',
        'model' => 'د موډل ډول چې اغیزه شوی',
        'event' => 'د عمل ډول چې ترسره شوی',
        'date_time' => 'کله چې عمل ترسره شو',
        'has_record' => 'که چیرې اغیزه شوی سند لا وجود ولري',
        'view_details' => 'د فعالیت تفصیلات وګورئ',
    ],
    
    'indicators' => [
        'from' => 'له :date',
        'to' => 'تر :date',
    ],
    
    'messages' => [
        'no_records' => 'هیڅ سند ونه موندل شو',
        'view_all_activities' => 'د ټولو د سیسټم فعالیتونو او د کاروونکي اقدامات وګورئ',
        'start_date' => 'د پیل نیټه',
        'end_date' => 'د پای نیټه',
    ],
    
    'actions' => [
        'view' => 'کتل',
        'view_details' => 'تفصیلات وګورئ',
    ],
];