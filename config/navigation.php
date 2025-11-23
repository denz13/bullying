<?php

return [
    'primary' => [
        [
            'label' => 'Dashboard',
            'icon' => 'grid',
            'route' => 'dashboard',
        ],
        [
            'label' => 'Request Counseling',
            'icon' => 'flag',
            'route' => 'request-counseling',
        ],
        [
            'label' => 'Shared Experiences',
            'icon' => 'document',
            'route' => 'shared-experience',
        ],
        [
            'label' => 'Resolved Cases',
            'icon' => 'check-circle',
            'route' => 'resolve-cases',
        ],
        [
            'label' => 'Incident Report',
            'icon' => 'exclamation-triangle',
            'route' => 'incident',
        ],
        [
            'label' => 'Schedule Calendar',
            'icon' => 'calendar',
            'route' => 'schedule-calendar',
        ],
        [
            'label' => 'User Management',
            'icon' => 'users',
            'route' => 'user-management',
            'role' => 'admin', // Only visible to admin users
        ],
    ],
];

