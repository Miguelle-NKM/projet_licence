<?php

namespace App\Config;

class Config
{
    private static $instance = null;
    private $config = [];

    private function __construct()
    {
        // Load environment variables from .env file in production
        $this->config = [
            'db' => [
                'host' => $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: 'localhost',
                'name' => $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: 'gestion-hotel',
                'user' => $_ENV['DB_USER'] ?? getenv('DB_USER') ?: 'root',
                'pass' => $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?: '',
                'charset' => $_ENV['DB_CHARSET'] ?? getenv('DB_CHARSET') ?: 'utf8mb4'
            ],
            'app' => [
                'env' => $_ENV['APP_ENV'] ?? getenv('APP_ENV') ?: 'development',
                'debug' => filter_var($_ENV['APP_DEBUG'] ?? getenv('APP_DEBUG') ?: true, FILTER_VALIDATE_BOOLEAN)
            ]
        ];
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get(string $key, $default = null)
    {
        $keys = explode('.', $key);
        $config = $this->config;

        foreach ($keys as $key) {
            if (!isset($config[$key])) {
                return $default;
            }
            $config = $config[$key];
        }

        return $config;
    }
}
