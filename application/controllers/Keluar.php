<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keluar extends CI_Controller {
	public function __construct()
    {
    	parent::__construct();
    	$this->load->model('M_index');
    	$this->load->model('M_keluar');

    }
    function index()
	{
		if ($this->session->userdata('username')) {
			$total = $this->M_keluar->row_keluar();
			$config['base_url'] 		= base_url().'keluar';
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
				'result' 	=> $this->M_keluar->keluar($config['per_page'], $from),
				'ttl' 		=> $this->M_keluar->total_keluar()
			);
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('keluar/keluar',$data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function pengeluaran()
	{
		if ($this->session->userdata('username')) {
			$result = $this->M_keluar->nomor();
			if (empty($result[0]['nomor'])){
				$no = date('Ymd')."000001";
			} else {
				$no = $result[0]['nomor']+1;
			}
			$data['nomor'] = $no;
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('keluar/pengeluaran',$data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function tambah_pengeluaran()
	{
		if ($this->session->userdata('username')) {
			$data = array(
				'nomor'			=> $this->input->post('nomor'),
				'keterangan'	=> $this->input->post('keterangan'),
				'tanggal' 		=> $this->input->post('tanggal'),
				'jumlah' 		=> $this->input->post('jumlah'),
				'jenis' 		=> 'keluar'
			);
			$input = $this->M_keluar->tambah_pengeluaran($data);
			if ($input){
				$this->session->set_flashdata('message', 'Data pengeluaran berhasil ditambahkan');
				redirect(base_url('keluar'));
			}else{
				$this->session->set_flashdata('message', 'Data pengeluaran gagal ditambahkan');
				redirect(base_url('keluar/tambah_pengeluaran'));
			}
		}else{
			redirect(base_url());
		}
	}

	function ubah_pengeluaran($nomor)
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
			$this->load->view('keluar/ubah_pengeluaran', $data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function update_pengeluaran()
	{
		if ($this->session->userdata('username')) {
			$data = array(
				'nomor'			=> $this->input->post('nomor'),
				'keterangan'	=> $this->input->post('keterangan'),
				'tanggal' 		=> $this->input->post('tanggal'),
				'jumlah' 		=> $this->input->post('jumlah'),
				'jenis' 		=> 'keluar'
			);
			$input = $this->M_index->ubah($this->input->post('nomor'),$data);
			if ($input){
				$this->session->set_flashdata('message', 'Data pengeluaran berhasil diubah');
				redirect(base_url('keluar'));
			}else{
				$this->session->set_flashdata('message', 'Data pengeluaran gagal diubah');
				redirect(base_url('keluar/ubah_pengeluaran/'.$this->input->post('nomor')));
			}
		}else{
			redirect(base_url());
		}
	}

	function hapus_pengeluaran($nomor)
	{
		if ($this->session->userdata('username')) {
			$hapus = $this->M_index->hapus($nomor);
			if ($hapus){
				$this->session->set_flashdata('message', 'Data barhasil dihapus');
				redirect(base_url('keluar'));
			}else{
				$this->session->set_flashdata('message', 'Data gagal dihapus');
				redirect(base_url('keluar'));
			}
		}else{
			redirect(base_url());
		}
	}
}
