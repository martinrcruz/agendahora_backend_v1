<?php

class Usuario_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getUsuario($where = '')
    {
        $sql = "SELECT u.id as id, u.*
        FROM users u
        JOIN users_groups ug ON ug.user_id=u.id
        WHERE active=1 AND ug.group_id=1 $where ORDER BY u.id desc;";
        $query = $this->db->query($sql);
        //var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

    public function getCliente($where = '')
    {
        $sql = "SELECT  u.id as id, u.*
        FROM users u
        JOIN users_groups ug ON ug.user_id=u.id
         WHERE active=1 AND ug.group_id=2 $where ORDER BY u.id desc;";
        $query = $this->db->query($sql);
        //var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }
    public function getTecnicos($where = '')
    {
        $sql = "SELECT  u.id as id,
        CONCAT(u.first_name, ' ', u.last_name) as nombre_tecnico,
        u.*
        FROM users u
        JOIN users_groups ug ON ug.user_id=u.id
         WHERE active=1 AND ug.group_id=5 $where ORDER BY u.id desc;";
        $query = $this->db->query($sql);
        //var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }
    public function insertUsuario($tabla, $data)
    {
        $query = $this->db->insert($tabla, $data);
        if ($query)
            return $this->db->insert_id();
        else
            return false;
    }
    public function updateUsuario($tabla, $comparar, $datos, $id)
    {
        $this->db->where($comparar, $id);
        $result = $this->db->update($tabla, $datos);
        if ($result)
            return true;
        else
            return false;
    }

    public function update($tabla, $comparar, $datos, $id)
    {
        $this->db->where($comparar, $id);
        $result = $this->db->update($tabla, $datos);
        if ($result)
            return true;
        else
            return false;
    }
}
