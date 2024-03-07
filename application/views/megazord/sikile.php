

        <footer class="footer">
            <div class="container-fluid">
<!--                <nav class="pull-left">
                    <ul>

                        <li>
                            <a href="http://www.creative-tim.com">
                                Creative Tim
                            </a>
                        </li>
                        <li>
                            <a href="http://blog.creative-tim.com">
                               Blog
                            </a>
                        </li>
                        <li>
                            <a href="http://www.creative-tim.com/license">
                                Licenses
                            </a>
                        </li>
                    </ul>
                </nav> -->
                <div class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart heart"></i> by <a href="https://www.bumidjajamandiri.asia">CVBDM</a>
                </div>
            </div>
        </footer>

    </div>
</div>


    <!--   Core JS Files   -->
    <script src="<?php echo base_url()?>assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url()?>dapur0/layout/js/all.js"></script>
  <script src="<?php echo base_url()?>dapur0/layout/js/html2canvas.js"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="<?php echo base_url()?>assets/js/bootstrap-checkbox-radio.js"></script>

	<!--  Charts Plugin -->
<!--	<script src="<?php echo base_url()?>assets/js/chartist.min.js"></script> -->

    <!--  Notifications Plugin    -->
    <script src="<?php echo base_url()?>assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
<!--    <script type="text/javascript" src="<?php echo base_url()?>dapur0/vendors/google/js"></script> -->

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="<?php echo base_url()?>assets/js/paper-dashboard.js"></script>

	<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="<?php echo base_url()?>dapur0/layout/js/excanvas.min.js"></script>
  <script src="<?php echo base_url()?>dapur0/layout/js/base.js"></script>
<!--  <script src="<?php echo base_url()?>dapur0/echart/echarts-en.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url()?>dapur0/vendors/echart/echarts.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>dapur0/vendors/echart/echarts-gl.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>dapur0/vendors/echart/ecStat.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>dapur0/vendors/echart/extension/dataTool.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>dapur0/vendors/echart/map/js/china.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>dapur0/vendors/echart/map/js/world.js"></script>

<script type="text/javascript" src="<?php echo base_url()?>dapur0/highcharts/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>dapur0/canvg/canvg.min.js"></script>

	<script src="<?php echo base_url()?>dapur0/vendors/sweetalert/dist/sweetalert.min.js"></script>
	<script src="<?php echo base_url()?>dapur0/vendors/pace/pace.js"></script>

	<!-- Datatables -->
	<script type="text/javascript" src="<?php echo base_url()?>dapur0/vendors/DataTables/datatables.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>dapur0/vendors/DataTables/pdfmake-0.1.32/pdfmake.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>dapur0/vendors/DataTables/pdfmake-0.1.32/vfs_fonts.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>dapur0/vendors/DataTables/Responsive-2.2.1/js/dataTables.responsive.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>dapur0/vendors/DataTables/FixedHeader-3.1.3/js/dataTables.fixedHeader.js"></script>


  <script>
  var baseurl = decodeURI("<?php echo base_url();?>");
  var jhalam = "<?php echo $judul;?>";
  $(".nav li a").click(function() {
    $(this).parent().addClass('active').siblings().removeClass('active');
  });
  $("#mndash").click(function() {
    location.assign(baseurl+'data/sethal/dash');
  });
  $("#mnstat").click(function() {
    location.assign(baseurl+'data/sethal/stat');
  });
  $("#mndetstat").click(function() {
    location.assign(baseurl+'data/sethal/detstat');
  });
  $("#btnflex").on('click',function() {
    $('.sidebar').toggleClass('is-hidden');
    $('.main-panel').toggleClass('container is-fluid');
    $('#flex1').toggleClass('ti-shift-right ti-shift-left');
//    $('#btnflex').html('<i class="fas fa-arrow-right"></i><i class="fas fa-chevron-right"></i>');
  });
  </script>
  <script src="<?php echo base_url()?>dapur0/vendors/dblock/jquery.blockUI.js"></script>
  <script type="text/javascript" src="<?php echo base_url().'dapur0/layout/js/'.$sandal.'.js'?>"></script>
