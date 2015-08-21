#!/usr/bin/env php
<?php

require __DIR__.'/../../../vendor/autoload.php';

use Gnugat\PommSearchEngine\Test\Fixtures\Project\ProjectBuild;

$config = ProjectBuild::config();

$command = 'psql';
$connectionOptions = "-h {$config['host']} -p {$config['port']} -U {$config['username']}";
if (isset($config['password'])) {
    $command = "PGPASSWORD={$config['password']} $command";
} else {
    $connectionOptions .= '-w';
}
exec("$command -c 'DROP DATABASE {$config['database']};' $connectionOptions >> /dev/null 2>&1");
exec("$command -c 'CREATE DATABASE {$config['database']};' $connectionOptions");

$queryManager = ProjectBuild::queryManager();

$queryManager->query(<<<SQL
CREATE TABLE author (
    id INT NOT NULL PRIMARY KEY,
    name TEXT NOT NULL UNIQUE
)
SQL
);
$queryManager->query("INSERT INTO author VALUES (1, 'Nate')");
$queryManager->query("INSERT INTO author VALUES (2, 'Nicolas')");
$queryManager->query("INSERT INTO author VALUES (3, 'Lorel')");

$queryManager->query(<<<SQL
CREATE TABLE blog (
    id INT NOT NULL PRIMARY KEY,
    title TEXT NOT NULL UNIQUE,
    author_id INT NOT NULL REFERENCES author(id) ON DELETE CASCADE
)
SQL
);
$queryManager->query("INSERT INTO blog VALUES (1, 'Big Title', 1)");
$queryManager->query("INSERT INTO blog VALUES (2, 'Big Header', 2)");
$queryManager->query("INSERT INTO blog VALUES (3, 'Ancient Title', 1)");
$queryManager->query("INSERT INTO blog VALUES (4, 'Ancient Header', 3)");
