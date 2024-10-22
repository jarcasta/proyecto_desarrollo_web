<?php
namespace App\Modules\Achievement\Models;

use PDO;
use PDOException;

class Achievement
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Obtener todos los logros y llamadas de atención con detalles de empleados
    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT 
                a.id,
                a.description,
                a.type,
                a.occurrence_date,
                a.employee_id,
                e.first_name,
                e.last_name
            FROM 
                achievements a
            JOIN 
                employees e ON a.employee_id = e.id
            ORDER BY 
                a.occurrence_date DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un logro o llamada de atención por ID
    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT 
                * 
            FROM 
                achievements 
            WHERE 
                id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo logro o llamada de atención
    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO achievements (description, type, occurrence_date, employee_id)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['description'],
            $data['type'],
            $data['occurrence_date'],
            $data['employee_id']
        ]);
    }

    // Actualizar un logro o llamada de atención existente
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE achievements 
            SET description = ?, type = ?, occurrence_date = ?, employee_id = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['description'],
            $data['type'],
            $data['occurrence_date'],
            $data['employee_id'],
            $id
        ]);
    }

    // Eliminar un logro o llamada de atención
    public function delete($id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM achievements 
            WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }

    // Obtener el total de logros
    public function getTotalAchievements()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM achievements WHERE type = 'positive'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    // Obtener el total de llamadas de atención
    public function getTotalWarnings()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM achievements WHERE type = 'negative'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
