<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");

// Cek method
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(["message" => "Method tidak diizinkan."]);
    exit;
}

// Include file
include_once '../config/Database.php';
include_once '../models/Mahasiswa.php';

// Koneksi database
$database = new Database();
$db = $database->getConnection();

// Object mahasiswa
$mahasiswa = new Mahasiswa($db);

// Ambil data JSON
$data = json_decode(file_get_contents("php://input"));

// Validasi input
if (
    empty($data->id) ||
    empty($data->npm) ||
    empty($data->nama) ||
    empty($data->jurusan)
) {
    http_response_code(400);
    echo json_encode(["message" => "Data tidak lengkap."]);
    exit;
}

// Set data
$mahasiswa->id = $data->id;
$mahasiswa->npm = $data->npm;
$mahasiswa->nama = $data->nama;
$mahasiswa->jurusan = $data->jurusan;

// Update data
if ($mahasiswa->update()) {
    http_response_code(200);
    echo json_encode([
        "message" => "Data mahasiswa berhasil diperbarui."
    ]);
} else {
    http_response_code(503);
    echo json_encode([
        "message" => "Gagal memperbarui data."
    ]);
}

?>