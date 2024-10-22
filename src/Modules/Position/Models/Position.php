<?php
namespace App\Modules\Position\Models;

use PDO;
use PDOException;

class Position
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->query('SELECT * FROM positions');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM positions WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name)
    {
        $stmt = $this->db->prepare('INSERT INTO positions (name) VALUES (?)');
        return $stmt->execute([$name]);
    }

    public function update($id, $name)
    {
        $stmt = $this->db->prepare('UPDATE positions SET name = ? WHERE id = ?');
        return $stmt->execute([$name, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM positions WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
