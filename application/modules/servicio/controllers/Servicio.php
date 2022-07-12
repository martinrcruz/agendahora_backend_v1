<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Servicio extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('servicio_model');
        $this->load->library(['ion_auth', 'form_validation']);

        date_default_timezone_set('America/Santiago');
    }


    public function getServicio()
    {
        if (true) {
            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $request->data = [];
            $where = '';
            $fecha = date('Y-m-d H:i:s');

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];

            if ($this->input->post('user_id')) {
                $user_id = $this->security->xss_clean($this->input->post('user_id'));
                $where = " AND u.id=" . $user_id;
            }

            if ($query = $this->servicio_model->getServicio($where)) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();

                    $row->id_servicio = $res->id_servicio;
                    $row->nombre_servicio = $res->nombre_servicio;
                    $row->observacion = $res->observacion;
                    $row->detalle = $res->detalles;

                    $row->nombre_supervisor = $res->nombre_supervisor;
                    $row->id_supervisor = $res->id_supervisor;
                    $row->id_tecnico = $res->nombre_tecnico;
                    $row->id_tecnico = $res->id_tecnico;
                    $row->id_cliente = $res->id_cliente;
                    $row->id_vehiculo = $res->id_vehiculo;
                    $row->estado_servicio = $res->estado_servicio;

                    $row->fecha_entrada = date('d-m-Y H:s', strtotime($res->fecha_entrada));
                    $row->fecha_salida = date('d-m-Y H:s', strtotime($res->fecha_salida));

                    $row->fecha_agenda = $res->fecha_agenda;
                    $row->agenda_inicio = $res->agenda_inicio;
                    $row->agenda_fin = $res->agenda_fin;

                    $row->marca = $res->marca;
                    $row->modelo = $res->modelo;
                    $row->version = $res->version;

                    $row->fecha_creacion = $res->fecha_creacion;

                    $row->estado = $res->estado;

                    array_push($response->data, $row);
                }
            }
            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function getIndicadores()
    {
        if (true) {
            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $request->data = [];
            $where = '';
            $fecha = date('Y-m-d H:i:s');

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];

            if ($this->input->post('user_id')) {
                $user_id = $this->security->xss_clean($this->input->post('user_id'));
                $where = " AND id_cliente=" . $user_id;
            }

            if ($query = $this->servicio_model->getIndicadores($where)) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();

                    $row->servicios_activos = $res->servicios_activos;
                    $row->servicios_pendientes = $res->servicios_pendientes;
                    $row->servicios_totales = $res->servicios_totales;
                    array_push($response->data, $row);
                }
            }
            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function getServiciosActivos()
    {
        if (true) {
            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $request->data = [];
            $where = '';
            $fecha = date('Y-m-d H:i:s');

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];

            if ($this->input->post('user_id')) {
                $user_id = $this->security->xss_clean($this->input->post('user_id'));
                $where = " AND u.id=" . $user_id;
            }
            if ($query = $this->servicio_model->getServicio($where)) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->id_servicio = $res->id_servicio;
                    $row->tipo_servicio = $res->tipo_servicio;
                    $row->observacion = $res->observacion;
                    $row->detalle = $res->detalles;

                    $row->nombre_supervisor = $res->nombre_supervisor;
                    $row->id_supervisor = $res->id_supervisor;
                    $row->id_tecnico = $res->nombre_tecnico;
                    $row->id_tecnico = $res->id_tecnico;
                    $row->id_cliente = $res->id_cliente;
                    $row->id_vehiculo = $res->id_vehiculo;
                    $row->estado_servicio = $res->estado_servicio;

                    $row->fecha_entrada = date('d-m-Y H:s', strtotime($res->fecha_entrada));
                    $row->fecha_salida = date('d-m-Y H:s', strtotime($res->fecha_salida));

                    $row->fecha_agenda = $res->fecha_agenda;
                    $row->agenda_inicio = $res->agenda_inicio;
                    $row->agenda_fin = $res->agenda_fin;

                    $row->marca = $res->marca;
                    $row->modelo = $res->modelo;
                    $row->version = $res->version;

                    $row->fecha_creacion = $res->fecha_creacion;

                    $row->estado = $res->estado;




                    array_push($response->data, $row);
                }
            }
            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }


    public function getServicioTabla()
    {
        if (true) {
            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $request->data = [];

            $fecha = date('Y-m-d H:i:s');
            $where = '';
            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];


            if (!empty($this->input->post('fecha_inicio'))) {
                if ($this->input->post('fecha_inicio') != 'null') {
                    $request->fecha_inicio = $this->security->xss_clean($this->input->post('fecha_inicio'));
                    $where .= " AND s.fecha_entrada >= '$request->fecha_inicio'";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener fecha_inicio";
            }

            if (!empty($this->input->post('fecha_fin'))) {
                if ($this->input->post('fecha_fin') != 'null') {
                    $request->fecha_fin = $this->security->xss_clean($this->input->post('fecha_fin'));
                    $where .= " AND s.fecha_salida <= '$request->fecha_fin'";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener fecha_fin";
            }

            if (!empty($this->input->post('fecha_agenda'))) {
                if ($this->input->post('fecha_agenda') != 'null') {
                    $request->fecha_agenda = $this->security->xss_clean($this->input->post('fecha_agenda'));
                    $where .= " AND s.fecha_agenda <= '$request->fecha_agenda'";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener fecha agenda";
            }

            if (!empty($this->input->post('tecnico'))) {
                if ($this->input->post('tecnico') != 'null') {
                    $request->tecnico = $this->security->xss_clean($this->input->post('tecnico'));
                    $where .= " AND s.id_tecnico = $request->tecnico";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener tecnico";
            }


            if (!empty($this->input->post('marca'))) {
                if ($this->input->post('marca') != 'null') {
                    $request->marca = $this->security->xss_clean($this->input->post('marca'));
                    $where .= " AND ma.id_marca = $request->marca";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener marca";
            }

            if (!empty($this->input->post('modelo'))) {
                if ($this->input->post('modelo') != 'null') {
                    $request->modelo = $this->security->xss_clean($this->input->post('modelo'));
                    $where .= " AND mo.id_modelo = $request->modelo";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener modelo";
            }

            if (!empty($this->input->post('version'))) {
                if ($this->input->post('version') != 'null') {
                    $request->version = $this->security->xss_clean($this->input->post('version'));
                    $where .= " AND ve.id_version = $request->version";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener version";
            }

            if (!empty($this->input->post('estado'))) {
                if ($this->input->post('estado') != 'null') {
                    $request->estado = $this->security->xss_clean($this->input->post('estado'));
                    $where .= " AND s.estado_servicio = $request->estado";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener version";
            }


            if ($query = $this->servicio_model->getServicioTabla($where)) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();

                    $row->id_servicio = $res->id_servicio;
                    $row->nombre = $res->nombre;
                    $row->observacion = $res->observacion;
                    $row->detalle = $res->detalles;

                    $row->fecha_entrada = date('d-m-Y H:s', strtotime($res->fecha_entrada));
                    $row->fecha_salida = date('d-m-Y H:s', strtotime($res->fecha_salida));

                    $row->fecha_agenda = $res->fecha_agenda;
                    $row->agenda_inicio = $res->agenda_inicio;
                    $row->agenda_fin = $res->agenda_fin;
                    $row->id_vehiculo = $res->id_vehiculo;
                    $row->id_tecnico = $res->id_tecnico;
                    $row->nombre_tecnico = $res->nombre_tecnico;
                    $row->nombre_cliente = $res->nombre_cliente;
                    $row->marca = $res->marca;
                    $row->modelo = $res->modelo;
                    $row->version = $res->version;

                    $row->fecha_creacion = $res->fecha_creacion;
                    $row->fecha_modificacion = $res->fecha_modificacion;
                    $row->estado = $res->estado;
                    $row->estado_servicio = $res->estado_servicio;

                    array_push($response->data, $row);
                }
            }
            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }



    public function getHistorialServicioTabla()
    {
        if (true) {
            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $request->data = [];

            $fecha = date('Y-m-d H:i:s');
            $where = '';
            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];


            if (!empty($this->input->post('fecha_inicio'))) {
                if ($this->input->post('fecha_inicio') != 'null') {
                    $request->fecha_inicio = $this->security->xss_clean($this->input->post('fecha_inicio'));
                    $where .= " AND s.fecha_entrada >= '$request->fecha_inicio'";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener fecha_inicio";
            }

            if (!empty($this->input->post('fecha_fin'))) {
                if ($this->input->post('fecha_fin') != 'null') {
                    $request->fecha_fin = $this->security->xss_clean($this->input->post('fecha_fin'));
                    $where .= " AND s.fecha_salida <= '$request->fecha_fin'";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener fecha_fin";
            }

            if (!empty($this->input->post('fecha_agenda'))) {
                if ($this->input->post('fecha_agenda') != 'null') {
                    $request->fecha_agenda = $this->security->xss_clean($this->input->post('fecha_agenda'));
                    $where .= " AND s.fecha_agenda <= '$request->fecha_agenda'";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener fecha agenda";
            }

            if (!empty($this->input->post('tecnico'))) {
                if ($this->input->post('tecnico') != 'null') {
                    $request->tecnico = $this->security->xss_clean($this->input->post('tecnico'));
                    $where .= " AND s.id_tecnico = $request->tecnico";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener tecnico";
            }


            if (!empty($this->input->post('marca'))) {
                if ($this->input->post('marca') != 'null') {
                    $request->marca = $this->security->xss_clean($this->input->post('marca'));
                    $where .= " AND ma.id_marca = $request->marca";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener marca";
            }

            if (!empty($this->input->post('modelo'))) {
                if ($this->input->post('modelo') != 'null') {
                    $request->modelo = $this->security->xss_clean($this->input->post('modelo'));
                    $where .= " AND mo.id_modelo = $request->modelo";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener modelo";
            }

            if (!empty($this->input->post('version'))) {
                if ($this->input->post('version') != 'null') {
                    $request->version = $this->security->xss_clean($this->input->post('version'));
                    $where .= " AND ve.id_version = $request->version";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener version";
            }

            if (!empty($this->input->post('estado'))) {
                if ($this->input->post('estado') != 'null') {
                    $request->estado = $this->security->xss_clean($this->input->post('estado'));
                    $where .= " AND s.estado_servicio = $request->estado";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener version";
            }


            if ($query = $this->servicio_model->getHistorialServicioTabla($where)) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();

                    $row->id_servicio = $res->id_servicio;
                    $row->nombre = $res->nombre;
                    $row->observacion = $res->observacion;
                    $row->detalle = $res->detalles;

                    $row->fecha_entrada = date('d-m-Y H:s', strtotime($res->fecha_entrada));
                    $row->fecha_salida = date('d-m-Y H:s', strtotime($res->fecha_salida));

                    $row->fecha_agenda = $res->fecha_agenda;
                    $row->agenda_inicio = $res->agenda_inicio;
                    $row->agenda_fin = $res->agenda_fin;
                    $row->id_vehiculo = $res->id_vehiculo;
                    $row->id_tecnico = $res->id_tecnico;
                    $row->nombre_tecnico = $res->nombre_tecnico;
                    $row->nombre_cliente = $res->nombre_cliente;
                    $row->marca = $res->marca;
                    $row->modelo = $res->modelo;
                    $row->version = $res->version;

                    $row->fecha_creacion = $res->fecha_creacion;
                    $row->fecha_modificacion = $res->fecha_modificacion;
                    $row->estado = $res->estado;
                    $row->estado_servicio = $res->estado_servicio;

                    array_push($response->data, $row);
                }
            }
            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }


    public function getServicioById()
    {
        if (true) {

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $request->data = [];

            $fecha = date('Y-m-d H:i:s');

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];


            //DECLARACION DE VARIABLES DE FILTRO PARA QUERY
            $where = '';

            if (is_numeric($this->input->post('id_servicio'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_servicio', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            $request->id ? $where = " AND id_servicio=$request->id" : $where = '';


            if (sizeof($response->errores) == 0) {
                if ($query = $this->servicio_model->getServicioTabla($where)) {
                    foreach ($query->result() as $res) {
                        $row = null;
                        $row = new stdClass();
                        $row->id_servicio = $res->id_servicio;
                        $row->nombre = $res->nombre;
                        $row->observacion = $res->observacion;
                        $row->detalle = $res->detalles;
                        $row->fecha_entrada = date('d-m-Y H:s', strtotime($res->fecha_entrada));
                        $row->fecha_salida = date('d-m-Y H:s', strtotime($res->fecha_salida));

                        $row->fecha_agenda = date('d-m-Y', strtotime($res->fecha_agenda));

                        $row->agenda_inicio = $res->agenda_inicio;
                        $row->agenda_fin = $res->agenda_fin;
                        $row->id_vehiculo = $res->id_vehiculo;
                        $row->id_tecnico = $res->id_tecnico;
                        $row->nombre_tecnico = $res->nombre_tecnico;
                        $row->id_cliente = $res->id_cliente;
                        $row->nombre_cliente = $res->nombre_cliente;
                        $row->id_supervisor = $res->id_supervisor;
                        $row->nombre_supervisor = $res->nombre_supervisor;
                        $row->marca = $res->marca;
                        $row->modelo = $res->modelo;
                        $row->version = $res->version;
                        $row->estado_servicio = $res->estado_servicio;

                        $row->fecha_creacion = $res->fecha_creacion;
                        $row->estado = $res->estado;


                        array_push($response->data, $row);
                    }
                }
            }

            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }



    public function insertServicio()
    {
        if (true) {

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $request->data = [];

            $fecha = date('Y-m-d H:i:s');

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];



            if (!empty($this->input->post('tipo_servicio'))) {
                $request->tipo_servicio = trim($this->security->xss_clean($this->input->post('tipo_servicio', true)));
            }
            if (!empty($this->input->post('nombre'))) {
                $request->nombre = trim($this->security->xss_clean($this->input->post('nombre', true)));
            }
            if (!empty($this->input->post('observacion'))) {
                $request->observacion = trim($this->security->xss_clean($this->input->post('observacion', true)));
            }
            if (!empty($this->input->post('detalle'))) {
                $request->detalle = trim($this->security->xss_clean($this->input->post('detalle', true)));
            }
            if (!empty($this->input->post('estado_servicio'))) {
                $request->estado_servicio = trim($this->security->xss_clean($this->input->post('estado_servicio', true)));
            }
            if (!empty($this->input->post('id_vehiculo'))) {
                $request->id_vehiculo = trim($this->security->xss_clean($this->input->post('id_vehiculo', true)));
            }

            if (!empty($this->input->post('id_tecnico'))) {
                $request->id_tecnico = trim($this->security->xss_clean($this->input->post('id_tecnico', true)));
            }

            if (!empty($this->input->post('id_cliente'))) {
                $request->id_cliente = trim($this->security->xss_clean($this->input->post('id_cliente', true)));
            }
            if (!empty($this->input->post('id_supervisor'))) {
                $request->id_supervisor = trim($this->security->xss_clean($this->input->post('id_supervisor', true)));
            }
            if (!empty($this->input->post('fecha_entrada'))) {
                $request->fecha_entrada = trim($this->security->xss_clean($this->input->post('fecha_entrada', true)));
            }
            if (!empty($this->input->post('fecha_salida'))) {
                $request->fecha_salida = trim($this->security->xss_clean($this->input->post('fecha_salida', true)));
            }
            if (!empty($this->input->post('fecha_agenda'))) {
                $request->fecha_agenda = trim($this->security->xss_clean($this->input->post('fecha_agenda', true)));
            }
            if (!empty($this->input->post('agenda_inicio'))) {
                $request->agenda_inicio = trim($this->security->xss_clean($this->input->post('agenda_inicio', true)));
            }
            if (!empty($this->input->post('agenda_fin'))) {
                $request->agenda_fin = trim($this->security->xss_clean($this->input->post('agenda_fin', true)));
            }



            //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
            $datos = array(
                'tipo_servicio' => $request->tipo_servicio,
                'estado_servicio' => $request->estado_servicio,
                'nombre' => $request->nombre,
                'observacion' => $request->observacion,
                'fecha_agenda' => $request->fecha_agenda,
                'agenda_inicio' => $request->agenda_inicio,
                'agenda_fin' => $request->agenda_fin,
                'fecha_entrada' => $request->fecha_entrada,
                'fecha_salida' => $request->fecha_salida,
                'id_tecnico' => $request->id_tecnico,
                'id_cliente' => $request->id_cliente,
                'id_vehiculo' => $request->id_vehiculo,
                'id_supervisor' => $request->id_supervisor,
                'fecha_creacion' => $fecha,
                'estado' => 1

            );

            //INSERCION, ACTUALIZACION U OPERACIONES
            if ($query = $this->servicio_model->insertServicio('servicio', $datos)) {
                $response->proceso = 1;
                $response->id = $query;
                $response->data = $datos;
            } else {
                $response->errores[] = "El dato no pudo ser ingresado";
            }

            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function updateServicio()
    {
        if (true) {

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $request->data = [];

            $fecha = date('Y-m-d H:i:s');

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];

            //COMPROBAMOS SI VIENE UN ID MEDIANTE LA PETICION POST, Y SI ES QUE VIENE LO GUARDAMOS (SI NO VIENE EL ID NO ES POSIBLE EDITAR, YA QUE NO ESTAMOS APUNTANDO A NINGUNA TUPLA DE DATOS)
            if ($this->input->post('id_servicio')) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_servicio', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            if (sizeof($response->errores) == 0) {
                //VERIFICAMOS LAS VARIABLES QUE RECIBIMOS PARA EDITAR.
                if (!empty($this->input->post('nombre'))) {
                    $request->nombre = trim($this->security->xss_clean($this->input->post('nombre', true)));
                }

                if (!empty($this->input->post('observacion'))) {
                    $request->descripcion = trim($this->security->xss_clean($this->input->post('observacion', true)));
                }

                if (!empty($this->input->post('id_vehiculo'))) {
                    $request->id_vehiculo = trim($this->security->xss_clean($this->input->post('id_vehiculo', true)));
                }

                if (!empty($this->input->post('id_tecnico'))) {
                    $request->id_tecnico = trim($this->security->xss_clean($this->input->post('id_tecnico', true)));
                }
                //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
                $datos = array(
                    'nombre' => $request->nombre,
                    'observacion' => $request->observacion,
                    'id_vehiculo' =>  $request->id_vehiculo,
                    'id_tecnico' =>  $request->id_tecnico,
                    'fecha_modificacion' =>  $fecha
                );
            }

            $where = " AND id_servicio=$request->id";
            $itemActualizado = $this->servicio_model->getServicio($where);
            $response->data = $itemActualizado->result();
            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($query = $this->servicio_model->updateServicio('servicio', 'id_servicio', $datos, $request->id)) {
                    //SI EL PROCESO ES EXITOSO, DEVOLVERA UN VALOR DENTRO DEL ARRAY DE RESPUESTA IGUAL A 1
                    $response->proceso = 1;
                    $response->id = $query;
                    $response->data = $datos;
                }
            } else {
                $response->errores[] = "Ocurrió un problema al procesar la edicion";
            }

            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function updateServicioState()
    {
        if (true) {

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $request->data = [];

            $fecha = date('Y-m-d H:i:s');

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];

            //COMPROBAMOS SI VIENE UN ID MEDIANTE LA PETICION POST, Y SI ES QUE VIENE LO GUARDAMOS (SI NO VIENE EL ID NO ES POSIBLE EDITAR, YA QUE NO ESTAMOS APUNTANDO A NINGUNA TUPLA DE DATOS)
            if ($this->input->post('id_servicio')) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_servicio', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            if (sizeof($response->errores) == 0) {
                //VERIFICAMOS LAS VARIABLES QUE RECIBIMOS PARA EDITAR.
                if (!empty($this->input->post('estado_servicio'))) {
                    $request->estado_servicio = trim($this->security->xss_clean($this->input->post('estado_servicio', true)));
                }

                //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
                $datos = array(
                    'estado_servicio' => $request->estado_servicio,
                    'fecha_modificacion' =>  $fecha
                );
            }

            $where = " AND id_servicio=$request->id";
            $itemActualizado = $this->servicio_model->getServicio($where);
            $response->data = $itemActualizado->result();
            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($query = $this->servicio_model->updateServicio('servicio', 'id_servicio', $datos, $request->id)) {
                    //SI EL PROCESO ES EXITOSO, DEVOLVERA UN VALOR DENTRO DEL ARRAY DE RESPUESTA IGUAL A 1
                    $response->proceso = 1;
                    $response->id = $query;
                    $response->data = $datos;
                }
            } else {
                $response->errores[] = "Ocurrió un problema al procesar la edicion";
            }

            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }


    public function deleteServicio()
    {
        if (true) {

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $fecha = date('Y-m-d H:i:s');

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];


            //COMPROBAMOS SI VIENE UN ID MEDIANTE LA PETICION POST, Y SI ES QUE VIENE LO GUARDAMOS.
            if (is_numeric($this->input->post('id_servicio'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_servicio', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }
            $where = " AND id_servicio=$request->id";
            $itemEliminado = $this->servicio_model->getServicio($where);
            $response->data = $itemEliminado->result();
            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($this->servicio_model->updateServicio("servicio", "id_servicio", array('fecha_baja' => $fecha, "estado" => 0), $request->id)) {
                    //SI EL PROCESO ES EXITOSO, DEVOLVERA UN VALOR DENTRO DEL ARRAY DE RESPUESTA IGUAL A 1
                    $response->proceso = 1;
                }
            } else {
                $response->errores[] = "Ocurrió un problema al procesar la eliminacion";
            }

            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }


    public function getIndicadoresWeb()
    {
        if (true) {
            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $request->data = [];
            $fecha = date('Y-m-d H:i:s');

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];

            $initTime = date('Y-m-01');
            $endTime =  date('Y-m-t');
            $where = " AND fecha_creacion >= '$initTime' AND fecha_creacion <= '$endTime'";

            if ($query = $this->servicio_model->getIndicadores($where)) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->servicios_activos = $res->servicios_activos;
                    $row->servicios_pendientes = $res->servicios_pendientes;
                    $row->servicios_totales = $res->servicios_totales;
                    array_push($response->data, $row);
                }
            }
            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function getIndicadorMarcaRecurrente()
    {
        if (true) {
            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $request->data = [];
            $fecha = date('Y-m-d H:i:s');

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];

            $initTime = date('Y-m-01');
            $endTime =  date('Y-m-t');
            $where = " AND s.fecha_creacion >= '$initTime' AND fecha_creacion <= '$endTime'";
            if ($query = $this->servicio_model->getIndicadorMarcaRecurrente($where)) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->marca_recurrente = $res->nombre_marca_recurrente;
                    array_push($response->data, $row);
                }
            }
            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function getIndicadorClienteNuevo()
    {
        if (true) {
            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $request->data = [];
            $fecha = date('Y-m-d H:i:s');

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];



            $initTime = date('Y-m-01');
            $endTime =  date('Y-m-t');

            $init = strtotime($initTime);
            $end = strtotime($endTime);


            if ($query = $this->servicio_model->getIndicadorClientenuevo($init, $end)) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->clientes_nuevos = $res->clientes_nuevos;
                    array_push($response->data, $row);
                }
            }
            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }
}
