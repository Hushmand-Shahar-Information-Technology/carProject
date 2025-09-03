<?php

return [
    'title' => 'کاربر',
    'plural' => 'کاربران',
    'navigation_label' => 'کاربران',
    'navigation_group' => 'مدیریت کاربران',
    
    'fields' => [
        'name' => 'نام',
        'email' => 'ایمیل',
        'email_verified_at' => 'تصدیق ایمیل',
        'password' => 'رمز عبور',
        'created_at' => 'تاریخ ایجاد',
        'updated_at' => 'تاریخ به‌روزرسانی',
    ],
    
    'pages' => [
        'list' => 'فهرست کاربران',
        'create' => 'ایجاد کاربر',
        'edit' => 'ویرایش کاربر',
        'view' => 'مشاهده کاربر',
    ],
    
    'actions' => [
        'view' => 'مشاهده',
        'edit' => 'ویرایش',
        'delete' => 'حذف',
        'create' => 'کاربر جدید',
    ],
    
    'filters' => [
        'name' => 'نام',
        'email' => 'ایمیل',
        'email_verified' => 'تصدیق ایمیل',
        'registration_date' => 'تاریخ ثبت‌نام',
        'search_name_placeholder' => 'نام را برای جستجو وارد کنید...',
        'search_email_placeholder' => 'ایمیل را برای جستجو وارد کنید...',
        'registered_from' => 'ثبت‌نام از',
        'registered_until' => 'ثبت‌نام تا',
        'select_date' => 'انتخاب تاریخ',
        'all_users' => 'تمام کاربران',
        'verified_users' => 'کاربران تصدیق شده',
        'unverified_users' => 'کاربران تصدیق نشده',
        'name_indicator' => 'نام شامل: :name',
        'email_indicator' => 'ایمیل شامل: :email',
        'registered_from_indicator' => 'ثبت‌نام از: :date',
        'registered_until_indicator' => 'ثبت‌نام تا: :date',
        'verified_indicator' => 'کاربران ایمیل تصدیق شده',
        'unverified_indicator' => 'کاربران ایمیل تصدیق نشده',
        'has_cars' => 'صاحب موتر',
        'all_users_cars' => 'تمام کاربران',
        'users_with_cars' => 'کاربران صاحب موتر',
        'users_without_cars' => 'کاربران بدون موتر',
        'car_count' => 'تعداد موتر',
        'min_cars' => 'حداقل موتر',
        'max_cars' => 'حداکثر موتر',
        'min_cars_indicator' => 'حداقل موتر: :count',
        'max_cars_indicator' => 'حداکثر موتر: :count',
    ],
];