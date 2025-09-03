<?php

return [
    'title' => 'کاروونکی',
    'plural' => 'کاروونکي',
    'navigation_label' => 'کاروونکي',
    'navigation_group' => 'د کاروونکو اداره',
    
    'fields' => [
        'name' => 'نوم',
        'email' => 'برېښنالیک',
        'email_verified_at' => 'د برېښنالیک تصدیق',
        'password' => 'پټنوم',
        'created_at' => 'د جوړولو نیټه',
        'updated_at' => 'د تازه کولو نیټه',
    ],
    
    'pages' => [
        'list' => 'د کاروونکو لیست',
        'create' => 'نوی کاروونکی',
        'edit' => 'کاروونکی سمول',
        'view' => 'کاروونکی کتل',
    ],
    
    'actions' => [
        'view' => 'کتل',
        'edit' => 'سمول',
        'delete' => 'پاکول',
        'create' => 'نوی کاروونکی',
    ],
    
    'filters' => [
        'name' => 'نوم',
        'email' => 'برېښنالیک',
        'email_verified' => 'د برېښنالیک تصدیق',
        'registration_date' => 'د نوملیکونے نیټه',
        'search_name_placeholder' => 'د لڼولو لپاره نوم ولیکئ...',
        'search_email_placeholder' => 'د لڼولو لپاره برېښنالیک ولیکئ...',
        'registered_from' => 'نوملیکون چې',
        'registered_until' => 'نوملیکون پورې',
        'select_date' => 'نیټه ٹاکل',
        'all_users' => 'ٹول کاروونکي',
        'verified_users' => 'تصدیق شوي کاروونکي',
        'unverified_users' => 'بې تصدیقه کاروونکي',
        'name_indicator' => 'نوم پکې شامل: :name',
        'email_indicator' => 'برېښنالیک پکې شامل: :email',
        'registered_from_indicator' => 'نوملیکون چې: :date',
        'registered_until_indicator' => 'نوملیکون پورې: :date',
        'verified_indicator' => 'د برېښنالیک تصدیق شوي کاروونکي',
        'unverified_indicator' => 'د برېښنالیک بې تصدیقه کاروونکي',
        'has_cars' => 'د موتر لرونکی',
        'all_users_cars' => 'ټول کاروونکي',
        'users_with_cars' => 'د موتر لرونکي کاروونکي',
        'users_without_cars' => 'هغه کاروونکي چې موتر نه لري',
        'car_count' => 'د موتر شمېره',
        'min_cars' => 'لږترلږه موتر',
        'max_cars' => 'زیاتمه موتر',
        'min_cars_indicator' => 'لږترلږه موتر: :count',
        'max_cars_indicator' => 'زیاتمه موتر: :count',
    ],
];