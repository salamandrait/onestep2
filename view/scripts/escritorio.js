var valor='';


$(function() {

  function number_format(number, decimals, dec_point, thousands_sep){
    
    //*example: number_format(1234.56, 2, ',', ' ');
    //*return: '1 234,56'
    number = (number+'').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ?0:+number,
    prec = !isFinite(+decimals) ?0: Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n,prec) {
      var k = Math.pow(10, prec);
      return''+ Math.round(n * k) / k;
    };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec?toFixedFix(n,prec):''+Math.round(n)).split('.');
    if (s[0].length>3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
  }

  //Total Clientes y Saldo Pendiente
  $.post("../ajax/escritorio.php",{'opcion':'totalclientes'}, function(data){

    var data=JSON.parse(data);
    $("#totalcliente").html(data.totalcl);
    $("#saldocxc").html(number_format(data.saldot,2,',','.'));
  });

  //Total Total Pedidos Venta
  $.post("../ajax/escritorio.php",{'opcion':'totalpedidov'}, function(data){

    var data=JSON.parse(data);
    $("#totalpv").html(data.totalp);
    $("#totalpedidov").html(number_format(data.saldoh,2,',','.'));
  });

  //Total Total Facturas Venta
  $.post("../ajax/escritorio.php",{'opcion':'totalfacturav'}, function(data){

    var data=JSON.parse(data);
    $("#totalfv").html(data.totalf);
    $("#totalfacturav").html(number_format(data.saldoh,2,',','.'));
  });

  //Pie Categorias
  $.ajax({
      url: "../ajax/escritorio.php",
      type:'POST',
      dataType: 'json',
      data:{'opcion':'categoria'},
      success: function(data){

              var categoria = [];
              var stockp = [];

              for (var i in data) {
                  stockp.push(data[i].stockp);
                  categoria.push(data[i].categoria);
              }
                var color = [ 
                  'rgba(243, 199, 13, 0.6)',  
                  'rgba(243, 49, 53, 0.8)',
                  'rgba(60, 163,106, 0.9)',
                  'rgba(54, 133, 206, 0.9)',
                  'rgba(123, 67, 153, 0.8)',
                  'rgba(173, 177, 171, 0.8)',
                  'rgba(243, 199, 13, 0.6)',  
                  'rgba(203, 49, 53, 0.8)',
                  'rgba(160, 163,106, 0.9)',
                  'rgba(154, 133, 206, 0.9)',
                  'rgba(103, 67, 153, 0.8)',
                  'rgba(173, 177, 171, 0.8)',
              ];

              var bgcolor = [ 
                  'rgba(75,75,75,1)', 
                  'rgba(75,75,75,1)',
                  'rgba(75,75,75,1)',
                  'rgba(75,75,75,1)',
                  'rgba(75,75,75,1)',
                  'rgba(75,75,75,1)', 
                  'rgba(75,75,75,1)',
                  'rgba(75,75,75,1)',
                  'rgba(75,75,75,1)',
                  'rgba(75,75,75,1)',         
              ];

              var ctx = document.getElementById("piecategoria");
              new Chart(ctx, {
                  type: 'pie',
                  data: {
                  labels: categoria,
                  datasets: [{
                      label: categoria,
                      data: stockp,
                      backgroundColor:color,
                      hoverBackgroundColor: "#2e59d9",
                      borderColor: bgcolor,
                      borderWidth: 2
                  }],
                  },
                  options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {left: 20,right: 20,top: 5,bottom: 5
                  }
                  },
                  scales:  
                  {
                      scaleBeginAtZero : false,
                      scaleGridLineColor : "rgba(0,0,0,0)",
                      zeroLineBorderDash:10,
                    },
                    legend: {
                      display: false
                    },
                    tooltips: {
                      titleMarginBottom:0,
                      titleFontColor: '#0f0f0f',
                      titleFontSize: 18,
                      backgroundColor: "rgb(55,55,65,0.8)",
                      bodyFontColor: '#4e73df',
                      borderColor: '#4e83df',
                      borderWidth: 15,
                      xPadding: 15,
                      yPadding: 15,
                      displayColors:true,
                      caretPadding: 10,
                        callbacks: {
                          data: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].data+'-%' || '';
                            return datasetLabel + '-%';
                          }
                        }
                  },
                }
            });         
          }
  });

  //Ultimas 10 Ventas
  $.ajax({
        url: "../ajax/escritorio.php",
        type:'POST',
        dataType: 'json',
        data:{'opcion':'ventas10'},
        success: function(dataset){

            var fecha = [];
            var total = [];
            if (dataset!=0) {
              for (var i in dataset) {
                fecha.push(dataset[i].fecha);
                total.push(dataset[i].totalh);
              }
            } else {
              fecha.push('NO DATA');
              total.push('NO DATA');
            }

            var color = [
              'rgba(66, 50, 205, 0.6)',
              'rgba(39, 150, 216, 0.6)',
              'rgba(66, 50, 205, 0.6)',
              'rgba(39, 150, 216, 0.6)',
              'rgba(66, 50, 205, 0.6)',
              'rgba(39, 150, 216, 0.6)',
              'rgba(66, 50, 205, 0.6)',
              'rgba(39, 150, 216, 0.6)',
              'rgba(66, 50, 205, 0.6)',
              'rgba(39, 150, 216, 0.6)',
            ];
            
            var bordercolor = [
                'rgba(14, 20, 30,1)',
                'rgba(14, 20, 30,1)', 
                'rgba(14, 20, 30,1)',
                'rgba(14, 20, 30,1)', 
                'rgba(14, 20, 30,1)',
                'rgba(14, 20, 30,1)', 
                'rgba(14, 20, 30,1)',
                'rgba(14, 20, 30,1)',  
                'rgba(14, 20, 30,1)',
                'rgba(14, 20, 30,1)', 
            ];

            var ctx = document.getElementById("ventas10");
            new Chart(ctx, {
                type: 'bar',
                data: {
                labels: fecha,
                datasets: [{
                    label: "Bs.",
                    data: total,
                    backgroundColor:color,
                    hoverBackgroundColor: "#2e59d9",
                    borderColor: bordercolor,
                    borderWidth: 2
                }],
                },
                options: {
                  maintainAspectRatio: false,
                  layout: {
                      padding: {left: 15,right: 15,top: 0,bottom: 0
                }
                },
                scales:  
                {
                  scaleBeginAtZero : true,
                  scaleGridLineColor : "rgba(0,0,0,0)",
                  zeroLineBorderDash:0,
                xAxes: [{
                      ticks: {
                          display:true,
                          maxTicksLimit: 25,
                    },
                    gridLines: {
                        color: "rgb(190, 190, 190)",
                        zeroLineColor: "rgb(190, 190, 190)",
                        drawBorder: true,
                        borderDash: [0],
                        zeroLineBorderDash: [0]
                    }}],
                yAxes: [{
                      ticks: {
                          display:false,
                          maxTicksLimit: 15,
                    },
                    gridLines: {
                        color: "rgb(190, 190, 190)",
                        zeroLineColor: "rgb(190, 190, 190)",
                        drawBorder: false,
                        borderDash: [0],
                        zeroLineBorderDash: [0]
                    }}],
                  },
                  legend: {
                    display: false
                  },
                  tooltips: {
                    titleMarginBottom:0,
                    titleFontColor: '#0f0f0f',
                    titleFontSize: 14,
                    backgroundColor: "rgb(55,55,65,0.8)",
                    bodyFontColor: '#4e73df',
                    borderColor: '#4e83df',
                    borderWidth: 15,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors:true,
                    caretPadding: 10,
                    callbacks: {
                      label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ':' + number_format(tooltipItem.yLabel,2,',','.');
                      }
                    }
                },
              }
          });         
        }
  });

  //Ultimas 10 Compras
  $.ajax({
    url: "../ajax/escritorio.php",
    type:'POST',
    dataType: 'json',
    data:{'opcion':'compras10'},
    success: function(dataset){

        var fecha = [];
        var total = [];
        if (dataset!=0) {
          for (var i in dataset) {
            fecha.push(dataset[i].fecha);
            total.push(dataset[i].totalh);
          }
        } else {
          fecha.push('NO DATA');
          total.push('NO DATA');
        }

        var color = [
          'rgba(207, 11, 45, 0.7)',
          'rgba(39, 150, 216, 0.6)',
          'rgba(207, 11, 45, 0.7)',
          'rgba(39, 150, 216, 0.6)',
          'rgba(207, 11, 45, 0.7)',
          'rgba(39, 150, 216, 0.6)',
          'rgba(207, 11, 45, 0.7)',
          'rgba(39, 150, 216, 0.6)',
          'rgba(207, 11, 45, 0.7)',
          'rgba(39, 150, 216, 0.6)',
        ];
        
        var bordercolor = [
            'rgba(14, 20, 30,1)',
            'rgba(14, 20, 30,1)', 
            'rgba(14, 20, 30,1)',
            'rgba(14, 20, 30,1)', 
            'rgba(14, 20, 30,1)',
            'rgba(14, 20, 30,1)', 
            'rgba(14, 20, 30,1)',
            'rgba(14, 20, 30,1)',  
            'rgba(14, 20, 30,1)',
            'rgba(14, 20, 30,1)', 
        ];

        var ctx = document.getElementById("compras10");
        new Chart(ctx, {
            type: 'bar',
            data: {
            labels: fecha,
            datasets: [{
                label: "Bs.",
                data: total,
                backgroundColor:color,
                hoverBackgroundColor: "#2e59d9",
                borderColor: bordercolor,
                borderWidth: 2
            }],
            },
            options: {
              maintainAspectRatio: false,
              layout: {
                  padding: {left: 15,right: 15,top: 0,bottom: 0
            }
            },
            scales:  
            {
              scaleBeginAtZero : true,
              scaleGridLineColor : "rgba(0,0,0,0)",
              zeroLineBorderDash:0,
            xAxes: [{
                  ticks: {
                      display:true,
                      maxTicksLimit: 25,
                },
                gridLines: {
                    color: "rgb(190, 190, 190)",
                    zeroLineColor: "rgb(190, 190, 190)",
                    drawBorder: true,
                    borderDash: [0],
                    zeroLineBorderDash: [0]
                }}],
            yAxes: [{
                  ticks: {
                      display:false,
                      maxTicksLimit: 15,
                },
                gridLines: {
                    color: "rgb(190, 190, 190)",
                    zeroLineColor: "rgb(190, 190, 190)",
                    drawBorder: false,
                    borderDash: [0],
                    zeroLineBorderDash: [0]
                }}],
              },
              legend: {
                display: false
              },
              tooltips: {
                titleMarginBottom:0,
                titleFontColor: '#0f0f0f',
                titleFontSize: 14,
                backgroundColor: "rgb(55,55,65,0.8)",
                bodyFontColor: '#4e73df',
                borderColor: '#4e83df',
                borderWidth: 15,
                xPadding: 15,
                yPadding: 15,
                displayColors:true,
                caretPadding: 10,
                callbacks: {
                  label: function(tooltipItem, chart) {
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ':' + number_format(tooltipItem.yLabel,2,',','.');
                  }
                }
            },
          }
      });         
    }
});

  //Total Proveedores y Saldo Pendiente
  $.post("../ajax/escritorio.php",{'opcion':'totalproveedores'}, function(data){

    var data=JSON.parse(data);
    $("#totalproveedor").html(data.totalpv);
    $("#saldocxp").html(number_format(data.saldot,2,',','.'));
  });

  //Total Total Pedidos Compra
  $.post("../ajax/escritorio.php",{'opcion':'totalpedidoc'}, function(data){

    var data=JSON.parse(data);
    $("#totalpc").html(data.totalp);
    $("#totalpedidoc").html(number_format(data.saldoh,2,',','.'));
  });

  //Total Total Facturas Compra
  $.post("../ajax/escritorio.php",{'opcion':'totalfacturac'}, function(data){
    var data=JSON.parse(data);
    $("#totalfc").html(data.totalf);
    $("#totalfacturac").html(number_format(data.saldoh,2,',','.'));
  });

  $.post("../ajax/escritorio.php",{'opcion':'articuloMasVentas'}, function(data){

    $("#artmasventas").html(data);
    if(data!=0){
        $('.artmas').removeClass('collapsed-box');
    }else{
      $('.artmas').addClass('collapsed-box');
    }
  });

  $.post("../ajax/escritorio.php",{'opcion':'Inventario'}, function(data){

    data=JSON.parse(data);
    $(".totalart").html(data.art);
    $(".totalstock").html(data.stock)

    if(data!=0){
        $('.inv-box').removeClass('collapsed-box');
    }else{
        $('.inv-box').addClass('collapsed-box');
    }
  });




});