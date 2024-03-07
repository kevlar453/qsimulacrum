var button = document.getElementById('mainButton');

var openForm = function() {
	var ghost = getCookie('sethost');
	var guser = getCookie('setuser');
	var gpass = getCookie('setpass');
	if(ghost!='zonk'&&guser!='zonk'){
		$.ajax({
			type: "POST",
			url: baseurl + 'oper/routekey/'+ghost+'/d',
			success: function(dec1) {
				$.ajax({
					type: "POST",
					url: baseurl + 'oper/routekey/'+guser+'/d',
					success: function(dec2) {
						$.ajax({
							type: "POST",
							url: baseurl + 'oper/routekey/'+gpass+'/d',
							success: function(dec3) {
								$('#host').val(dec1);
								$('#user').val(dec2);
								$('#pass').val(dec3);
							}
						});
					}
				});
			}
		});
	}
	button.className = 'active';
};

var checkInput = function(input) {
	if (input.value.length > 0) {
		input.className = 'active';
	} else {
		input.className = '';
	}
};

var closeForm = function(n) {
	var ihost = $('#host').val();
	var iuser = $('#user').val();
	var ipass = $('#pass').val();
	if(ihost != '' && n =='y'){
		$.blockUI({
	    message: '<img class="animated pulse infinite" src="' + decodeURI(baseurl + 'imgpdf/logoAnim.png') + '" width="100" height="auto"><h3 class="animated rubberBand infinite">Connecting to data server...</h3>'
	  });
		$.ajax({
			type: "POST",
			url: baseurl + 'oper/authenticate',
			data: jQuery.param({
				qhost: ihost,
				quser: iuser,
				qpass: ipass
			}),
			success: function(datav) {
				if(datav=='SIAP'){
					$.ajax({
						type: "POST",
						url: baseurl + 'oper/routekey/'+ihost,
						success: function(crypt1) {
							var crypthost = crypt1;
							$.ajax({
								type: "POST",
								url: baseurl + 'oper/routekey/'+iuser,
								success: function(crypt2) {
									var cryptuser = crypt2;
									$.ajax({
										type: "POST",
										url: baseurl + 'oper/routekey/'+ipass,
										success: function(crypt3) {
											var cryptpass = crypt3;
											$.ajax({
												type: "POST",
												url: baseurl + 'data/simcok',
												data: jQuery.param({
													nmcok: 'sethost',
													nlcok: crypthost
												}),
												success: function(cok1) {
													$.ajax({
														type: "POST",
														url: baseurl + 'data/simcok',
														data: jQuery.param({
															nmcok: 'setuser',
															nlcok: cryptuser
														}),
														success: function(cok2) {
															$.ajax({
																type: "POST",
																url: baseurl + 'data/simcok',
																data: jQuery.param({
																	nmcok: 'setpass',
																	nlcok: cryptpass
																}),
																success: function(cok3) {
																	$.ajax({
																		type: "POST",
																		url: baseurl + 'data/check_database',
																		success: function(cdb) {
																			button.className = '';
																			if(cdb == 'AMAN'){
																				$.unblockUI();
																				window.location.assign(baseurl+'data');
																			} else {
																				window.location.assign(baseurl+'data/kuncimon');
																			}
																		}
																	});
																}
															});
														}
													});
												}
											});
										}
									});
								}
							});
						}
					});
				}
			}
		});
	} else {
		button.className = '';
	}
};

function getCookie(name) {
	var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
	return v ? v[2] : 'zonk';
}

document.addEventListener("keyup", function(e) {
	if (e.keyCode == 27 || e.keyCode == 13) {
		closeForm();
	}
});
