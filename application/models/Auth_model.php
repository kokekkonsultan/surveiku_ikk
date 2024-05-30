<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

	public function dropdown_jenis_survey()
	{
		$query = $this->db->get('jenis_survey');

		if ($query->num_rows() > 0) {

			$dd[''] = 'Please Select';
			foreach ($query->result_array() as $row) {
				$dd[$row['id']] = $row['nama_jenis_survey'];
			}

			return $dd;
		}
	}

	
}

/* End of file Auth_model.php */
/* Location: ./application/models/Auth_model.php */