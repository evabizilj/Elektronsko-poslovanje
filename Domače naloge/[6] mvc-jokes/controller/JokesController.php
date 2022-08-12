<?php

require_once("model/database_init.php");
require_once("ViewHelper.php");
require_once("model/JokesDB.php");

class JokesController {

    public static function helloWorld() {
	$parameters = [
		"name" => "Eva"
	];
        echo ViewHelper::render("view/hello-world.php", $parameters);
    }
    
    public static function index() {
        echo ViewHelper::render("view/prikaz-sal.php", [
                "jokes" => JokesDB::getAll()]);
    }
    
    public static function add() {
        $data = filter_input_array(INPUT_POST);

        if (self::checkValues($data)) {
            $id = JokesDB::insert($data);
            echo ViewHelper::redirect(BASE_URL . "jokes?id=" . $id);
        } else {
            self::addForm($data);
        }
    }

    public static function addForm($values = [
        "joke_date" => "",
        "joke_text" => "",
    ]) {
        echo ViewHelper::render("view/vnos-sal.php", $values);
    }
    
    private static function checkValues($input) {
        if (empty($input)) {
            return FALSE;
        }

        $result = TRUE;
        foreach ($input as $value) {
            $result = $result && $value != false;
        }

        return $result;
    }
}
 
  