<?php

class Sucursal_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getSucursal($where='')
    {
        $sql = "SELECT * FROM sucursal WHERE ESTADO=1 $where;";
        $query = $this->db->query($sql);
        //var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

    public function insertSucursal($tabla, $data)
    {
        $query = $this->db->insert($tabla, $data);
		if ($query)
			return $this->db->insert_id(); 
		else
			return false;
    }
    public function updateSucursal($tabla, $comparar, $datos, $id)
    {
    	$this->db->where($comparar, $id);
		$result = $this->db->update($tabla, $datos);
		if ($result)
			return true;
		else
			return false;
    }


}