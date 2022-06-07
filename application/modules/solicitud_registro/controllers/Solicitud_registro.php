<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Solicitud_registro extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('solicitud_registro_model');
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
                'titulo' => "Solicitud_registro",
                'vista' => array('index', 'modals'),
                'libjs' => array('libjs'),
                'active' => 'solicitud_registro'
            );
            $this->load->view('estructura/body', $data);
        }
    }
    public function getSolicitudRegistroById()
    {
        if ($this->ion_auth->logged_in()) {

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

            if (is_numeric($this->input->post('id_solicitud_registro'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_solicitud_registro', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            $request->id ? $where = " AND id_solicitud_registro=$request->id" : $where = '';


            if (sizeof($response->errores) == 0) {
                if ($query = $this->solicitud_registro_model->getSolicitudRegistro($where)) {
                    foreach ($query->result() as $res) {
                        $row = null;
                        $row = new stdClass();
                        $row->id_solicitud_registro = $res->id_solicitud_registro;
                        $row->nombre = $res->nombre;
                        $row->correo = $res->correo;
                        $row->apellidop = $res->apellidop;
                        $row->apellidom = $res->apellidom;
                        $row->rut = $res->rut;
                        $row->numero_contacto = $res->numero_contacto;
                        $row->direccion = $res->direccion;
                        $row->sucursal = $res->sucursal;
                        $row->nombre_usuario = $res->nombre_usuario;
                        $row->contrasena = $res->contrasena;
                        $row->id_usuario_gestor = $res->id_usuario_gestor;
                        $row->fecha_creacion = $res->fecha_creacion;
                        $row->fecha_modificacion = $res->fecha_modificacion;
                        $row->fecha_baja = $res->fecha_baja;
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
    public function getSolicitudRegistro()
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

            if ($query = $this->solicitud_registro_model->getSolicitudRegistro()) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->id_solicitud_registro = $res->id_solicitud_registro;
                    $row->nombre = $res->nombre;
                    $row->correo = $res->correo;
                    $row->apellidop = $res->apellidop;
                    $row->apellidom = $res->apellidom;
                    $row->rut = $res->rut;
                    $row->numero_contacto = $res->numero_contacto;
                    $row->direccion = $res->direccion;
                    $row->sucursal = $res->sucursal;
                    $row->nombre_usuario = $res->nombre_usuario;
                    $row->contrasena = $res->contrasena;
                    $row->id_usuario_gestor = $res->id_usuario_gestor;
                    $row->fecha_creacion = $res->fecha_creacion;
                    $row->fecha_modificacion = $res->fecha_modificacion;
                    $row->fecha_baja = $res->fecha_baja;
                    $row->estado = $res->estado;

                    array_push($response->data, $row);
                }
            }
            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function insertSolicitudRegistro()
    {
        if ($this->ion_auth->logged_in()) {

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



            /** CUANDO NO RECIBAMOS UN ID COMO FOREIGN KEY, DEBEMOS ASIGNARLE UN ERROR AL PROCESO, 
        PARA QUE NO HAGA LA INSERCION, DEBIDO A QUE EN LA BASE DE DATOS, ESTOS CAMPOS SON NOT NULL **/

            //VERIFICAMOS LAS VARIABLES QUE RECIBIMOS PARA EDITAR.

            if (!empty($this->input->post('nombre'))) {
                $request->nombre = trim($this->security->xss_clean($this->input->post('nombre', true)));
            }
            if (!empty($this->input->post('correo'))) {
                $request->correo = trim($this->security->xss_clean($this->input->post('correo', true)));
            }
            if (!empty($this->input->post('apellidop'))) {
                $request->apellidop = trim($this->security->xss_clean($this->input->post('apellidop', true)));
            }
            if (!empty($this->input->post('apellidom'))) {
                $request->apellidom = trim($this->security->xss_clean($this->input->post('apellidom', true)));
            }
            if (!empty($this->input->post('rut'))) {
                $request->rut = trim($this->security->xss_clean($this->input->post('rut', true)));
            } 
            if (!empty($this->input->post('numero_contacto'))) {
                $request->numero_contacto = trim($this->security->xss_clean($this->input->post('numero_contacto', true)));
            } 
            if (!empty($this->input->post('direccion'))) {
                $request->direccion = trim($this->security->xss_clean($this->input->post('direccion', true)));
            } 
            if (!empty($this->input->post('sucursal'))) {
                $request->sucursal = trim($this->security->xss_clean($this->input->post('sucursal', true)));
            } 
            if (!empty($this->input->post('nombre_usuario'))) {
                $request->nombre_usuario = trim($this->security->xss_clean($this->input->post('nombre_usuario', true)));
            } 
            if (!empty($this->input->post('contrasena'))) {
                $request->contrasena = trim($this->security->xss_clean($this->input->post('contrasena', true)));
            } 
            if (!empty($this->input->post('id_usuario_gestor'))) {
                $request->id_usuario_gestor = trim($this->security->xss_clean($this->input->post('id_usuario_gestor', true)));
            } else {
                $response->errores[] = "Ocurrió un problema al obtener el id_usuario_gestor";
            }

            //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
            $datos = array(
                    'nombre' => $request->nombre,
                    'correo' => $request->correo,
                    'apellidop' => $request->apellidop,
                    'apellidom' => $request->apellidom,
                    'rut' => $request->rut,
                    'numero_contacto' => $request->numero_contacto,
                    'direccion' => $request->direccion,
                    'sucursal' => $request->sucursal,
                    'nombre_usuario' => $request->nombre_usuario,
                    'contrasena' => $request->contrasena,
                    'id_usuario_gestor' => $request->id_usuario_gestor,
                    'fecha_creacion' => $fecha,
                    'estado' => 1
            );

            //INSERCION, ACTUALIZACION U OPERACIONES
            if ($query = $this->solicitud_registro_model->insertSolicitudRegistro('solicitud_registro', $datos)) {
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
    public function updateSolicitudRegistro()
    {
        if ($this->ion_auth->logged_in()) {

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
            if ($this->input->post('id_solicitud_registro')) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_solicitud_registro', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            if (sizeof($response->errores) == 0) {
                //VERIFICAMOS LAS VARIABLES QUE RECIBIMOS PARA EDITAR.

                if (!empty($this->input->post('nombre'))) {
                    $request->nombre = trim($this->security->xss_clean($this->input->post('nombre', true)));
                }
                if (!empty($this->input->post('correo'))) {
                    $request->correo = trim($this->security->xss_clean($this->input->post('correo', true)));
                }
                if (!empty($this->input->post('apellidop'))) {
                    $request->apellidop = trim($this->security->xss_clean($this->input->post('apellidop', true)));
                }
                if (!empty($this->input->post('apellidom'))) {
                    $request->apellidom = trim($this->security->xss_clean($this->input->post('apellidom', true)));
                }
                if (!empty($this->input->post('rut'))) {
                    $request->rut = trim($this->security->xss_clean($this->input->post('rut', true)));
                } 
                if (!empty($this->input->post('numero_contacto'))) {
                    $request->numero_contacto = trim($this->security->xss_clean($this->input->post('numero_contacto', true)));
                } 
                if (!empty($this->input->post('direccion'))) {
                    $request->direccion = trim($this->security->xss_clean($this->input->post('direccion', true)));
                } 
                if (!empty($this->input->post('sucursal'))) {
                    $request->sucursal = trim($this->security->xss_clean($this->input->post('sucursal', true)));
                } 
                if (!empty($this->input->post('nombre_usuario'))) {
                    $request->nombre_usuario = trim($this->security->xss_clean($this->input->post('nombre_usuario', true)));
                } 
                if (!empty($this->input->post('contrasena'))) {
                    $request->contrasena = trim($this->security->xss_clean($this->input->post('contrasena', true)));
                } 
                if (!empty($this->input->post('id_usuario_gestor'))) {
                    $request->id_usuario_gestor = trim($this->security->xss_clean($this->input->post('id_usuario_gestor', true)));
                } 

                //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
                $datos = array(
                    'nombre' => $request->nombre,
                    'correo' => $request->correo,
                    'apellidop' => $request->apellidop,
                    'apellidom' => $request->apellidom,
                    'rut' => $request->rut,
                    'numero_contacto' => $request->numero_contacto,
                    'direccion' => $request->direccion,
                    'sucursal' => $request->sucursal,
                    'nombre_usuario' => $request->nombre_usuario,
                    'contrasena' => $request->contrasena,
                    'id_usuario_gestor' => $request->id_usuario_gestor,
                    'fecha_modificacion' => $fecha

                );
            }


            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($query = $this->solicitud_registro_model->updateSolicitudRegistro('solicitud_registro', 'id_solicitud_registro', $datos, $request->id)) {
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
    public function deleteSolicitudRegistro()
    {
        if ($this->ion_auth->logged_in()) {

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
            if (is_numeric($this->input->post('id_solicitud_registro'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_solicitud_registro', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($this->solicitud_registro_model->updateSolicitudRegistro("solicitud_registro", "id_solicitud_registro", array('fecha_baja' => $fecha, "estado" => 0), $request->id)) {
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
