<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3 col-sm-6">
				<div class="card">
					<div class="content">
						<div class="row">
							<div class="col-xs-5">
								<div class="icon-big icon-warning text-center">
									<i class="ti-world"></i>
								</div>
							</div>
							<div class="col-xs-7">
								<div class="numbers">
									<p>Total Umat</p>
									<?php echo $jtot;?>
								</div>
							</div>
						</div>
						<div class="footer">
							<hr />
							<div class="stats">
								<i class="ti-printer"></i> Cetak List
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6">
				<div class="card">
					<div class="content">
						<div class="row">
							<div class="col-xs-5">
								<div class="icon-big icon-success text-center">
									<i class="ti-user"></i>
								</div>
							</div>
							<div class="col-xs-7">
								<div class="numbers">
									<p>Laki-Laki</p>
									<?php echo $jlak;?>
								</div>
							</div>
						</div>
						<div class="footer">
							<hr />
							<div class="stats">
								<i class="ti-printer"></i> Cetak List
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6">
				<div class="card">
					<div class="content">
						<div class="row">
							<div class="col-xs-5">
								<div class="icon-big icon-info text-center">
									<i class="ti-user"></i>
								</div>
							</div>
							<div class="col-xs-7">
								<div class="numbers">
									<p>Perempuan</p>
									<?php echo $jper;?>
								</div>
							</div>
						</div>
						<div class="footer">
							<hr />
							<div class="stats">
								<i class="ti-printer"></i> Cetak List
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6">
				<div class="card">
					<div class="content">
						<div class="row">
							<div class="col-xs-5">
								<div class="icon-big icon-danger text-center">
									<i class="ti-help-alt"></i>
								</div>
							</div>
							<div class="col-xs-7">
								<div class="numbers">
									<p>Kurang Data</p>
									<?php echo $jnot;?>
								</div>
							</div>
						</div>
						<div class="footer">
							<hr />
							<div class="stats">
								<i class="ti-printer"></i> Cetak List
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<h4 class="title">Data Stasi</h4>
		<hr />
		<div class="row">
			<?php
foreach ($lstasi as $gostasi) {
    ?>
			<div class="col-lg-3 col-sm-6">
				<div class="card">
					<div class="content">
						<div class="row">
							<div class="col-xs-3">
								<div class="icon-big icon-danger text-center">
									<i class="ti-home pulse" id="ico<?php echo $gostasi['id_stasi']; ?>"></i>
								</div>
							</div>
							<div class="col-xs-8">
								<div class="numbers">
									<p>
										<?php echo $gostasi['nama_stasi']; ?>
									</p>
									<?php echo $gostasi['jumkk']; ?>
									<h6>org</h6>
								</div>
							</div>
						</div>
						<div class="footer">
							<hr />
							<div class="stats">
								<button class="btn btn-sm btn-icon btn-small btn-success" onclick="bulkCetak('sts',<?php echo $gostasi['id_stasi']; ?>)" title="CETAK"><i class="ti-printer"></i></button>
							</div>
							<div class="stats hidden pull-right" id="zip_<?php echo $gostasi['id_stasi']; ?>">
								<button class="btn btn-sm btn-icon btn-small btn-warning" title="ZIP" onclick="unduhzip(<?php echo $gostasi['id_stasi']; ?>)"><i class="ti-package icon-danger"></i></button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php
}
         ?>
		</div>

		<h4 class="title">Data Kring/Lingkungan</h4>
		<hr />
		<div class="row">
			<?php
      foreach ($lslkg as $lingku) {
          ?>
			<div class="col-lg-3 col-sm-6">
				<div class="card">
					<div class="content">
						<div class="row">
							<div class="col-xs-3">
								<div class="icon-big icon-danger text-center">
									<i class="ti-home pulse" id="ico<?php echo $lingku['id_lingkungan']; ?>"></i>
								</div>
							</div>
							<div class="col-xs-8">
								<div class="numbers">
									<p>
										<?php echo $lingku['nama_lingkungan']; ?>
									</p>
									<?php echo $lingku['jumkk']; ?>
									<h6>org</h6>
								</div>
							</div>
						</div>
						<div class="footer">
							<hr />
							<div class="stats">
								<button class="btn btn-sm btn-icon btn-small btn-success" onclick="bulkCetak('lkg',<?php echo $lingku['id_lingkungan']; ?>)" title="CETAK"><i class="ti-printer"></i></button>
							</div>
							<div class="stats hidden pull-right" id="zip_<?php echo $lingku['id_lingkungan']; ?>">
								<button class="btn btn-sm btn-icon btn-small btn-warning" title="ZIP" onclick="unduhzip(<?php echo $lingku['id_lingkungan']; ?>)"><i class="ti-package icon-danger"></i></button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php
      }
                       ?>
		</div>


		<div class="row" id="detprint">
			<div class="col-md-12 hidden" id="formcetak">
				<div class="card">
					<div class="header">
						<h4 class="title">Kartu Keluarga Terproses <span id="dlall"></span></h4>
						<p class="category">List akan hilang jika halaman ini di-refresh</p>
					</div>
					<div class="content table-responsive table-full-width">
						<table class="table table-striped" id="tbdetail">
						</table>

					</div>
				</div>
			</div>

		</div>

		<div class="row">

			<div class="col-md-12">
				<div class="card">
					<div class="header">
						<h4 class="title">Jumlah Baptisan</h4>
						<p class="category">Berdasar tahun baptis</p>
					</div>
					<div class="content">
						<div id="ggrb" class="ct-chart" style="width:100%;"></div>
						<div class="footer">
							<hr>
							<div class="stats">
								<i class="ti-reload"></i> Updated
								<?php echo date('d/m/y H:i');?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
