<?php
require_once "../config/database.php";
require_once "../models/mahasiswa.php";

$database = new Database();
$db = $database->getConnection();
$mahasiswa = new Mahasiswa($db);

$data = json_decode(file_get_contents("php://input"));

$mahasiswa->npm = $data->npm;
$mahasiswa->nama = $data->nama;
$mahasiswa->jurusan = $data->jurusan;

echo json_encode(["success"=>$mahasiswa->create()]);