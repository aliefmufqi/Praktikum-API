<?php
require_once "../config/database.php";
require_once "../models/mahasiswa.php";

$database = new Database();
$db = $database->getConnection();
$mahasiswa = new Mahasiswa($db);

$stmt = $mahasiswa->read();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);