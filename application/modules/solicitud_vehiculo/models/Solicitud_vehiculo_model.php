<?php

class Solicitud_vehiculo_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getSolicitudVehiculo($where='')
    {
        $sql = "SELECT sv.*,
        ma.nombre as marca,
        mo.nombre as modelo
        FROM solicitud_vehiculo sv
        JOIN marca ma on ma.id_marca=sv.marca
        JOIN modelo mo on mo.id_modelo=sv.modelo
        WHERE sv.ESTADO=1 $where
        ORDER BY id_solicitud_vehiculo desc;";
        $query = $this->db->query($sql);
        // var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

    public function insertSolicitudVehiculo($tabla, $data)
    {
        $query = $this->db->insert($tabla, $data);
		if ($query)
			return $this->db->insert_id();
		else
			return false;
    }
    public function updateSolicitudVehiculo($tabla, $comparar, $datos, $id)
    {
    	$this->db->where($comparar, $id);
		$result = $this->db->update($tabla, $datos);
		if ($result)
			return true;
		else
			return false;
    }


}
