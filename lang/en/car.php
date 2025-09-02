<?php

return [
    'title' => 'Car',
    'plural' => 'Cars',
    'navigation_label' => 'Cars',
    'navigation_group' => 'Vehicle Management',
    
    'fields' => [
        'title' => 'Title',
        'year' => 'Year',
        'make' => 'Make',
        'model' => 'Model',
        'vin_number' => 'VIN Number',
        'regular_price' => 'Regular Price',
        'sale_price' => 'Sale Price',
        'request_price' => 'Request Price',
        'request_price_status' => 'Request Price Status',
        'location' => 'Location',
        'images' => 'Images',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],
    
    'labels' => [
        'select_location' => 'Select Location',
        'upload_images_help' => 'Upload up to 10 images, max size 10MB, only JPEG, PNG, GIF, and BMP files are allowed',
    ],
    
    'pages' => [
        'list' => 'List Cars',
        'create' => 'Create Car',
        'edit' => 'Edit Car',
        'view' => 'View Car',
    ],
    
    'actions' => [
        'view' => 'View',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'create' => 'New Car',
    ],
];