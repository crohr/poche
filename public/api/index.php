<?php
require_once '../inc/config.inc.php';
require_once '../../vendor/restler.php';
use Luracast\Restler\Restler;

$r = new Restler();
// comment the line above and uncomment the line below for production mode
// $r = new Restler(true);

$r->addAPIClass('Links');
$r->addAPIClass('Resources'); // tout est en protected,donc rien dans la doc ?
$r->addAuthenticationClass('AccessControl');
$r->handle();