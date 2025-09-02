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
];