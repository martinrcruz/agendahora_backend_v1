<?php
class Agenda_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getHoraAgenda($where='')
    {
      $sql = "SELECT * FROM hora_agenda WHERE ESTADO=1 $where;";
        $query = $this->db->query($sql);
        //var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

    public function getHoraAgendaTabla($where='')
    {
      $sql = "SELECT
              ha.id_hora_agenda as id_hora_agenda,
              ha.id_servicio as id_servicio,
              ha.tipo_servicio as tipo_servicio,
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
