<?php
require_once dirname(__FILE__).'/../../config.php';

// 1. zakończenie sesji
session_start();
session_destroy();

// 2. przekierowanie na stronę główną (ta odeśle do logowania)
header("Location: "._APP_URL);
exit();
