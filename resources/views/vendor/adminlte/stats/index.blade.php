@extends('adminlte::layouts.app')

@section('title','Estadísticas')
@section('content_header','Estadísticas')
@section('content_description','')


@section('main-content')
<div class="container-fluid spark-screen">

  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-body">

            <div class="col-md-12">
                <div class="col-md-3">
                    <canvas id="edadChart" width="100" height="100"></canvas>
                    <hr>
                </div>
                <div class="col-md-3">
                    <canvas id="sexoChart" width="100" height="100"></canvas>
                    <hr>
                </div>
              </div>
          
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>

</div>
@endsection


@section('page_styles')
  
  <style type="text/css">
    .chart-container {
      position: relative;
      margin: auto;
      height: 20vh;
      width: 80vw;
    }
  </style>

@endsection

@section('page_scripts')
        
<script>

$(document).ready(function() {

  var edadData = {
    labels: [
          "0-10",
          "10-20",
          "20-30",
          "30-40",
          "40-50",
          "50-60",
          "60+"
      ],
      datasets: [
          {
              data: [
                "<?php echo $edad['age10']; ?>",
                "<?php echo $edad['age20']; ?>",
                "<?php echo $edad['age30']; ?>",
                "<?php echo $edad['age40']; ?>",
                "<?php echo $edad['age50']; ?>",
                "<?php echo $edad['age60']; ?>",
                "<?php echo $edad['age60plus']; ?>"
              ],
              backgroundColor: [
                  "rgba(0, 153, 153, 1)",
                  "rgba(204, 0, 0, 1)",
                  "rgba(102, 0, 102, 1)",
                  "rgba(0, 128, 0, 1)",
                  "rgba(0, 0, 128, 1)",
                  "rgba(153, 153, 102, 1)",
                  "rgba(102, 102, 102, 1)"
              ],
              borderColor: "black",
              borderWidth: 1
          }]
  };

  var sexoData = {
    labels: [ "Hombre","Mujer"],
      datasets: [
          {
              data: [ "<?php echo $sexo['hombre']; ?>",  "<?php echo $sexo['mujer']; ?>"],
              backgroundColor: [ "rgba(0, 153, 153, 1)",  "rgba(204, 0, 0, 1)"],
              borderColor: "black",
              borderWidth: 1
          }]
  };

  var edadOptions = {
    legend:{
      display: false
    },
    cutoutPercentage: 70,
        title: {
          display: true,
          text: 'Edad Pacientes',
        },
    animation: {
      animateRotate: false,
      animateScale: true
    }
  };

  var sexoOptions = {
    legend:{
      display: false
    },
    cutoutPercentage: 70,
        title: {
          display: true,
          text: 'Sexo',
        },
    animation: {
      animateRotate: false,
      animateScale: true
    }
  };


  var edadCanvas = document.getElementById("edadChart");
  var sexoCanvas = document.getElementById("sexoChart");

  var edadChart = new Chart(edadCanvas, {
    type: 'doughnut',
    data: edadData,
    options: edadOptions
  });

  var sexoChart = new Chart(sexoCanvas, {
    type: 'doughnut',
    data: sexoData,
    options: sexoOptions
  });
});
</script>
@endsection
