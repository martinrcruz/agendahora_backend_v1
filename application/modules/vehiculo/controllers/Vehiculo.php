<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Headers: Content-Type');

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


    public function getVehiculoTabla()
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
                    $where .= " AND v.fecha_creacion >= '$request->fecha_inicio'";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener fecha_inicio";
            }

            if (!empty($this->input->post('fecha_fin'))) {
                if ($this->input->post('fecha_fin') != 'null') {
                    $request->fecha_fin = $this->security->xss_clean($this->input->post('fecha_fin'));
                    $where .= " AND v.fecha_creacion <= '$request->fecha_fin'";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener fecha_fin";
            }

            if (!empty($this->input->post('marca'))) {
                if ($this->input->post('marca') != 'null') {
                    $request->marca = $this->security->xss_clean($this->input->post('marca'));
                    $where .= " AND v.marca = $request->marca";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener marca";
            }

            if (!empty($this->input->post('modelo'))) {
                if ($this->input->post('modelo') != 'null') {
                    $request->modelo = $this->security->xss_clean($this->input->post('modelo'));
                    $where .= " AND v.modelo = $request->modelo";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener modelo";
            }

            if (!empty($this->input->post('version'))) {
                if ($this->input->post('version') != 'null') {
                    $request->version = $this->security->xss_clean($this->input->post('version'));
                    $where .= " AND v.version = $request->version";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener version";
            }




            if ($query = $this->vehiculo_model->getVehiculoTabla($where)) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->id_vehiculo = $res->id_vehiculo;
                    $row->nombre = $res->nombre;
                    $row->marca = $res->marca;
                    $row->modelo = $res->modelo;
                    $row->patente = $res->patente;
                    $row->id_cliente = $res->id_cliente;
                    $row->nombre_cliente = $res->nombre_cliente;
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

            if (!empty($this->input->post('nombre'))) {
                $request->nombre = $this->security->xss_clean($this->input->post('nombre'));
            }

            if (!empty($this->input->post('marca'))) {
                $request->marca = $this->security->xss_clean($this->input->post('marca'));
            } else {
                $response->errores[] = "Ocurrió un problema al obtener la marca";
            }

            if (!empty($this->input->post('modelo'))) {
                $request->modelo = $this->security->xss_clean($this->input->post('modelo'));
            }

            if (!empty($this->input->post('version'))) {
                $request->version = $this->security->xss_clean($this->input->post('version'));
            }

            if (!empty($this->input->post('patente'))) {
                $request->patente = $this->security->xss_clean($this->input->post('patente'));
            }

            if (!empty($this->input->post('id_cliente'))) {
                $request->id_cliente = $this->security->xss_clean($this->input->post('id_cliente'));
            } else {
                $response->errores[] = "Ocurrió un problema al obtener el id_cliente";
            }

            if (!empty($this->input->post('color'))) {
                $request->color = $this->security->xss_clean($this->input->post('color'));
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

            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }
    public function updateVehiculo()
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
            if ($this->input->post('id_vehiculo')) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_vehiculo', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            if (sizeof($response->errores) == 0) {
                //VERIFICAMOS LAS VARIABLES QUE RECIBIMOS PARA EDITAR.

                if (!empty($this->input->post('nombre'))) {
                    $request->nombre = $this->security->xss_clean($this->input->post('nombre'));
                }

                if (!empty($this->input->post('marca'))) {
                    $request->marca = $this->security->xss_clean($this->input->post('marca'));
                }

                if (!empty($this->input->post('modelo'))) {
                    $request->modelo = $this->security->xss_clean($this->input->post('modelo'));
                }

                if (!empty($this->input->post('version'))) {
                    $request->version = $this->security->xss_clean($this->input->post('version'));
                }

                if (!empty($this->input->post('patente'))) {
                    $request->patente = $this->security->xss_clean($this->input->post('patente'));
                }

                if (!empty($this->input->post('id_cliente'))) {
                    $request->id_cliente = $this->security->xss_clean($this->input->post('id_cliente'));
                } else {
                    $response->errores[] = "Ocurrió un problema al obtener el id_cliente";
                }

                if (!empty($this->input->post('color'))) {
                    $request->color = $this->security->xss_clean($this->input->post('color'));
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
            $where = " AND id_vehiculo=$request->id";
            $itemActualizado = $this->vehiculo_model->getVehiculo($where);

            $response->data = $itemActualizado->result();


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

            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function deleteVehiculo()
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

            $where = '';


            //COMPROBAMOS SI VIENE UN ID MEDIANTE LA PETICION POST, Y SI ES QUE VIENE LO GUARDAMOS.
            if (is_numeric($this->input->post('id_vehiculo'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_vehiculo', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            $where = " AND id_vehiculo=$request->id";
            $itemEliminado = $this->vehiculo_model->getVehiculo($where);

            $response->data = $itemEliminado->result();

            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($this->vehiculo_model->updateVehiculo("vehiculo", "id_vehiculo", array('fecha_baja' => $fecha, "estado" => 0), $request->id)) {
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


    /****************************************************************/
    /****************************************************************/
    /****************** MOBILE BACKEND API FUNCTIONS ****************/
    /****************************************************************/
    /****************************************************************/

    public function getVehiculoMobile()
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


            if ($query = $this->vehiculo_model->getVehiculoMobile($where)) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->id_vehiculo = $res->id_vehiculo;
                    $row->nombre_vehiculo = $res->nombre_vehiculo;
                    $row->nombre_marca = $res->nombre_marca;
                    $row->nombre_modelo = $res->nombre_modelo;
                    // $row->nombre_version = $res->nombre_version;
                    $row->ultimo_servicio = date('d-m-Y', strtotime($res->ultimo_servicio));
                    $row->detalle_ultimo_servicio = $res->detalle_ultimo_servicio;
                    $row->patente = $res->patente;
                    $row->color = $res->color;
                    $row->fecha_creacion = $res->fecha_creacion;
                    $row->estado = $res->estado;

                    array_push($response->data, $row);
                }
            }
            echo json_encode($response);
        } else {
            redirect('login', 'refresh');
        }
    }
}
