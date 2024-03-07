//$(document).ajaxStop($.unblockUI);
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


});

function bulkCetak(idjen, idstasi) {
  $.blockUI({
    message: '<img class="animated pulse infinite" src="' + decodeURI(baseurl + 'imgpdf/logoAnim.png') + '" width="100" height="auto"><h3 class="animated rubberBand infinite">Menjalankan Proses</h3>'
  });
  $.ajax({
    type: "POST",
    url: baseurl + 'data/setpdf/',
    data: {
      kodeper: idjen,
      kodestasi: idstasi
    },
    success: function(dataar) {
      var setdataar = JSON.parse(dataar);
      $.ajax({
        type: "POST",
        url: baseurl + 'data/gabungpdf/',
        data: {
          setarpdf: setdataar
        },
        success: function(data) {
          var AmbilData = setdataar;
          var i = 0;
          var jsupp = AmbilData.length;
          if (jsupp > 0) {
            $('#formcetak').removeClass('hidden');
            $('#detprint').get(0).scrollIntoView({
              block: "start",
              behavior: "smooth"
            });

            var setdatatb = [];

            var tableId = "#tbdetail";
            if ($.fn.DataTable.isDataTable(tableId)) {
              $(tableId).DataTable().clear().destroy();
            }


            for (i = 0; i <= jsupp - 1; i++) {
              var setpdf = '<a target="_blank" href="' + baseurl + 'propdf/' + AmbilData[i].split(/[/ ]+/).pop() + '"><i class="ti-download"></i></a>';
              var getstr = AmbilData[i].split(/[/ ]+/).pop().replace(/_/g, ' ').replace('.pdf', '');
              var var1 = eval(i + 1);
              var var2 = getstr.substr(0, getstr.length - 15).toUpperCase();
              var var3 = AmbilData[i].split(/[/ ]+/).pop().replace('.pdf', '').substr(-15).replace(/_/g, '.');
              setdatatb[i] = new Array(var1, var2, var3, setpdf);
            }

            tableObj = $(tableId).DataTable({
              data: setdatatb,
              columns: [{
                  title: "No"
                },
                {
                  title: "Kepala Keluarga"
                },
                {
                  title: "Nomor KK"
                },
                {
                  title: "Unduh"
                }
              ]
            });
          }
          $('#dlall').html('[all: <a target="_blank" href="' + baseurl + 'propdf/power_ranger_bergabung.pdf">link</a>]');
          cekzip();
          $.unblockUI();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $.unblockUI();
          Swal.fire(
            'Error!',
            'Terjadi kesalahan!',
            'error'
          );
          //            location.reload();
        }
      });
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $.unblockUI();
      Swal.fire(
        'Error!',
        'Terjadi kesalahan!',
        'error'
      );
      //            location.reload();
    }
  });
}

function lstData(varData) {
  var tableId = "#tbdetail";
  var myEle = document.getElementById("gambare");
   if(myEle){
     if ($.fn.DataTable.isDataTable(tableId)) {
       $(tableId).DataTable().clear().destroy();
     }
     $('#gambare').remove();
   }
  $.blockUI({
    message: '<img class="animated pulse infinite" src="' + decodeURI(baseurl + 'imgpdf/logoAnim.png') + '" width="100" height="auto"><h3 class="animated rubberBand infinite">Menjalankan Proses</h3>'
  });
  $.ajax({
    type: "POST",
    url: baseurl + 'data/setlst/',
    data: {
      setdata: varData
    },
    success: function(data) {
      $('#grmain').css('display','none');
      var logoY;
      var img;
      $.ajax({
        type: "POST",
        url: baseurl + 'data/gonampat/',
        data: {
          gbr: 'imgpdf/logoAnim.png'
        },
        success: function(dec3) {
//            alert(dec3);
          return logoY = 'data:image/jpg;base64,' + dec3;
        }
      });
      var AmbilData = JSON.parse(data);
      var i = 0;
      var jsupp = AmbilData.length;
      if (jsupp > 0) {
        //          $('#formcetak').removeClass('hidden');
        var setdatatb = [];

        for (i = 0; i <= jsupp - 1; i++) {
          var var1 = eval(i + 1);
          var markDel = (AmbilData[i].is_deleted == 1) ? '(#) ' : '';
          setdatatb[i] = new Array(var1, AmbilData[i].id_umat, markDel + AmbilData[i].nama, AmbilData[i].tempat_lahir, gantgl(AmbilData[i].tanggal_lahir), AmbilData[i].nama_stasi, AmbilData[i].nama_lingkungan);
        }

        tableObj = $(tableId).DataTable({
          data: setdatatb,
          createdRow: function( row, data, dataIndex){
            if( data[2].substr(0,3) ==  '(#)'){
              $(row).addClass('info');
//                $(row).addClass('hidden');
            }
          },
          lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "All"]
          ],
          paging: true,
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
          //        		serverSide: true,
          order: [],
          dom: '<"well col-md-12 col-sm-12 col-xs-12"<"col-md-6 col-sm-6 col-xs-6"f><"col-md-6 col-sm-6 col-xs-6"B>>t<"col-md-12 col-sm-12 col-xs-12"<"col-md-6 col-sm-6 col-xs-6"i><"col-md-6 col-sm-6 col-xs-6"p>>',
          buttons: [
            "pageLength",
            {
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
              filename: 'dt_custom_pdf',
              orientation: 'portrait', //portrait
              pageSize: 'A4', //A3 , A5 , A6 , legal , letter
              exportOptions: {
                columns: ':visible',
                search: 'applied',
                order: 'applied'
              },
              customize: function(doc) {
                doc.content.splice(0, 1);
                var now = new Date();
                var jsDate = gantgl(now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate());
                var logo = logoY;
//                  var gbchart = img;
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
                        },' [QS2020V1]'],
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
                doc.pageMargins = [50, 20, 20, 30];
                doc.content[0].table.headerRows = 1;
                doc.content[0].table.widths = ['8%', '24%', '20%', '15%', '15%', '15%'];
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
              width: '50%',
              alignment: 'center',
              text: ''
            },
            {
              width: '15%',
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
              width: '23%',
              margin: [12, 0, 0, 12],
              fontSize: 9,
              text: 'DATA UMAT '+varData.toUpperCase()+'\n'+jsDate.toString()
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
                  width: 800
                });

              }
            }
          ],
          columns: [{
              title: "No"
            },
            {
              title: "Kode Umat"
            },
            {
              title: "Nama Jelas"
            },
            {
              title: "Tempat Lahir"
            },
            {
              title: "Tanggal Lahir"
            },
            {
              title: "Stasi"
            },
            {
              title: "Kring"
            }
          ],
          columnDefs: [{
            targets: [0],
            visible: false,
            searchable: false
          },
          {
            targets: [3],
            visible: true,
            searchable: false,
            sortable: false
          }]

        });
/*test chart*/
var container = $('<div/>').insertBefore(tableObj.table().container()).attr('id','gambare');

// Build the chart
var chart =  Highcharts.chart(container[0], {
  chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
  },
  title: {
      text: 'DATA UMAT ' + varData.toUpperCase()
  },
  tooltip: {
      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  accessibility: {
      point: {
          valueSuffix: '%'
      }
  },
  plotOptions: {
      pie: {
          allowPointSelect: true,
          center: ['50%', '50%'],
          cursor: 'pointer',
          dataLabels: {
              enabled: true,
              format: '<b>{point.name}</b>: {point.percentage:.1f} %',
              connectorColor: 'silver'
          }
      }
  },
  series: [{
      name: 'L',
      data: chartData(tableObj,6),
      colorByPoint: true,
      size: '100%',
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
        connectorColor: '#0000ff',
        color: '#0000ff',
        distance: 60
      }

  },{
      name: 'P',
      data: chartData(tableObj,5),
      colorByPoint: true,
      size: '60%',
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
        connectorColor: '#ff0000',
        color: '#ff0000',
        distance: 10
      }

  }],
    responsive: {
        rules: [{
            condition: {
                maxWidth: 400
            },
            chartOptions: {
                series: [{
                }, {
                    id: 'versions',
                    dataLabels: {
                        enabled: false
                    }
                }]
            }
        }]
    }
});

// On each draw, update the data in the chart
tableObj.on('draw', function () {
  chart.series[0].setData(chartData(tableObj,5));
});
/*test chart*/
      }
      $('#jdlData').text('Data Umat Paroki St. Yosef Meraban');
      $('#subData').text('Ketikkan # pada kotak pencarian untuk memunculkan data terhapus');
      $.unblockUI();
      $('.well').addClass('animated flash infinite');
      $('.dt-button').addClass('is-hidden');
      setTimeout(function(){
/*
        // Initiate download of blob
        function download(
          filename, // string
          blob // Blob
        ) {
          if (window.navigator.msSaveOrOpenBlob) {
            window.navigator.msSaveBlob(blob, filename);
          } else {
            const elem = window.document.createElement('a');
            elem.href = window.URL.createObjectURL(blob);
            elem.download = filename;
            document.body.appendChild(elem);
            elem.click();
            document.body.removeChild(elem);
          }
        }
*/
$('.table-responsive').get(0).scrollIntoView({
  block: "start",
  behavior: "smooth"
});

const options = {
  scale: 5,
  scrollY: -window.scrollY
}
html2canvas(document.querySelector("#gambare"),options).then(canvas => {
    img = canvas.toDataURL();
    setTimeout(function(){
    $('.dt-button').removeClass('is-hidden');
    $('.well').removeClass('animated flash infinite');
  },3000);
});
      },3000);

    },
    error: function(jqXHR, textStatus, errorThrown) {
      $.unblockUI();
      Swal.fire(
        'Error!',
        'Terjadi kesalahan!',
        'error'
      );
    }


  });
}

function chartData(table,kolom) {
    var counts = {};

    // Count the number of entries for each position
    table
        .column(kolom, { search: 'applied' })
        .data()
        .each(function (val) {
            if (counts[val]) {
                counts[val] += 1;
            } else {
                counts[val] = 1;
            }
        });

    // And map it to the format highcharts uses
    return $.map(counts, function (val, key) {
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
    timeout: 6000,
    cache:false,
    success: function(data) {
      if (data) {
        var isiz = data;
        var jumz = isiz.length;
        if (jumz > 0) {
          for (var i = 0; i < isiz.length; i++) {
            $('#zip_' + isiz[i]).removeClass('hidden');
          }
        }
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $.unblockUI();
      Swal.fire(
        'Error!',
        'Lost Connections!',
        'error'
      );
    }
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

function tampilgrap(jgrap) {
  var url = baseurl + 'data/' + jgrap;
  var isiarea = new Array();
  var isipro = new Array();
  var isivar = new Array();
  var chartHeight = 0;
  $.blockUI({
    message: '<img class="animated pulse infinite" src="' + decodeURI(baseurl + 'imgpdf/logoAnim.png') + '" width="100" height="auto"><h3 class="animated rubberBand infinite">Menjalankan Proses</h3>'
  });
  $.ajax({
    url: url,
    type: 'POST',
    timeout: 6000,
    cache:false,
    success: function(datas) {
      if (datas != '') {
        var data = datas;
        chartHeight = 500;
        var jgrafik = '#' + jgrap;
        $(jgrafik).css({
          'height': chartHeight
        });
        $('canvas').css({
          'height': chartHeight
        });
        if (jgrap == 'gstat') {
          var setarr1 = hitconv(data[1]);
          var setarr2 = hitconv(data[2]);
          var setarr3 = hitconv(data[3]);
          $('#jtotal').text(setarr2);
          $('#jbaptis').text(setarr1);
          $('#jmati').text(eval(-1 * setarr3));
        }
        $.unblockUI();
        var myChart = echarts.init(document.getElementById(jgrap));

        setTimeout(function() {

          option0 = {
            legend: {},
            tooltip: {
              trigger: 'axis',
              showContent: true
            },
            dataset: {
              source: data
            },
            xAxis: {
              type: 'category'
            },
            yAxis: {
              gridIndex: 0
            },
            grid: {
              top: '45%'
            },
            series: [{
                type: 'line',
                smooth: true,
                seriesLayoutBy: 'row'
              },
              {
                type: 'line',
                smooth: true,
                seriesLayoutBy: 'row'
              },
              {
                type: 'pie',
                id: 'pie',
                radius: '30%',
                center: ['50%', '25%'],
                label: {
                  formatter: '{b}: {@2010} ({d}%)'
                },
                encode: {
                  itemName: 'tahun',
                  value: '2010',
                  tooltip: '2010'
                }
              }
            ]
          };

          option1 = {
            tooltip: {
              trigger: 'axis',
              axisPointer: { // 坐标轴指示器，坐标轴触发有效
                type: 'shadow' // 默认为直线，可选为：'line' | 'shadow'
              }
            },
            legend: {
              data: ['baptis', 'kematian', 'umat']
            },
            grid: {
              left: '3%',
              right: '4%',
              bottom: '3%',
              containLabel: true
            },
            xAxis: [{
              type: 'value'
            }],
            yAxis: [{
              type: 'category',
              axisTick: {
                show: false
              },
              data: data[0]
            }],
            series: [{
                name: 'baptis',
                type: 'bar',
                label: {
                  show: true,
                  position: 'inside'
                },
                data: data[1]
              },
              {
                name: 'umat',
                type: 'bar',
                stack: '总量',
                label: {
                  show: true
                },
                data: data[2]
              },
              {
                name: 'kematian',
                type: 'bar',
                stack: '总量',
                label: {
                  show: true,
                  position: 'left'
                },
                data: data[3]
              }
            ]
          };

          if (jgrap == 'ggrb') {
            myChart.on('updateAxisPointer', function(event) {
              var xAxisInfo = event.axesInfo[0];
              if (xAxisInfo) {
                var dimension = xAxisInfo.value + 1;
                myChart.setOption({
                  series: {
                    id: 'pie',
                    label: {
                      formatter: '{b}: {@[' + dimension + ']} ({d}%)'
                    },
                    encode: {
                      value: dimension,
                      tooltip: dimension
                    }
                  }
                });
              }
            });
            myChart.setOption(option0);
          } else if (jgrap == 'gstat') {
            myChart.setOption(option1, true);
          }
          $('canvas').attr('id','canvasmain');
        });
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $.unblockUI();
      Swal.fire(
        'Error!',
        'Lost Connections!',
        'error'
      );
    }
  });
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
        Swal.fire(
          'Error!',
          'Lost Connections!',
          'error'
        );
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $.unblockUI();
      Swal.fire(
        'Error!',
        'Lost Connections!',
        'error'
      );
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
