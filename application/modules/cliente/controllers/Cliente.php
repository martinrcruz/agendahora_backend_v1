<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cliente extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('cliente_model');
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
                'titulo' => "Cliente",
                'vista' => array('index', 'modals'),
                'libjs' => array('libjs'),
                'active' => 'cliente'
            );
            $this->load->view('estructura/body', $data);
        }
    }
    public function getClienteById()
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

            if (is_numeric($this->input->post('id_cliente'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_cliente', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            $request->id ? $where = " AND id_cliente=$request->id" : $where = '';


            if (sizeof($response->errores) == 0) {
                if ($query = $this->cliente_model->getCliente($where)) {
                    foreach ($query->result() as $res) {
                        $row = null;
                        $row = new stdClass();
                        $row->id_cliente = $res->id_cliente;
                        $row->correo = $res->correo;
                        $row->nombre = $res->nombre;
                        $row->apellidop = $res->apellidop;
                        $row->apellidom = $res->apellidom;
                        $row->rut = $res->rut;
                        $row->numero_contacto = $res->numero_contacto;
                        $row->direccion = $res->direccion;
                        $row->sucursal = $res->sucursal;
                        $row->nombre_usuario = $res->nombre_usuario;
                        $row->contrasena = $res->contrasena;
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
    public function getCliente()
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

            if ($query = $this->cliente_model->getCliente()) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->id_cliente = $res->id_cliente;
                    $row->correo = $res->correo;
                    $row->nombre = $res->nombre;
                    $row->apellidop = $res->apellidop;
                    $row->apellidom = $res->apellidom;
                    $row->rut = $res->rut;
                    $row->numero_contacto = $res->numero_contacto;
                    $row->direccion = $res->direccion;
                    $row->sucursal = $res->sucursal;
                    $row->nombre_usuario = $res->nombre_usuario;
                    $row->contrasena = $res->contrasena;
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

    public function insertCliente()
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

            if (!empty($this->input->post('correo'))) {
                $request->correo = trim($this->security->xss_clean($this->input->post('correo', true)));
            }
            if (!empty($this->input->post('nombre'))) {
                $request->nombre = trim($this->security->xss_clean($this->input->post('nombre', true)));
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

            //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
            $datos = array(
                'correo' => $request->correo,
                'nombre' => $request->nombre,
                'apellidop' => $request->apellidop,
                'apellidom' => $request->apellidom,
                'rut' => $request->rut,
                'numero_contacto' => $request->numero_contacto,
                'direccion' => $request->direccion,
                'sucursal' => $request->sucursal,
                'fecha_creacion' => $fecha,
                'estado' => 1
            );

            //INSERCION, ACTUALIZACION U OPERACIONES
            if ($query = $this->cliente_model->insertCliente('cliente', $datos)) {
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
    public function updateCliente()
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
            if ($this->input->post('id_cliente')) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_cliente', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            if (sizeof($response->errores) == 0) {
                //VERIFICAMOS LAS VARIABLES QUE RECIBIMOS PARA EDITAR.

                if (!empty($this->input->post('correo'))) {
                    $request->correo = trim($this->security->xss_clean($this->input->post('correo', true)));
                }
                if (!empty($this->input->post('nombre'))) {
                    $request->nombre = trim($this->security->xss_clean($this->input->post('nombre', true)));
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



                //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
                $datos = array(
                    'correo' => $request->correo,
                    'nombre' => $request->nombre,
                    'apellidop' => $request->apellidop,
                    'apellidom' => $request->apellidom,
                    'rut' => $request->rut,
                    'numero_contacto' => $request->numero_contacto,
                    'direccion' => $request->direccion,
                    'sucursal' => $request->sucursal,
                    'fecha_modificacion' => $fecha,
                );
            }


            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($query = $this->cliente_model->updateCliente('cliente', 'id_cliente', $datos, $request->id)) {
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
    public function deleteCliente()
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
            if (is_numeric($this->input->post('id_cliente'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_cliente', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }
            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($this->cliente_model->updateCliente("cliente", "id_cliente", array('fecha_baja' => $fecha, "estado" => 0), $request->id)) {
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
