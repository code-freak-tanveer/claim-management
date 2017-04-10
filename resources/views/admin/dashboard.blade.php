@extends('layouts.main')
@section('heading')
    <a class="navbar-brand" href="#">Admin Dashboard</a>
@endsection

@section('body')
<script type="text/javascript">

$(function () {
    var chartData=1;
     $.ajax({
            type: "GET",
            url: '/admin/claimscount',
            dataType: 'json',
            success: function(json) {

                
        },
            complete: function(data) {
                loadChart(data);
              
        }
    })

   $.ajax({
        type: "GET",
        url: '/admin/module_claims',
        dataType: 'json',
        success: function(json) {

            
        },
        complete: function(data) {
            loadBarchart(data);
        }
    })
   $.ajax({
        type: "GET",
        url: '/admin/claims/student',
        dataType: 'json',
        success: function(json) {

            
        },
        complete: function(data) {
            loadBarchartstudentcount(data);
        }
    })


     function loadChart(data){
        var chartData=data.responseJSON;
    
        

        var chart = new CanvasJS.Chart("chartContainer",
            {
                title:{
                    text: "Claim Submitted by each Faculty"
                },
                        animationEnabled: true,
                legend:{
                    verticalAlign: "center",
                    horizontalAlign: "left",
                    fontSize: 14,
                    fontFamily: "Helvetica"        
                },
                theme: "theme2",
                data: [
                {        
                    type: "pie",       
                    indexLabelFontFamily: "Garamond",       
                    indexLabelFontSize: 12,
                    indexLabel: "{label} {y}%",
                    startAngle:0,      
                    showInLegend: true,
                    toolTipContent:"{legendText} {y}%",
                    dataPoints: chartData
                }
                ]
            });
            chart.render();
     }

     function loadBarchart(data){
        var chart = new CanvasJS.Chart("barchart",
        {
          title:{
            text: "Claims"    
          },
          axisY: {
            title: "Quantity"
          },
          legend: {
            verticalAlign: "bottom",
            horizontalAlign: "center"
          },
          data: [

          {        
            color: "#B0D0B0",
            type: "column",  
            showInLegend: true, 
            legendMarkerType: "none",
            legendText: "",
            dataPoints: data.responseJSON
          }
          ]
        });

        chart.render();
     }

      function loadBarchartstudentcount(data){
        var chart = new CanvasJS.Chart("barchart_student",
        {
          title:{
            text: "Claims"    
          },
          axisY: {
            title: "Quantity"
          },
          legend: {
            verticalAlign: "bottom",
            horizontalAlign: "center"
          },
          data: [

          {        
            color: "#B0D0B0",
            type: "column",  
            showInLegend: true, 
            legendMarkerType: "none",
            legendText: "",
            dataPoints: data.responseJSON
          }
          ]
        });

        chart.render();
     }
   
});
</script>
<div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Claim Percentage</h4>
                                <p class="category">Claim each faculty</p>
                            </div>
                            <div class="content">
                                <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Claim count</h4>
                                <p class="category">By Faculty</p>
                            </div>
                            <div class="content">
                              <div id="barchart" style="height: 300px; width: 100%;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Student</h4>
                                <p class="category">submitted claim / Faculty</p>
                            </div>
                            <div class="content">
                              <div id="barchart_student" style="height: 300px; width: 100%;">
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title">Tasks</h4>
                                <p class="category">Backend development</p>
                            </div>
                            <div class="content">
                                <div class="table-full-width">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="" data-toggle="checkbox">
                                                    </label>
                                                </td>
                                                <td>Sign contract for "What are conference organizers afraid of?"</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="" data-toggle="checkbox" checked="">
                                                    </label>
                                                </td>
                                                <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="" data-toggle="checkbox" checked="">
                                                    </label>
                                                </td>
                                                <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="" data-toggle="checkbox">
                                                    </label>
                                                </td>
                                                <td>Create 4 Invisible User Experiences you Never Knew About</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="" data-toggle="checkbox">
                                                    </label>
                                                </td>
                                                <td>Read "Following makes Medium better"</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="" data-toggle="checkbox">
                                                    </label>
                                                </td>
                                                <td>Unfollow 5 enemies from twitter</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> Updated 3 minutes ago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
@endsection