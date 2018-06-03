<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_hutang extends CI_Model {
	function nomor()
	{
		$this->db->select('nomor');
		$this->db->order_by('nomor DESC');
		$query = $this->db->get('data');
		return $query->result_array();
	}
	function tambah_hutangkeluar($data)
	{
		$query = $this->db->insert('data', $data);
		return $query;
	}
	 function row_hutang(){
    	$this->db->where('jenis', 'hutang');
        $query = $this->db->get('data');
        return $query->num_rows();
    }

	function hutang($number, $offset){
		$this->db->where('jenis', 'hutang');
        $this->db->order_by('nomor DESC');
        $query = $this->db->get('data', $number, $offset);
        return $query->result();
    }
    function total_hutang()
    {
    	$this->db->select('jumlah');
    	$this->db->from('data');
    	$this->db->where('jenis', 'hutang');
    	$query = $this->db->get();
    	return $query->result();
    }
    function total_harian_hutang($tanggal)
    {
    	$this->db->select('jumlah');
    	$this->db->from('data');
    	$this->db->where('tanggal', $tanggal);
    	$this->db->where('jenis','hutang');
    	$query = $this->db->get();
    	return $query->result();
    }

    function total_periode_hutang($mulai, $sampai)
    {
    	$this->db->select('jumlah');
    	$this->db->from('data');
		$this->db->where('tanggal >=', $mulai);
		$this->db->where('tanggal <=', $sampai);
    	$this->db->where('jenis', 'hutang');
    	$query = $this->db->get();
    	return $query->result();
    }
}
