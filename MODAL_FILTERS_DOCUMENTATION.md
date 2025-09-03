# Modal-Based Filter System for CarResource

## Overview
The CarResource now features a comprehensive modal-based filter system with a 4-column grid layout. This provides a more organized and user-friendly filtering experience compared to the default sidebar approach.

## Features

### 1. Modal Layout
- Filters open in a popup modal instead of the sidebar
- Better use of screen real estate
- More organized filter grouping

### 2. 4-Column Grid Structure
- **Column 1**: Basic Information (Title, VIN, Make, Model)
- **Column 2**: Specifications (Year Range, Transmission, Body Type)
- **Column 3**: Appearance & Condition (Colors, Condition, Request Status)
- **Column 4**: Price & Date Range (Price Range, Creation Dates, Currency)

### 3. Advanced Search Section
- Collapsible section for keyword-based search
- Searches across all relevant fields
- Helpful placeholder text and guidance

## Filter Categories

### Basic Information
- **Title**: Text search for car titles
- **VIN Number**: Search by Vehicle Identification Number
- **Make**: Multiple select dropdown with all car makes
- **Model**: Multiple select dropdown with all car models

### Specifications
- **Year Range**: From/To year selectors with searchable dropdowns
- **Transmission Type**: Multiple select for manual/automatic
- **Body Type**: Multiple select with all available body types

### Appearance & Condition
- **Car Color**: Multiple select with all available colors
- **Interior Color**: Multiple select with interior colors
- **Car Condition**: Multiple select for car conditions
- **Request Price Status**: Toggle for price request acceptance

### Price & Date Range
- **Price Range**: From/To price inputs with dollar prefix
- **Creation Date Range**: Date pickers for created date filtering
- **Currency Type**: Multiple select for currency filtering

### Advanced Search
- **Keyword Search**: Searches across all fields
- **Help Text**: Guidance on searchable fields

## Usage

1. Click the "Filters" button in the CarResource table
2. The modal will open with the 4-column grid layout
3. Fill in the desired filter criteria
4. Click "Apply" to filter the results
5. Active filters will be displayed as indicators above the table

## Benefits

- **Better Organization**: Filters are logically grouped into columns
- **Improved UX**: Modal layout provides better focus on filtering
- **More Space**: 4-column layout allows more filters to be visible at once
- **Responsive Design**: Works well on different screen sizes
- **Multilingual**: Fully translated into English, Pashto, and Dari
- **Persistent Indicators**: Active filters are clearly displayed

## Technical Implementation

The filter system uses Filament's `FiltersLayout::Modal` with a custom `Grid` layout containing 4 columns. Each column is a `Section` with related filters. The query logic handles all filter combinations efficiently using Laravel's `when` method for conditional query building.