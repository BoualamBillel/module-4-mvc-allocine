<?php
class Database {
    private static PDO $instance;

    public static function getInstance(): PDO {
        try {
            
        } catch (PDOException) {
            exit();
        }
    }
}