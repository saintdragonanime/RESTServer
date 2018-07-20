<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Escuela_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

	// FUNCION GET ALUMNOS EN GENERAL O ALUMNO SI SE LE PASA ID
    public function get($id)
    {
        if (!is_null($id)) {
            $this->db->select('a.id_t_usuarios,
							a.nombre,
							a.ap_paterno,
							m.nombre as "materia",
							c.calificacion,
							DATE_FORMAT(c.fecha_registro,"%d/%m/%Y ") as "fecha_registro" ');
			$this->db->from('t_calificaciones as c');
			$this->db->join('t_alumnos as a','a.id_t_usuarios=c.id_t_usuarios');
			$this->db->join('t_materias as m','m.id_t_materias=c.id_t_materias');
			$this->db->where('a.id_t_usuarios',$id);
			$query = $this->db->get();
			
            if ($query->num_rows() === 1) {
                return $query->row_array();
            }

            else return null;
        }
    }

	// FUNCION SAVE CALIFICACION
    public function save($calificacion)
    {
		$this->db->set($this->_setCalificacion($calificacion))->insert('t_calificaciones');
		
        if ($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }
		return null;
    }

	// FUNCION ACTUALIZA CALIFICACION
    public function update($calificacion)
    {
        $id = $calificacion['id'];
		
        $this->db->set($this->_setCalificacion($calificacion))->where('id', $id)->update('t_calificaciones');

        if ($this->db->affected_rows() === 1) {
            return true;
        }
        return null;
    }

	// FUNCION ELIMINA CALIFICACION
    public function delete($id)
    {
        $this->db->where('id_t_calificaciones', $id)->delete('t_calificaciones');

        if ($this->db->affected_rows() === 1) {
            return true;
        }
		return null;
    }

    private function _setCalificacion($calificacion)
    {	
		 return array(
            'id_t_materias' => $calificacion['id_t_materias'],
			'id_t_usuarios' => $calificacion['id_t_usuarios'],
			'calificacion' => $calificacion['calificacion'],
			'fecha_registro' => $calificacion['fecha_registro']
        );
    }
}