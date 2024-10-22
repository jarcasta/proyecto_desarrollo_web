<?php
namespace App\Modules\Store\Models;

use PDO;

class Store
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->query('SELECT * FROM stores');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM stores WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name)
    {
        $stmt = $this->db->prepare('INSERT INTO stores (name) VALUES (?)');
        return $stmt->execute([$name]);
    }

    public function update($id, $name)
    {
        $stmt = $this->db->prepare('UPDATE stores SET name = ? WHERE id = ?');
        return $stmt->execute([$name, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM stores WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
