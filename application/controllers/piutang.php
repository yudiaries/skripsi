<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class piutang extends CI_Controller {
	public function __construct()
    {
    	parent::__construct();
    	$this->load->model('M_piutang');
    	$this->load->model('M_index');
    }
    function index()
	{
		if ($this->session->userdata('username')) {
			$total = $this->M_piutang->row_piutang();
			$config['base_url'] 		= base_url().'piutang';
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
				'result' 	=> $this->M_piutang->piutang($config['per_page'], $from),
				'ttl' 		=> $this->M_piutang->total_piutang()
			);
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('piutang/piutang',$data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function piutangmasuk()
	{
		if ($this->session->userdata('username')) {
			$result = $this->M_piutang->nomor();
			if (empty($result[0]['nomor'])){
				$no = "HL".date('Ymd')."000001";
			} else {
				$no = $result[0]['nomor']+1;
			}
			$data['nomor'] = $no;
			$this->load->view('template/header');
			$this->load->view('template/navbar');
			$this->load->view('piutang/piutangmasuk',$data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function tambah_piutangmasuk()
	{
		if ($this->session->userdata('username')) {
			$data = array(
				'nomor'			=> $this->input->post('nomor'),
				'keterangan'	=> $this->input->post('keterangan'),
				'tanggal' 		=> $this->input->post('tanggal'),
				'jumlah' 		=> $this->input->post('jumlah'),
				'jenis' 		=> 'piutang'
			);
			$input = $this->M_piutang->tambah_piutangmasuk($data);
			if ($input){
				$this->session->set_flashdata('message', 'Data piutang berhasil ditambahkan');
				redirect(base_url('piutang'));
			}else{
				$this->session->set_flashdata('message', 'Data piutang gagal ditambahkan');
				redirect(base_url('tambah_piutangmasuk'));
			}
		}else{
			redirect(base_url());
		}
	}

	function ubah_piutangmasuk($nomor)
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
			$this->load->view('piutang/ubah_piutangmasuk', $data);
			$this->load->view('template/footer');
		}else{
			redirect(base_url());
		}
	}

	function update_piutangmasuk()
	{
		if ($this->session->userdata('username')) {
			$data = array(
				'nomor'			=> $this->input->post('nomor'),
				'keterangan'	=> $this->input->post('keterangan'),
				'tanggal' 		=> $this->input->post('tanggal'),
				'jumlah' 		=> $this->input->post('jumlah'),
				'jenis' 		=> 'piutang'
			);
			$input = $this->M_index->ubah($this->input->post('nomor'),$data);
			if ($input){
				$this->session->set_flashdata('message', 'Data piutang berhasil diubah');
				redirect(base_url('piutang'));
			}else{
				$this->session->set_flashdata('message', 'Data piutang gagal diubah');
				redirect(base_url('ubah_piutangmasuk/'.$this->input->post('nomor')));
			}
		}else{
			redirect(base_url());
		}
	}

	function hapus_piutangmasuk($nomor)
	{
		if ($this->session->userdata('username')) {
			$hapus = $this->M_index->hapus($nomor);
			if ($hapus){
				$this->session->set_flashdata('message', 'Data barhasil dihapus');
				redirect(base_url('piutang'));
			}else{
				$this->session->set_flashdata('message', 'Data gagal dihapus');
				redirect(base_url('piutang'));
			}
		}else{
			redirect(base_url());
		}
	}
}
