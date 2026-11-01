<?php
// KONTROLER strony kalkulatora - wzrost procentowy
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.

// 1. pobranie parametrów
$stara = isset($_REQUEST['stara']) ? trim($_REQUEST['stara']) : null;
$nowa  = isset($_REQUEST['nowa'])  ? trim($_REQUEST['nowa'])  : null;

$messages = [];
$result = null;

// 2. walidacja parametrów
if ($stara === null || $nowa === null) {
	$messages[] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
} else {
	if ($stara === '') {
		$messages[] = 'Nie podano starej wartości';
	}
	if ($nowa === '') {
		$messages[] = 'Nie podano nowej wartości';
	}
}

if (empty($messages)) {
	// zamiana przecinka na kropkę
	$stara = str_replace(',', '.', $stara);
	$nowa  = str_replace(',', '.', $nowa);

	if (!is_numeric($stara)) {
		$messages[] = 'Stara wartość nie jest liczbą';
	}
	if (!is_numeric($nowa)) {
		$messages[] = 'Nowa wartość nie jest liczbą';
	}
}

if (empty($messages) && floatval($stara) == 0) {
	$messages[] = 'Stara wartość nie może być równa 0 (dzielenie przez zero)';
}

// 3. wykonanie zadania, jeśli wszystko w porządku
if (empty($messages)) {
	$stara = floatval($stara);
	$nowa  = floatval($nowa);

	// wzór: ((nowa - stara) / stara) * 100%
	$result = round((($nowa - $stara) / $stara) * 100, 2);
}

// 4. wywołanie widoku z przekazaniem zmiennych
include 'calc_view.php';
