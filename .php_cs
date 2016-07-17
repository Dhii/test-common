<?php

require_once __DIR__.DIRECTORY_SEPARATOR.'vendor/autoload.php';
$config = Dhii\Configuration\PHPCSFixer\Config::create();
$config->getFinder()->in(__DIR__.DIRECTORY_SEPARATOR.'src');
return $config;
