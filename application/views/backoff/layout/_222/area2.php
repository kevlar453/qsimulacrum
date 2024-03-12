<!-- page content -->
<div class="right_col" role="main">

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
          <h2>Daftar Jurnal</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li id="tgexp"><button type="button" class="btn btn-sm btn-warning" onclick="exfile()" title="Ambil"><i class="glyphicon glyphicon-save"></i></button></li>
            <li id="tgimp"><button type="button" class="btn btn-sm btn-info" onclick="imfile()" title="Kirim"><i class="glyphicon glyphicon-open"></i></button></li>
            <li><button type="button" class="btn btn-sm btn-success" onclick="table.destroy();fillgrid('');" title="Reset"><i class="glyphicon glyphicon-refresh"></i></button></li>
              <li><button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target=".impjurnal" title="Import Excel"><i class="glyphicon glyphicon-open-file"></i></button></li>
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              <li><a title="Bantuan" onclick="obantuan();"><i class="fa fa-question"></i></a></li>
          </ul>
          <div class="clearfix"></div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_content panatas">
          <div class="col-md-6 col-sm-12 col-xs-12">
            <h2>Isi Jurnal</h2>
            <div class="clearfix"></div>
            <div class="container cropper">
                    <?php
                        echo form_open('markas/core1/akharian/area2',array('id'=>'transaksi','data-parsley-validate class'=>'form-horizontal form-label-left'));
                        ?>
                          <div class="col-md-6 col-sm-12 col-xs-12">
                            <?php
                                echo form_error('fj_jns');
                                echo form_label('NO.JURNAL','fj_jns',array('class'=>'input-group'));
                                echo form_input(array('id' => 'fj_nomor', 'name' => 'fj_nomor','class'=>'form-control','onblur'=>'prosescari(this.value);','onkeyup'=>'this.value = this.value.toUpperCase();', 'data-inputmask'=>'\'mask\': \'***.**.***\'','required'=>'required','readonly'=>'readonly','data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Otomatis terisi'));
                                ?>
                              </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                <?php
                                echo form_label('TGL','fj_tgl',array('class'=>'input-group'));

                            ?>
                                <input id="fj_tgl" name="fj_tgl" placeholder="HH/BB/TTTT" class="form-control datepicker" type="text" data-toggle="tooltip" data-placement="top" title="Tgl transaksi terjadi/Tgl NOTA" value="<?php echo date(" d-m-Y ",now());?>">
                                <input id="fj_sts" name="fj_sts" type="hidden" value="0">
                                <input id="fj_akses" name="fj_akses" type="hidden" value="<?php echo $akses; ?>">
                              </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <?php
                                echo form_label('JURNAL','fj_noacc',array('class'=>'input-group')); ?>
                                <?php echo form_error('fj_noacc');
                                echo form_dropdown('fj_jenis', $jjenis, '#', 'id="fj_jenis" class="form-control" style="float: left;"  data-toggle="tooltip" data-placement="top" title="Pilih Jns Buku/Jns Jurnal"');
                                ?>
                              </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                                <?php
                                echo form_label('TRANSAKSI','fj_jnsjur',array('class'=>'input-group'));
                                echo form_dropdown('ft_jnsjur', array('X' => 'Pilih','M' => 'Masuk','K' => 'Keluar'), 'X', 'id="ft_jnsjur" class="form-control" data-toggle="tooltip" data-placement="top" title="Transaksi Keluar/Masuk"');
                            ?>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php
                                echo form_label('KETERANGAN','fj_ket',array('class'=>'input-group')); ?>
                                <?php echo form_error('fj_ket');
                                echo form_input(array('id' => 'fj_ket', 'name' => 'fj_ket','class'=>'form-control' ,'placeholder' => 'Keterangan (harus diisi)', 'data-parsley-length' =>'[2, 50]','required'=>'required','data-toggle'=>'tooltip','data-placement'=>'bottom','title'=>'Keterangan transaksi'));
                            ?>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <hr/>
                            <input type="submit" class="btn btn-success" id="exampleInputPassword2" value="TAMBAH">
                        </div>
                        <?php
                        echo form_close();
                        ?>
                </div>

    </div>

    <div class="col-md-6 col-sm-12 col-xs-12">
      <h2>Post Masal</h2>
      <div class="clearfix"></div>
                <div class="container cropper">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <hr/>
                      <div class="lapdetail">
                        <div id="buttable" style="width:100%;"></div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="container cropper">
                        <table id="tfillgrid" class="display table-compact table-striped table-hover table-responsive table-full-width nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>No.Jurnal</th>
                                    <th>Keterangan</th>
                                    <th>Selisih</th>
                                    <th>Jml. Trx</th>
                                    <th><span class="opta2">Post</span></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>No.Jurnal</th>
                                    <th>Keterangan</th>
                                    <th>Selisih</th>
                                    <th>Jml. Trx</th>
                                    <th><span class="opta2">Post</span></th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--/row-->
    </div>
</div>
<!-- /page content -->

<div class="modal fade mdisikode" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="tutupmodal" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="modalInfo">Kirim/Terima Data</h4>
            </div>
            <div class="modal-body">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <button type="button" class="btn btn-info" name="button" onclick="exfile()">Backup</button>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <form action="<?php echo base_url();?>markas/proeksternal/prosesimj001" id="impqbk" method="post" enctype="multipart/form-data">
                  <input type="file" name="fileqbk" id="fileqbk" />
                  <input type="submit" class="btn btn-warning" value="Restore" id="kirimqbk" />
                </form>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="modal fade impjurnal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="modalInfo">Import Jurnal</h4>
            </div>
            <div class="modal-body">
                <p>
                    <h3>Aturan Penggunaan:</h3>
                    <ol>
                        <li>Buat file excel dengan format yang telah ditentukan atau unduh dari sini (<a href="<?php echo base_url().'dapur0/semstorage/blankqhmsjurnal.xls'?>" class="animated infinite pulse green" title="Contoh Format Jurnal">berkas kosong</a>)</li>
                        <li>JenJurnal adalah jenis jurnal. Diisi dengan kode saja
                          <div id="cekisijur"></div>
                        </li>
                        <li>TglJurnal diisi dengan format TTTT-BB-HH (mis: 2018-04-24)</li>
                        <li>Pastikan file excel tetap menggunakan bentuk <strong>xls</strong> atau Excel-2003, jangan dirubah menjadi <strong>xlsx</strong> atau Excel-2007</li>
                        <li>Selebihnya sesuaikan dengan contoh</li>
                    </ol>
                </p>

                <form action="<?php echo base_url();?>markas/proeksternal/proses/" id="impexcel" method="post" enctype="multipart/form-data">
                    <input type="file" name="file" id="isiexcel" />
                    <div id="upexcelprog" class="hidden"><img src="<?php echo base_url().'dapur0/images/loader2.gif'?>" /> <span class="animated infinite flash">Menkonversi berkas.....</span></div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-info" value="Unggah Berkas" id="kirimexcel" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
