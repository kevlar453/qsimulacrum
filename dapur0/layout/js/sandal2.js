$(document).ready(function() {
	cekdb();

	// Add smooth scrolling to all links
	$('a[href*="#"]')
		// Remove links that don't actually link to anything
		.not('[href="#"]')
		.not('[href="#0"]')
		.click(function(event) {
			// On-page links
			if (
				location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
				location.hostname == this.hostname
			) {
				// Figure out element to scroll to
				var target = $(this.hash);
				target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
				// Does a scroll target exist?
				if (target.length) {
					// Only prevent default if animation is actually gonna happen
					event.preventDefault();
					$('html, body').animate({
						scrollTop: target.offset().top
					}, 1000, function() {
						// Callback after animation
						// Must change focus!
						var $target = $(target);
						$target.focus();
						if ($target.is(":focus")) { // Checking if the target was focused
							return false;
						} else {
							$target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
							$target.focus(); // Set focus again
						};
					});
				}
			}
		});

	/*
	$.notify({
		icon: 'ti-comments-smiley',
		message: "Masih dalam tahap <b>PENGEMBANGAN</b> - untuk Paroki St. Yosef Meraban."

	}, {
		type: 'success',
		timer: 2000
	});
		cekzip();
		switch (jhalam.toLowerCase()) {
			case 'detail':
			case 'statistik':
				tampilgrap('gstat');
				break;
			default:
				tampilgrap('ggrb');
		}
	*/

});

$('#btnsel').on('click', function() {
	var katvar0 = $('#selkategori0').val();
	var katvar1 = $('#selkategori1').val();
	var katvar2 = $('#selkategori2').val();
	if ((katvar1 != '') && (katvar2 != '')) {
		if (parseInt(katvar2) >= parseInt(katvar1)) {
			if(parseInt(katvar0.substr(-2).replace(/[A-Za-z+#,]/g, '')) < 8){
				$('#detprint').removeClass('hidden');
				lstData(katvar0, katvar1, katvar2);
			} else {
				$.notify({
			    icon: 'ti-info-alt',
			    message: "Mohon maaf!!! Fitur ini masih dalam pengembangan."

			  }, {
			    type: 'info',
			    timer: 2000
			  });
			}
		} else {
			$.notify({
				icon: 'ti-info-alt',
				message: "Tahun Awal harus <strong>LEBIH KECIL</strong> dari Tahun Akhir."

			}, {
				type: 'warning',
				timer: 2000
			});
		}
	}
});

function cekvalid(jkateg){
	$.ajax({
		type: "POST",
		url: baseurl + 'data/check_valid',
		data: jQuery.param({
			goparam: jkateg.substr(-2).replace(/[A-Za-z+#,]/g, '')
		}),
		success: function(datav) {

			if(datav.length > 0){
				$.notify({
			    icon: 'ti-info-alt',
			    message: datav

			  }, {
			    type: 'info',
			    timer: 2000
			  });
			}

		}
	});
}

function lstData(varData, varPar1, varPar2) {
	$.blockUI({
		message: '<img class="animated pulse infinite" src="' + decodeURI(baseurl + 'imgpdf/logoAnim.png') + '" width="100" height="auto"><h3 class="animated rubberBand infinite">Menjalankan Proses</h3>'
	});
	var tableObj;
	var setJen = varData;
	var tableId = "#tbdetail";
	var myEle = document.getElementById("gambare");

	var bsts;
	var setkolom = [];
	switch (varData.substr(-1)) {
		case '8':
			var jdlChart = 'KEMATIAN';
			var jdlFile = 'Kematian';
			setkolom = [{
					title: "Tahun"
				},
				{
					title: "Jumlah"
				}
			];
			var settarget1 = [1];
			var setkategoris = ['Jumlah'];
			break;
		case '7':
			var jdlChart = 'KOMUNI PER STASI';
			var jdlFile = 'Komuni_Per_Stasi';
			setkolom = [{
					title: "STASI"
				},
				{
					title: "Jumlah"
				}
			];
			var settarget1 = [1];
			var setkategoris = ['Jumlah'];
			break;
		case '6':
			var jdlChart = 'KRISMA PER STASI';
			var jdlFile = 'Krisma_Per_Stasi';
			setkolom = [{
					title: "STASI"
				},
				{
					title: "Jumlah"
				}
			];
			var settarget1 = [1];
			var setkategoris = ['Jumlah'];
			break;
		case '5':
			var jdlChart = 'BAPTIS PER STASI';
			var jdlFile = 'Baptis_Per_Stasi';
			setkolom = [{
					title: "STASI"
				},
				{
					title: "Jumlah"
				}
			];
			var settarget1 = [1];
			var setkategoris = ['Jumlah'];
			break;
		case '4':
			var jdlChart = 'PERKAWINAN';
			var jdlFile = 'PERKAWINAN';
			setkolom = [{
					title: "Tahun"
				},
				{
					title: "Jumlah"
				}
			];
			var settarget1 = [1];
			var setkategoris = ['Jumlah'];
			break;
		case '3':
			var jdlChart = 'KK PER LINGKUNGAN';
			var jdlFile = 'KK_PER_LINGKUNGAN';
			setkolom = [{
					title: "Lingkungan"
				},
				{
					title: "Jumlah"
				}
			];
			var settarget1 = [1];
			var setkategoris = ['Jum.KK'];
			break;
		case '2':
			var jdlChart = 'KK PER STASI';
			var jdlFile = 'KK_PER_STASI';
			setkolom = [{
					title: "Stasi"
				},
				{
					title: "Jumlah"
				}
			];
			var settarget1 = [1];
			var setkategoris = ['Jum.KK'];
			break;
		case '1':
			var jdlChart = 'Status';
			var jdlFile = 'Status';
			setkolom = [{
					title: "Stasi"
				},
				{
					title: "Jenis<br>\nKelamin"
				},
				{
					title: "Tidak<br>\nTeridentifikasi"
				},
				{
					title: "Aktif"
				},
				{
					title: "Pindah<br>\nDomisili"
				},
				{
					title: "Pindah<br>\nAgama"
				},
				{
					title: "Meninggal"
				},
				{
					title: "Hapus"
				},
				{
					title: "Sub<br>\nTotal"
				}
			];
			var settarget1 = [2, 3, 4, 5, 6, 7, 8];
			var setkategoris = ['???', 'Aktif', 'P.Domisili', 'P.Agama', 'Meninggal', 'Hapus'];
			break;
		default:
			var jdlChart = 'Jns Kelamin';
			var jdlFile = 'Jns_Kelamin';
			setkolom = [{
					title: "Stasi"
				},
				{
					title: "Jenis<br>\nKelamin"
				},
				{
					title: "Tidak<br>\nTeridentifikasi"
				},
				{
					title: "Balita<br>\n(0 - 5)"
				},
				{
					title: "Kanak-kanak<br>\n(6 - 11)"
				},
				{
					title: "Pra Remaja<br>\n(12 - 16)"
				},
				{
					title: "Remaja<br>\n(17 - 25)"
				},
				{
					title: "Dewasa Awal<br>\n(26 - 35)"
				},
				{
					title: "Dewasa Akhir<br>\n(36 - 45)"
				},
				{
					title: "Lansia Awal<br>\n(46 - 55)"
				},
				{
					title: "Lansia Akhir<br>\n(56 - 65)"
				},
				{
					title: "Manula<br>\n(>66)"
				},
				{
					title: "Sub<br>\nTotal"
				}
			];
			var settarget1 = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
			var setkategoris = ['0-5', '6-11', '12-16', '17-25', '26-35', '36-45', '46-55', '56-65', '>66'];
	}
	//alert(JSON.stringify(setkolom));
	$.ajax({
		type: "POST",
		url: baseurl + 'data/ambilstasi/',
		data: {
			setkat: varData,
			setct1: varPar1,
			setct2: varPar2,
		},
		success: function(getstasi) {
			bsts = getstasi;
			var z = 0;
			var jsts = bsts.length;
			if (jsts > 0) {
				if ($.fn.DataTable.isDataTable(tableId)) {
					$(tableId).DataTable().clear().destroy();
					$(tableId).remove();
					$('.table-container').html('<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth nowrap" id="tbdetail"></table>');
				}
				if (myEle) {
					$('#gambare').remove();
				}
				$.ajax({
					type: "POST",
					url: baseurl + 'data/umurstasi/',
					data: {
						setkat: varData,
						setct1: varPar1,
						setct2: varPar2,
					},
					success: function(lststasi) {

						var AmbilData = JSON.parse(lststasi);
						var i = 0;
						var jsupp = AmbilData.length;
						if (jsupp > 0) {
							$('#grmain').css('display', 'none');
							var logoY;
							var img;
							$.ajax({
								type: "POST",
								url: baseurl + 'data/gonampat/',
								data: {
									gbr: 'imgpdf/logoAnim.png'
								},
								success: function(dec3) {

									logoY = 'data:image/jpg;base64,' + dec3;

									var setdatatb = [];
									switch (varData.substr(-1)) {
										case '8':
										case '7':
										case '6':
										case '5':
										case '4':
										case '3':
										case '2':
											for (i = 0; i <= jsupp - 1; i++) {
												setdatatb[i] = new Array(AmbilData[i].stsnm, AmbilData[i].stsjum);
											}
											break;
										case '1':
											for (i = 0; i <= jsupp - 1; i++) {
												setdatatb[i] = new Array(AmbilData[i].stsnm, AmbilData[i].stsjk, AmbilData[i].stsmr0, AmbilData[i].stsmr1, AmbilData[i].stsmr2, AmbilData[i].stsmr3, AmbilData[i].stsmr4, AmbilData[i].stsmr5, AmbilData[i].stsjum);
											}
											break;
										default:
											for (i = 0; i <= jsupp - 1; i++) {
												setdatatb[i] = new Array(AmbilData[i].stsnm, AmbilData[i].stsjk, AmbilData[i].stsmr0, AmbilData[i].stsmr1, AmbilData[i].stsmr2, AmbilData[i].stsmr3, AmbilData[i].stsmr4, AmbilData[i].stsmr5, AmbilData[i].stsmr6, AmbilData[i].stsmr7, AmbilData[i].stsmr8, AmbilData[i].stsmr9, AmbilData[i].stsjum);
											}

									}
									tableObj = $(tableId).DataTable({
										data: setdatatb,
										lengthMenu: [
											[25, 50, 100, -1],
											[25, 50, 100, "All"]
										],
										paging: false,
										destroy: true,
										responsive: false,
										autowidth: true,
										language: {
											"decimal": ",",
											"emptyTable": "Belum ada data",
											"info": "Data ke _START_ s/d _END_ dari _TOTAL_ data",
											"infoEmpty": "Data ke 0 s/d 0 dari 0 data",
											"infoFiltered": "(Disaring dari _MAX_ data)",
											"infoPostFix": "",
											"thousands": ".",
											"lengthMenu": "Tampilkan _MENU_ data",
											"loadingRecords": "Memuat...",
											"search": "Cari:",
											"zeroRecords": "Tidak ada data yang cocok",
											"paginate": {
												"first": "Awal",
												"last": "Akhir",
												"next": "<i class='fa fa-chevron-circle-right'></i>",
												"previous": "<i class='fa fa-chevron-circle-left'></i>"
											},
											"aria": {
												"sortAscending": ": activate to sort column ascending",
												"sortDescending": ": activate to sort column descending"
											}
										},
										processing: true,
										order: [],
										dom: '<"well col-md-12 col-sm-12 col-xs-12"<"col-md-6 col-sm-6 col-xs-6"><"col-md-6 col-sm-6 col-xs-6"B>>t<"col-md-12 col-sm-12 col-xs-12"<"col-md-6 col-sm-6 col-xs-6"i><"col-md-6 col-sm-6 col-xs-6"p>>',
										buttons: [{
												"extend": 'print',
												"text": '<i class="ti-printer"></i>',
												"message": 'Data Umat',
												"customize": function(win) {
													$(win.document.body).find('table').addClass('display').css('font-size', '12px');
													$(win.document.body).find('tr:nth-child(odd) td').each(function(index) {
														$(this).css('background-color', '#e2e2e2');
													});
													$(win.document.body).find('h1').css('text-align', 'center');
												},
												"exportOptions": {
													columns: ':visible'
												}
											},
											{
												text: '<i class="fa fa-file-pdf"></i>',
												extend: 'pdfHtml5',
												filename: jdlFile + '_' + (Math.floor(Math.random() * 16777215).toString(16)),
												orientation: 'portrait',
												pageSize: 'A4',
												exportOptions: {
													columns: ':visible',
													stripNewlines: false
												},
												customize: function(doc) {
													var rowCount = doc.content[1].table.body.length;
													switch (varData.substr(-1)) {
														case '8':
														case '7':
														case '6':
														case '5':
														case '4':
														case '3':
														case '2':
															for (i = 1; i < rowCount; i++) {
																doc.content[1].table.body[i][1].alignment = 'right';
															}
															break;
														case '1':
															for (i = 1; i < rowCount; i++) {
																doc.content[1].table.body[i][1].alignment = 'center';
																doc.content[1].table.body[i][2].alignment = 'right';
																doc.content[1].table.body[i][3].alignment = 'right';
																doc.content[1].table.body[i][4].alignment = 'right';
																doc.content[1].table.body[i][5].alignment = 'right';
																doc.content[1].table.body[i][6].alignment = 'right';
																doc.content[1].table.body[i][7].alignment = 'right';
																doc.content[1].table.body[i][8].alignment = 'right';
															}
															break;
														default:
															for (i = 1; i < rowCount; i++) {
																doc.content[1].table.body[i][1].alignment = 'center';
																doc.content[1].table.body[i][2].alignment = 'right';
																doc.content[1].table.body[i][3].alignment = 'right';
																doc.content[1].table.body[i][4].alignment = 'right';
																doc.content[1].table.body[i][5].alignment = 'right';
																doc.content[1].table.body[i][6].alignment = 'right';
																doc.content[1].table.body[i][7].alignment = 'right';
																doc.content[1].table.body[i][8].alignment = 'right';
																doc.content[1].table.body[i][9].alignment = 'right';
																doc.content[1].table.body[i][10].alignment = 'right';
																doc.content[1].table.body[i][11].alignment = 'right';
																doc.content[1].table.body[i][12].alignment = 'right';
															}

													}
													doc.content.splice(0, 1);
													var now = new Date();
													var jsDate = gantgl(now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate());
													var logo = logoY;
													doc.defaultStyle.fontSize = 7;
													doc.styles.tableHeader.fontSize = 7;
													doc['footer'] = (function(page, pages) {
														return {
															columns: [{
																	text: ['Paroki St. Yosef Meraban, Keuskupan Ketapang'],
																	fontSize: 8,
																	bold: false,
																	alignment: 'left',
																	italics: true,
																	margin: [10]
																},
																{
																	alignment: 'right',
																	text: [{
																		text: page.toString(),
																		italics: true
																	}, ' dari ', {
																		text: pages.toString(),
																		italics: true
																	}, ' [QS2020V1]'],
																	fontSize: 6,
																	alignment: 'right',
																	margin: [0, 0, 20]
																}
															]
														}
													});
													var objLayout = {};
													objLayout['hLineWidth'] = function(i) {
														return .5;
													};
													objLayout['vLineWidth'] = function(i) {
														return .5;
													};
													objLayout['hLineColor'] = function(i) {
														return '#aaa';
													};
													objLayout['vLineColor'] = function(i) {
														return '#aaa';
													};
													objLayout['paddingLeft'] = function(i) {
														return 4;
													};
													objLayout['paddingRight'] = function(i) {
														return 4;
													};
													doc.content[0].layout = objLayout;
													doc.pageMargins = [40, 20, 20, 10];
													doc.content[0].table.headerRows = 1;
													switch (varData.substr(-1)) {
														case '8':
														case '7':
														case '6':
														case '5':
														case '4':
														case '3':
														case '2':
															doc.content[0].table.widths = ['70%', '30%'];
															break;
														case '1':
															doc.content[0].table.widths = ['11%', '10%', '10%', '10%', '10%', '10%', '10%', '10%', '10%'];
															break;
														default:
															doc.content[0].table.widths = ['13%', '10%', '7%', '7%', '7%', '7%', '7%', '7%', '7%', '7%', '7%', '7%', '7%'];
													}
													doc.content.splice(0, 0, {
														columns: [{
																margin: [0, 0, 12, 12],
																fontSize: 9,
																bold: true,
																alignment: 'left',
																image: logo,
																width: 60
															},
															{
																width: '40%',
																alignment: 'center',
																text: ''
															},
															{
																width: '10%',
																margin: [12, 0, 0, 12],
																fontSize: 9,
																text: 'Dokumen\nDicetak\n\n'
															},
															{
																width: '2%',
																margin: [12, 0, 0, 12],
																fontSize: 9,
																text: ':\n:\n\n'
															},
															{
																width: '38%',
																margin: [12, 0, 0, 12],
																fontSize: 9,
																text: 'DATA UMAT BERDASAR ' + jdlChart.toUpperCase() + '\n' + jsDate.toString()
															}
														],
														columnGap: 2
													});

													doc.content.splice(2, 0, {
														margin: [10, 10, 10, 10],
														fontSize: 9,
														bold: true,
														alignment: 'center',
														image: img,
														width: 520
													});

													doc.content.splice(3, 0, {
														columns: [
															{
																width: '30%',
																margin: [10, 60, 10, 10],
																alignment: 'center',
																fontSize: 9,
																text: 'Mengetahui,\nPastor Paroki\n\n\n\n\n\n__________________'
															},
															{
																width: '40%',
																alignment: 'center',
																text: ''
															},
															{
																width: '30%',
																margin: [10, 60, 10, 10],
																alignment: 'center',
																fontSize: 9,
																text: '\nSekretariat Paroki\n\n\n\n\n\n__________________'
															}
														],
														columnGap: 2
													});

												}
											}
										],
										ordering: false,
										columns: setkolom,
										columnDefs: [{
											targets: [0],
											visible: true,
											searchable: false,
											sortable: false
										}, {
											targets: [1],
											createdCell: function(td, cellData, rowData, row, col) {
												$(td).css('text-align', 'center');
											}
										}, {
											targets: settarget1,
											render: $.fn.dataTable.render.number(',', '.', 0),

											createdCell: function(td, cellData, rowData, row, col) {
												$(td).css('text-align', 'right');
											}
										}]

									});

									$('#jdlData').text('Data Umat Paroki St. Yosef Meraban');
									$('#subData').text('Hanya data yang valid yang akan ditampilkan');
									$('.well').addClass('animated flash infinite');
									$('.dt-button').addClass('is-hidden');
									$('thead tr').addClass('is-selected');
									$('thead th').css('text-align', 'center');
									$('thead th').css('font-size', '12px');

									switch (varData.substr(-1)) {
										case '8':
										case '7':
										case '6':
										case '5':
										case '4':
										case '3':
										case '2':
										chartBar(tableObj, bsts, jdlChart, setkategoris, varData);
											break;
										case '1':
										chartStack(tableObj, bsts, jdlChart, setkategoris, varData);
											break;
										default:
										chartStack(tableObj, bsts, jdlChart, setkategoris, varData);
									}

									setTimeout(function() {

										$('.table-responsive').get(0).scrollIntoView({
											block: "start",
											behavior: "smooth"
										});

										const options = {
											scale: 5,
											scrollY: -window.scrollY
										}
										html2canvas(document.querySelector("#gambare"), options).then(canvas => {
											img = canvas.toDataURL();
											setTimeout(function() {
												$('.dt-button').removeClass('is-hidden');
												$('.well').removeClass('animated flash infinite');
												$.unblockUI();
												cekvalid(varData);
											}, 3000);
										});
									}, 3000);

								}
							});
						}
					}
				});
			}
		}
	});
}

function chartBar(table, bsts, jdlChart, setkategoris, varData) {
	var asts;
	var goseries = [];
	var container = $('<div/>').insertBefore(table.table().container()).attr('id', 'gambare');
	asts = JSON.parse(bsts);

	var setsts = {};
	setsts.data = chartData0(varData, table, 0);
	setsts.color = getRandomColor();

	goseries = chartData0(varData, table, 0);

	var chart = Highcharts.chart(container[0], {
		chart: {
        type: 'column'
    },
		title: {
			text: 'DATA UMAT BERDASARKAN ' + jdlChart.toUpperCase()
		},
		legend: {
        enabled: false
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Jumlah'
        }

    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:.0f}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
    },

    series: [
        {
            name: "Jum.KK",
            colorByPoint: true,
            data: goseries
        }
    ]
	});
	table.on('draw', function() {
		chart;
	});
}

function chartPie(table, bsts, jdlChart, setkategoris, varData) {
	var asts;
	var goseries = [];
	var container = $('<div/>').insertBefore(table.table().container()).attr('id', 'gambare');
	asts = JSON.parse(bsts);

	var setsts = {};
	setsts.data = chartData0(varData, table, 0);
	setsts.color = getRandomColor();

	goseries = chartData0(varData, table, 0);

	var chart = Highcharts.chart(container[0], {
		chart: {
			height: 520,
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie',
			alignTicks: false
		},
		title: {
			text: 'DATA UMAT BERDASARKAN ' + jdlChart.toUpperCase()
		},
		legend: {
			align: 'center',
			borderColor: '#232323',
			borderWidth: 1,
			shadow: true
		},
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y:.0f}</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        series: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.0f}%'
            },
						showInLegend: true
        }
    },
		series: [{name:"STASI",data:chartData0(varData, table)}],
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						align: 'center',
						verticalAlign: 'bottom',
						layout: 'horizontal'
					},
					yAxis: {
						labels: {
							align: 'left',
							x: 0,
							y: -5
						},
						title: {
							text: null
						}
					},
					subtitle: {
						text: null
					},
					credits: {
						enabled: false
					}
				}
			}]
		}
	});
	table.on('draw', function() {
		chart;
	});
}

function chartData0(jData, table) {
	var arrsem = new Object();
	var arrkey = table
		.column(0, {
			search: 'applied'
		})
		.data()
		.toArray();
	var arrval = table
		.column(1, {
			search: 'applied'
		})
		.data()
		.toArray();
	for (var i = 0; i < arrkey.length; i++) {
		arrsem[arrkey[i]] = arrval[i]
	}

	return $.map(arrsem, function(val, key) {
		return {
			name: key,
			y: val,
		};
	});
}

function chartStack(table, bsts, jdlChart, setkategoris, varData) {
	var asts;
	var goseries = [];
	var container = $('<div/>').insertBefore(table.table().container()).attr('id', 'gambare');
	asts = JSON.parse(bsts);


	for (var y = 0; y < asts.length; y++) {
		var bagtot = 100 / asts.length;
		var bagpart = (asts.length) - y;
		var setpart = y == 0 ? 100 : (bagtot * bagpart);
		var setsts = {};
		var substs = {};
		substs.enabled = false;
		substs.format = '<span style="font-size:9px;">{point.y:.0f}</span>';
		substs.allowOverlap = true;
		substs.defer = true;
		substs.color = '#0000aa';
		var subnil = table
			.row(y)
			.data();

			switch (varData.substr(-1)) {
				case '3':
				case '2':
					var setstack = subnil[0];
					break;
				case '1':
				var setstack = subnil[1];
					break;
				default:
				var setstack = subnil[1];
			}
//alert(asts);
		setsts.name = asts[y];
		setsts.data = chartData(varData, table, y);
		setsts.color = getRandomColor();
		setsts.stack = setstack;
		setsts.dataLabels = substs;
		goseries.push(setsts);
	}
	var chart = Highcharts.chart(container[0], {
		chart: {
			height: 600,
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'column',
			alignTicks: false
		},
		title: {
			text: 'DATA UMAT BERDASARKAN ' + jdlChart.toUpperCase()
		},
		xAxis: {
			categories: setkategoris,
			crosshair: true
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {
				text: 'Jumlah'
			},
			stackLabels: {
					enabled: true,
					useHTML: true,
					style: {
							fontWeight: 'bold',
							//color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray',
							color: 'black',
							//backgroundColor: 'rgba(252, 255, 197, 0.7)',
							position:'absolute'
					},
					formatter: function () {
						var points = this.points;
						var pname = this.stack;
//console.log(this);
							var max = 0;
							for (var index in points) {
									var currentValue = Math.abs(points[index][0] - points[index][1]);
									if (currentValue >= max) {
											max = currentValue;
									}
							}
							return "<center><span>" + pname + ":" + this.total +"</span></center>";
					}
	},
			tickInterval: 1
		},
		legend: {
			align: 'center',
			borderColor: '#232323',
			borderWidth: 1,
			shadow: true
		},
		tooltip: {
			headerFormat: '<span style="font-size:12px">{point.key}</span><table>',
			pointFormat: '<tr><td style="font-size:10px;color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="font-size:10px;padding:0"><strong>{point.percentage:.0f} %</strong></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
		},
		accessibility: {
			point: {
				valueSuffix: '%'
			}
		},
		plotOptions: {
			series: {
				stacking: 'normal',
				label: {
					enabled: false
				}
			}
		},
		series: goseries,
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						align: 'center',
						verticalAlign: 'bottom',
						layout: 'horizontal'
					},
					yAxis: {
						labels: {
							align: 'left',
							x: 0,
							y: -5
						},
						title: {
							text: null
						}
					},
					subtitle: {
						text: null
					},
					credits: {
						enabled: false
					}
				}
			}]
		}
	});
	table.on('draw', function() {
		chart.series[0].setData();
	});
}

function getRandomColor() {
	var letters = '05789EF';
	var color = '#';
	for (var i = 0; i < 6; i++) {
		var cekcol = letters[Math.floor(Math.random() * 7)];
		color += cekcol;
	}
	return color;
}

function chartData(jData, table, kolom) {
	var arrsem = new Object();
	var arrnil = table
		.row(kolom)
		.data();
	var arrkey = table
		.column(0, {
			search: 'applied'
		})
		.data()
		.toArray();
	switch (jData.substr(-1)) {
		case '2':
			arrsem['Jum.KK'] = arrnil[1];
			break;
		case '1':
			arrsem['???'] = arrnil[2];
			arrsem['Aktif'] = arrnil[3];
			arrsem['P.Domisili'] = arrnil[4];
			arrsem['P.Agama'] = arrnil[5];
			arrsem['Meninggal'] = arrnil[6];
			arrsem['Hapus'] = arrnil[7];
			break;
		default:
			arrsem['0-5'] = arrnil[3];
			arrsem['6-11'] = arrnil[4];
			arrsem['12-16'] = arrnil[5];
			arrsem['17-25'] = arrnil[6];
			arrsem['26-35'] = arrnil[7];
			arrsem['36-45'] = arrnil[8];
			arrsem['46-55'] = arrnil[9];
			arrsem['56-65'] = arrnil[10];
			arrsem['>66'] = arrnil[11];

	}
	return $.map(arrsem, function(val, key) {
		return {
			name: key,
			y: val,
		};
	});
}

function gantgl(tanggalymd) {
	var utime = Math.floor(new Date(tanggalymd).getTime() / 1000);

	//    var bln_arr = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember'];
	var bln_arr = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
	var date = new Date(utime * 1000);
	var year = date.getFullYear();
	var month = bln_arr[date.getMonth()];
	var day = ('0' + date.getDate()).slice(-2);
	var hours = date.getHours();
	var minutes = "0" + date.getMinutes();
	var seconds = "0" + date.getSeconds();
	var convdataTime = day + ' / ' + month + ' / ' + year;
	return convdataTime;
}

function cekzip() {
	$.ajax({
		type: "POST",
		url: baseurl + 'data/cekdatazip',
		success: function(data) {
			if (data != '') {
				var isiz = JSON.parse(data);
				var jumz = isiz.length;
				if (jumz > 0) {
					for (var i = 0; i < isiz.length; i++) {
						$('#zip_' + isiz[i]).removeClass('hidden');
					}
				}
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {}
	});
}

function unduhzip(kstasi) {
	fetch(baseurl + 'prozip/' + kstasi + '.zip')
		.then(resp => resp.blob())
		.then(blob => {
			const url = window.URL.createObjectURL(blob);
			const a = document.createElement('a');
			a.style.display = 'none';
			a.href = url;
			// the filename you want
			a.download = 'qs_' + kstasi + Math.floor(Date.now() / 1000) + '.zip';
			document.body.appendChild(a);
			a.click();
			window.URL.revokeObjectURL(url);
		})
		.catch(() => alert('oh no!'));

}

function hitconv(jarr) {
	var hitung = jarr.map(function(x) {
		return parseInt(x, 10);
	});
	var sum = hitung.reduce(function(a, b) {
		return a + b;
	}, 0);
	return sum;
}

function cekdb() {
	$.ajax({
		type: "POST",
		url: baseurl + 'data/check_database',
		data: jQuery.param({
			vusr: ''
		}),
		success: function(datav) {
			if (datav != 'AMAN') {
				alert('Lost connections!');
			}
		}
	});
}

function getCookie(name) {
	var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
	return v ? v[2] : null;
}

function setCookie(name, value, days) {
	var d = new Date;
	d.setTime(d.getTime() + 24 * 60 * 60 * 1000 * days);
	document.cookie = name + "=" + value + ";path=/;expires=" + d.toGMTString();
}

function deleteCookie(name) {
	setCookie(name, '', -1);
}
