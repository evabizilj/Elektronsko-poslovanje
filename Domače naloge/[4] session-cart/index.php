<?php
session_start();

require_once 'Knjiga.php';
require_once 'BazaKnjig.php';

$url = filter_input(INPUT_SERVER, "PHP_SELF", FILTER_SANITIZE_SPECIAL_CHARS);
$method = filter_input(INPUT_SERVER, "REQUEST_METHOD", FILTER_SANITIZE_SPECIAL_CHARS);

if ($method == "POST") {
    $validationRules = [
        'do' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                // dopustne vrednosti spremenljivke do
                "regexp" => "/^(add_into_cart|purge_cart|update_cart)$/"
            ]
        ],
        'id' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => ['min_range' => 0]
        ],
        'numBooks' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => ['min_range' => 0]
        ]
    ];
    
    $post = filter_input_array(INPUT_POST, $validationRules);
    
    switch ($post["do"]) {
            // dodajanje posameznega artikla v voziček
        case "add_into_cart":
            try {
                $knjiga = BazaKnjig::vrniKnjigo($post["id"]);

                if (isset($_SESSION["cart"][$knjiga->id])) {
                    $_SESSION["cart"][$knjiga->id]++;
                } else {
                    $_SESSION["cart"][$knjiga->id] = 1;
                }
            } catch (Exception $exc) {
                die($exc->getMessage());
            }
            break;
        case "purge_cart":
            // TODO: izbris celotne vsebine nakupovalne košarice
            session_destroy();
            session_start();
            break;
           // TODO: posodabljanje količin v vozičku
        case "update_cart":
            $knjiga = BazaKnjig::vrniKnjigo($post["id"]);
            $_SESSION["cart"][$knjiga->id] = $post["numBooks"];
            
        default:
            // default naj bo prazen
            break;
    }
}

?><!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="UTF-8" />
        <title>Knjigarna</title>
    </head>
    <body>
        <h1>Knjigarna</h1>

        <div id="main">
            <?php foreach (BazaKnjig::seznamVsehKnjig() as $knjiga): ?>
                <div class="book">
                    <form action="<?= $url ?>" method="post">
                        <input type="hidden" name="do" value="add_into_cart" />
                        <input type="hidden" name="id" value="<?= $knjiga->id ?>" />
                        <p><?= $knjiga->avtor ?>: <?= $knjiga->naslov ?></p>
                        <p><?= number_format($knjiga->cena, 2) ?> EUR<br/>
                            <button type="submit">V košarico</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart">
            <h3>Košarica</h3>
            <p><?php
            if (isset($_SESSION["cart"])) {
                // var_dump($_SESSION["cart"]); 
                $totalPrice = 0;
                foreach(BazaKnjig::seznamVsehKnjig() as $knjiga):
                    if (isset($_SESSION["cart"][$knjiga->id])) { 
                        $number = $_SESSION["cart"][$knjiga->id];    
                        
                        ?>
                        <form action="<?= $url ?>" method="post">
                            <input type="hidden" name="do" value="update_cart" />
                            <input type="hidden" name="id" value="<?= $knjiga->id ?>" />
                            <p>
                                <input type="number" name="numBooks" value="<?= $number ?>" size="1">  <?= $knjiga->avtor ?>: <?= substr($knjiga->naslov, 0, 20) ?> ...
                                <button type="submit">Posodobi</button>
                            </p>
                        </form>
                        <?php
                            $totalPrice = $totalPrice + ($knjiga->cena) * $number;
                    }
                endforeach;
                ?>
            <p> Skupaj: <b> <?= number_format($totalPrice, 2) ?> EUR </b></p>
            <?php
                
            } else {
                echo "Košara je prazna.";
            }            
            ?>
            </p>
             <form action="<?= $url ?>" method="post">
                <input type="hidden" name="do" value="purge_cart"/>
                <button type="submit">Izprazni košarico</button>
            </form> 
        </div>
    </body>
</html>
