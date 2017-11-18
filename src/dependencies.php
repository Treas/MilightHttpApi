<?php
// DIC configuration

$container = $app->getContainer();

// monolog
$container['logger'] = function ($c) {
	
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// milight api
$container['milight'] = function($c) {
    $milight_controller_ips = $c->get('settings')['milight'];
    $i = 0;
    foreach ($milight_controller_ips as $ip)
    {
        $milight[$i] = new Milight($ip);
        $i = $i + 1;
    }
    return $milight;
};


