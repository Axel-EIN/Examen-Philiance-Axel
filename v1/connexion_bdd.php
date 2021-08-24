<?php
// 1. Connexion à la BDD
require_once __DIR__ . '/SimpleOrm.class.php';
$connexion = new mysqli('localhost', 'root', '');
if (!empty($connexion->connect_error))
	die('Unable to connect to the database / Impossible de se connecter à la base de données. ' . $connexion->connect_error);
SimpleOrm::useConnection($connexion, 'exam_v1');