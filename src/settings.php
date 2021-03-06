<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header


		// Milight settings
        'milight' => [
            0 => '192.168.15.34',
            1 => '192.168.15.32',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'MilightHttpAPI',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
