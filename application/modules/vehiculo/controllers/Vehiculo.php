<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vehiculo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('vehiculo_model');
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
                'titulo' => "Vehiculo",
                'vista' => array('index', 'modals'),
                'libjs' => array('libjs'),
                'active' => 'vehiculo'
            );
            $this->load->view('estructura/body', $data);
        }
    }


    public function getVehiculo()
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

            if ($query = $this->vehiculo_model->getVehiculo()) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->id_vehiculo = $res->id_vehiculo;
                    $row->nombre = $res->nombre;
                    $row->marca = $res->marca;
                    $row->modelo = $res->modelo;
                    $row->version = $res->version;
                    $row->patente = $res->patente;
                    $row->id_cliente = $res->id_cliente;
                    $row->color = $res->color;
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


    public function getVehiculoById()
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

            if (is_numeric($this->input->post('id_vehiculo'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_vehiculo', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            $request->id ? $where = " AND id_vehiculo=$request->id" : $where = '';


            if (sizeof($response->errores) == 0) {
                if ($query = $this->vehiculo_model->getVehiculo($where)) {
                    foreach ($query->result() as $res) {
                        $row = null;
                        $row = new stdClass();
                        $row->id_vehiculo = $res->id_vehiculo;
                        $row->nombre = $res->nombre;
                        $row->marca = $res->marca;
                        $row->modelo = $res->modelo;
                        $row->version = $res->version;
                        $row->patente = $res->patente;
                        $row->id_cliente = $res->id_cliente;
                        $row->color = $res->color;
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

    public function insertVehiculo()
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

            if (!empty($this->input->post('marca'))) {
                $request->descripcion = trim($this->security->xss_clean($this->input->post('marca', true)));
            }

            if (!empty($this->input->post('version'))) {
                $request->fecha_entrada = trim($this->security->xss_clean($this->input->post('version', true)));
            }

            if (!empty($this->input->post('patente'))) {
                $request->fecha_salida = trim($this->security->xss_clean($this->input->post('patente', true)));
            }

            if (!empty($this->input->post('id_cliente'))) {
                $request->id_usuario_tecnico = trim($this->security->xss_clean($this->input->post('id_cliente', true)));
            } else {
                $response->errores[] = "Ocurrió un problema al obtener el id_cliente";
            }

            if (!empty($this->input->post('color'))) {
                $request->id_cliente = trim($this->security->xss_clean($this->input->post('color', true)));
            } 


            //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
            $datos = array(
                'nombre' => $request->nombre,
                'marca' => $request->marca,
                'modelo' => $request->modelo,
                'version' => $request->version,
                'patente' => $request->patente,
                'id_cliente' => $request->id_cliente,
                'color' => $request->color,
                'fecha_creacion' => $fecha,
                'estado' => 1,

            );

            //INSERCION, ACTUALIZACION U OPERACIONES
            if ($query = $this->vehiculo_model->insertVehiculo('vehiculo', $datos)) {
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
    public function updateVehiculo()
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
            if ($this->input->post('id_vehiculo')) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_vehiculo', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            if (sizeof($response->errores) == 0) {
                //VERIFICAMOS LAS VARIABLES QUE RECIBIMOS PARA EDITAR.

                if (!empty($this->input->post('nombre'))) {
                    $request->nombre = trim($this->security->xss_clean($this->input->post('nombre', true)));
                }
    
                if (!empty($this->input->post('marca'))) {
                    $request->descripcion = trim($this->security->xss_clean($this->input->post('marca', true)));
                }
    
                if (!empty($this->input->post('version'))) {
                    $request->fecha_entrada = trim($this->security->xss_clean($this->input->post('version', true)));
                }
    
                if (!empty($this->input->post('patente'))) {
                    $request->fecha_salida = trim($this->security->xss_clean($this->input->post('patente', true)));
                }
    
                if (!empty($this->input->post('id_cliente'))) {
                    $request->id_usuario_tecnico = trim($this->security->xss_clean($this->input->post('id_cliente', true)));
                } else {
                    $response->errores[] = "Ocurrió un problema al obtener el id_cliente";
                }
    
                if (!empty($this->input->post('color'))) {
                    $request->id_cliente = trim($this->security->xss_clean($this->input->post('color', true)));
                } 



                //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
                $datos = array(
                    'nombre' => $request->nombre,
                    'marca' => $request->marca,
                    'modelo' => $request->modelo,
                    'version' => $request->version,
                    'patente' => $request->patente,
                    'id_cliente' => $request->id_cliente,
                    'color' => $request->color,
                    'fecha_modificacion' => $fecha,

                );
            }


            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($query = $this->vehiculo_model->updateVehiculo('vehiculo', 'id_vehiculo', $datos, $request->id)) {
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

    public function deleteVehiculo()
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
            if (is_numeric($this->input->post('id_vehiculo'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_vehiculo', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($this->vehiculo_model->updateVehiculo("vehiculo", "id_vehiculo", array('fecha_baja' => $fecha, "estado" => 0), $request->id)) {
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
