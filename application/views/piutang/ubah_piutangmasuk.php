
<p><a href="<?=base_url('piutang');?>"><button type="button" class="btn btn-primary">Kembali ke Daftar Pepiutangan</button></a></p>
<h4>Ubah data Piutang</h4>
<?php if ($this->session->flashdata('message')) { ?>
	<div class="alert alert-dismissible alert-danger">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p class="mb-0"><?php echo $this->session->flashdata('message');?></p>
	</div>
<?php } ?>
<form action="<?=base_url('piutang/update_piutangmasuk');?>" method="POST">
	<div class="form-group">
		<label class="col-form-label" for="nomor">Nomor</label>
		<input type="number" class="form-control" name="nomor" id="nomor" value="<?=$nomor;?>" readonly="">
	</div>
	<div class="form-group">
		<label class="col-form-label" for="keterangan">Keterangan</label>
		<textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" required=""><?=$keterangan;?></textarea>
	</div>
	<div class="form-group">
		<label class="col-form-label" for="tanggal">Tanggal</label>
		<input type="text" class="form-control" name="tanggal" id="tanggal" placeholder="YYYY/MM/DD" value="<?=$tanggal;?>" required="">
	</div>
	<div class="form-group">
		<label class="col-form-label" for="jumlah">Jumlah</label>
		<input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?=$jumlah;?>" required="">
	</div>
	<button type="submit" class="btn btn-primary">Simpan</button>
</form>
<br />
