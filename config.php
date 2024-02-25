<?php
require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database credentials
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define('DB_NAME', $_ENV['DB_NAME']);

// AWS S3 credentials
define('AWS_ACCESS_KEY', $_ENV['AWS_ACCESS_KEY']);
define('AWS_SECRET_KEY', $_ENV['AWS_SECRET_KEY']);
define('AWS_REGION', $_ENV['AWS_REGION']);
define('S3_BUCKET', $_ENV['S3_BUCKET']);