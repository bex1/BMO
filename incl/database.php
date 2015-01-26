<?php
$dbPath = dirname(__FILE__) . "/bmo/data/bmo.sqlite";

$db = new PDO("sqlite:$dbPath");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // Display errors, but continue script