<div class="content">
    <div class="container-fluid" style="height: 100%; margin: 0">

      <div class="row">
        <div class="box col-md-12">
          <div class="col-lg-6 col-sm-12">
            <div class="field">
              <div class="control">
                <div class="select is-large is-fullwidth">
                  <select id="selkategori0">
                    <option value="kategori0">Jumlah Umat Berdasarkan Jenis Kelamin</option>
                    <option value="kategori1">Jumlah Umat Berdasarkan Status</option>
                    <option value="kategori2">Jumlah KK per Stasi</option>
                    <option value="kategori3">Jumlah KK per Lingkungan</option>
                    <option value="kategori4">Jumlah Perkawinan per Tahun</option>
                    <option value="kategori5">Jumlah Baptis per Stasi</option>
                    <option value="kategori6">Jumlah Krisman per Stasi</option>
                    <option value="kategori7">Jumlah Komuni per Stasi</option>
                    <option value="kategori8">Jumlah Kematian</option>
                    <option value="kategori9">Jumlah Pekerjaan Umat</option>
                    <option value="kategori10">Jumlah Pendidikan Umat</option>
                    <option value="kategori11">Jumlah Agama</option>
                    <option value="kategori12">Jumlah Perkawinan per Stasi</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-sm-12">
            <div class="field has-addons">
              <div class="control">
                <input class="input is-large" type="text" placeholder="Tahun Awal" id="selkategori1" value=2000>
              </div>
              <p class="control">
                <a class="button is-static is-large">
                  s/d
                </a>
              </p>

              <div class="control">
                <input class="input is-large" type="text" placeholder="Tahun Akhir" id="selkategori2" value=2020>
              </div>
              <div class="control">
                <a class="button is-info is-large" id="btnsel">
                  Saring
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

<!--        <div class="row">
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
                                    <span id="jtotal">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr />
                            <div class="stats">
                              <button class="btn btn-sm btn-icon btn-small btn-info" onclick="lstData('total')" title="DETAIL"><i class="ti-eye"></i></button>
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
                                    <p>Baptis</p>
                                    <span id="jbaptis">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr />
                            <div class="stats">
                              <button class="btn btn-sm btn-icon btn-small btn-info" onclick="lstData('baptis')" title="DETAIL"><i class="ti-eye"></i></button>
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
                                    <p>Meninggal</p>
                                    <span id="jmati">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr />
                            <div class="stats">
                              <button class="btn btn-sm btn-icon btn-small btn-info" onclick="lstData('umur')" title="DETAIL"><i class="ti-eye"></i></button>
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
        </div> -->

        <div class="row hidden" id="detprint">
          <hr />
            <div class="col-md-12" id="formcetak">
                <div class="card">
                    <div class="header">
                        <h4 class="title" id="jdlData"><span id="dlall"></span></h4>
                        <p class="category" id="subData"></p>
                    </div>
                    <div class="content table-responsive table-full-width">
                      <div class="table-container">
                        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth nowrap" id="tbdetail">
                        </table>
                      </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
