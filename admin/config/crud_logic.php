<?php
require_once 'connection.php';

/**
 * Class Database untuk menangani operasi CRUD
 */
class Database
{
    private $koneksi;
    private $table;
    private $primaryKey;
    // private $currentTime;
    // private $currentUser;

    /**
     * Constructor untuk inisialisasi koneksi dan table
     */
    public function __construct($table = '', $primaryKey = 'id')
    {
        global $koneksi;
        $this->koneksi = $koneksi;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        // $this->currentTime = '2025-02-19 09:02:49';
        // $this->currentUser = 'azlan07';
    }

    /**
     * Fungsi untuk mendapatkan semua data dari tabel
     * @param array $conditions Kondisi WHERE (opsional)
     * @param array $orderBy Pengurutan data (opsional)
     * @param int $limit Batas jumlah data (opsional)
     * @param int $offset Mulai dari data ke-n (opsional)
     * @return array
     */
    public function getAll($conditions = [], $orderBy = [], $limit = null, $offset = null)
    {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $params = [];

            // Tambahkan WHERE clause
            if (!empty($conditions)) {
                $sql .= " WHERE ";
                $wheres = [];
                foreach ($conditions as $key => $value) {
                    $wheres[] = "$key = ?";
                    $params[] = $value;
                }
                $sql .= implode(" AND ", $wheres);
            }

            // Tambahkan ORDER BY
            if (!empty($orderBy)) {
                $sql .= " ORDER BY ";
                $orders = [];
                foreach ($orderBy as $column => $direction) {
                    $orders[] = "$column $direction";
                }
                $sql .= implode(", ", $orders);
            }

            // Tambahkan LIMIT dan OFFSET
            if ($limit) {
                $sql .= " LIMIT ?";
                $params[] = $limit;

                if ($offset) {
                    $sql .= " OFFSET ?";
                    $params[] = $offset;
                }
            }

            $stmt = $this->koneksi->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get All Error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Fungsi untuk mendapatkan satu data berdasarkan ID
     * @param mixed $id ID data yang dicari
     * @return array|false
     */
    public function getById($id)
    {
        try {
            $stmt = $this->koneksi->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Get By ID Error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Fungsi untuk menyimpan data baru
     * @param array $data Data yang akan disimpan
     * @return string ID data yang baru disimpan
     */
    public function create($data)
    {
        try {
            // Tambahkan audit fields
            // $data['created_at'] = $this->currentTime;
            // $data['updated_at'] = $this->currentTime;
            // $data['created_by'] = $this->currentUser;
            // $data['updated_by'] = $this->currentUser;

            $columns = implode(", ", array_keys($data));
            $values = implode(", ", array_fill(0, count($data), "?"));

            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
            $stmt = $this->koneksi->prepare($sql);
            $stmt->execute(array_values($data));

            return $this->koneksi->lastInsertId();
        } catch (PDOException $e) {
            error_log("Create Error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Fungsi untuk mengupdate data
     * @param mixed $id ID data yang akan diupdate
     * @param array $data Data baru
     * @return bool
     */
    public function update($id, $data)
    {
        try {
            // Tambahkan audit fields
            // $data['updated_at'] = $this->currentTime;
            // $data['updated_by'] = $this->currentUser;

            $sets = [];
            foreach ($data as $key => $value) {
                $sets[] = "$key = ?";
            }
            $sql = "UPDATE {$this->table} SET " . implode(", ", $sets) . " WHERE {$this->primaryKey} = ?";

            $values = array_values($data);
            $values[] = $id;

            $stmt = $this->koneksi->prepare($sql);
            return $stmt->execute($values);
        } catch (PDOException $e) {
            error_log("Update Error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Fungsi untuk menghapus data
     * @param mixed $id ID data yang akan dihapus
     * @return bool
     */
    public function delete($id)
    {
        try {
            $stmt = $this->koneksi->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Delete Error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Fungsi untuk memulai transaksi
     */
    public function beginTransaction()
    {
        $this->koneksi->beginTransaction();
    }

    /**
     * Fungsi untuk mengkonfirmasi transaksi
     */
    public function commit()
    {
        $this->koneksi->commit();
    }

    /**
     * Fungsi untuk membatalkan transaksi
     */
    public function rollback()
    {
        $this->koneksi->rollBack();
    }

    /**
     * Fungsi untuk mencari data dengan LIKE
     * @param string $column Kolom yang dicari
     * @param string $keyword Kata kunci pencarian
     * @return array
     */
    public function search($column, $keyword)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE $column LIKE ?";
            $stmt = $this->koneksi->prepare($sql);
            $stmt->execute(["%$keyword%"]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Search Error: " . $e->getMessage());
            throw $e;
        }
    }
}
