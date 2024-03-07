<?php
$this->load->view('megazord/ndase');
$this->load->view('megazord/gulune');

if($mnv[0]=='active'){
	$this->load->view('megazord/bd_dashboard');
	$subdata = array('sandal'=>'sandal1');
}
if($mnv[1]=='active'){
	$this->load->view('megazord/bd_stats');
	$subdata = array('sandal'=>'sandal1');
}
if($mnv[2]=='active'){
	$this->load->view('megazord/bd_kategori');
	$subdata = array('sandal'=>'sandal2');
}
$this->load->view('megazord/sikile',$subdata);
?>
<script type="application/javascript">
	$(document).ready(function() {
		var baseurl = decodeURI("<?php echo base_url();?>");
		var time1;
		var time3;
		window.onload = resetTimer;
		// DOM Events
		document.onmousemove = resetTimer;
		document.onkeypress = resetTimer;

		function logout() {
//				document.getElementById("myNav").style.width = "100%";
window.location.assign(baseurl+'oper/logout');
		}

		function resetTimer() {
//			document.getElementById("myNav").style.width = "0%";
			clearTimeout(time3);
			time3 = setTimeout(logout, 600000)
			// 1000 milliseconds = 1 second
		}
	});
</script>
</body>
</html>
