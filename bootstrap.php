<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;
use Src\System\DatabaseConnector;


//loading a .env file
$dotenv = new Dotenv(__DIR__);
$dotenv->load();

//connecting DB and get PDO instance
$dbConnection = (new DatabaseConnector)->getConnection();
