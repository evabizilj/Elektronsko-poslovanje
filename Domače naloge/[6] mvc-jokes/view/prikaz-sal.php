
<!DOCTYPE html>

<meta charset="UTF-8" />

<h1>Vse šale</h1>

<ul>
 
<a href="<?= BASE_URL . "jokes" ?>">Vnos šale</a>
    <?php foreach ($jokes as $jokes) :?>
        <li>
            <p> 
                [<?= $jokes["joke_date"] ?>]
            </p>
            <p>
                 <?= $jokes["joke_text"] ?> 
            </p>
        </li>
    <?php endforeach; ?>

</ul>
