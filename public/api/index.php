<?php

require_once('./config.php');

$http_origin = $_SERVER['HTTP_ORIGIN'];

if ($http_origin == "http://localhost:8080" || $http_origin == "https://advent.vojtechsanda.cz") {
    header("Access-Control-Allow-Origin: $http_origin");
}

if (isset($_GET) && isset($_GET['advent-key']) && isset($_GET['days'])) {
    $advent_key = strtolower(htmlspecialchars($_GET['advent-key']));
    $days = json_encode(htmlspecialchars($_GET['days']));

    $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $sql = "UPDATE `advent` SET `days` = ? WHERE `advent_key` = ?";
    $stmt = $mysqli->prepare($sql); 
    $stmt->bind_param("ss", $days, $advent_key);
    $stmt->execute();

    $mysqli->close();
} else if (isset($_GET) && isset($_GET['advent-key'])) {
    $advent_key = strtolower(htmlspecialchars($_GET['advent-key']));

    $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $sql = "SELECT `days` FROM `advent` WHERE `advent_key`=?";
    $stmt = $mysqli->prepare($sql); 
    $stmt->bind_param("s", $advent_key);
    $stmt->execute();
    $result = $stmt->get_result();
    $advent_calendar = $result->fetch_assoc();

    echo json_encode($advent_calendar);
    
    $mysqli->close();
}
