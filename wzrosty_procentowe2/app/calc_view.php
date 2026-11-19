<?php
// Widok nie jest punktem wejścia do aplikacji - żądania idą do kontrolera,
// a kontroler wywołuje ten skrypt (konfiguracja jest już załadowana).
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Wzrost procentowy</title>
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
</head>
<body>

<div style="width:90%; margin: 2em auto;">
	<a href="<?php print(_APP_ROOT); ?>/app/inna_chroniona.php" class="pure-button">kolejna chroniona strona</a>
	<a href="<?php print(_APP_ROOT); ?>/app/security/logout.php" class="pure-button pure-button-active">Wyloguj</a>
	<span style="margin-left: 1em;">Zalogowano jako: <b><?php out($role); ?></b></span>
</div>

<div style="width:90%; margin: 2em auto;">

<form action="<?php print(_APP_ROOT); ?>/app/calc.php" method="post" class="pure-form pure-form-stacked">
	<legend>Wzrost procentowy: ((nowa &minus; stara) / stara) &middot; 100%</legend>
	<fieldset>
		<label for="id_stara">Stara wartość: </label>
		<input id="id_stara" type="text" name="stara" value="<?php out($form['stara']); ?>" />
		<label for="id_nowa">Nowa wartość: </label>
		<input id="id_nowa" type="text" name="nowa" value="<?php out($form['nowa']); ?>" />
	</fieldset>
	<input type="submit" value="Oblicz" class="pure-button pure-button-primary" />
</form>

<?php
//wyświetlenie listy błędów, jeśli istnieją
if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin-top: 1em; padding: 1em 1em 1em 2em; border-radius: 0.5em; background-color: #f88; width:25em;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.htmlspecialchars($msg).'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($result)){ ?>
<div style="margin-top: 1em; padding: 1em; border-radius: 0.5em; background-color: #ff0; width:25em;">
<?php echo 'Wzrost procentowy: '.$result.' %'; ?>
</div>
<?php } ?>

</div>

</body>
</html>
