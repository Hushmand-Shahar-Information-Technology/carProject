<?php

return [
    'title' => 'Activity Log',
    'description' => 'View all system activities and user actions',
    'navigation_label' => 'Activity Log',
    
    'columns' => [
        'user' => 'User',
        'model' => 'Model',
        'event' => 'Event',
        'description' => 'Description',
        'date_time' => 'Date & Time',
        'has_record' => 'Has Record',
    ],
    
    'events' => [
        'created' => 'Created',
        'updated' => 'Updated',
        'deleted' => 'Deleted',
        'restored' => 'Restored',
    ],
    
    'filters' => [
        'event_type' => 'Event Type',
        'model_type' => 'Model Type',
        'date_range' => 'Date Range',
        'from' => 'From',
        'to' => 'To',
        'select_event_type' => 'Select an event type',
        'select_model_type' => 'Select a model type',
    ],
    
    'tooltips' => [
        'user' => 'User who performed the action',
        'model' => 'Model type that was affected',
        'event' => 'Type of action performed',
        'date_time' => 'When the action occurred',
        'has_record' => 'Whether the affected record still exists',
        'view_details' => 'View activity details',
    ],
    
    'indicators' => [
        'from' => 'From :date',
        'to' => 'To :date',
    ],
    
    'messages' => [
        'no_records' => 'No records found',
        'view_all_activities' => 'View all system activities and user actions',
        'start_date' => 'Start date',
        'end_date' => 'End date',
    ],
    
    'actions' => [
        'view' => 'View',
        'view_details' => 'View Details',
    ],
    
    'details' => [
        'title' => 'Activity Details',
        'back_to_list' => 'Back to List',
        'properties' => 'Properties',
        'old_values' => 'Old Values',
        'new_values' => 'New Values',
        'no_changes' => 'No changes recorded',
        'attribute' => 'Attribute',
        'old' => 'Old',
        'new' => 'New',
    ],
];