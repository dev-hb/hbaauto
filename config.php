<?php

define("HOSTNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("DBNAME", "hbaauto");

$conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DBNAME);
$conn->set_charset("utf8");

include_once 'constants.php';