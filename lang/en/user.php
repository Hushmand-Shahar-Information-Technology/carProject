<?php

return [
    'title' => 'User',
    'plural' => 'Users',
    'navigation_label' => 'Users',
    'navigation_group' => 'User Management',
    
    'fields' => [
        'name' => 'Name',
        'email' => 'Email',
        'email_verified_at' => 'Email Verified At',
        'password' => 'Password',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],
    
    'pages' => [
        'list' => 'List Users',
        'create' => 'Create User',
        'edit' => 'Edit User',
        'view' => 'View User',
    ],
    
    'actions' => [
        'view' => 'View',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'create' => 'New User',
    ],
    
    'filters' => [
        'name' => 'Name',
        'email' => 'Email',
        'email_verified' => 'Email Verified',
        'registration_date' => 'Registration Date',
        'search_name_placeholder' => 'Enter name to search...',
        'search_email_placeholder' => 'Enter email to search...',
        'registered_from' => 'Registered From',
        'registered_until' => 'Registered Until',
        'select_date' => 'Select Date',
        'all_users' => 'All Users',
        'verified_users' => 'Verified Users',
        'unverified_users' => 'Unverified Users',
        'name_indicator' => 'Name contains: :name',
        'email_indicator' => 'Email contains: :email',
        'registered_from_indicator' => 'Registered from: :date',
        'registered_until_indicator' => 'Registered until: :date',
        'verified_indicator' => 'Email verified users',
        'unverified_indicator' => 'Email unverified users',
        'has_cars' => 'Has Cars',
        'all_users_cars' => 'All Users',
        'users_with_cars' => 'Users with Cars',
        'users_without_cars' => 'Users without Cars',
        'car_count' => 'Car Count',
        'min_cars' => 'Min Cars',
        'max_cars' => 'Max Cars',
        'min_cars_indicator' => 'Min cars: :count',
        'max_cars_indicator' => 'Max cars: :count',
    ],
];