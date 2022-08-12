<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
require_once 'model/AbstractDB.php';

class JokesDB extends AbstractDB  {
    
    
      public static function getAll() {
        return parent::query("SELECT id, joke_text, joke_date"
                        . " FROM jokes"
                        . " ORDER BY id ASC");
    }

    public static function insert(array $params) {
        return parent::modify("INSERT INTO jokes (joke_date, joke_text) "
                        . " VALUES (:joke_date, :joke_text)", $params);
    }
}

