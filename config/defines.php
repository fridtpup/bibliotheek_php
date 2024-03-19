<?php
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_NAME", "bibliotheek");

    session_start();

    include_once("../src/DB.php");
    $DB = new DB();
?>