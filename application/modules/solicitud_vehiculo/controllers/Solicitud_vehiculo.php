<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Solicitud_vehiculo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('solicitud_vehiculo_model');
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
                'titulo' => "Solicitud_vehiculo",
                'vista' => array('index', 'modals'),
                'libjs' => array('libjs'),
                'active' => 'solicitud_vehiculo'
            );
            $this->load->view('estructura/body', $data);
        }
    }
    public function getSolicitudVehiculoById($id)
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

              $id ? $where = " AND sv.id_solicitud_vehiculo=$id" : $where = '';




            if (sizeof($response->errores) == 0) {
                if ($query = $this->solicitud_vehiculo_model->getSolicitudVehiculo($where)) {
                    foreach ($query->result() as $res) {
                        $row = null;
                        $row = new stdClass();
                        $row->id_solicitud_vehiculo = $res->id_solicitud_vehiculo;
                        $row->marca = $res->marca;
                        $row->modelo = $res->modelo;
                        $row->ano = $res->ano;
                        $row->patente = $res->patente;
                        $row->version = $res->version;
                        $row->ano_compra = $res->ano_compra;
                        $row->sucursal = $res->sucursal;
                        $row->nro_chasis = $res->nro_chasis;
                        $row->nro_motor = $res->nro_motor;
                        $row->img_1 = $res->img_1;
                        $row->img_2 = $res->img_2;
                        $row->img_3 = $res->img_3;
                        $row->id_usuario_gestor = $res->id_usuario_gestor;
                        $row->id_cliente = $res->id_cliente;
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
    public function getSolicitudVehiculo()
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

            if ($this->input->post('user_id')) {
                $request->user_id = trim($this->security->xss_clean($this->input->post('user_id', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener el id de usuario";
            }

            $request->user_id ? $where = " AND id_cliente=$request->user_id" : $where = '';


            if ($query = $this->solicitud_vehiculo_model->getSolicitudVehiculo($where)) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->id_solicitud_vehiculo = $res->id_solicitud_vehiculo;
                    $row->marca = $res->marca;
                    $row->modelo = $res->modelo;
                    $row->ano = $res->ano;
                    $row->patente = $res->patente;
                    $row->version = $res->version;
                    $row->ano_compra = $res->ano_compra;
                    $row->sucursal = $res->sucursal;
                    $row->nro_chasis = $res->nro_chasis;
                    $row->nro_motor = $res->nro_motor;
                    $row->img_1 = $res->img_1;
                    $row->img_2 = $res->img_2;
                    $row->img_3 = $res->img_3;
                    $row->id_usuario_gestor = $res->id_usuario_gestor;
                    $row->id_cliente = $res->id_cliente;
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

    public function insertSolicitudVehiculo()
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



            /** CUANDO NO RECIBAMOS UN ID COMO FOREIGN KEY, DEBEMOS ASIGNARLE UN ERROR AL PROCESO,
        PARA QUE NO HAGA LA INSERCION, DEBIDO A QUE EN LA BASE DE DATOS, ESTOS CAMPOS SON NOT NULL **/

            //VERIFICAMOS LAS VARIABLES QUE RECIBIMOS PARA EDITAR.
            if (!empty($this->input->post('marca'))) {
                $request->marca = trim($this->security->xss_clean($this->input->post('marca', true)));
            }
            if (!empty($this->input->post('modelo'))) {
                $request->modelo = trim($this->security->xss_clean($this->input->post('modelo', true)));
            }
            if (!empty($this->input->post('ano'))) {
                $request->ano = trim($this->security->xss_clean($this->input->post('ano', true)));
            }
            if (!empty($this->input->post('patente'))) {
                $request->patente = trim($this->security->xss_clean($this->input->post('patente', true)));
            }
            if (!empty($this->input->post('version'))) {
                $request->version = trim($this->security->xss_clean($this->input->post('version', true)));
            }
            if (!empty($this->input->post('ano_compra'))) {
                $request->ano_compra = trim($this->security->xss_clean($this->input->post('ano_compra', true)));
            }
            if (!empty($this->input->post('sucursal'))) {
                $request->sucursal = trim($this->security->xss_clean($this->input->post('sucursal', true)));
            }
            if (!empty($this->input->post('nro_chasis'))) {
                $request->nro_chasis = trim($this->security->xss_clean($this->input->post('nro_chasis', true)));
            }
            if (!empty($this->input->post('nro_motor'))) {
                $request->nro_motor = trim($this->security->xss_clean($this->input->post('nro_motor', true)));
            }
            if (!empty($this->input->post('img_1'))) {
                $request->img_1 = trim($this->security->xss_clean($this->input->post('img_1', true)));
            }
            if (!empty($this->input->post('img_2'))) {
                $request->img_2 = trim($this->security->xss_clean($this->input->post('img_2', true)));
            }
            if (!empty($this->input->post('img_3'))) {
                $request->img_3 = trim($this->security->xss_clean($this->input->post('img_3', true)));
            }

            if (!empty($this->input->post('id_cliente'))) {
                $request->id_cliente = trim($this->security->xss_clean($this->input->post('id_cliente', true)));
            } else {
                $response->errores[] = "Ocurrió un problema al obtener el id_cliente";
            }
            //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
            $datos = array(
                'marca' => $request->marca,
                'modelo' => $request->modelo,
                'patente' => $request->patente,
                'version' => $request->version,
                'ano_compra' => $request->ano_compra,
                'sucursal' => $request->sucursal,
                'nro_chasis' => $request->nro_chasis,
                'nro_motor' => $request->nro_motor,
                'id_cliente' => $request->id_cliente,
                'fecha_creacion' => $fecha,
                'estado' => 1
            );

            //INSERCION, ACTUALIZACION U OPERACIONES
            if ($query = $this->solicitud_vehiculo_model->insertSolicitudVehiculo('solicitud_vehiculo', $datos)) {
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
    public function updateSolicitudVehiculo()
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
            if ($this->input->post('id_solicitud_vehiculo')) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_solicitud_vehiculo', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            if (sizeof($response->errores) == 0) {
                //VERIFICAMOS LAS VARIABLES QUE RECIBIMOS PARA EDITAR.
                if (!empty($this->input->post('marca'))) {
                    $request->marca = trim($this->security->xss_clean($this->input->post('marca', true)));
                }
                if (!empty($this->input->post('modelo'))) {
                    $request->modelo = trim($this->security->xss_clean($this->input->post('modelo', true)));
                }
                if (!empty($this->input->post('ano'))) {
                    $request->ano = trim($this->security->xss_clean($this->input->post('ano', true)));
                }
                if (!empty($this->input->post('patente'))) {
                    $request->patente = trim($this->security->xss_clean($this->input->post('patente', true)));
                }
                if (!empty($this->input->post('version'))) {
                    $request->version = trim($this->security->xss_clean($this->input->post('version', true)));
                }
                if (!empty($this->input->post('ano_compra'))) {
                    $request->ano_compra = trim($this->security->xss_clean($this->input->post('ano_compra', true)));
                }
                if (!empty($this->input->post('sucursal'))) {
                    $request->sucursal = trim($this->security->xss_clean($this->input->post('sucursal', true)));
                }
                if (!empty($this->input->post('nro_chasis'))) {
                    $request->nro_chasis = trim($this->security->xss_clean($this->input->post('nro_chasis', true)));
                }
                if (!empty($this->input->post('nro_motor'))) {
                    $request->nro_motor = trim($this->security->xss_clean($this->input->post('nro_motor', true)));
                }
                if (!empty($this->input->post('img_1'))) {
                    $request->img_1 = trim($this->security->xss_clean($this->input->post('img_1', true)));
                }
                if (!empty($this->input->post('img_2'))) {
                    $request->img_2 = trim($this->security->xss_clean($this->input->post('img_2', true)));
                }
                if (!empty($this->input->post('img_3'))) {
                    $request->img_3 = trim($this->security->xss_clean($this->input->post('img_3', true)));
                }
                if (!empty($this->input->post('id_usuario_gestor'))) {
                    $request->id_usuario_gestor = trim($this->security->xss_clean($this->input->post('id_usuario_gestor', true)));
                }
                if (!empty($this->input->post('id_cliente'))) {
                    $request->id_cliente = trim($this->security->xss_clean($this->input->post('id_cliente', true)));
                }



                //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
                $datos = array(
                    'marca' => $request->marca,
                    'modelo' => $request->modelo,
                    'ano' => $request->ano,
                    'patente' => $request->patente,
                    'version' => $request->version,
                    'ano_compra' => $request->ano_compra,
                    'sucursal' => $request->sucursal,
                    'nro_chasis' => $request->nro_chasis,
                    'nro_motor' => $request->nro_motor,
                    'img_1' => $request->img_1,
                    'img_2' => $request->img_2,
                    'img_3' => $request->img_3,
                    'id_usuario_gestor' => $request->id_usuario_gestor,
                    'id_cliente' => $request->id_cliente,
                    'fecha_modificacion' => $fecha,

                );
            }
            $where = " AND id_solicitud_vehiculo=$request->id";
            $itemActualizado = $this->solicitud_vehiculo_model->getSolicitudVehiculo($where);
            $response->data = $itemActualizado->result();

            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($query = $this->solicitud_vehiculo_model->updateSolicitudVehiculo('solicitud_vehiculo', 'id_solicitud_vehiculo', $datos, $request->id)) {
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
    public function deleteSolicitudVehiculo()
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
            if (is_numeric($this->input->post('id_solicitud_vehiculo'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_solicitud_vehiculo', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }
            $where = " AND id_solicitud_vehiculo=$request->id";
            $itemEliminado = $this->solicitud_vehiculo_model->getSolicitudVehiculo($where);
            $response->data = $itemEliminado->result();

            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($this->solicitud_vehiculo_model->updateSolicitudVehiculo("solicitud_vehiculo", "id_solicitud_vehiculo", array('fecha_baja' => $fecha, "estado" => 0), $request->id)) {
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

}
