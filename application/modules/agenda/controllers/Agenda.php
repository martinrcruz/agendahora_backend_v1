<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Agenda extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('agenda_model');
        $this->load->library(['ion_auth', 'form_validation']);
        date_default_timezone_set('America/Santiago');
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } else {

            $data['datalibrary'] = array(
                'titulo' => "Agenda",
                'vista' => array('index', 'modals'),
                'libjs' => array('libjs'),
                'active' => 'agenda'
            );
            $this->load->view('estructura/body', $data);
        }
    }



    public function getHoraAgenda()
    {

        //CHEQUEAMOS PERMISOS DE USUARIO (SESION)
        // if ($this->ion_auth->check_permission()) {
        //     echo 'true';
        // } else {
        //     echo 'false';
        // }


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
            $response->userData = [];


            if ($query = $this->agenda_model->getHoraAgendaTabla()) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->id_hora_agenda = $res->id_hora_agenda;
                    $row->id_servicio = $res->id_servicio;
                    $row->nombre = $res->nombre;
                    $row->observacion = $res->observacion;
                    $row->agenda_inicio = $res->agenda_inicio;
                    $row->agenda_fin = $res->agenda_fin;
                    $row->fecha_entrada = $res->fecha_entrada;
                    $row->fecha_salida = $res->fecha_salida;
                    $row->id_usuario_tecnico = $res->id_usuario_tecnico;
                    $row->id_cliente = $res->id_cliente;
                    $row->id_vehiculo = $res->id_vehiculo;
                    $row->id_usuario_cargo = $res->id_usuario_cargo;
                    $row->fecha_creacion = $res->fecha_creacion;

                    array_push($response->data, $row);
                }
            }
            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
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

            if (is_numeric($this->input->post('id_hora_agenda'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_hora_agenda', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            $request->id ? $where = " AND id_hora_agenda=$request->id" : $where = '';


            if (sizeof($response->errores) == 0) {
                if ($query = $this->agenda_model->getHoraAgenda($where)) {
                    foreach ($query->result() as $res) {
                        $row = null;
                        $row = new stdClass();
                        $row->id_hora_agenda = $res->id_hora_agenda;
                        $row->id_servicio = $res->id_servicio;
                        $row->nombre = $res->nombre;
                        $row->observacion = $res->observacion;
                        $row->fecha_entrada = $res->fecha_entrada;
                        $row->fecha_salida = $res->fecha_salida;
                        $row->id_usuario_tecnico = $res->id_usuario_tecnico;
                        $row->id_cliente = $res->id_cliente;
                        $row->id_vehiculo = $res->id_vehiculo;
                        $row->id_usuario_cargo = $res->id_usuario_cargo;

                        array_push($response->data, $row);
                    }
                }
            }

            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }





    public function getHoraAgendaTabla()
    {

        //CHEQUEAMOS PERMISOS DE USUARIO (SESION)
        // if ($this->ion_auth->check_permission()) {
        //     echo 'true';
        // } else {
        //     echo 'false';
        // }


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
            $response->userData = [];


            if ($query = $this->agenda_model->getHoraAgendaTabla()) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->id_hora_agenda = $res->id_hora_agenda;
                    $row->id_servicio = $res->id_servicio;
                    $row->nombre = $res->nombre;
                    $row->observacion = $res->observacion;
                    $row->fecha_agenda = $res->fecha_agenda;
                    $row->agenda_inicio = $res->agenda_inicio;
                    $row->agenda_fin = $res->agenda_fin;
                    $row->id_tecnico = $res->id_tecnico;
                    $row->id_cliente = $res->id_cliente;
                    $row->id_vehiculo = $res->id_vehiculo;
                    $row->marca = $res->marca;
                    $row->modelo = $res->modelo;
                    $row->version = $res->version;
                    // $row->id_usuario_cargo = $res->id_usuario_cargo;
                    $row->fecha_creacion = $res->fecha_creacion;

                    array_push($response->data, $row);
                }
            }
            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }


    public function getHoraAgendaTablaById()
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

            if (is_numeric($this->input->post('id_hora_agenda'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_hora_agenda', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            $request->id ? $where = " AND id_hora_agenda=$request->id" : $where = '';


            if (sizeof($response->errores) == 0) {
                if ($query = $this->agenda_model->getHoraAgendaTabla($where)) {
                    foreach ($query->result() as $res) {
                        $row = null;
                        $row = new stdClass();
                        $row->id_hora_agenda = $res->id_hora_agenda;
                        $row->id_servicio = $res->id_servicio;
                        $row->nombre = $res->nombre;
                        $row->observacion = $res->observacion;
                        $row->fecha_entrada = $res->fecha_entrada;
                        $row->fecha_salida = $res->fecha_salida;
                        $row->id_usuario_tecnico = $res->id_usuario_tecnico;
                        $row->id_cliente = $res->id_cliente;
                        $row->id_vehiculo = $res->id_vehiculo;
                        $row->id_usuario_cargo = $res->id_usuario_cargo;

                        array_push($response->data, $row);
                    }
                }
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

            $fecha = date('Y-m-d H:i:s');

            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];



            /**** CUANDO NO RECIBAMOS UN ID COMO FOREIGN KEY, DEBEMOS ASIGNARLE UN ERROR AL PROCESO,
        PARA QUE NO HAGA LA INSERCION, DEBIDO A QUE EN LA BASE DE DATOS, ESTOS CAMPOS SON NOT NULL ****/

            //VERIFICAMOS LAS VARIABLES QUE RECIBIMOS PARA EDITAR.
            if (!empty($this->input->post('id_servicio'))) {
                $request->id_servicio = trim($this->security->xss_clean($this->input->post('id_servicio', true)));
            } else {
                $response->errores[] = "Ocurrió un problema al obtener el id_servicio";
            }

            if (!empty($this->input->post('nombre'))) {
                $request->nombre = trim($this->security->xss_clean($this->input->post('nombre', true)));
            }

            if (!empty($this->input->post('observacion'))) {
                $request->observacion = trim($this->security->xss_clean($this->input->post('observacion', true)));
            }

            if (!empty($this->input->post('fecha_entrada'))) {
                $request->fecha_entrada = trim($this->security->xss_clean($this->input->post('fecha_entrada', true)));
            }

            if (!empty($this->input->post('fecha_salida'))) {
                $request->fecha_salida = trim($this->security->xss_clean($this->input->post('fecha_salida', true)));
            }

            if (!empty($this->input->post('id_usuario_tecnico'))) {
                $request->id_usuario_tecnico = trim($this->security->xss_clean($this->input->post('id_usuario_tecnico', true)));
            } else {
                $response->errores[] = "Ocurrió un problema al obtener el id_usuario_tecnico";
            }

            if (!empty($this->input->post('id_cliente'))) {
                $request->id_cliente = trim($this->security->xss_clean($this->input->post('id_cliente', true)));
            } else {
                $response->errores[] = "Ocurrió un problema al obtener el id_cliente";
            }

            if (!empty($this->input->post('id_vehiculo'))) {
                $request->id_vehiculo = trim($this->security->xss_clean($this->input->post('id_vehiculo', true)));
            } else {
                $response->errores[] = "Ocurrió un problema al obtener el id_vehiculo";
            }

            if (!empty($this->input->post('id_usuario_cargo'))) {
                $request->id_usuario_cargo = trim($this->security->xss_clean($this->input->post('id_usuario_cargo', true)));
            } else {
                $response->errores[] = "Ocurrió un problema al obtener el id_usuario_cargo";
            }

            //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
            $datos = array(
                'id_servicio' => $request->id_servicio,
                'nombre' => $request->nombre,
                'observacion' => $request->observacion,
                'fecha_entrada' => $request->fecha_entrada,
                'fecha_salida' => $request->fecha_salida,
                'id_usuario_tecnico' => $request->id_usuario_tecnico,
                'id_cliente' => $request->id_cliente,
                'id_vehiculo' => $request->id_vehiculo,
                'id_usuario_cargo' => $request->id_usuario_cargo,
                'fecha_creacion' => $fecha,
                'estado' => 1

            );

            //INSERCION, ACTUALIZACION U OPERACIONES
            if ($query = $this->agenda_model->insertHoraAgenda('hora_agenda', $datos)) {
                $response->proceso = 1;
                $response->id = $query;
                $response->data = $datos;
            } else {
                $response->errores[] = "El dato no pudo ser ingresado";
            }

            print_r($response);
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
                if (!empty($this->input->post('nombre'))) {
                    $request->nombre = trim($this->security->xss_clean($this->input->post('nombre', true)));
                }
                if (!empty($this->input->post('observacion'))) {
                    $request->observacion = trim($this->security->xss_clean($this->input->post('observacion', true)));
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
                    'nombre' => $request->nombre,
                    'observacion' => $request->observacion,
                    'fecha_entrada' => $request->fecha_entrada,
                    'fecha_salida' => $request->fecha_salida,
                    'id_usuario_tecnico' => $request->id_usuario_tecnico,
                    'id_cliente' => $request->id_cliente,
                    'id_vehiculo' => $request->id_vehiculo,
                    'id_usuario_cargo' => $request->id_usuario_cargo,
                    'fecha_modificacion' => $fecha

                );
            }


            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($query = $this->agenda_model->updateHoraAgenda('hora_agenda', 'id_hora_agenda', $datos, $request->id)) {
                    //SI EL PROCESO ES EXITOSO, DEVOLVERA UN VALOR DENTRO DEL ARRAY DE RESPUESTA IGUAL A 1
                    $response->proceso = 1;
                    $response->id = $query;
                    $response->data = $datos;
                }
            } else {
                $response->errores[] = "Ocurrió un problema al procesar la edicion";
            }

            print_r($response);
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

            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($this->agenda_model->updateHoraAgenda("hora_agenda", "id_hora_agenda", array('fecha_baja' => $fecha, "estado" => 0), $request->id)) {
                    //SI EL PROCESO ES EXITOSO, DEVOLVERA UN VALOR DENTRO DEL ARRAY DE RESPUESTA IGUAL A 1
                    $response->proceso = 1;
                }
            } else {
                $response->errores[] = "Ocurrió un problema al procesar la eliminacion";
            }

            print_r($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }
}
