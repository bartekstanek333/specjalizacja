<?php
require_once dirname(__FILE__).'/../config.php';

// KONTROLER strony kalkulatora wzrostu procentowego
// wzór: ((nowa - stara) / stara) * 100%

// ochrona kontrolera - skrypt przerwie przetwarzanie w tym punkcie, gdy użytkownik jest niezalogowany
include _ROOT_PATH.'/app/security/check.php';

// powyżej tego progu (wartość bezwzględna) obliczenia może wykonać tylko administrator
define('_LIMIT_USER', 100000);

// pobranie parametrów - dane z formularza w jednej tablicy
function getParams(&$form){
	$form['stara'] = isset($_REQUEST['stara']) ? trim($_REQUEST['stara']) : null;
	$form['nowa']  = isset($_REQUEST['nowa'])  ? trim($_REQUEST['nowa'])  : null;
}

// walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$form, &$messages){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($form['stara']) && isset($form['nowa']))) {
		// kontroler wywołany bezpośrednio, nie z formularza - po prostu nie wykonujemy obliczeń
		return false;
	}

	// sprawdzenie, czy potrzebne wartości zostały przekazane
	if ($form['stara'] === '') {
		$messages[] = 'Nie podano starej wartości';
	}
	if ($form['nowa'] === '') {
		$messages[] = 'Nie podano nowej wartości';
	}

	// nie ma sensu walidować dalej, gdy brak parametrów
	if (count($messages) != 0) return false;

	// dopuszczamy przecinek jako separator dziesiętny
	$form['stara'] = str_replace(',', '.', $form['stara']);
	$form['nowa']  = str_replace(',', '.', $form['nowa']);

	// sprawdzenie, czy wartości są liczbami
	if (!is_numeric($form['stara'])) {
		$messages[] = 'Stara wartość nie jest liczbą';
	}
	if (!is_numeric($form['nowa'])) {
		$messages[] = 'Nowa wartość nie jest liczbą';
	}

	if (count($messages) != 0) return false;

	// dzielenie przez starą wartość - nie może być zerem
	if (floatval($form['stara']) == 0) {
		$messages[] = 'Stara wartość nie może być równa 0 (dzielenie przez zero)';
		return false;
	}

	return true;
}

// wykonanie zadania z uwzględnieniem roli użytkownika
function process(&$form, &$messages, &$result){
	global $role;

	$stara = floatval($form['stara']);
	$nowa  = floatval($form['nowa']);

	// podział zadania wg roli: wysokie wartości tylko dla administratora
	if ($role != 'admin' && (abs($stara) > _LIMIT_USER || abs($nowa) > _LIMIT_USER)) {
		$messages[] = 'Wartości powyżej '._LIMIT_USER.' może przeliczać tylko administrator!';
		return;
	}

	// wzór: ((nowa - stara) / stara) * 100%
	$result = round((($nowa - $stara) / $stara) * 100, 2);
}

// definicja zmiennych kontrolera
$form = array();
$messages = array();
$result = null;

// pobierz parametry i wykonaj zadanie, jeśli wszystko w porządku
getParams($form);
if (validate($form, $messages)) {
	process($form, $messages, $result);
}

// wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages, $form, $result, $role) będą dostępne w widoku
include 'calc_view.php';
