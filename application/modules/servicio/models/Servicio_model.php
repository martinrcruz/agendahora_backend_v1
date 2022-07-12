<?php

class Servicio_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getServicio($where='')
    {
        $sql = "SELECT
                s.id_servicio as id_servicio,
                v.id_vehiculo as id_vehiculo,
                s.nombre as nombre_servicio,
                s.observacion as observacion,
                s.detalle as detalles,
                s.id_tecnico as id_tecnico,
                CONCAT(t.first_name, ' ', t.last_name) as nombre_tecnico,
                u.id as id_cliente,
                CONCAT(u.first_name, ' ', u.last_name) as nombre_cliente,
                sup.id as id_supervisor,
                CONCAT(sup.first_name, ' ', sup.last_name) as nombre_supervisor,
                s.fecha_entrada as fecha_entrada,
                s.fecha_salida as fecha_salida,
                s.fecha_agenda as fecha_agenda,
                s.agenda_inicio as agenda_inicio,
                s.agenda_fin as agenda_fin,
                ma.nombre as marca,
                mo.nombre as modelo,
                ve.nombre as version,
                s.fecha_creacion as fecha_creacion,
                s.estado as estado,
                ts.nombre as tipo_servicio,
                es.nombre as estado_servicio



                FROM servicio s
                JOIN vehiculo v on v.id_vehiculo=s.id_vehiculo
                JOIN marca ma on ma.id_marca=v.marca
                JOIN modelo mo on mo.id_modelo=v.modelo
                JOIN version ve on ve.id_version=v.version
                JOIN users u on u.id=s.id_cliente
                JOIN users sup on sup.id=s.id_supervisor
                JOIN users t on t.id=s.id_tecnico
                JOIN estado_servicio es ON es.id_estado_servicio=s.estado_servicio
                JOIN tipo_servicio ts ON ts.id_tipo_servicio=s.tipo_servicio
                WHERE s.ESTADO=1 $where ORDER BY s.id_servicio DESC;";
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
        s.observacion as observacion,
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
        s.agenda_inicio as agenda_inicio,
        s.agenda_fin as agenda_fin,
        ma.nombre as marca,
        mo.nombre as modelo,
        ve.nombre as version,
        s.fecha_creacion as fecha_creacion,
        s.fecha_modificacion as fecha_modificacion,

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
        JOIN users t on t.id=s.id_tecnico WHERE s.ESTADO=1 $where ORDER BY s.id_servicio DESC;";
        $query = $this->db->query($sql);
        // var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }
    public function getHistorialServicioTabla($where='')
    {
        $sql = " SELECT
        s.id_servicio as id_servicio,
        v.id_vehiculo as id_vehiculo,
        s.nombre as nombre,
        s.observacion as observacion,
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
        s.agenda_inicio as agenda_inicio,
        s.agenda_fin as agenda_fin,
        ma.nombre as marca,
        mo.nombre as modelo,
        ve.nombre as version,
        s.fecha_creacion as fecha_creacion,
        s.fecha_modificacion as fecha_modificacion,

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
        JOIN users t on t.id=s.id_tecnico WHERE s.ESTADO=1 $where ORDER BY s.id_servicio DESC;";
        $query = $this->db->query($sql);
        // var_dump($this->db->last_query());

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

    public function getIndicadores($where){
      $sql = "SELECT
                  COUNT(
                      CASE estado_servicio WHEN 2 THEN 1 ELSE NULL
                  END
              ) as servicios_activos,
                  COUNT(
                      CASE estado_servicio WHEN 4 THEN 1 ELSE NULL
                  END
              ) as servicios_pendientes,
                  COUNT(
                      CASE estado WHEN 1 THEN 1 ELSE NULL
                  END
              ) as servicios_totales
              FROM
                  servicio
              WHERE
                  estado = 1 $where;";
      $query = $this->db->query($sql);
      // var_dump($this->db->last_query());

      if ($query->num_rows() > 0)
          return $query;
      else
          return false;
    }

    public function getIndicadoresWeb(){
      $sql = "SELECT
                  COUNT(
                      CASE estado_servicio WHEN 2 THEN 1 ELSE NULL
                  END
              ) as servicios_activos,
                  COUNT(
                      CASE estado_servicio WHEN 4 THEN 1 ELSE NULL
                  END
              ) as servicios_pendientes,
                  COUNT(
                      CASE estado WHEN 1 THEN 1 ELSE NULL
                  END
              ) as servicios_totales
              FROM
                  servicio
              WHERE
                  estado = 1 $where;";
      $query = $this->db->query($sql);
      // var_dump($this->db->last_query());

      if ($query->num_rows() > 0)
          return $query;
      else
          return false;
    }
    public function getIndicadorMarcaRecurrente(){
      $sql = "SELECT
                  m.nombre as nombre_marca_recurrente,
                  COUNT(m.id_marca) AS marca_recurrente
              FROM
                  servicio s
              JOIN vehiculo v ON v.id_vehiculo=s.id_vehiculo
              JOIN marca m ON
                  m.id_marca = v.marca
              WHERE
                  s.estado = 1
              GROUP BY
                  m.id_marca
              ORDER BY
                  marca_recurrente
              DESC
              LIMIT 1";
      $query = $this->db->query($sql);
      // var_dump($this->db->last_query());

      if ($query->num_rows() > 0)
          return $query;
      else
          return false;
    }


    public function getIndicadorClienteNuevo($init, $end){
      $sql = "SELECT
              COUNT(u.id) as clientes_nuevos
              FROM
                  users u
              JOIN users_groups ug ON ug.user_id=u.id
              JOIN groups g ON g.id=ug.group_id
              WHERE u.created_on>=$init AND u.created_on<=$end;";
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
