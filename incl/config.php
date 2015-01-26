<?php
error_reporting(-1);

// start a named session
session_name(preg_replace('/[:\.\/-_]/', '', __FILE__));
session_start();

// time page generation, display in footer. comment out to disable timing.
$pageTimeGeneration = microtime(true);

// include common functions
include_once(dirname(__FILE__) . "/../src/common.php");

// include functions for login & logout
include_once(dirname(__FILE__) . "/../src/login.php");

// account and password that can login
$userAccount = "bex";
$userPassword = userPassword("bex");

$base_url = str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname($_SERVER['PHP_SELF']));
