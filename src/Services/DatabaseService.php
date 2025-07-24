<?php
namespace App\Services;

use PDO;
use PDOException;
use App\Config\Config;

class DatabaseService {
    private static $instance = null;
    private PDO $pdo;

    private function __construct() {
        $config = Config::getInstance();
        
        try {
            $dsn = sprintf(
                "mysql:host=%s;dbname=%s;charset=%s",
                $config->get('db.host'),
                $config->get('db.name'),
                $config->get('db.charset')
            );

            $this->pdo = new PDO(
                $dsn,
                $config->get('db.user'),
                $config->get('db.pass'),
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            // Log error properly in production
            if ($config->get('app.debug')) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            throw new PDOException('Database connection failed');
        }
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }

    public function query(string $sql, array $params = []): \PDOStatement {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
} 