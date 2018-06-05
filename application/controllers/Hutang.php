<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hutang extends CI_Controller {
	public function __construct()
    {
    	parent::__construct();
    	$this->load->model('M_index');
    	$this->load->model('M_hutang');

    }
    function index()
	{
		if ($this->session->userdata('username')) {
			$total = $this->M_hutang->row_hutang();
			$config['base_url'] 		= base_url().'hutang';
			$config['total_rows'] 		= $total;
			$config['per_page'] 		= 10;
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
			$from = $this->uri->segment(3);
			$data = array(
				'halaman' 	=> $this->pagination->create_links(),
				'result' 	=> $this->M_hutang->hutang($config['per_page'], $from),
				'ttl' 		=> $this->M_hutang->total_hutang()
			);
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('hutang/hutang',$data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function hutangkeluar()
	{
		if ($this->session->userdata('username')) {
			$result = $this->M_hutang->nomor();
			if (empty($result[0]['nomor'])){
				$no = date('Ymd')."000001";
			} else {
				$no = $result[0]['nomor']+1;
			}
			$data['nomor'] = $no;
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('hutang/hutangkeluar',$data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function tambah_hutangkeluar()
	{
		if ($this->session->userdata('username')) {
			$data = array(
				'nomor'			=> $this->input->post('nomor'),
				'keterangan'	=> $this->input->post('keterangan'),
				'tanggal' 		=> $this->input->post('tanggal'),
				'jumlah' 		=> $this->input->post('jumlah'),
				'jenis' 		=> 'hutang'
			);
			$input = $this->M_hutang->tambah_hutangkeluar($data);
			if ($input){
				$this->session->set_flashdata('message', 'Data hutang berhasil ditambahkan');
				redirect(base_url('hutang'));
			}else{
				$this->session->set_flashdata('message', 'Data hutang gagal ditambahkan');
				redirect(base_url('hutang/tambah_hutangkeluar'));
			}
		}else{
			redirect(base_url());
		}
	}

	function ubah_hutangkeluar($nomor)
	{
		if ($this->session->userdata('username')) {
			$result = $this->M_index->ambil_data($nomor);
			$data = array(
				'nomor'			=> $result[0]['nomor'],
				'keterangan'	=> $result[0]['keterangan'],
				'tanggal'		=> $result[0]['tanggal'],
				'jumlah'		=> $result[0]['jumlah']
			);
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('hutang/ubah_hutangkeluar', $data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function update_hutangkeluar()
	{
		if ($this->session->userdata('username')) {
			$data = array(
				'nomor'			=> $this->input->post('nomor'),
				'keterangan'	=> $this->input->post('keterangan'),
				'tanggal' 		=> $this->input->post('tanggal'),
				'jumlah' 		=> $this->input->post('jumlah'),
				'jenis' 		=> 'hutang'
			);
			$input = $this->M_index->ubah($this->input->post('nomor'),$data);
			if ($input){
				$this->session->set_flashdata('message', 'Data hutang berhasil diubah');
				redirect(base_url('hutang'));
			}else{
				$this->session->set_flashdata('message', 'Data hutang gagal diubah');
				redirect(base_url('hutang/ubah_hutangkeluar/'.$this->input->post('nomor')));
			}
		}else{
			redirect(base_url());
		}
	}

	function hapus_hutangkeluar($nomor)
	{
		if ($this->session->userdata('username')) {
			$hapus = $this->M_index->hapus($nomor);
			if ($hapus){
				$this->session->set_flashdata('message', 'Data barhasil dihapus');
				redirect(base_url('hutang'));
			}else{
				$this->session->set_flashdata('message', 'Data gagal dihapus');
				redirect(base_url('hutang'));
			}
		}else{
			redirect(base_url());
		}
	}
}
