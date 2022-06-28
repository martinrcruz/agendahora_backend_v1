<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Headers: Content-Type');

class Historial_servicio extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('historial_servicio_model');
        $this->load->library(['ion_auth', 'form_validation']);

        date_default_timezone_set('America/Santiago');
    }

    public function index()
    {
        if (!true) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } else {

            $data['datalibrary'] = array(
                'titulo' => "Historial_servicio",
                'vista' => array('index', 'modals'),
                'libjs' => array('libjs'),
                'active' => 'historial_servicio'
            );
            $this->load->view('estructura/body', $data);
        }
    }

    public function getHistorialServicio()
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

            if ($query = $this->historial_servicio_model->getHistorialServicio()) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->id_historial_servicio = $res->id_historial_servicio;
                    $row->nombre = $res->nombre;
                    $row->descripcion = $res->descripcion;
                    $row->fecha_entrada = $res->fecha_entrada;
                    $row->fecha_salida = $res->fecha_salida;
                    $row->id_supervisor = $res->id_supervisor;
                    $row->id_cliente = $res->id_cliente;
                    $row->id_usuario_tecnico = $res->id_usuario_tecnico;
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

    public function getHistorialServicioTabla()
    {
        if (true) {
            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [PETICION]
            $request = new stdClass();
            $request->id = null;
            $request->data = [];

            $fecha = date('Y-m-d H:i:s');
            $where ='';
            //DECLARACION DE VARIABLES, OBJETOS Y ARRAYS DE [RESPUESTA]
            $response = new stdClass();
            $response->id = null;
            $response->data = [];
            $response->proceso = 0;
            $response->errores = [];


            if (!empty($this->input->post('fecha_inicio'))) {
                if ($this->input->post('fecha_inicio') != 'null') {
                    $request->fecha_inicio = $this->security->xss_clean($this->input->post('fecha_inicio'));
                    $where .= " AND hs.fecha_entrada >= '$request->fecha_inicio'";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener fecha_inicio";
            }

            if (!empty($this->input->post('fecha_fin'))) {
                if ($this->input->post('fecha_fin') != 'null') {
                    $request->fecha_fin = $this->security->xss_clean($this->input->post('fecha_fin'));
                    $where .= " AND hs.fecha_salida <= '$request->fecha_fin'";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener fecha_fin";
            }

            if (!empty($this->input->post('fecha_agenda'))) {
                if ($this->input->post('fecha_agenda') != 'null') {
                    $request->fecha_agenda = $this->security->xss_clean($this->input->post('fecha_agenda'));
                    $where .= " AND hs.fecha_agenda <= '$request->fecha_agenda'";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener fecha agenda";
            }

            if (!empty($this->input->post('tecnico'))) {
                if ($this->input->post('tecnico') != 'null') {
                    $request->tecnico = $this->security->xss_clean($this->input->post('tecnico'));
                    $where .= " AND hs.id_tecnico = $request->tecnico";
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
                    $where .= " AND hs.estado_servicio = $request->estado";
                }
            } else {
                $response->errores[] = "Ocurrió un problema al obtener estado";
            }




            if ($query = $this->historial_servicio_model->getHistorialServicioTabla($where)) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->id_historial_servicio = $res->id_historial_servicio;
                    $row->nombre = $res->nombre;
                    $row->descripcion = $res->descripcion;
                    $row->detalle = $res->detalles;
                    $row->fecha_entrada = date('d-m-Y H:s', strtotime($res->fecha_entrada));
                    $row->fecha_salida = date('d-m-Y H:s', strtotime($res->fecha_salida));

                    $fecha_agenda = date('d-m-Y', strtotime($res->fecha_agenda));
                    $hora_agenda = date('H:s', strtotime($res->hora_agenda));

                    $row->fecha_agenda = $fecha_agenda . ' ' . $hora_agenda;
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


    public function getHistorialServicioById()
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

            if (is_numeric($this->input->post('id_historial_servicio'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_historial_servicio', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            $request->id ? $where = " AND id_historial_servicio=$request->id" : $where = '';


            if (sizeof($response->errores) == 0) {
                if ($query = $this->historial_servicio_model->getHistorialServicio($where)) {
                    foreach ($query->result() as $res) {
                        $row = null;
                        $row = new stdClass();
                        $row->id_historial_servicio = $res->id_historial_servicio;
                        $row->nombre = $res->nombre;
                        $row->descripcion = $res->descripcion;
                        $row->detalles = $res->detalle;
                        $row->fecha_entrada = $res->fecha_entrada;
                        $row->fecha_salida = $res->fecha_salida;
                        $row->id_supervisor = $res->id_supervisor;
                        $row->id_cliente = $res->id_cliente;
                        $row->id_vehiculo = $res->id_vehiculo;
                        $row->id_tecnico = $res->id_tecnico;
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


    public function insertHistorialServicio()
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
                $request->nombre = trim($this->security->xss_clean($this->input->post('nombre', true)));
            }

            if (!empty($this->input->post('descripcion'))) {
                $request->descripcion = trim($this->security->xss_clean($this->input->post('descripcion', true)));
            }

            if (!empty($this->input->post('fecha_entrada'))) {
                $request->fecha_entrada = trim($this->security->xss_clean($this->input->post('fecha_entrada', true)));
            }

            if (!empty($this->input->post('fecha_salida'))) {
                $request->fecha_salida = trim($this->security->xss_clean($this->input->post('fecha_salida', true)));
            }

            if (!empty($this->input->post('id_usuario_cargo'))) {
                $request->id_usuario_cargo = trim($this->security->xss_clean($this->input->post('id_usuario_cargo', true)));
            } else {
                $response->errores[] = "Ocurrió un problema al obtener el id_usuario_cargo";
            }

            if (!empty($this->input->post('id_cliente'))) {
                $request->id_cliente = trim($this->security->xss_clean($this->input->post('id_cliente', true)));
            } else {
                $response->errores[] = "Ocurrió un problema al obtener el id_cliente";
            }

            if (!empty($this->input->post('id_usuario_tecnico'))) {
                $request->id_usuario_tecnico = trim($this->security->xss_clean($this->input->post('id_usuario_tecnico', true)));
            } else {
                $response->errores[] = "Ocurrió un problema al obtener el id_usuario_tecnico";
            }

            //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
            $datos = array(
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'fecha_entrada' => $request->fecha_entrada,
                'fecha_salida' => $request->fecha_salida,
                'id_usuario_cargo' => $request->id_usuario_cargo,
                'id_cliente' => $request->id_cliente,
                'id_usuario_tecnico' => $request->id_usuario_tecnico,
                'fecha_creacion' => $fecha,
                'fecha_modificacion' => $request->fecha_modificacion,
                'fecha_baja' => $request->fecha_baja,
                'estado' => 1

            );

            //INSERCION, ACTUALIZACION U OPERACIONES
            if ($query = $this->historial_servicio_model->insertHistorialServicio('historial_servicio', $datos)) {
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
    public function updateHistorialServicio()
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
            if ($this->input->post('id_historial_servicio')) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_historial_servicio', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            if (sizeof($response->errores) == 0) {
                //VERIFICAMOS LAS VARIABLES QUE RECIBIMOS PARA EDITAR.
                if (!empty($this->input->post('nombre'))) {
                    $request->nombre = trim($this->security->xss_clean($this->input->post('nombre', true)));
                }

                if (!empty($this->input->post('descripcion'))) {
                    $request->descripcion = trim($this->security->xss_clean($this->input->post('descripcion', true)));
                }

                if (!empty($this->input->post('fecha_entrada'))) {
                    $request->fecha_entrada = trim($this->security->xss_clean($this->input->post('fecha_entrada', true)));
                }

                if (!empty($this->input->post('fecha_salida'))) {
                    $request->fecha_salida = trim($this->security->xss_clean($this->input->post('fecha_salida', true)));
                }

                if (!empty($this->input->post('id_usuario_cargo'))) {
                    $request->id_usuario_cargo = trim($this->security->xss_clean($this->input->post('id_usuario_cargo', true)));
                }

                if (!empty($this->input->post('id_cliente'))) {
                    $request->id_cliente = trim($this->security->xss_clean($this->input->post('id_cliente', true)));
                }

                if (!empty($this->input->post('id_usuario_tecnico'))) {
                    $request->id_usuario_tecnico = trim($this->security->xss_clean($this->input->post('id_usuario_tecnico', true)));
                }





                //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
                $datos = array(
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'fecha_entrada' => $request->fecha_entrada,
                    'fecha_salida' => $request->fecha_salida,
                    'id_usuario_cargo' => $request->id_usuario_cargo,
                    'id_cliente' => $request->id_cliente,
                    'id_usuario_tecnico' => $request->id_usuario_tecnico,
                    'fecha_modificacion' => $fecha,
                    'fecha_baja' => $request->fecha_baja,

                );
            }

            $where = " AND id_historial_servicio=$request->id";
            $itemActualizado = $this->historial_servicio_model->getHistorialServicio($where);

            $response->data = $itemActualizado->result();
            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($query = $this->historial_servicio_model->updateHistorialServicio('historial_servicio', 'id_historial_servicio', $datos, $request->id)) {
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
    public function deleteHistorialServicio()
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
            if (is_numeric($this->input->post('id_historial_servicio'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_historial_servicio', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }
            $where = " AND id_historial_servicio=$request->id";
            $itemEliminado = $this->historial_servicio_model->getHistorialServicio($where);

            $response->data = $itemEliminado->result();
            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($this->historial_servicio_model->updateHistorialServicio("historial_servicio", "id_historial_servicio", array('fecha_baja' => $fecha, "estado" => 0), $request->id)) {
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
