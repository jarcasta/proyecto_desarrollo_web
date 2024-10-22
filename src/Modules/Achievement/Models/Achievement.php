<?php
namespace App\Modules\Achievement\Models;

use PDO;

class Achievement
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

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

    public function delete($id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM achievements 
            WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }

    public function getTotalAchievements()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM achievements WHERE type = 'positive'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getTotalWarnings()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM achievements WHERE type = 'negative'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getAchievementsByType($type)
    {
        $allowedTypes = ['positive', 'negative'];

        if (!in_array($type, $allowedTypes)) {
            throw new \InvalidArgumentException("Tipo de logro inválido. Tipos permitidos: 'positive', 'negative'.");
        }

        $stmt = $this->db->prepare("
            SELECT 
                a.*, 
                e.first_name, 
                e.last_name 
            FROM 
                achievements a
            JOIN 
                employees e ON a.employee_id = e.id
            WHERE 
                a.type = :type
            ORDER BY 
                a.occurrence_date DESC
        ");
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalAchievementsByType($type)
    {
        $allowedTypes = ['positive', 'negative'];

        if (!in_array($type, $allowedTypes)) {
            throw new \InvalidArgumentException("Tipo de logro inválido. Tipos permitidos: 'positive', 'negative'.");
        }

        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total 
            FROM achievements 
            WHERE type = :type
        ");
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
