<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Escuela extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('escuela_model');
    }
	
    public function index_get($id)
    {	
		// Validamos que venga el ID para poder hacer la búsqueda
        if (!$id) {
            $this->response(null, 400);
        }
        $alumno = $this->escuela_model->get($id);

		// Si encuentra al alumno, regresa sus datos, en caso de que no, regresará el mensaje
        if (!is_null($alumno)) {
			
            $this->response(array('response' => $alumno), 200);
			
		} else {
            $this->response(array('error' => 'Alumno no encontrado...'), 404);
        }
    }

    public function index_post()
    {	
		// Validamos que venga el array con datos que se le pasará al modelo para la inserción
        if (!$this->post('calificacion')) {
            $this->response(null, 400);
        }

        $id = $this->escuela_model->save($this->post('calificacion'));
		// Si lo inserta, regresamos mensaje de exitoso; de lo contrario mandará error
        if (!is_null($id)) {
            $this->response(array('success' => 'ok', 'response' => 'Calificación registrada'), 200);
        } else {
            $this->response(array('error', 'Error al tratar de registrar calificación'), 400);
        }
    }

    public function index_put()
    {
		// Validamos que venga el array con datos que se le pasará al modelo para la actualizar
        if (!$this->put('calificacion')) {
            $this->response(null, 400);
        }

        $update = $this->escuela_model->update($this->put('calificacion'));
		// Si lo actualiza, regresamos mensaje de exitoso; de lo contrario mandará error
        if (!is_null($update)) {
            $this->response(array('response' => 'Calificación actualizada!'), 200);
        } else {
            $this->response(array('error', 'Error al tratar de actualizar calificación'), 400);
        }
    }

    public function index_delete($id)
    {
		// Validamos que venga el ID para poder eliminar un registro
        if (!$id) {
            $this->response(array('error', 'No se recibió el ID para eliminar'), 400);
        }

        $delete = $this->escuela_model->delete($id);
		// Si lo elimina, regresamos mensaje de exitoso; de lo contrario mandará error
        if (!is_null($delete)) {
            $this->response(array('success' => 'ok', 'response' => 'Calificacion eliminada!'), 200);
        } else {
            $this->response(array('error', 'Error al tratar de eliminar la calificación'), 400);
        }
    }
}