<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct()
    {
    	parent::__construct();
    	$this->load->model('M_index');
    }

	public function index()
	{
		if ($this->session->userdata('username')) {
			redirect(base_url('home/beranda'));
		}else{
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('login');
			$this->load->view('template/footer');
		}
	}

	function login()
	{
		if ($this->session->userdata('username')) {
			redirect(base_url('home/beranda'));
		}else{
			$username 	= $this->input->post('username');
			$password 	= md5($this->input->post('password'));
			$result 	= $this->M_index->login($username,$password);
			if ($result){
				$sess = array(
				    'username'  => $result[0]['username'],
				    'name'  	=> $result[0]['name'],
				    'logged_in' => TRUE
				);
				$this->session->set_userdata($sess);
				redirect(base_url('home/beranda'));
			}else{
				$this->session->set_flashdata('message', 'Username atau password salah');
				redirect(base_url());
			}
		}
	}

	function beranda()
	{
		if ($this->session->userdata('username')) {
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('beranda');
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}
	function cari()
	{
		if ($this->session->userdata('username')) {
			$key= $this->input->get('s');
	        $page=$this->input->get('per_page');
	        $cari=array(
	            'nomor' => $key,
	            'keterangan' => $key,
	            'tanggal' => $key,
	            'jumlah' => $key,
	            'jenis' => $key,
	        );
	        $batas = 5;
	 		if(!$page){
				$offset = 0;
			}else{
				$offset = $page;
			}
			$this->load->model('M_index');
			$total = $this->M_index->row_cari($cari);
			$config['page_query_string'] = TRUE;
			$config['base_url'] = base_url().'p/cari?s='.$key;
			$config['total_rows'] = $total;
			$config['per_page'] = $batas;
			$config['uri_segment'] = $page;
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
			$data['cari'] = $key;
			$data['halaman'] = $this->pagination->create_links();
			$data['result'] = $this->M_index->cari($batas, $offset, $cari);
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('cari',$data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function bersihkan()
	{
		if ($this->session->userdata('username')) {
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('konfirmasi');
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function clean()
	{
		if ($this->session->userdata('username')) {
			$exec = $this->M_index->clean();
			if ($exec){
				$this->session->set_flashdata('message', 'Semua data berhasil dihapus');
				redirect(base_url('home'));
			}else{
				$this->session->set_flashdata('message', 'Semua data gagal dihapus');
				redirect(base_url('home/bersihkan'));
			}
		}else{
			redirect(base_url());
		}
	}

	function logout()
	{
		session_destroy();
		redirect(base_url());
	}
}
