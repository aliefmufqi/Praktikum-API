<?php
require_once "../config/database.php";
require_once "../models/mahasiswa.php";

$database = new Database();
$db = $database->getConnection();

$mahasiswa = new Mahasiswa($db);
$data = json_decode(file_get_contents("php://input"));

$mahasiswa->id = $data->id;

if($mahasiswa->delete()) {
    echo json_encode(["message" => "Data berhasil dihapus"]);
} else {
    echo json_encode(["message" => "Gagal hapus"]);
}