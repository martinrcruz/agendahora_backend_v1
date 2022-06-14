<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mensaje extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('mensaje_model');
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
                'titulo' => "Mensaje",
                'vista' => array('index', 'modals'),
                'libjs' => array('libjs'),
                'active' => 'mensaje'
            );
            $this->load->view('estructura/body', $data);
        }
    }


    public function getMensaje()
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

            if ($query = $this->mensaje_model->getMensaje()) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->id_mensaje = $res->id_mensaje;
                    $row->usuario_emisor = $res->usuario_emisor;
                    $row->usuario_receptor = $res->usuario_receptor;
                    $row->mensaje = $res->mensaje;
                    $row->fecha_lectura = $res->fecha_lectura;
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


    public function getMensajeById()
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

            if (is_numeric($this->input->post('id_mensaje'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_mensaje', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            $request->id ? $where = " AND id_mensaje=$request->id" : $where = '';


            if (sizeof($response->errores) == 0) {
                if ($query = $this->mensaje_model->getMensaje($where)) {
                    foreach ($query->result() as $res) {
                        $row = null;
                        $row = new stdClass();
                        $row->id_mensaje = $res->id_mensaje;
                        $row->usuario_emisor = $res->usuario_emisor;
                        $row->usuario_receptor = $res->usuario_receptor;
                        $row->mensaje = $res->mensaje;
                        $row->fecha_lectura = $res->fecha_lectura;
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

    public function insertMensaje()
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
            if (!empty($this->input->post('usuario_emisor'))) {
                $request->usuario_emisor = trim($this->security->xss_clean($this->input->post('usuario_emisor', true)));
            }else {
                $response->errores[] = "Ocurrió un problema al obtener el usuario_emisor";
            }

            if (!empty($this->input->post('usuario_receptor'))) {
                $request->usuario_receptor = trim($this->security->xss_clean($this->input->post('usuario_receptor', true)));
            }else {
                $response->errores[] = "Ocurrió un problema al obtener el usuario_receptor";
            }

            if (!empty($this->input->post('mensaje'))) {
                $request->mensaje = trim($this->security->xss_clean($this->input->post('mensaje', true)));
            }

            if (!empty($this->input->post('fecha_lectura'))) {
                $request->fecha_lectura = trim($this->security->xss_clean($this->input->post('fecha_lectura', true)));
            }


            //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
            $datos = array(
                'usuario_emisor' => $request->usuario_emisor,
                'usuario_receptor' => $request->usuario_receptor,
                'mensaje' => $request->mensaje,
                'fecha_lectura' => $request->fecha_lectura,
                'fecha_creacion' => $fecha,
                'estado' => 1

            );

            //INSERCION, ACTUALIZACION U OPERACIONES
            if ($query = $this->mensaje_model->insertMensaje('mensaje', $datos)) {
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
    public function updateMensaje()
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
            if ($this->input->post('id_mensaje')) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_mensaje', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            if (sizeof($response->errores) == 0) {
                //VERIFICAMOS LAS VARIABLES QUE RECIBIMOS PARA EDITAR.
                if (!empty($this->input->post('usuario_emisor'))) {
                    $request->usuario_emisor = trim($this->security->xss_clean($this->input->post('usuario_emisor', true)));
                }
    
                if (!empty($this->input->post('usuario_receptor'))) {
                    $request->usuario_receptor = trim($this->security->xss_clean($this->input->post('usuario_receptor', true)));
                }
    
                if (!empty($this->input->post('mensaje'))) {
                    $request->mensaje = trim($this->security->xss_clean($this->input->post('mensaje', true)));
                }
    
                if (!empty($this->input->post('fecha_lectura'))) {
                    $request->fecha_lectura = trim($this->security->xss_clean($this->input->post('fecha_lectura', true)));
                }



                //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
                $datos = array(
                    'usuario_emisor' => $request->usuario_emisor,
                    'usuario_receptor' => $request->usuario_receptor,
                    'mensaje' => $request->mensaje,
                    'fecha_lectura' => $request->fecha_lectura,
                    'fecha_modificacion' => $fecha

                );
            }

            $where = " AND id_mensaje=$request->id";
            $itemActualizado = $this->mensaje_model->getMensaje($where);
            $response->data = $itemActualizado->result();
            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($query = $this->mensaje_model->updateMensaje('mensaje', 'id_mensaje', $datos, $request->id)) {
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
    public function deleteMensaje()
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
            if (is_numeric($this->input->post('id_mensaje'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id_mensaje', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }
            $where = " AND id_mensaje=$request->id";
            $itemEliminado = $this->mensaje_model->getMensaje($where);
            $response->data = $itemEliminado->result();
            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($this->mensaje_model->updateMensaje("mensaje", "id_mensaje", array('fecha_baja' => $fecha, "estado" => 0), $request->id)) {
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
