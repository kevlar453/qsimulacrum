<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");
?>
<html>
<head>
  <title>Simulacrum</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url()?>dapur0/layout/img/ico/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url()?>dapur0/layout/img/ico/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url()?>dapur0/layout/img/ico/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url()?>dapur0/layout/img/ico/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url()?>dapur0/layout/img/ico/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url()?>dapur0/layout/img/ico/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url()?>dapur0/layout/img/ico/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url()?>dapur0/layout/img/ico/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url()?>dapur0/layout/img/ico/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url()?>dapur0/layout/img/ico/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url()?>dapur0/layout/img/ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url()?>dapur0/layout/img/ico/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url()?>dapur0/layout/img/ico/favicon-16x16.png">
    <link rel="manifest" href="<?php echo base_url()?>dapur0/layout/img/ico/manifest.json">

    <!-- Bootstrap core CSS     -->

    <link href="<?php echo base_url()?>dapur0/vendors/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>assets/css/themify-icons.css" rel="stylesheet">
    <link href="<?php echo base_url()?>dapur0/layout/css/mlebet.css" rel="stylesheet" />
    <!-- Animation library for notifications   -->
    <link href="<?php echo base_url()?>assets/css/animate.min.css" rel="stylesheet"/>
</head>
<body>
  <div id='stars'></div>
<div id='stars2'></div>
<div id='stars3'></div>
<div id='title'>
  <center><span>
    SIMULACRUM
  </span></center>
</div>
<!--  <link href='https://fonts.googleapis.com/css?family=Raleway:400,500,300' rel='stylesheet' type='text/css'> -->
  <div id="mainButton">
  	<div class="btn-text" onclick="openForm()"><center><img src="<?php echo base_url().'dapur0/layout/img/QL001.png'?>"></center></div>
  	<div class="modal">
  		<div class="close-button" onclick="closeForm('x')"><i class="ti-close"></i></div>
  		<div class="form-title">Target Server</div>
  		<div class="input-group">
  			<input type="text" id="host" onblur="checkInput(this)" />
  			<label for="name">Hostname</label>
  		</div>
      <div class="input-group">
  			<input type="text" id="user" onblur="checkInput(this)" />
  			<label for="user">User</label>
  		</div>
      <div class="input-group">
  			<input type="password" id="pass" onblur="checkInput(this)" />
  			<label for="password">Password</label>
  		</div>
  		<div class="form-button" onclick="closeForm('y')">Sambung</div>
  		<div class="codepen-by">Powered by CVBDM</div>
  	</div>
  </div>
  <div class="codepen-by">Powered by CVBDM</div>

  <script src="<?php echo base_url()?>assets/js/jquery.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url()?>dapur0/vendors/dblock/jquery.blockUI.js"></script>

  <script>
  var baseurl = decodeURI("<?php echo base_url();?>");
  </script>
  <script type="text/javascript" src="<?php echo base_url()?>dapur0/layout/js/mlebet.js"></script>
</body>
</html>
