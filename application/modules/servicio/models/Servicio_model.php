<?php

class Servicio_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getServicio($where='')
    {
        $sql = "SELECT * FROM servicio s JOIN users u ON u.id=s.id_cliente WHERE ESTADO=1 $where;";
        $query = $this->db->query($sql);
        // var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

    public function getServicioTabla($where='')
    {
        $sql = " SELECT
        s.id_servicio as id_servicio,
        v.id_vehiculo as id_vehiculo,
        s.nombre as nombre,
        s.descripcion as descripcion,
        s.detalle as detalles,
        s.id_tecnico as id_tecnico,
        CONCAT(t.first_name, ' ', t.last_name) as nombre_tecnico,
        c.id as id_cliente,
        CONCAT(c.first_name, ' ', c.last_name) as nombre_cliente,
        sup.id as id_supervisor,
        CONCAT(sup.first_name, ' ', sup.last_name) as nombre_supervisor,
        s.fecha_entrada as fecha_entrada,
        s.fecha_salida as fecha_salida,
        s.fecha_agenda as fecha_agenda,
        s.hora_agenda as hora_agenda,
        ma.nombre as marca,
        mo.nombre as modelo,
        ve.nombre as version,
        s.fecha_creacion as fecha_creacion,
        s.fecha_modificacion as fecha_modificacion,
        s.fecha_baja as fecha_baja,
        s.estado_servicio as estado_servicio,
        s.estado as estado

    FROM
        servicio s
        JOIN vehiculo v on v.id_vehiculo=s.id_vehiculo
        JOIN marca ma on ma.id_marca=v.marca
        JOIN modelo mo on mo.id_modelo=v.modelo
        JOIN version ve on ve.id_version=v.version
        JOIN users c on c.id=s.id_cliente
        JOIN users sup on sup.id=s.id_supervisor
        JOIN users t on t.id=s.id_tecnico WHERE s.ESTADO=1 $where;";
        $query = $this->db->query($sql);
        // var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    public function insertServicio($tabla, $data)
    {
        $query = $this->db->insert($tabla, $data);
		if ($query)
			return $this->db->insert_id();
		else
			return false;
    }
    public function updateServicio($tabla, $comparar, $datos, $id)
    {
    	$this->db->where($comparar, $id);
		$result = $this->db->update($tabla, $datos);
		if ($result)
			return true;
		else
			return false;
    }

}
