<?php	if ( ! defined('BASEPATH')) exit('nemas tu co robit');
//@author Matus jankovic 
class Notes_model extends CI_Model {
	
	function getData(){
		
		$q = $this->db->order_by('date','time')
							->get('program');
		
		return $q->result();
		
	}
	
	function addData($data){
		
		$this->db->insert('program',$data);
		
		
	}
	
	function delData($id){

		$this->db->where('date', $id);
		$this->db->delete('program');
		
	}
	
		
	function zmenData($data1,$data2){
		$this->db->where('id', $data1);
		$this->db->delete('den');
		$this->db->insert('den',$data2);
		
	}
}