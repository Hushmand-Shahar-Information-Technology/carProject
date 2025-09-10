# Activity Logging System Documentation

## Overview

This project implements a comprehensive  d activity logging system using the Spatie Laravel Activity Log package. All models in the `app/Models` directory are now configured to automatically log activities when records are created, updated, or deleted.

## Implementation Details

### 1. Base Model

A [BaseModel](file:///D:/web/carProject/app/Models/BaseModel.php#L11-L26) class was created in `app/Models/BaseModel.php` that implements the Spatie `LogsActivity` trait with default configuration:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BaseModel extends Model
{
    use LogsActivity;

    /**
     * Get the options for logging activities.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
```

### 2. Updated Models

All existing models in the `app/Models` directory have been updated to extend [BaseModel](file:///D:/web/carProject/app/Models/BaseModel.php#L11-L26):

1. [Car](file:///D:/web/carProject/app/Models/Car.php#L11-L85) - extends [BaseModel](file:///D:/web/carProject/app/Models/BaseModel.php#L11-L26)
2. [User](file:///D:/web/carProject/app/Models/User.php#L10-L51) - extends [BaseModel](file:///D:/web/carProject/app/Models/BaseModel.php#L11-L26)
3. [Offer](file:///D:/web/carProject/app/Models/Offer.php#L3-L34) - extends [BaseModel](file:///D:/web/carProject/app/Models/BaseModel.php#L11-L26)
4. [Bargain](file:///D:/web/carProject/app/Models/Bargain.php#L3-L27) - extends [BaseModel](file:///D:/web/carProject/app/Models/BaseModel.php#L11-L26)
5. [Promotion](file:///D:/web/carProject/app/Models/Promotion.php#L3-L36) - extends [BaseModel](file:///D:/web/carProject/app/Models/BaseModel.php#L11-L26)
6. [ChMessage](file:///D:/web/carProject/app/Models/ChMessage.php#L3-L10) - extends [BaseModel](file:///D:/web/carProject/app/Models/BaseModel.php#L11-L26)
7. [ChFavorite](file:///D:/web/carProject/app/Models/ChFavorite.php#L3-L10) - extends [BaseModel](file:///D:/web/carProject/app/Models/BaseModel.php#L11-L26)

### 3. Configuration

The logging system is configured with the following options by default:

- `logAll()` - Logs all attributes of the model
- `logOnlyDirty()` - Only logs attributes that have actually changed
- `dontSubmitEmptyLogs()` - Prevents logging when no relevant changes occurred

## Usage Examples

### Retrieving Activities

To retrieve activities for a specific model instance:

```php
$car = Car::first();
$activities = $car->activities;

foreach ($activities as $activity) {
    echo $activity->description; // created, updated, deleted
    echo $activity->event; // created, updated, deleted
    echo $activity->created_at;
    
    // Access the changed attributes
    $properties = $activity->properties;
    // $properties['attributes'] - current values
    // $properties['old'] - previous values (for updates)
}
```

### Customizing Logging for Specific Models

If you need to customize the logging options for a specific model, you can override the `getActivitylogOptions()` method:

```php
// In your model class
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logOnly(['title', 'description']) // Only log specific attributes
        ->logOnlyDirty()
        ->useLogName('custom_log') // Use a custom log name
        ->setDescriptionForEvent(fn(string $eventName) => "Car {$eventName}"); // Custom description
}
```

### Querying Activities

You can also query activities directly:

```php
use Spatie\Activitylog\Models\Activity;

// Get all activities
$activities = Activity::all();

// Get activities for a specific model type
$carActivities = Activity::forSubjectType(Car::class)->get();

// Get activities for a specific model instance
$car = Car::first();
$carActivities = Activity::forSubject($car)->get();

// Get activities by event type
$createdActivities = Activity::where('event', 'created')->get();
```

## Adding Logging to New Models

When creating new models in the future, simply extend [BaseModel](file:///D:/web/carProject/app/Models/BaseModel.php#L11-L26) instead of the standard Eloquent [Model](file:///D:/web/carProject/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php#L33-L1337):

```php
<?php

namespace App\Models;

use App\Models\BaseModel;

class NewModel extends BaseModel
{
    protected $fillable = [
        // your fillable attributes
    ];
}
```

Alternatively, you can use the trait directly in your model:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class NewModel extends Model
{
    use LogsActivity;
    
    protected $fillable = [
        // your fillable attributes
    ];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
```

## Testing the Logging System

To verify that the logging system is working correctly:

1. Create, update, or delete a record in any of the models
2. Check the `activity_log` table for the corresponding entries
3. Each activity will contain information about what happened and what changed

The system automatically logs:
- Creation of new records
- Updates to existing records (only changed attributes)
- Deletion of records

Each log entry includes:
- The event type (created, updated, deleted)
- The model type and ID
- The changed attributes
- Timestamps