<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_index extends CI_Model {
	function login($username, $password)
	{
		$this->db->where('username', $username);
        $this->db->where('password', $password);
		$query = $this->db->get('login');
		return $query->result_array();
	}

	function nomor()
	{
		$this->db->select('nomor');
		$this->db->order_by('nomor DESC');
		$query = $this->db->get('data');
		return $query->result_array();
	}

	function ambil_data($nomor)
	{
		$this->db->where('nomor', $nomor);
		$query = $this->db->get('data');
		return $query->result_array();
	}

	function ubah($nomor, $data)
	{
		$this->db->where('nomor', $nomor);
		$query = $this->db->update('data', $data);
		return $query;
	}

	function hapus($nomor)
	{
		$this->db->where('nomor', $nomor);
		$query = $this->db->delete('data');
		return $query;
	}

    function row_harian($tanggal){
    	$this->db->where('tanggal', $tanggal);
        $query = $this->db->get('data');
        return $query->num_rows();
    }

	function laporan_harian($tanggal, $number, $offset)
	{
		$this->db->where('tanggal', $tanggal);
        $this->db->order_by('nomor DESC');
        $query = $this->db->get('data', $number, $offset);
        return $query->result();
	}

	function row_periode($mulai, $sampai)
	{
		$this->db->where('tanggal >=', $mulai);
		$this->db->where('tanggal <=', $sampai);
        $query = $this->db->get('data');
        return $query->num_rows();
	}

	function laporan_periode($mulai, $sampai, $number, $offset)
	{
		$this->db->where('tanggal >=', $mulai);
		$this->db->where('tanggal <=', $sampai);
        $this->db->order_by('nomor DESC');
        $query = $this->db->get('data', $number, $offset);
        return $query->result();
	}

    function row_cari($search)
    {
        $this->db->from('data');
        $this->db->or_like($search);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function cari($batas=null, $offset=null, $search=null)
    {
        $this->db->from('data');
        if($batas != null){
           $this->db->limit($batas, $offset);
        }
        if ($search != null) {
           $this->db->or_like($search);
        }
        $this->db->order_by('nomor DESC');
        $query = $this->db->get();
     
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
    function clean()
    {
        $query = $this->db->truncate('data');
        return $query;
    }
}