<?php

return [
    'title' => 'لاگ فعالیت‌ها',
    'description' => 'مشاهده تمام فعالیت‌های سیستم و اقدامات کاربران',
    'navigation_label' => 'لاگ فعالیت‌ها',
    
    'columns' => [
        'user' => 'کاربر',
        'model' => 'مدل',
        'event' => 'رویداد',
        'description' => 'توضیحات',
        'date_time' => 'تاریخ و زمان',
        'has_record' => 'دارای رکورد',
    ],
    
    'events' => [
        'created' => 'ایجاد شده',
        'updated' => 'به‌روزرسانی شده',
        'deleted' => 'حذف شده',
        'restored' => 'بازیابی شده',
    ],
    
    'filters' => [
        'event_type' => 'نوع رویداد',
        'model_type' => 'نوع مدل',
        'date_range' => 'محدوده تاریخ',
        'from' => 'از',
        'to' => 'تا',
        'select_event_type' => 'نوع رویداد را انتخاب کنید',
        'select_model_type' => 'نوع مدل را انتخاب کنید',
    ],
    
    'tooltips' => [
        'user' => 'کاربری که عمل را انجام داده است',
        'model' => 'نوع مدلی که تحت تأثیر قرار گرفته است',
        'event' => 'نوع عمل انجام شده',
        'date_time' => 'زمانی که عمل رخ داده است',
        'has_record' => 'آیا رکورد تحت تأثیر هنوز وجود دارد',
        'view_details' => 'مشاهده جزئیات فعالیت',
    ],
    
    'indicators' => [
        'from' => 'از :date',
        'to' => 'تا :date',
    ],
    
    'messages' => [
        'no_records' => 'هیچ رکوردی یافت نشد',
        'view_all_activities' => 'مشاهده تمام فعالیت‌های سیستم و اقدامات کاربران',
        'start_date' => 'تاریخ شروع',
        'end_date' => 'تاریخ پایان',
    ],
    
    'actions' => [
        'view' => 'مشاهده',
        'view_details' => 'مشاهده جزئیات',
    ],
];