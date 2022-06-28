<?php

class Vehiculo_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getVehiculo($where = '')
    {
        $sql = "SELECT * FROM vehiculo WHERE ESTADO=1 $where;";
        $query = $this->db->query($sql);
        //var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

    public function getVehiculoTabla($where = '')
    {
        $sql = "SELECT 
        v.id_vehiculo as id_vehiculo,
        v.nombre as nombre,
        ma.nombre as marca,
        mo.nombre as modelo,
        v.patente as patente,
        v.color as color,
        c.id as id_cliente,
        CONCAT(c.first_name, ' ', c.last_name) as nombre_cliente,
        v.fecha_creacion as fecha_creacion,
        v.fecha_modificacion as fecha_modificacion,
        v.fecha_baja as fecha_baja,
        v.estado as estado
        FROM vehiculo v
        JOIN marca ma on ma.id_marca=v.marca
        JOIN modelo mo on mo.id_modelo=v.modelo
        JOIN users c on c.id=v.id_cliente

        WHERE v.ESTADO=1 $where;";
        $query = $this->db->query($sql);
        // var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

    public function getVehiculoMobile($where = '')
    {
        $sql = "SELECT
        v.id_vehiculo as id_vehiculo,
        v.nombre as nombre_vehiculo,
        v.patente as patente,
        v.color as color,
        ma.nombre as nombre_marca,
        mo.nombre as nombre_modelo,
        s.fecha_entrada as ultimo_servicio,
        s.detalle as detalle_ultimo_servicio,
             v.fecha_creacion as fecha_creacion,
            v.estado as estado
    FROM
       vehiculo v
       JOIN marca ma ON ma.id_marca=v.marca
       JOIN modelo mo ON mo.id_modelo=v.modelo
       JOIN servicio s ON s.id_vehiculo=v.id_vehiculo
       WHERE v.ESTADO=1 $where;";
        $query = $this->db->query($sql);
        //var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    public function insertVehiculo($tabla, $data)
    {
        $query = $this->db->insert($tabla, $data);
        if ($query)
            return $this->db->insert_id();
        else
            return false;
    }
    public function updateVehiculo($tabla, $comparar, $datos, $id)
    {
        $this->db->where($comparar, $id);
        $result = $this->db->update($tabla, $datos);
        if ($result)
            return true;
        else
            return false;
    }
}
