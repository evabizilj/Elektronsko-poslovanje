<?php
try {
    // nastavitve za povezavo do PB
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_PERSISTENT => true,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    );

    // objekt PDO
    // povezemo se na podatkovno bazo
    $db = new PDO("mysql:host=localhost;dbname=jokes", "root", "ep", $options);

    # priprava poizvedbe SQL
    $statement = $db->prepare("select * from jokes");

    // izvedba poizvedbe
    $statement->execute();

    // zapis rezultata poizvedbe v spremenljivko (dobimo vse sale)
    $allJokes = $statement->fetchAll();

    // Rezultat ,ki ga vrne PDO, lahko vidimo, če odkomentiramo spodnjo vrstico
   // var_dump($allJokes);
    // exit();
} catch (PDOException $e) {
    echo "Prišlo je do napake: {$e->getMessage()}";
    exit();
}
// iteriramo, izpisemo sale, povezava na urejanje

?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Spletne šale: seznam vseh</title>
    </head>
    <body>
        <h1>Vse šale</h1>
        <p><a href="vnos.php">Vnos nove</a></p>
        <?php foreach ($allJokes as $num => $row): ?>
            <p>
                <b><?= $row["joke_date"] ?></b>: <?= $row["joke_text"] ?><br/>
                <small>[<a href='urejanje.php?id=<?= $row["id"] ?>'>Uredi</a>]</small>
            </p>
        <?php endforeach; ?>
    </body>
</html>