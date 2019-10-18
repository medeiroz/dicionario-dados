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

$h = new H("127.0.0.1", "database", "root", "root");

$aux_array = $h->getTables();

echo json_encode($aux_array); exit;