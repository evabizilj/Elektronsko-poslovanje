<?php
require_once 'database_jokes.php';
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Primer z bazo in knjižnico PDO</title>
    </head>
    <body>
        <?php
       
        // VNOS -- ZASLONSKA MASKA
        if (isset($_GET["do"]) && $_GET["do"] == "add"): 
        
        ?>    

            <h1>Dodajanje</h1>
            
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <input type="hidden" name="do" value="add" />
                Datum: <input type="text" name="joke_date" value="<?= date("Y-m-d") ?>" /><br />
                <textarea rows="8" cols="60" name="joke_text"></textarea><br />
                <input type="submit" value="Shrani" />
            </form>
        <?php 

        // BRANJE PODATKOV ZA VNOS
        elseif (isset($_POST["do"]) && $_POST["do"] == "add"):

            try {
                DBJokes::insert($_POST["joke_date"], htmlspecialchars($_POST["joke_text"]));
            } catch (Exception $e) {
                echo "Prišlo je do napake pri vnosu {$e->getMessage()}";
            }

            header('Location: ' . $_SERVER["PHP_SELF"]);
            exit();

        // UREJANJE -- ZASLONSKA MASKA
        elseif (isset($_GET["do"]) && $_GET["do"] == "edit"): 
        ?>
            <h1>Urejanje</h1>
            
            <?php
            /* TODO: Naložite podatke iz baze
             * Namigi: 
             * - ID preberite iz globalne spremenljivke $_GET
             * - in ga uporabite, da iz PB naložite vsebino šale
             */
         
            $id = $_GET["id"];
   
            $joke = DBJokes::get($id);
            $date = $joke["joke_date"];
            $text = $joke["joke_text"];
            
            ?> 

            <h2>Urejanje zapisa id = <?= $id ?></h2>
           
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <input type="hidden" name="id" value="<?= $id ?>" />
                <input type="hidden" name="do" value="edit" />
                Datum: <input type="text" name="joke_date" value="<?php echo $date ?>" /><br />
                <textarea rows="8" cols="60" name="joke_text"><?= $text ?></textarea><br />
                <input type="submit" value="Shrani" />
            </form>

            <h2>Izbris zapisa</h2>
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <input type="hidden" name="id" value="<?= $id ?>" />
                <input type="hidden" name="do" value="delete" />
                <input type="submit" value="Briši" />
            </form>	
            
            <?php

        // BRANJE PODATKOV ZA UREJANJE
        elseif (isset($_POST["do"]) && $_POST["do"] == "edit"):

            try {
                DBJokes::update($id, $_POST["joke_date"], htmlspecialchars($_POST["joke_text"]));
            } catch (Exception $e) {
                echo "Prišlo je do napake pri urejanju {$e->getMessage()}";
            }
                    
            header('Location: ' . $_SERVER["PHP_SELF"]);
            exit();

        // BRISANJE -- SQL
        elseif (isset($_POST["do"]) && $_POST["do"] == "delete"): 
            ?>
            
            <h1>Brisanje zapisa</h1>
            
            <?php
            try {
                DBJokes::delete($_POST["id"]);
                echo "Šala uspešno odstranjena. <a href='$_SERVER[PHP_SELF]'>Na prvo stran.</a></p>";
            } catch (Exception $e) {
                echo "<p>Napaka pri brisanju: {$e->getMessage()}.</p>";
            }
            
        // PRIKAZ VSEH ZAPISOV
        else:
            ?>
            
            <h1>Vse šale</h1>
            
            <h2><a href="<?= $_SERVER["PHP_SELF"] . "?do=add" ?>">Dodajanje šal</a></h2>
            
            <?php
            try {
                $allJokes = DBJokes::getAll();
            } catch (Exception $e) {
                echo "Prišlo je do napake: {$e->getMessage()}";
            }

            foreach ($allJokes as $key => $row) {
                $url = $_SERVER["PHP_SELF"] . "?do=edit&id=" . $row["id"];
                $date = $row["joke_date"];
                $text = $row["joke_text"];

                echo "<p><b>$date</b>. $text [<a href='$url'>Uredi</a>]";
            }
        endif;
        ?>
            
    </body>
</html>
