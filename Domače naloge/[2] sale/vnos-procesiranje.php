<?php
try {
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_PERSISTENT => true,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    );

    # Preberemo vrednosti spremenljivk iz zahtevka
    $date = $_POST["joke_date"];
    $text = $_POST["joke_text"];
    

    $db = new PDO("mysql:host=localhost;dbname=jokes", "root", "ep", $options);

    # Vpišemo SQL za vnos
    $statement = $db->prepare("INSERT INTO jokes (joke_text, joke_date) VALUES (?, ?)");

    // Zgornji SQL naj vsebuje dva imenska parametma
    $statement->bindValue(1, $text);
    $statement->bindValue(2, $date);

    $statement->execute();
    
} catch (Exception $e) {
    echo "Prišlo je do napake: {$e->getMessage()}";
    exit();
}
// Sedaj lahko naredimo avtomatično preusmeritev na seznam vseh šal
  // header("Location: index.php");
// ali pa izpišemo obvestilo s povezavo
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Spletne šale: vnos</title>
    </head>
    <body>
        <h1>Vnos</h1>
        <p>Šala je bila dodana. Nadaljuj na <a href='index.php'>seznam vseh</a>.</p>
    </body>
</html>
