<?php
require_once('vendor/autoload.php');

$data = \App\Controller\ParseController::getData($argv[1]);
$commission = new \App\Controller\CommissionController($data);
$commission->generate();