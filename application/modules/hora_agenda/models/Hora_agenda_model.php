<?php

class Hora_agenda_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getHoraAgenda($where='')
    {
        $sql = "SELECT
        ha.id_hora_agenda as id_hora_agenda,
        ha.id_servicio as id_servicio,
        ha.tipo_servicio as tipo_servicio,
        ts.nombre as nombre_tipo_servicio,
        ha.id_vehiculo as id_vehiculo,
        ha.nombre as nombre,
        ha.observacion as observacion,
        ha.detalle as detalle,
        ha.id_usuario_tecnico as id_tecnico,
        CONCAT(t.first_name, ' ', t.last_name) as nombre_tecnico,
        c.id as id_cliente,
        CONCAT(c.first_name, ' ', c.last_name) as nombre_cliente,
        su.id as id_supervisor,
        CONCAT(su.first_name, ' ', su.last_name) as nombre_supervisor,
        ha.fecha_agenda as fecha_agenda,
        ha.agenda_inicio as agenda_inicio,
        ha.agenda_fin as agenda_fin,
        ha.fecha_entrada as fecha_entrada,
        ha.fecha_salida as fecha_salida,
        ma.nombre as marca,
        mo.nombre as modelo,
        ve.nombre as version,
        ha.fecha_creacion as fecha_creacion,
        ha.fecha_modificacion as fecha_modificacion,
        ha.fecha_baja as fecha_baja,
        ha.estado as estado,
        ha.estado_solicitud as estado_solicitud

        FROM hora_agenda ha
        JOIN vehiculo v on v.id_vehiculo=ha.id_vehiculo
        JOIN marca ma on ma.id_marca=v.marca
        JOIN modelo mo on mo.id_modelo=v.modelo
        JOIN version ve on ve.id_version=v.version
        JOIN tipo_servicio ts on ts.id_tipo_servicio=ha.tipo_servicio
        JOIN users c on c.id=ha.id_cliente
        JOIN users su on su.id=ha.id_usuario_cargo
        JOIN users t on t.id=ha.id_usuario_tecnico
         WHERE ha.ESTADO=1 $where ORDER BY ha.id_hora_agenda DESC;";
        $query = $this->db->query($sql);
        // var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }
    public function getServiciosDia($where='')
    {
        $sql = "SELECT
        s.id_servicio as id_servicio,
        s.tipo_servicio as tipo_servicio,
        ts.nombre as nombre_tipo_servicio,

        s.id_vehiculo as id_vehiculo,
        s.nombre as nombre,
        s.observacion as observacion,
        s.detalle as detalles,
        s.id_tecnico as id_tecnico,
        CONCAT(t.first_name, ' ', t.last_name) as nombre_tecnico,
        c.id as id_cliente,
        CONCAT(c.first_name, ' ', c.last_name) as nombre_cliente,
        s.fecha_agenda as fecha_agenda,
        s.agenda_inicio as agenda_inicio,
        s.agenda_fin as agenda_fin,
        s.fecha_entrada as fecha_entrada,
        s.fecha_salida as fecha_salida,
        ma.nombre as marca,
        mo.nombre as modelo,
        ve.nombre as version,
        s.fecha_creacion as fecha_creacion,
        s.fecha_modificacion as fecha_modificacion,
        s.fecha_baja as fecha_baja,
        s.estado as estado,
        s.estado_servicio as estado_servicio

        FROM servicio s
        JOIN vehiculo v on v.id_vehiculo=s.id_vehiculo
        JOIN marca ma on ma.id_marca=v.marca
        JOIN modelo mo on mo.id_modelo=v.modelo
        JOIN version ve on ve.id_version=v.version
        JOIN users c on c.id=s.id_cliente
        JOIN users t on t.id=s.id_tecnico
        JOIN tipo_servicio ts ON ts.id_tipo_servicio=s.tipo_servicio
         WHERE s.ESTADO=1 $where;";
        $query = $this->db->query($sql);
        // var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }
    public function getHorasDisponibles($where)
    {
        $sql = "SELECT * FROM hora_agenda WHERE ESTADO=1 $where;";
        $query = $this->db->query($sql);
        // var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

    public function getHoraAgendaMobile($where='')
    {
      $sql = "SELECT
              ha.id_hora_agenda as id_hora_agenda,
              ha.id_vehiculo as id_vehiculo,
              ha.nombre as nombre,
              ha.observacion as observacion,
              ha.detalle as detalles,
              ha.id_usuario_tecnico as id_tecnico,
              CONCAT(t.first_name, ' ', t.last_name) as nombre_tecnico,
              c.id as id_cliente,
              CONCAT(c.first_name, ' ', c.last_name) as nombre_cliente,
              ha.fecha_agenda as fecha_agenda,
              ha.agenda_inicio as agenda_inicio,
              ha.agenda_fin as agenda_fin,
              ma.nombre as marca,
              mo.nombre as modelo,
              ve.nombre as version,
              ha.fecha_creacion as fecha_creacion,
              ha.fecha_modificacion as fecha_modificacion,
              ha.fecha_baja as fecha_baja,
              ha.estado as estado

          FROM
              hora_agenda ha
              JOIN vehiculo v on v.id_vehiculo=ha.id_vehiculo
              JOIN marca ma on ma.id_marca=v.marca
              JOIN modelo mo on mo.id_modelo=v.modelo
              JOIN version ve on ve.id_version=v.version
              JOIN users c on c.id=ha.id_cliente
              JOIN users t on t.id=ha.id_usuario_tecnico WHERE ha.ESTADO=1 $where;";
        $query = $this->db->query($sql);
        //var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    public function insertHoraAgenda($tabla, $data)
    {
        $query = $this->db->insert($tabla, $data);
		if ($query)
			return $this->db->insert_id();
		else
			return false;
    }
    public function updateHoraAgenda($tabla, $comparar, $datos, $id)
    {
    	$this->db->where($comparar, $id);
		$result = $this->db->update($tabla, $datos);
		if ($result)
			return true;
		else
			return false;
    }


}
