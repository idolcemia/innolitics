<?php

/**
 * Instantiate database connection.
 */

define("DB_HOST", "localhost");
define("DB_DATABASE_NAME", "innolitics");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");

// Initialize database connection.
$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE_NAME ,
    DB_USERNAME, DB_PASSWORD);

// Open error conditions for review.
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);