<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Headers: Content-Type');

class Usuario extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('usuario_model');
        $this->load->library(['ion_auth', 'form_validation']);

        date_default_timezone_set('America/Santiago');
    }



    public function getUsuario()
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

            if ($query = $this->usuario_model->getUsuario()) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->id = $res->id;
                    $row->first_name = $res->first_name;
                    $row->last_name = $res->last_name;
                    $row->email = $res->email;
                    $row->username = $res->username;


                    array_push($response->data, $row);
                }
            }
            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function getCliente()
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

            if ($query = $this->usuario_model->getCliente()) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->id = $res->id;
                    $row->first_name = $res->first_name;
                    $row->last_name = $res->last_name;
                    $row->email = $res->email;
                    $row->username = $res->username;


                    array_push($response->data, $row);
                }
            }
            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function getTecnicos()
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

            if ($query = $this->usuario_model->getTecnicos()) {
                foreach ($query->result() as $res) {
                    $row = null;
                    $row = new stdClass();
                    $row->id = $res->id;
                    $row->nombre_tecnico = $res->nombre_tecnico;
                    $row->first_name = $res->first_name;
                    $row->last_name = $res->last_name;
                    $row->email = $res->email;
                    $row->username = $res->username;


                    array_push($response->data, $row);
                }
            }
            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function getUsuarioById()
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

            if ($this->input->post('id')) {
                $request->id = $this->security->xss_clean($this->input->post('id'));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            $request->id ? $where = " AND u.id=$request->id" : $where = '';


            if (sizeof($response->errores) == 0) {
                if ($query = $this->usuario_model->getUsuario($where)) {
                    foreach ($query->result() as $res) {
                        $row = null;
                        $row = new stdClass();
                        $row->id = $res->id;
                        $row->first_name = $res->first_name;
                        $row->last_name = $res->last_name;
                        $row->email = $res->email;
                        $row->username = $res->username;

                        array_push($response->data, $row);
                    }
                }
            }

            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }


    public function getClienteById()
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

            if ($this->input->post('id')) {
                $request->id = $this->security->xss_clean($this->input->post('id'));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            $request->id ? $where = " AND u.id=$request->id" : $where = '';


            if (sizeof($response->errores) == 0) {
                if ($query = $this->usuario_model->getCliente($where)) {
                    foreach ($query->result() as $res) {
                        $row = null;
                        $row = new stdClass();
                        $row->id = $res->id;
                        $row->first_name = $res->first_name;
                        $row->last_name = $res->last_name;
                        $row->email = $res->email;
                        $row->username = $res->username;

                        array_push($response->data, $row);
                    }
                }
            }

            echo json_encode($response);
        } else {
            redirect('auth/login', 'refresh');
        }
    }
    public function insertUsuario()
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

            if (!empty($this->input->post('first_name'))) {
                $request->first_name = $this->security->xss_clean($this->input->post('first_name'));
            }

            if (!empty($this->input->post('last_name'))) {
                $request->last_name = $this->security->xss_clean($this->input->post('last_name'));
            }
            if (!empty($this->input->post('email'))) {
                $request->email = $this->security->xss_clean($this->input->post('email'));
            }

            if (!empty($this->input->post('username'))) {
                $request->username = $this->security->xss_clean($this->input->post('username'));
            }



            //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
            $datos = array(
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'username' => $request->username,


            );

            //INSERCION, ACTUALIZACION U OPERACIONES
            if ($query = $this->usuario_model->insertUsuario('users', $datos)) {
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
    public function updateUsuario()
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
            if ($this->input->post('id')) {
                $request->id = trim($this->security->xss_clean($this->input->post('id', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            if (sizeof($response->errores) == 0) {
                //VERIFICAMOS LAS VARIABLES QUE RECIBIMOS PARA EDITAR.


                if (!empty($this->input->post('first_name'))) {
                    $request->first_name = $this->security->xss_clean($this->input->post('first_name'));
                }

                if (!empty($this->input->post('last_name'))) {
                    $request->last_name = $this->security->xss_clean($this->input->post('last_name'));
                }
                if (!empty($this->input->post('email'))) {
                    $request->email = $this->security->xss_clean($this->input->post('email'));
                }

                if (!empty($this->input->post('username'))) {
                    $request->username = $this->security->xss_clean($this->input->post('username'));
                }




                //ALMACENAMOS LOS DATOS QUE VIENEN DEL POST, QUE REEMPLAZARAN A LA FILA ACTUAL EN LA BASE DE DATOS.
                $datos = array(
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'username' => $request->username,

                );
            }
            $where = " AND u.id=$request->id";
            $itemActualizado = $this->usuario_model->getUsuario($where);

            $response->data = $itemActualizado->result();


            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($query = $this->usuario_model->updateUsuario('users', 'id', $datos, $request->id)) {
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

    public function deleteUsuario()
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
            if (is_numeric($this->input->post('id'))) {
                $request->id = trim($this->security->xss_clean($this->input->post('id', true)));
            } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
                $response->errores[] = "Ocurrió un problema al obtener la solicitud";
            }

            $where = " AND u.id=$request->id";
            $itemEliminado = $this->usuario_model->getUsuario($where);

            $response->data = $itemEliminado->result();

            //SI ES QUE NO HAY ERRORES, PROCEDEMOS A HACER LA PETICION MEDIANTE UN LLAMADO A LA FUNCION DEL MODELO.
            if (sizeof($response->errores) == 0) {
                if ($this->usuario_model->updateUsuario("users", "id", array("active" => 0), $request->id)) {
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


    public function edit_group()
    {
        echo 'se activa';
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
        if ($this->input->post('id')) {
            $request->id = $this->security->xss_clean($this->input->post('id'));
        } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
            $response->errores[] = "Ocurrió un problema al obtener la solicitud";
        }

        if ($this->input->post('grupo')) {
            $request->grupo = $this->security->xss_clean($this->input->post('grupo'));
        } else { //SI NO, ALMACENAMOS EL ERROR EN UN ARRAY PARA DEVOLVERLO COMO RESPUESTA.
            $response->errores[] = "Ocurrió un problema al obtener la solicitud";
        }


        if (sizeof($response->errores) == 0) {
            if ($this->usuario_model->update("users_groups", "user_id", array("group_id" => $request->grupo), $request->id)) {
                //SI EL PROCESO ES EXITOSO, DEVOLVERA UN VALOR DENTRO DEL ARRAY DE RESPUESTA IGUAL A 1
                $response->proceso = 1;
            }
        } else {
            $response->errores[] = "Ocurrió un problema al procesar la eliminacion";
        }
        echo json_encode($response);
    }
}
