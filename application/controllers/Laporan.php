<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
	public function __construct()
    {
    	parent::__construct();
    	$this->load->model('M_index');
    	$this->load->model('M_masuk');
    	$this->load->model('M_keluar');
    }
    function index()
	{
		if ($this->session->userdata('username')) {
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('laporan/laporan');
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function laporan_harian()
	{
		if ($this->session->userdata('username')) {
			if (!$this->uri->segment(3)){
				$cek = $this->input->post('tanggal');
			}else{
				$cek = $this->uri->segment(3);
			}
			$tgl_uri = str_replace('/','-',$cek);
			$tgldb = str_replace('-', '/', $cek);
			$total = $this->M_index->row_harian($tgldb);
			$config['base_url'] 		= base_url().'laporan/laporan_harian/'.$tgl_uri;
			$config['total_rows'] 		= $total;
			$config['per_page'] 		= 5;
	        $config['full_tag_open']    = '<div><ul class="pagination">';
	        $config['full_tag_close']   = '</ul></div>';
        	$config['first_link']       = '<li class="page-item page-link">Awal</li>';
        	$config['last_link']        = '<li class="page-item page-link">Akhir</li>';
	        $config['prev_link']        = '&laquo';
	        $config['prev_tag_open']    = '<li class="page-item page-link">';
	        $config['prev_tag_close']   = '</li>';
	        $config['next_link']        = '&raquo';
	        $config['next_tag_open']    = '<li class="page-item page-link">';
	        $config['next_tag_close']   = '</li>';
	        $config['cur_tag_open']     = '<li class="page-item page-link">';
	        $config['cur_tag_close']    = '</li>';
	        $config['num_tag_open']     = '<li class="page-item page-link">';
	        $config['num_tag_close']    = '</li>';
			$this->pagination->initialize($config);
			$from = $this->uri->segment(4);
			$data = array(
				'tanggal' 		=> $tgldb,
				'ttl_masuk'		=> $this->M_masuk->total_harian_masuk($tgldb),
				'ttl_keluar'	=> $this->M_keluar->total_harian_keluar($tgldb),
				'halaman' 		=> $this->pagination->create_links(),
				'result' 		=> $this->M_index->laporan_harian($tgldb,$config['per_page'], $from)
			);
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('laporan/laporan_harian',$data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function laporan_periode()
	{
		if ($this->session->userdata('username')) {
			if (!$this->uri->segment(3) && !$this->uri->segment(4)){
				$tgl_mulai = str_replace('/','-',$this->input->post('tgl_mulai'));
				$tgl_sampai = str_replace('/','-',$this->input->post('tgl_sampai'));
			}else{
				$tgl_mulai = $this->uri->segment(3);
				$tgl_sampai = $this->uri->segment(4);
			}
			$tgl_mulai_db = str_replace('-','/',$tgl_mulai);
			$tgl_sampai_db = str_replace('-','/',$tgl_sampai);
			$total = $this->M_index->row_periode($tgl_mulai_db, $tgl_sampai_db);
			$config['base_url'] 		= base_url().'laporan/laporan_periode/'.$tgl_mulai.'/'.$tgl_sampai;
			$config['total_rows'] 		= $total;
			$config['per_page'] 		= 5;
	        $config['full_tag_open']    = '<div><ul class="pagination">';
	        $config['full_tag_close']   = '</ul></div>';
        	$config['first_link']       = '<li class="page-item page-link">Awal</li>';
        	$config['last_link']        = '<li class="page-item page-link">Akhir</li>';
	        $config['prev_link']        = '&laquo';
	        $config['prev_tag_open']    = '<li class="page-item page-link">';
	        $config['prev_tag_close']   = '</li>';
	        $config['next_link']        = '&raquo';
	        $config['next_tag_open']    = '<li class="page-item page-link">';
	        $config['next_tag_close']   = '</li>';
	        $config['cur_tag_open']     = '<li class="page-item page-link">';
	        $config['cur_tag_close']    = '</li>';
	        $config['num_tag_open']     = '<li class="page-item page-link">';
	        $config['num_tag_close']    = '</li>';
			$this->pagination->initialize($config);
			$from = $this->uri->segment(5);
			$data = array(
				'tgl_mulai' 	=> $tgl_mulai_db,
				'tgl_sampai'	=> $tgl_sampai_db,
				'ttl_masuk'		=> $this->M_masuk->total_periode_masuk($tgl_mulai,$tgl_sampai),
				'ttl_keluar'	=> $this->M_keluar->total_periode_keluar($tgl_mulai,$tgl_sampai),
				'halaman' 		=> $this->pagination->create_links(),
				'result' 		=> $this->M_index->laporan_periode($tgl_mulai_db, $tgl_sampai_db, $config['per_page'], $from)
			);
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('laporan/laporan_periode',$data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}
}
