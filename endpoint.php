<?php

require_once "vendor/autoload.php";

/**
 * COLUMN_KEY
 *  PRI -> PRIMARY KEY
 *  UNI -> UNIQUE
 *  MUL -> Não é Unique
 *
 * EXTRA
 *  auto_increment
 */

$h = new H("atena");

$aux_array = $h->getTables();

echo json_encode($aux_array); exit;