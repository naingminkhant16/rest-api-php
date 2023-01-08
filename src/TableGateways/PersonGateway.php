<?php

namespace Src\TableGateways;

class PersonGateway
{
    private $db = null;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $query = "SELECT * FROM person";
        try {
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id)
    {
        $query = "SELECT * FROM person WHERE id=:id;";
        try {
            $statement = $this->db->prepare($query);
            $statement->execute(['id' => $id]);
            return $statement->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(array $input)
    {
        $query = "
        INSERT INTO person 
            (firstname,lastname,firstparent_id,secondparent_id) 
        VALUES
            (:firstname,:lastname,:firstparent_id,:secondparent_id)
        ";

        try {
            $statement = $this->db->prepare($query);
            $statement->execute([
                'firstname' => $input['firstname'],
                'lastname' => $input['lastname'],
                'firstparent_id' => $input['firstparent_id'] ?? null,
                'secondparent_id' => $input['secondparent_id'] ?? null
            ]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, array $input)
    {
        $query = "
        UPDATE person 
        SET    
            firstname = :firstname,
            lastname  = :lastname,
            firstparent_id = :firstparent_id,
            secondparent_id = :secondparent_id
        WHERE id=:id;
        ";

        try {
            $statement = $this->db->prepare($query);
            $statement->execute([
                "id" => (int) $id,
                'firstname' => $input['firstname'],
                'lastname'  => $input['lastname'],
                'firstparent_id' => $input['firstparent_id'] ?? null,
                'secondparent_id' => $input['secondparent_id'] ?? null,
            ]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $query = "
        DELETE FROM person WHERE id=:id;
        ";
        try {
            $statement = $this->db->prepare($query);
            $statement->execute([
                "id" => (int) $id
            ]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
