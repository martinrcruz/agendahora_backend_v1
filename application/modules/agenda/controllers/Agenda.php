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


    public function getHorasAgenda()
    {
        $response = new stdClass();
        $response->data = [];

        if ($query = $this->agenda_model->getHorasAgenda()) {
            foreach ($query->result() as $res) {
                $row = null;
                $row = new stdClass();
                $row->id_hora_agenda = $res->id_hora_agenda;
                $row->id_servicio = $res->id_servicio;
                $row->nombre = $res->nombre;
                $row->descripcion = $res->descripcion;
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
    }


    public function getHorasAgendaById($id = '')
    {
        $response = new stdClass();
        $response->data = [];
        $where = '';

        $id ? $where = " AND id_hora_agenda=$id" : $where = '';
        // if($id){
        //     $where = " AND id_hora_agenda=$id";
        // }

        if ($query = $this->agenda_model->getHorasAgenda($where)) {
            foreach ($query->result() as $res) {
                $row = null;
                $row = new stdClass();
                $row->id_hora_agenda = $res->id_hora_agenda;
                $row->id_servicio = $res->id_servicio;
                $row->nombre = $res->nombre;
                $row->descripcion = $res->descripcion;
                $row->fecha_entrada = $res->fecha_entrada;
                $row->fecha_salida = $res->fecha_salida;
                $row->id_usuario_tecnico = $res->id_usuario_tecnico;
                $row->id_cliente = $res->id_cliente;
                $row->id_vehiculo = $res->id_vehiculo;
                $row->id_usuario_cargo = $res->id_usuario_cargo;

                array_push($response->data, $row);
            }
        }
        echo json_encode($response);
    }

    public function insertHoraAgenda()
    {
        //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS
        $response = new stdClass();
        $response->id = null;
        $response->data = [];
        $response->proceso = 0;
        $response->errores = [];
        $id_agenda_hora = '';// REPRESENTA EL IDENTIFICADOR DE HORA_AGENDA
        $datos = [];

        //LOGICA DE NEGOCIO Y REQUEST/RESPONSE DE API
        $datos = array(
            'id_servicio' => 1,
            'nombre' => 'Mantencion numero 2',
            'descripcion' => 'Mantencion preventiva Toyota corolla',
            'fecha_entrada' => '2022-06-01',
            'fecha_salida' => '2022-06-04',
            'id_usuario_tecnico' => 1,
            'id_cliente' => 1,
            'id_vehiculo' => 1,
            'id_usuario_cargo' => 1,
            'fecha_creacion' => date('Y-m-d H:s'),
            'estado' => 1,
        );

        //INSERCION, ACTUALIZACION U OPERACIONES
        if ($id_agenda_hora) {
            if ($query = $this->agenda_model->updateAgendaHora('hora_agenda', 'id_hora_agenda', $datos, $id_agenda_hora)) {
                $response->proceso = 1;
                $response->id = $query;
                $response->data = $datos;
            }
        } else {
            if ($query = $this->agenda_model->insertHoraAgenda('hora_agenda', $datos)) {
                $response->proceso = 1;
                $response->id = $query;
                $response->data = $datos;
            }
        }
        print_r($response);
    }
}
