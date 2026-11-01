<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator wzrostu procentowego</title>
</head>
<body>

<h2>Wzrost procentowy</h2>
<p>Wzór: ((nowa &minus; stara) / stara) &middot; 100%</p>

<form action="<?php print(_APP_URL);?>/app/calc.php" method="get">
	<label for="id_stara">Stara wartość: </label>
	<input id="id_stara" type="text" name="stara" value="<?php echo isset($stara) ? htmlspecialchars($stara) : ''; ?>" /><br />
	<label for="id_nowa">Nowa wartość: </label>
	<input id="id_nowa" type="text" name="nowa" value="<?php echo isset($nowa) ? htmlspecialchars($nowa) : ''; ?>" /><br />
	<input type="submit" value="Oblicz" />
</form>

<?php
//wyświetlenie listy błędów, jeśli istnieją
if (isset($messages) && count($messages) > 0) {
	echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
	foreach ($messages as $key => $msg) {
		echo '<li>'.htmlspecialchars($msg).'</li>';
	}
	echo '</ol>';
}
?>

<?php if (isset($result)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;">
<?php echo 'Wzrost procentowy: '.$result.' %'; ?>
</div>
<?php } ?>

</body>
</html>
