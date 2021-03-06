<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hora_agenda extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('hora_agenda_model');
        $this->load->library(['ion_auth', 'form_validation']);

        date_default_timezone_set('America/Santiago');
    }

    public function index()
    {
        if (true) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } else {

            $data['datalibrary'] = array(
                'titulo' => "Hora_agenda",
                'vista' => array('index', 'modals'),
                'libjs' => array('libjs'),
                'active' => 'hora_agenda'
            );
            $this->load->view('estructura/body', $data);
        }
    }
    public function getHoraAgendaById()
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

            if ($this->input->post('id_hora_agenda')) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_hora_agenda', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            $request->id ? $where = " AND id_hora_agenda=$request->id" : $where = '';


            if (sizeof($response->errores) == 0) {
                if ($query = $this->hora_agenda_model->getHoraAgenda($where)) {
                    foreach ($query->result() as $res) {
                        $row = null;
                        $row = new stdClass();
                        $row->id_hora_agenda = $res->id_hora_agenda;
                        $row->id_servicio = $res->id_servicio;
                        $row->tipo_servicio = $res->tipo_servicio;
                        $row->nombre_tipo_servicio = $res->nombre_tipo_servicio;
                        $row->nombre = $res->nombre;
                        $row->observacion = $res->observacion;
                        $row->detalle = $res->detalle;
                        $row->fecha_agenda = $res->fecha_agenda;
                        $row->agenda_inicio = $res->agenda_inicio;
                        $row->agenda_fin = $res->agenda_fin;
                        $row->fecha_entrada = $res->fecha_entrada;
                        $row->fecha_salida = $res->fecha_salida;
                        $row->id_tecnico = $res->id_tecnico;
                        $row->nombre_tecnico = $res->nombre_tecnico;
                        $row->id_cliente = $res->id_cliente;
                        $row->nombre_cliente = $res->nombre_cliente;
                        $row->id_supervisor = $res->id_supervisor;
                        $row->nombre_supervisor = $res->nombre_supervisor;
                        $row->estado_solicitud = $res->estado_solicitud;
                        $row->id_vehiculo = $res->id_vehiculo;
                        $row->marca = $res->marca;
                        $row->modelo = $res->modelo;
                        $row->version = $res->version;
                        $row->fecha_creacion = $res->fecha_creacion;

                        array_push($response->data, $row);
                    }
                }
            }

            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }
    public function getHoraAgenda()
    {
        if (true) {
            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $request->data = [];

			      $fecha = date('Y-m-d H:i:s');
            $where = "";
            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];

            if (!empty($this->input->post('fecha_inicio'))) {
                if ($this->input->post('fecha_inicio') != 'null') {
                    $request->fecha_inicio = $this->security->xss_clean($this->input->post('fecha_inicio'));
                    $where .= " AND ha.fecha_entrada >= '$request->fecha_inicio'";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener fecha_inicio";
            }

            if (!empty($this->input->post('fecha_fin'))) {
                if ($this->input->post('fecha_fin') != 'null') {
                    $request->fecha_fin = $this->security->xss_clean($this->input->post('fecha_fin'));
                    $where .= " AND ha.fecha_salida <= '$request->fecha_fin'";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener fecha_fin";
            }

            if (!empty($this->input->post('fecha_agenda'))) {
                if ($this->input->post('fecha_agenda') != 'null') {
                    $request->fecha_agenda = $this->security->xss_clean($this->input->post('fecha_agenda'));
                    $where .= " AND ha.fecha_agenda <= '$request->fecha_agenda'";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener fecha agenda";
            }

            if (!empty($this->input->post('tecnico'))) {
                if ($this->input->post('tecnico') != 'null') {
                    $request->tecnico = $this->security->xss_clean($this->input->post('tecnico'));
                    $where .= " AND ha.id_tecnico = $request->tecnico";
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
                    $where .= " AND ha.estado_solicitud = $request->estado";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener estado";
            }


            if ($query = $this->hora_agenda_model->getHoraAgenda($where)) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->id_hora_agenda = $res->id_hora_agenda;
                    $row->id_servicio = $res->id_servicio;
                    $row->tipo_servicio = $res->tipo_servicio;
                    $row->nombre_tipo_servicio = $res->nombre_tipo_servicio;
                    $row->nombre = $res->nombre;
                    $row->observacion = $res->observacion;
                    $row->fecha_agenda = $res->fecha_agenda;
                    $row->agenda_inicio = $res->agenda_inicio;
                    $row->agenda_fin = $res->agenda_fin;
                    $row->fecha_entrada = $res->fecha_entrada;
                    $row->fecha_salida = $res->fecha_salida;
                    $row->id_tecnico = $res->id_tecnico;
                    $row->nombre_tecnico = $res->nombre_tecnico;
                    $row->id_cliente = $res->id_cliente;
                    $row->nombre_cliente = $res->nombre_cliente;
                    $row->id_supervisor = $res->id_supervisor;
                    $row->nombre_supervisor = $res->nombre_supervisor;
                    $row->estado_solicitud = $res->estado_solicitud;
                    $row->id_vehiculo = $res->id_vehiculo;
                    $row->marca = $res->marca;
                    $row->modelo = $res->modelo;
                    $row->version = $res->version;

                    $row->fecha_creacion = $res->fecha_creacion;

                    array_push($response->data, $row);
                }
            }
            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function getHoraAgendaDia()
    {
        if (true) {
            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $request->data = [];
            $where='';
			      $fecha = date('Y-m-d');

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];

            // $where = " AND fecha_agenda= '$fecha'";

            if ($query = $this->hora_agenda_model->getServiciosDia($where)) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->id_servicio = $res->id_servicio;
                    $row->tipo_servicio = $res->tipo_servicio;
                    $row->nombre = $res->nombre;
                    $row->observacion = $res->observacion;
                    $row->fecha_agenda = $res->fecha_agenda;
                    $row->agenda_inicio = $res->agenda_inicio;
                    $row->agenda_fin = $res->agenda_fin;
                    $row->fecha_entrada = $res->fecha_entrada;
                    $row->fecha_salida = $res->fecha_salida;
                    $row->id_tecnico = $res->id_tecnico;
                    $row->id_cliente = $res->id_cliente;
                    $row->nombre_cliente = $res->nombre_cliente;
                    $row->marca = $res->marca;
                    $row->modelo = $res->modelo;
                    $row->version = $res->version;
                    $row->id_vehiculo = $res->id_vehiculo;
                    $row->estado_servicio = $res->estado_servicio;


                    $row->fecha_creacion = $res->fecha_creacion;

                    array_push($response->data, $row);
                }
            }
            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }


    public function getHorasDisponibles($fecha)
    {
        if (true) {
            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $request->data = [];
            $where = '';


            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];

            if (empty($fecha) || $fecha == null || $fecha == '') {
                $response->errores[] = "Ocurrió un problema al obtener la fecha";
            }

            if (sizeof($response->errores) == 0) {
              $hora8  = 0;
              $hora9  = 0;
              $hora10 = 0;
              $hora11 = 0;
              $hora12 = 0;
              $hora13 = 0;
              $hora14 = 0;
              $hora15 = 0;
              $hora16 = 0;
              $hora17 = 0;

              $this->hora_agenda_model->getHorasDisponibles( " AND agenda_inicio='".$fecha . ' '."08:00:00"."'") ? array_push($response->data, $hora8=1) : array_push($response->data, $hora8);
              $this->hora_agenda_model->getHorasDisponibles( " AND agenda_inicio='".$fecha . ' '."09:00:00"."'") ? array_push($response->data, $hora9=1) : array_push($response->data, $hora9);
              $this->hora_agenda_model->getHorasDisponibles( " AND agenda_inicio='".$fecha . ' '."10:00:00"."'") ? array_push($response->data, $hora10=1) : array_push($response->data, $hora10);
              $this->hora_agenda_model->getHorasDisponibles( " AND agenda_inicio='".$fecha . ' '."11:00:00"."'") ? array_push($response->data, $hora11=1) : array_push($response->data, $hora11);
              $this->hora_agenda_model->getHorasDisponibles( " AND agenda_inicio='".$fecha . ' '."12:00:00"."'") ? array_push($response->data, $hora12=1) : array_push($response->data, $hora12);
              $this->hora_agenda_model->getHorasDisponibles( " AND agenda_inicio='".$fecha . ' '."13:00:00"."'") ? array_push($response->data, $hora13=1) : array_push($response->data, $hora13);
              $this->hora_agenda_model->getHorasDisponibles( " AND agenda_inicio='".$fecha . ' '."14:00:00"."'") ? array_push($response->data, $hora14=1) : array_push($response->data, $hora14);
              $this->hora_agenda_model->getHorasDisponibles( " AND agenda_inicio='".$fecha . ' '."15:00:00"."'") ? array_push($response->data, $hora15=1) : array_push($response->data, $hora15);
              $this->hora_agenda_model->getHorasDisponibles( " AND agenda_inicio='".$fecha . ' '."16:00:00"."'") ? array_push($response->data, $hora16=1) : array_push($response->data, $hora16);
              $this->hora_agenda_model->getHorasDisponibles( " AND agenda_inicio='".$fecha . ' '."17:00:00"."'") ? array_push($response->data, $hora17=1) : array_push($response->data, $hora17);

            }



            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function insertHoraAgenda()
    {
        if (true) {

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $request->data = [];
            $request->id_servicio = null;
            $request->tipo_servicio = null;
            $request->nombre  = null;
            $request->observacion = null;
            $request->fecha_agenda  = null;
            $request->agenda_inicio = null;
            $request->agenda_fin  = null;
            $request->fecha_entrada = null;
            $request->fecha_salida  = null;
            $request->id_usuario_tecnico  = null;
            $request->id_cliente  = null;
            $request->id_vehiculo = null;
            $request->id_usuario_cargo  = null;

            $fecha = date('Y-m-d H:i:s');

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];





            //VERIFICAMOS LAS VARIABLES QUE RECIBIMOS PARA EDITAR.
            if (!empty($this->input->post('id_servicio'))) {
                $request->id_servicio = trim($this->security->xss_clean($this->input->post('id_servicio', true)));
            }

            if (!empty($this->input->post('tipo_servicio'))) {
                $request->tipo_servicio = trim($this->security->xss_clean($this->input->post('tipo_servicio', true)));
            }

            if (!empty($this->input->post('nombre'))) {
                $request->nombre = trim($this->security->xss_clean($this->input->post('nombre', true)));
            }

            if (!empty($this->input->post('observacion'))) {
                $request->observacion = trim($this->security->xss_clean($this->input->post('observacion', true)));
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

            if (!empty($this->input->post('fecha_entrada'))) {
                $request->fecha_entrada = trim($this->security->xss_clean($this->input->post('fecha_entrada', true)));
            }

            if (!empty($this->input->post('fecha_salida'))) {
                $request->fecha_salida = trim($this->security->xss_clean($this->input->post('fecha_salida', true)));
            }

            if (!empty($this->input->post('id_usuario_tecnico'))) {
                $request->id_usuario_tecnico = trim($this->security->xss_clean($this->input->post('id_usuario_tecnico', true)));
            }

            if (!empty($this->input->post('id_cliente'))) {
                $request->id_cliente = trim($this->security->xss_clean($this->input->post('id_cliente', true)));
            }

            if (!empty($this->input->post('id_vehiculo'))) {
                $request->id_vehiculo = trim($this->security->xss_clean($this->input->post('id_vehiculo', true)));
            }

            if (!empty($this->input->post('id_usuario_cargo'))) {
                $request->id_usuario_cargo = trim($this->security->xss_clean($this->input->post('id_usuario_cargo', true)));
            }

            //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
            $datos = array(
                'id_servicio' => $request->id_servicio,
                'tipo_servicio' => $request->tipo_servicio,
                'estado_solicitud' => 3,
                'nombre' => $request->nombre,
                'observacion' => $request->observacion,
                'fecha_agenda' => $request->fecha_agenda,
                'agenda_inicio' => $request->agenda_inicio,
                'agenda_fin' => $request->agenda_fin,
                'fecha_entrada' => $request->fecha_entrada,
                'fecha_salida' => $request->fecha_salida,
                'id_usuario_tecnico' => 1,
                'id_cliente' => $request->id_cliente,
                'id_vehiculo' => $request->id_vehiculo,
                'id_usuario_cargo' => 1,
                'fecha_creacion' => $fecha,
                'estado' => 1

            );

            //INSERCION, ACTUALIZACION U OPERACIONES
            if ($query = $this->hora_agenda_model->insertHoraAgenda('hora_agenda', $datos)) {
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
    public function updateHoraAgenda()
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
            if ($this->input->post('id_hora_agenda')) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_hora_agenda', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            if (sizeof($response->errores) == 0) {
                //VERIFICAMOS LAS VARIABLES QUE RECIBIMOS PARA EDITAR.
                if (!empty($this->input->post('id_servicio'))) {
                    $request->id_servicio = trim($this->security->xss_clean($this->input->post('id_servicio', true)));
                }

                if (!empty($this->input->post('tipo_servicio'))) {
                    $request->tipo_servicio = trim($this->security->xss_clean($this->input->post('tipo_servicio', true)));
                }

                if (!empty($this->input->post('nombre'))) {
                    $request->nombre = trim($this->security->xss_clean($this->input->post('nombre', true)));
                }

                if (!empty($this->input->post('observacion'))) {
                    $request->observacion = trim($this->security->xss_clean($this->input->post('observacion', true)));
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

                if (!empty($this->input->post('fecha_entrada'))) {
                    $request->fecha_entrada = trim($this->security->xss_clean($this->input->post('fecha_entrada', true)));
                }

                if (!empty($this->input->post('fecha_salida'))) {
                    $request->fecha_salida = trim($this->security->xss_clean($this->input->post('fecha_salida', true)));
                }

                if (!empty($this->input->post('id_usuario_tecnico'))) {
                    $request->id_usuario_tecnico = trim($this->security->xss_clean($this->input->post('id_usuario_tecnico', true)));
                }

                if (!empty($this->input->post('id_cliente'))) {
                    $request->id_cliente = trim($this->security->xss_clean($this->input->post('id_cliente', true)));
                }

                if (!empty($this->input->post('id_vehiculo'))) {
                    $request->id_vehiculo = trim($this->security->xss_clean($this->input->post('id_vehiculo', true)));
                }

                if (!empty($this->input->post('id_usuario_cargo'))) {
                    $request->id_usuario_cargo = trim($this->security->xss_clean($this->input->post('id_usuario_cargo', true)));
                }


                //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
                $datos = array(
                    'id_servicio' => $request->id_servicio,
                    'tipo_servicio' => $request->tipo_servicio,
                    'estado_solicitud' => $request->estado_solicitud,
                    'nombre' => $request->nombre,
                    'observacion' => $request->observacion,
                    'fecha_agenda' => $request->fecha_agenda,
                    'agenda_inicio' => $request->agenda_inicio,
                    'agenda_fin' => $request->agenda_fin,
                    'fecha_entrada' => $request->fecha_entrada,
                    'fecha_salida' => $request->fecha_salida,
                    'id_usuario_tecnico' => 1,
                    'id_cliente' => $request->id_cliente,
                    'id_vehiculo' => $request->id_vehiculo,
                    'id_usuario_cargo' => 1,
                    'fecha_creacion' => $fecha,
                    'estado' => 1

                );
            }

            $where = " AND id_hora_agenda=$request->id";
            $itemActualizado = $this->hora_agenda_model->getHoraAgenda($where);
            $response->data = $itemActualizado->result();

            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($query = $this->hora_agenda_model->updateHoraAgenda('hora_agenda', 'id_hora_agenda', $datos, $request->id)) {
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
    public function deleteHoraAgenda()
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
            if (is_numeric($this->input->post('id_hora_agenda'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_hora_agenda', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }
            $where = " AND id_hora_agenda=$request->id";
            $itemEliminado = $this->hora_agenda_model->getHoraAgenda($where);
            $response->data = $itemEliminado->result();
            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($this->hora_agenda_model->updateHoraAgenda("hora_agenda", "id_hora_agenda", array('fecha_baja' => $fecha, "estado" => 0), $request->id)) {
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



    public function processHoraAgenda()
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
            if ($this->input->post('id_hora_agenda')) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_hora_agenda', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            if (sizeof($response->errores) == 0) {
                //VERIFICAMOS LAS VARIABLES QUE RECIBIMOS PARA EDITAR.


                if (!empty($this->input->post('estado_solicitud'))) {
                    $request->estado_solicitud = trim($this->security->xss_clean($this->input->post('estado_solicitud', true)));
                }


                //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
                $datos = array(
                    'estado_solicitud' => $request->estado_solicitud,
                    'fecha_modificacion' => $fecha,


                );
            }

            $where = " AND id_hora_agenda=$request->id";
            $itemActualizado = $this->hora_agenda_model->getHoraAgenda($where);
            $response->data = $itemActualizado->result();

            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($query = $this->hora_agenda_model->updateHoraAgenda('hora_agenda', 'id_hora_agenda', $datos, $request->id)) {
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

}
