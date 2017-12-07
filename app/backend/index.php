<?php
ini_set('display.errors', -1);

include './functions.php';
//include './pinpie/pinpie.php';
//include './pinpie.new/standalone.php';

//include './vendor/autoload.php';

$autoloader = require "./vendor/autoload.php";

/*$results = $autoloader->findFile("\\pinpie\\pinpie\\PinPIE");
var_dump($results);
print "Found file for class at: $results";
exit(1);*/


class_alias('\pinpie\pinpie\PinPIE', 'PinPIE');
PinPIE::renderPage();
