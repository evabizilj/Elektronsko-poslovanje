<?php

session_start();

require_once("controller/JokesController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

// var_dump(BASE_URL);
// var_dump($path);


// ROUTER: defines mapping between URLS and controllers
$urls = [
    // testiranje
   "hello/world" => function() {
	JokesController::helloWorld();
    },
    "vse-sale" => function() {
        JokesController::index();
    },
    "jokes" => function() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            JokesController::add();
        } else {
            JokesController::addForm();
        }
    },
    "" => function () {
        ViewHelper::redirect(BASE_URL . "vse-sale");
    },
];

try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (InvalidArgumentException $e) {
    ViewHelper::error404();
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
} 

?>
