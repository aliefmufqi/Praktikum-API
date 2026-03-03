<?php
class Database {
    private $host = "localhost";
    private $db_name = "kampus";
<<<<<<< HEAD
    private $username = "aliefmufqi";
    private $password = "admin123";

=======
    private $username = "root";
    private $password = "";
>>>>>>> d44490a1eea3401d88c3a4588cb765eb17782b9f
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Koneksi gagal: " . $e->getMessage();
        }
        return $this->conn;
    }
<<<<<<< HEAD
}
?>
=======
}
>>>>>>> d44490a1eea3401d88c3a4588cb765eb17782b9f
