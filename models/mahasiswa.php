<?php
class Mahasiswa {
    private $conn;
    private $table = "mahasiswa";

    public $id;
    public $npm;
    public $nama;
    public $jurusan;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO {$this->table} (npm,nama,jurusan)
                  VALUES (:npm,:nama,:jurusan)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ":npm"=>$this->npm,
            ":nama"=>$this->nama,
            ":jurusan"=>$this->jurusan
        ]);
    }

    public function read() {
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE {$this->table}
                  SET npm=:npm,nama=:nama,jurusan=:jurusan
                  WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ":id"=>$this->id,
            ":npm"=>$this->npm,
            ":nama"=>$this->nama,
            ":jurusan"=>$this->jurusan
        ]);
    }

    public function delete() {
        $query = "DELETE FROM {$this->table} WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([":id"=>$this->id]);
    }
}