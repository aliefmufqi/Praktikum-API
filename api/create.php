<?php
// Header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

// Cek method harus POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "message" => "Method tidak diizinkan."
    ]);
    exit;
}

// Include file
include_once '../config/Database.php';
include_once '../models/Mahasiswa.php';

// Koneksi database
$database = new Database();
$db = $database->getConnection();

// Inisialisasi object Mahasiswa
$mahasiswa = new Mahasiswa($db);

// Ambil data JSON
$data = json_decode(file_get_contents("php://input"));

// Validasi data
if (
    $data !== null &&
    !empty($data->npm) &&
    !empty($data->nama) &&
    !empty($data->jurusan)
) {
    $mahasiswa->npm     = $data->npm;
    $mahasiswa->nama    = $data->nama;
    $mahasiswa->jurusan = $data->jurusan;

    if ($mahasiswa->create()) {
        http_response_code(201); // Created
        echo json_encode([
            "message" => "Mahasiswa berhasil ditambahkan."
        ]);
    } else {
        http_response_code(503); // Service Unavailable
        echo json_encode([
            "message" => "Gagal menambahkan mahasiswa."
        ]);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode([
        "message" => "Data tidak lengkap."
    ]);
}
?>