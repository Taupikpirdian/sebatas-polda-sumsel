
<script>
//#chart_widget_2
if(jQuery('#chart_widget_2').length > 0 ){
	
  const chart_widget_2 = document.getElementById("chart_widget_2").getContext('2d');
  //generate gradient
  const chart_widget_2gradientStroke = chart_widget_2.createLinearGradient(0, 0, 0, 250);
  chart_widget_2gradientStroke.addColorStop(0, "#a0bfff");
  chart_widget_2gradientStroke.addColorStop(1, "#a0bfff");

  // chart_widget_2.attr('height', '100');

  new Chart(chart_widget_2, {
    type: 'bar',
    data: {
      defaultFontFamily: 'Poppins',
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [
        {
          label: "Jumlah Kejahatan",
          data: [
            {{ $jan_f_diagram_ty }},
            {{ $feb_f_diagram_ty }},
            {{ $mar_f_diagram_ty }},
            {{ $apr_f_diagram_ty }},
            {{ $mei_f_diagram_ty }},
            {{ $jun_f_diagram_ty }},
            {{ $jul_f_diagram_ty }},
            {{ $aug_f_diagram_ty }},
            {{ $sep_f_diagram_ty }},
            {{ $oct_f_diagram_ty }},
            {{ $nov_f_diagram_ty }},
            {{ $des_f_diagram_ty }}
          ],
          borderColor: chart_widget_2gradientStroke,
          borderWidth: "0",
          backgroundColor: chart_widget_2gradientStroke, 
          hoverBackgroundColor: chart_widget_2gradientStroke
        }
      ]
    },
    options: {
        legend: false,
        responsive: true, 
        maintainAspectRatio: false,  
        scales: {
            yAxes: [{
                display: false, 
                ticks: {
                    beginAtZero: true, 
                    display: false, 
                    max: 100, 
                    min: 0, 
                    stepSize: 10
                }, 
                gridLines: {
                    display: false, 
                    drawBorder: false
                }
            }],
            xAxes: [{
                display: false, 
                barPercentage: 0.3, 
                gridLines: {
                    display: false, 
                    drawBorder: false
                }, 
                ticks: {
                    display: false
                }
            }]
        }
    }
  });
}

//pie chart total Kejahatan
if(jQuery('#pie_chart_2').length > 0 ){
  //pie chart
  const pie_chart = document.getElementById("pie_chart_2").getContext('2d');
  // pie_chart.height = 100;
  new Chart(pie_chart, {
    type: 'pie',
    data: {
      defaultFontFamily: 'Poppins',
      datasets: [{
          data: [{{ $count_kasus_selesai }}, {{ $count_kasus_belum }}],
          borderWidth: 0, 
          backgroundColor: [
              "rgb(41,200,112)",
              "rgb(242,87,103)"
          ],
          hoverBackgroundColor: [
              "rgb(41,200,112)",
              "rgb(242,87,103)"
          ]

      }],
      labels: [
          "done",
          "progress"
      ]
    },
    options: {
      responsive: true, 
      legend: false, 
      maintainAspectRatio: false
    }
  });
}

// select2
$("#satker").select2();
$("#jenis_kasus").select2();
$("#month-select2").select2();
$("#year-select2").select2();
</script>

@if($is_open == true)
<!-- google maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYiwleTNi8Ww0Un6Jna9LuQyWGvdFYEcI&callback=initMap"
async defer></script>

<script>
  function initMap() {
    var options = {
        zoom:8,
        center:{lat:-0.528119,lng:100.538150}
    }

    var locations = [
      @foreach($petas as $i=>$peta)
        @if($peta != null)
        [new google.maps.LatLng(
          {{$peta->lat}}, 
          {{$peta->long}}), 
          '{{$peta->divisi}}', 
          'No LP: {{ $peta->no_lp }}, <a target="_blank" href="{{URL::to('/perkara/show/'.$peta->id)}}">Detail</a>',
          '{{$peta->pin}}'],
        @endif
      @endforeach
    ];

    var map = new google.maps.Map(document.getElementById('map'), options);

    var infowindow = new google.maps.InfoWindow();

    for (var i = 0; i < locations.length; i++) {
      var marker = new google.maps.Marker({
        position: locations[i][0],
        map: map,
        title: locations[i][1],
        icon: locations[i][3],
      });

      // Register a click event listener on the marker to display the corresponding infowindow content
      google.maps.event.addListener(marker, 'click', (function(marker, i) {

        return function() {
          infowindow.setContent(locations[i][2]);
          infowindow.open(map, marker);
        }

      })(marker, i));
    }
  }

  //basic bar chart
  if(jQuery('#barChart_1').length > 0 ){
    const barChart_1 = document.getElementById("barChart_1").getContext('2d');
    
    barChart_1.height = 100;

    new Chart(barChart_1, {
      type: 'bar',
      data: {
          defaultFontFamily: 'Poppins',
          labels: [
            "Jan", 
            "Feb", 
            "Mar", 
            "Apr", 
            "May", 
            "Jun", 
            "Jul", 
            "Aug", 
            "Sep", 
            "Oct", 
            "Nov", 
            "Des"
          ],
          datasets: [
            {
              label: "Kejahatan Selesai",
              data: [
                {{ $jan_f_diagram_done }}, 
                {{ $feb_f_diagram_done }}, 
                {{ $mar_f_diagram_done }}, 
                {{ $apr_f_diagram_done }}, 
                {{ $mei_f_diagram_done }}, 
                {{ $jun_f_diagram_done }}, 
                {{ $jul_f_diagram_done }}, 
                {{ $aug_f_diagram_done }}, 
                {{ $sep_f_diagram_done }}, 
                {{ $oct_f_diagram_done }}, 
                {{ $nov_f_diagram_done }}, 
                {{ $des_f_diagram_done }},
              ],
              borderColor: 'rgba(58, 122, 254, 1)',
              borderWidth: "0",
              backgroundColor: 'rgba(58, 122, 254, 1)'
            },
            {
              label: "Kejahatan Progress",
              data: [
                {{ $jan_f_diagram_progres }}, 
                {{ $feb_f_diagram_progres }}, 
                {{ $mar_f_diagram_progres }}, 
                {{ $apr_f_diagram_progres }}, 
                {{ $mei_f_diagram_progres }}, 
                {{ $jun_f_diagram_progres }}, 
                {{ $jul_f_diagram_progres }}, 
                {{ $aug_f_diagram_progres }}, 
                {{ $sep_f_diagram_progres }}, 
                {{ $oct_f_diagram_progres }}, 
                {{ $nov_f_diagram_progres }}, 
                {{ $des_f_diagram_progres }},
              ],
              borderColor: 'rgba(58, 122, 254, 1)',
              borderWidth: "0",
              backgroundColor: 'rgb(234,67,53)'
            }
          ]
      },
      options: {
        legend: false, 
        scales: {
          yAxes: [{
              ticks: {
                  beginAtZero: true
              }
          }],
          xAxes: [{
              // Change here
              barPercentage: 0.5
          }]
        }
      }
    });
  }

  // chart time
  // variable
  var time_session_1 = {{ $data_time[0] }};
  var time_session_2 = {{ $data_time[1] }};
  var time_session_3 = {{ $data_time[2] }};
  var time_session_4 = {{ $data_time[3] }};
  var time_session_5 = {{ $data_time[4] }};
  var time_session_6 = {{ $data_time[5] }};
  var time_session_7 = {{ $data_time[6] }};
  var time_session_8 = {{ $data_time[7] }};
  var min            = {{ $min }};
  var max            = {{ $max }};
  var range          = {{ $range }};

  if(jQuery('#lineChart_1').length > 0){
    let draw = Chart.controllers.line.__super__.draw; //draw shadow
    
    //basic line chart
    const lineChart_1 = document.getElementById("lineChart_1").getContext('2d');

    Chart.controllers.line = Chart.controllers.line.extend({
      draw: function () {
        draw.apply(this, arguments);
        let nk = this.chart.chart.ctx;
        let _stroke = nk.stroke;
        nk.stroke = function () {
          nk.save();
          nk.shadowColor = 'rgba(255, 0, 0, .2)';
          nk.shadowBlur = 10;
          nk.shadowOffsetX = 0;
          nk.shadowOffsetY = 10;
          _stroke.apply(this, arguments)
          nk.restore();
        }
      }
    });
    
    lineChart_1.height = 100;

    new Chart(lineChart_1, {
      type: 'line',
      data: {
        defaultFontFamily: 'Poppins',
        labels: [
          "00.00-03.00", 
          "03.01-06.00", 
          "06.01-09.00", 
          "09.01-12.00", 
          "12.01-15.00", 
          "15.01-18.00", 
          "18.01-21.00",
          "21.01-23.59"
        ],
        datasets: [
          {
            label: "Jumlah Kejahatan",
            data: [
              time_session_1, 
              time_session_2, 
              time_session_3, 
              time_session_4, 
              time_session_5, 
              time_session_6, 
              time_session_7, 
              time_session_8, 
            ],
            borderColor: 'rgba(56, 164, 248, 1)',
            borderWidth: "2",
            backgroundColor: 'transparent',  
            pointBackgroundColor: 'rgba(56, 164, 248, 1)'
          }
        ]
      },
      options: {
        legend: false, 
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true, 
              max: max, 
              min: min, 
              stepSize: range, 
              padding: 10
            }
          }],
          xAxes: [{
            ticks: {
              padding: 5
            }
          }]
        }
      }
    });
  }
</script>
@endif

<!-- First Chart Admin-->
@if(Auth::user()->groups()->where("name", "=", "Admin")->first())
<script>

</script>
@endif

<!-- First Chart Bukan Admin-->
@if(Auth::user()->groups()->where("name", "!=", "Admin")->first())
<script>

</script>
@endif