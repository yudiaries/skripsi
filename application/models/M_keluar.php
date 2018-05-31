<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_keluar extends CI_Model {
	function nomor()
	{
		$this->db->select('nomor');
		$this->db->order_by('nomor DESC');
		$query = $this->db->get('data');
		return $query->result_array();
	}
	function tambah_pengeluaran($data)
	{
		$query = $this->db->insert('data', $data);
		return $query;
	}
	 function row_keluar(){
    	$this->db->where('jenis', 'keluar');
        $query = $this->db->get('data');
        return $query->num_rows();
    }

	function keluar($number, $offset){
		$this->db->where('jenis', 'keluar');
        $this->db->order_by('nomor DESC');
        $query = $this->db->get('data', $number, $offset);
        return $query->result();
    }
    function total_keluar()
    {
    	$this->db->select('jumlah');
    	$this->db->from('data');
    	$this->db->where('jenis', 'keluar');
    	$query = $this->db->get();
    	return $query->result();
    }
    function total_harian_keluar($tanggal)
    {
    	$this->db->select('jumlah');
    	$this->db->from('data');
    	$this->db->where('tanggal', $tanggal);
    	$this->db->where('jenis','keluar');
    	$query = $this->db->get();
    	return $query->result();
    }

    function total_periode_keluar($mulai, $sampai)
    {
    	$this->db->select('jumlah');
    	$this->db->from('data');
		$this->db->where('tanggal >=', $mulai);
		$this->db->where('tanggal <=', $sampai);
    	$this->db->where('jenis', 'keluar');
    	$query = $this->db->get();
    	return $query->result();
    }
}