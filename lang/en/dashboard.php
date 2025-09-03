<?php

return [
    'title' => 'Dashboard',
    'welcome' => 'Welcome to the Dashboard',
    'overview' => 'Overview',
    'statistics' => 'Statistics',
    'recent_activity' => 'Recent Activity',
    'view_all' => 'View All',
    
    'widgets' => [
        'stats_overview' => [
            'title' => 'Stats Overview',
            'total_cars' => 'Total Cars',
            'total_offers' => 'Total Offers',
            'total_users' => 'Total Users',
            'recent_activity' => 'Recent Activity',
        ],
        
        'car_sales_chart' => [
            'title' => 'Car Sales Trend',
            'description' => 'Monthly car listings and sales',
            'listings' => 'Listings',
            'sales' => 'Sales',
            'months' => [
                'jan' => 'Jan',
                'feb' => 'Feb',
                'mar' => 'Mar',
                'apr' => 'Apr',
                'may' => 'May',
                'jun' => 'Jun',
                'jul' => 'Jul',
                'aug' => 'Aug',
                'sep' => 'Sep',
                'oct' => 'Oct',
                'nov' => 'Nov',
                'dec' => 'Dec',
            ],
        ],
        
        'offer_analytics' => [
            'title' => 'Offer Analytics',
            'description' => 'Offer statistics and conversion rates',
            'total_offers' => 'Total Offers',
            'accepted_offers' => 'Accepted',
            'rejected_offers' => 'Rejected',
            'pending_offers' => 'Pending',
            'conversion_rate' => 'Conversion Rate',
        ],
        
        'recent_activities' => [
            'title' => 'Recent Activities',
            'description' => 'Latest cars, offers, and user registrations',
            'no_activities' => 'No recent activities found',
            'car_added' => 'New car added: :title',
            'offer_submitted' => 'New offer submitted for :car',
            'user_registered' => 'New user registered: :name',
            'car_added_tooltip' => 'New car added',
        ],
        
        'popular_cars' => [
            'title' => 'Popular Cars',
            'description' => 'Most viewed/offered cars',
            'no_popular_cars' => 'No popular cars found',
            'car' => 'Car',
            'make' => 'Make',
            'model' => 'Model',
            'views' => 'Views',
            'offers' => 'Offers',
        ],
    ],
    
    'messages' => [
        'no_data' => 'No data available',
        'loading' => 'Loading dashboard data...',
    ],
];