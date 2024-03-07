<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url()?>assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url()?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
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
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<title>Simulacrum</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

		<link href="<?php echo base_url()?>dapur0/layout/css/bulma.adv.css" rel="stylesheet">


    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="<?php echo base_url()?>assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
		<link href="<?php echo base_url()?>assets/css/paper-dashboard.css" rel="stylesheet"/>


		<link href="<?php echo base_url()?>dapur0/vendors/DataTables/datatables.css" rel="stylesheet">


    <!--  Fonts and icons     -->
		<link href="<?php echo base_url()?>dapur0/vendors/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>assets/css/themify-icons.css" rel="stylesheet">

		<link rel="stylesheet" href="<?php echo base_url()?>dapur0/vendors/animate.css/animate.css"/>
		<link rel="stylesheet" href="<?php echo base_url()?>dapur0/vendors/pace/pace.css"/>
    <script type="text/javascript">
/*
      var isCtrl = false;
      document.onkeydown = function(e) {
        if (e.which == 17)
          isCtrl = true;
        if ((e.which == 85) || (e.which == 67) && (isCtrl == true)) {
          return false;
        }
      }

          var isNS = (navigator.appName == "Netscape") ? 1 : 0;
          if (navigator.appName == "Netscape") document.captureEvents(Event.MOUSEDOWN || Event.MOUSEUP);

          function mischandler() {
            return false;
          }

          function mousehandler(e) {
            var myevent = (isNS) ? e : event;
            var eventbutton = (isNS) ? myevent.which : myevent.button;
            if ((eventbutton == 2) || (eventbutton == 3)) return false;
          }
          document.oncontextmenu = mischandler;
          document.onmousedown = mousehandler;
          document.onmouseup = mousehandler;
*/
    </script>

</head>
<body>
