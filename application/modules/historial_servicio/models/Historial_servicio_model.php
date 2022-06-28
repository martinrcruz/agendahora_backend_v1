<?php

class Historial_servicio_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getHistorialServicio($where='')
    {
        $sql = "SELECT * FROM historial_servicio WHERE ESTADO=1 $where;";
        $query = $this->db->query($sql);
        //var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

    public function getHistorialServicioTabla($where='')
    {
        $sql = " SELECT
        hs.id_historial_servicio as id_historial_servicio,
        v.id_vehiculo as id_vehiculo,
        hs.nombre as nombre,
        hs.descripcion as descripcion,
        hs.detalle as detalles,
        hs.id_tecnico as id_tecnico,
        CONCAT(t.first_name, ' ', t.last_name) as nombre_tecnico,
        c.id as id_cliente,
        CONCAT(c.first_name, ' ', c.last_name) as nombre_cliente,
        sup.id as id_supervisor,
        CONCAT(sup.first_name, ' ', sup.last_name) as nombre_supervisor,
        hs.fecha_entrada as fecha_entrada,
        hs.fecha_salida as fecha_salida,
        hs.fecha_agenda as fecha_agenda,
        hs.hora_agenda as hora_agenda,
        ma.nombre as marca,
        mo.nombre as modelo,
        ve.nombre as version,
        hs.fecha_creacion as fecha_creacion,
        hs.fecha_modificacion as fecha_modificacion,
        hs.fecha_baja as fecha_baja,
        hs.estado_servicio as estado_servicio,
        hs.estado as estado

    FROM
        historial_servicio hs
        JOIN vehiculo v on v.id_vehiculo=hs.id_vehiculo
        JOIN marca ma on ma.id_marca=v.marca
        JOIN modelo mo on mo.id_modelo=v.modelo
        JOIN version ve on ve.id_version=v.version
        JOIN users c on c.id=hs.id_cliente
        JOIN users sup on sup.id=hs.id_supervisor
        JOIN users t on t.id=hs.id_tecnico WHERE hs.ESTADO=1 $where;";
        $query = $this->db->query($sql);
        // var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

    public function insertHistorialServicio($tabla, $data)
    {
        $query = $this->db->insert($tabla, $data);
		if ($query)
			return $this->db->insert_id();
		else
			return false;
    }
    public function updateHistorialServicio($tabla, $comparar, $datos, $id)
    {
    	$this->db->where($comparar, $id);
		$result = $this->db->update($tabla, $datos);
		if ($result)
			return true;
		else
			return false;
    }


}
