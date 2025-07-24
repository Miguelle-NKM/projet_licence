<?php
class Config {
    private static $instance = null;
    private $config = [];

    private function __construct() {
        // Load environment variables from .env file in production
        $this->config = [
            'db' => [
                'host' => getenv('DB_HOST') ?: 'localhost',
                'name' => getenv('DB_NAME') ?: 'gestion-hotel',
                'user' => getenv('DB_USER') ?: 'root',
                'pass' => getenv('DB_PASS') ?: '',
                'charset' => 'utf8mb4'
            ],
            'app' => [
                'env' => getenv('APP_ENV') ?: 'development',
                'debug' => getenv('APP_DEBUG') ?: true
            ]
        ];
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get(string $key, $default = null) {
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
?>