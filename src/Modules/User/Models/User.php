<?php
namespace App\Modules\User\Models;

use PDO;
use PDOException;

class User
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->query('SELECT * FROM usuarios');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM usuarios WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nombre, $correo, $clave_acceso)
    {
        $stmt = $this->db->prepare('INSERT INTO usuarios (nombre, correo, clave_acceso) VALUES (?, ?, ?)');
        return $stmt->execute([$nombre, $correo, $clave_acceso]);
    }

    public function update($id, $nombre, $correo, $clave_acceso)
    {
        $stmt = $this->db->prepare('UPDATE usuarios SET nombre = ?, correo = ?, clave_acceso = ? WHERE id = ?');
        return $stmt->execute([$nombre, $correo, $clave_acceso, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM usuarios WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
