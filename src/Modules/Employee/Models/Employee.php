<?php
namespace App\Modules\Employee\Models;

use PDO;
use PDOException;

class Employee
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
                e.id,
                e.first_name,
                e.last_name,
                e.date_of_birth,
                e.photo_path,
                p.name AS position,
                e.salary,
                s.name AS store
            FROM 
                employees e
            JOIN 
                positions p ON e.position_id = p.id
            JOIN 
                stores s ON e.store_id = s.id
            ORDER BY 
                e.last_name ASC, e.first_name ASC
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
                employees 
            WHERE 
                id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO employees (first_name, last_name, date_of_birth, photo_path, position_id, salary, store_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['first_name'],
            $data['last_name'],
            $data['date_of_birth'],
            $data['photo_path'],
            $data['position_id'],
            $data['salary'],
            $data['store_id']
        ]);
    }

    public function update($id, $data)
    {
        if (isset($data['photo_path'])) {
            $stmt = $this->db->prepare("
                UPDATE employees 
                SET first_name = ?, last_name = ?, date_of_birth = ?, photo_path = ?, position_id = ?, salary = ?, store_id = ?
                WHERE id = ?
            ");
            return $stmt->execute([
                $data['first_name'],
                $data['last_name'],
                $data['date_of_birth'],
                $data['photo_path'],
                $data['position_id'],
                $data['salary'],
                $data['store_id'],
                $id
            ]);
        } else {
            $stmt = $this->db->prepare("
                UPDATE employees 
                SET first_name = ?, last_name = ?, date_of_birth = ?, position_id = ?, salary = ?, store_id = ?
                WHERE id = ?
            ");
            return $stmt->execute([
                $data['first_name'],
                $data['last_name'],
                $data['date_of_birth'],
                $data['position_id'],
                $data['salary'],
                $data['store_id'],
                $id
            ]);
        }
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM employees 
            WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }

    public function getTotalEmployees()
    {
        $stmt = $this->db->query('SELECT COUNT(*) as total FROM employees');
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getTotalSalary()
    {
        $stmt = $this->db->query('SELECT SUM(salary) as total_salary FROM employees');
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_salary'] ?? 0;
    }

    public function getSalaryByStore()
    {
        $stmt = $this->db->prepare("
            SELECT 
                s.name as store_name, 
                e.first_name, 
                e.last_name, 
                e.salary
            FROM 
                employees e
            JOIN 
                stores s ON e.store_id = s.id
            ORDER BY 
                s.name ASC, e.salary DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEmployeeDetails($id)
    {
        $stmt = $this->db->prepare("
            SELECT 
                e.*, 
                p.name as position, 
                s.name as store
            FROM 
                employees e
            JOIN 
                positions p ON e.position_id = p.id
            JOIN 
                stores s ON e.store_id = s.id
            WHERE 
                e.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
