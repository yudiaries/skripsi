<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_masuk extends CI_Model {
	function tambah_pemasukan($data)
	{
		$query = $this->db->insert('data', $data);
		return $query;
	}
	function nomor()
	{
		$this->db->select('nomor');
		$this->db->order_by('nomor DESC');
		$query = $this->db->get('data');
		return $query->result_array();
	}
	function row_masuk(){
    	$this->db->where('jenis', 'masuk');
        $query = $this->db->get('data');
        return $query->num_rows();
    }
    function masuk($number, $offset){
		$this->db->where('jenis', 'masuk');
        $this->db->order_by('nomor DESC');
        $query = $this->db->get('data',$number,$offset);
        return $query->result();
    }
    function total_masuk()
    {
    	$this->db->select('jumlah');
    	$this->db->from('data');
    	$this->db->where('jenis', 'masuk');
    	$query = $this->db->get();
    	return $query->result();
    }
     function total_harian_masuk($tanggal)
    {
    	$this->db->select('jumlah');
    	$this->db->from('data');
    	$this->db->where('tanggal', $tanggal);
    	$this->db->where('jenis','masuk');
    	$query = $this->db->get();
    	return $query->result();
    }
    function total_periode_masuk($mulai, $sampai)
    {
    	$this->db->select('jumlah');
    	$this->db->from('data');
		$this->db->where('tanggal >=', $mulai);
		$this->db->where('tanggal <=', $sampai);
    	$this->db->where('jenis', 'masuk');
    	$query = $this->db->get();
    	return $query->result();
    }
}
