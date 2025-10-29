<?php
class Database
{
    private static ?Database $instance = null;
    private PDO $connection;

    private function __construct()
    {
        $config = require __DIR__ . '/config.php';
        $dbConfig = $config['database'];

        $dsn = sprintf('%s:host=%s;port=%s;dbname=%s;charset=%s',
            $dbConfig['driver'],
            $dbConfig['host'],
            $dbConfig['port'],
            $dbConfig['name'],
            $dbConfig['charset']
        );

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->connection = new PDO($dsn, $dbConfig['user'], $dbConfig['password'], $options);
        } catch (PDOException $exception) {
            throw new RuntimeException('Database connection failed: ' . $exception->getMessage());
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    public function fetchSiteSettings(): array
    {
        $statement = $this->connection->prepare('SELECT * FROM site_settings ORDER BY id DESC LIMIT 1');
        $statement->execute();
        return $statement->fetch() ?: [];
    }

    public function fetchLatestBlogPosts(int $limit = 3): array
    {
        $statement = $this->connection->prepare('SELECT id, title, slug, excerpt, published_at FROM blog_posts WHERE status = ? ORDER BY published_at DESC LIMIT ?');
        $statement->execute(['published', $limit]);
        return $statement->fetchAll();
    }

    public function fetchUpcomingEvents(int $limit = 3): array
    {
        $statement = $this->connection->prepare('SELECT id, title, venue, start_date, end_date FROM events WHERE is_active = 1 AND start_date >= NOW() ORDER BY start_date ASC LIMIT ?');
        $statement->bindValue(1, $limit, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
