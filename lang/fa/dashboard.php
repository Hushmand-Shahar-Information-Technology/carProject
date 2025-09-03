<?php

return [
    'title' => 'داشبورد',
    'welcome' => 'به داشبورد خوش آمدید',
    'overview' => 'نمای کلی',
    'statistics' => 'آمار',
    'recent_activity' => 'فعالیت اخیر',
    'view_all' => 'مشاهده همه',
    
    'widgets' => [
        'stats_overview' => [
            'title' => 'بررسی آماری',
            'total_cars' => 'مجموعه موترها',
            'total_offers' => 'مجموعه پیشنهادات',
            'total_users' => 'مجموعه کاربران',
            'recent_activity' => 'فعالیت اخیر',
        ],
        
        'car_sales_chart' => [
            'title' => 'روند فروش موتر',
            'description' => 'لیست موترها و فروش ماهانه',
            'listings' => 'لیست‌ها',
            'sales' => 'فروش',
            'months' => [
                'jan' => 'ژانویه',
                'feb' => 'فوریه',
                'mar' => 'مارس',
                'apr' => 'آوریل',
                'may' => 'مه',
                'jun' => 'ژوئن',
                'jul' => 'ژوئیه',
                'aug' => 'اوت',
                'sep' => 'سپتامبر',
                'oct' => 'اکتبر',
                'nov' => 'نوامبر',
                'dec' => 'دسامبر',
            ],
        ],
        
        'offer_analytics' => [
            'title' => 'تحلیل پیشنهادات',
            'description' => 'آمار پیشنهادات و نرخ تبدیل',
            'total_offers' => 'مجموعه پیشنهادات',
            'accepted_offers' => 'پذیرفته شده',
            'rejected_offers' => 'رد شده',
            'pending_offers' => 'در انتظار',
            'conversion_rate' => 'نرخ تبدیل',
        ],
        
        'recent_activities' => [
            'title' => 'فعالیت‌های اخیر',
            'description' => 'آخرین موترها، پیشنهادات و ثبت نام کاربران',
            'no_activities' => 'فعالیت اخیر یافت نشد',
            'car_added' => 'موتری جدید اضافه شد: :title',
            'offer_submitted' => 'پیشنهاد جدید برای :car ارسال شد',
            'user_registered' => 'کاربر جدید ثبت نام کرد: :name',
            'car_added_tooltip' => 'موتری جدید اضافه شد',
        ],
        
        'popular_cars' => [
            'title' => 'موترهای محبوب',
            'description' => 'بیشترین بازدید/پیشنهاد موترها',
            'no_popular_cars' => 'موتری محبوبی یافت نشد',
            'car' => 'موتر',
            'make' => 'برند',
            'model' => 'مدل',
            'views' => 'بازدیدها',
            'offers' => 'پیشنهادات',
        ],
    ],
    
    'messages' => [
        'no_data' => 'داده‌ای موجود نیست',
        'loading' => 'در حال بارگذاری داده‌های داشبورد...',
    ],
];