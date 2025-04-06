<?php

return [
    'unauthenticated' => [
        'title' => 'Unauthenticated.',
        'detail' => 'Authentication failed.',
    ],
    'resource_not_found' => [
        'title' => 'Resource not found.',
        'detail' => 'The specified resource was not found.',
    ],
    'json_parse_error' => [
        'title' => 'Bad Request.',
        'detail' => 'The JSON syntax is invalid or corrupted.',
    ],
    'unauthorized' => [
        'title' => 'Unauthorized.',
        'detail' => 'You are not authorized to access this resource.',
    ],
    'validation_error' => [
        'title' => 'Validation Error.',
        'project' => [
            'name' => [
                'required' => 'The name field is required.',
                'max' => 'The name field must not exceed 255 characters.',
            ],
            'planned_start_date' => [
                'date' => 'The planned_start_date field must be a valid date.',
            ],
            'planned_end_date' => [
                'date' => 'The planned_end_date field must be a valid date.',
                'after_or_equal' => 'The planned_end_date field must be a date after or equal to the planned_start_date field.',
            ],
            'actual_start_date' => [
                'date' => 'The actual_start_date field must be a valid date.',
            ],
            'actual_end_date' => [
                'date' => 'The actual_end_date field must be a valid date.',
                'after_or_equal' => 'The actual_end_date field must be a date after or equal to the actual_start_date field.',
            ],
            'is_private' => [
                'required' => 'The is_private field is required.',
                'boolean' => 'The is_private field must be a boolean.',
            ],
        ],
    ],
];
