<?php
class Auth_model extends CI_Model {

	public function canLogin($login_id, $password)
	{
		$this->db->where('login_id', $login_id);
		$query = $this->db->get('users');

		if($query->num_rows())
		{
			return password_verify($password,$query->row()->password);		
		}
		return false;
	}

	public function getUser($login_id)
	{
		$this->db->where('login_id', $login_id);
		$query = $this->db->get('users');
		return $query->row_array();
	}

}