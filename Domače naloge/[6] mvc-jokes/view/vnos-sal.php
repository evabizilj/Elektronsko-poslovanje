<!DOCTYPE html>

<title>Vnos šale</title>

<h1>Vnos šale</h1>

<p>[
<a href="<?= BASE_URL . "vse-sale" ?>">Vse Šale</a>
]</p>

<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <input type="hidden" name="do" value="add" />
                Datum: <input type="text" name="joke_date" value="<?= date("Y-m-d") ?>" /><br />
                <textarea rows="8" cols="60" name="joke_text"></textarea><br />
                <input type="submit" value="Shrani" />
</form>

