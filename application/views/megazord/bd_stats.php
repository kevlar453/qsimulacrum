<div class="content">
    <div class="container-fluid" style="height: 100%; margin: 0">

      <div class="row" id="grmain">

          <div class="col-md-12">
              <div class="card">
                  <div class="header">
                      <h4 class="title">Total Umat, Baptis, dan Kematian per Stasi</h4>
                      <p class="category">Data yang ditampilkan hanya data yang lengkap</p>
                  </div>
                  <div class="content">
                    <div id="gstat" class="ct-chart" style="width:100%;"></div>
                      <div class="footer">
                          <hr>
                          <div class="stats">
                              <i class="ti-reload"></i> Updated <?php echo date('d/m/y H:i');?>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

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
                              <button class="btn btn-sm btn-icon btn-small btn-info" onclick="lstData('meninggal')" title="DETAIL"><i class="ti-eye"></i></button>
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

        <div class="row" id="detprint">
            <div class="col-md-12" id="formcetak">
                <div class="card">
                    <div class="header">
                        <h4 class="title" id="jdlData"><span id="dlall"></span></h4>
                        <p class="category" id="subData"></p>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-striped" id="tbdetail">
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
