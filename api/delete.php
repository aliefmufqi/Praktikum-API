<?php

// ==============================
// Header
// ==============================
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// ==============================
// Validasi Method
// ==============================
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode([
        "status"  => false,
        "message" => "Method tidak diizinkan. Gunakan DELETE."
    ]);
    exit;
}

// ==============================
// Include File
// ==============================
include_once '../config/Database.php';
include_once '../models/Mahasiswa.php';

// ==============================
// Koneksi Database
// ==============================
$database = new Database();
$db = $database->getConnection();

if (!$db) {
    http_response_code(500);
    echo json_encode([
        "status"  => false,
        "message" => "Koneksi database gagal."
    ]);
    exit;
}

$mahasiswa = new Mahasiswa($db);

// ==============================
// Ambil Data JSON
// ==============================
$data = json_decode(file_get_contents("php://input"));

// Validasi JSON kosong
if (!$data) {
    http_response_code(400);
    echo json_encode([
        "status"  => false,
        "message" => "Body JSON tidak boleh kosong."
    ]);
    exit;
}

// Validasi ID
if (!isset($data->id) || empty($data->id)) {
    http_response_code(400);
    echo json_encode([
        "status"  => false,
        "message" => "ID mahasiswa wajib diisi."
    ]);
    exit;
}

$mahasiswa->id = htmlspecialchars(strip_tags($data->id));

// ==============================
// Proses Delete
// ==============================
if ($mahasiswa->delete()) {
    http_response_code(200);
    echo json_encode([
        "status"  => true,
        "message" => "Mahasiswa berhasil dihapus."
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "status"  => false,
        "message" => "Gagal menghapus mahasiswa."
    ]);
}