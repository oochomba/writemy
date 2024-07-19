<!doctype html>
@extends('layouts.app')
@section('title','Dashboard')
@section('content')
  <script src="http://www.chartjs.org/dist/2.7.3/Chart.bundle.js"></script>

  
  <style>
  canvas {
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
  }
  </style>
    <div id="container  " style="width: 80%; background-color:#fff;">
        <div id="card-body " >
            <div id="card " >
                <canvas id="canvas"></canvas>
            </div>
        </div>
    </div>
    <script>

    var chartdata = {
    type: 'bar', data: {
    labels: <?php echo json_encode($Months); ?>,
    // labels: month,
    datasets: [
        {
        label: 'Income By Month',
        backgroundColor: '#26B99A',
        borderWidth: 1,
        data: <?php echo json_encode($Data); ?>
        }
    ]
    },
    options: {
    scales: {
    yAxes: [{
    ticks: {
    beginAtZero:true
    }
    }]
    }
    }
    }


    var ctx = document.getElementById('canvas').getContext('2d');
    new Chart(ctx, chartdata);
    </script>
@stop