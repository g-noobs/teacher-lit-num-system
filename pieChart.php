<section class="content">
    <div class="row">
        <!-- Chart JS -- Donut -->
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Donut Chart</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body" style="">
                    <canvas id="pieChart" style="height: 165px; width: 331px;" height="206" width="413"></canvas>
                </div>
            </div>
        </div>

        <!-- Morris.js -- Donut -->
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Donut Chart</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="sales-chart" style="height: 300px; position: relative;"><svg height="300"
                            version="1.1" width="274.225" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            style="overflow: hidden; position: relative; top: -0.200012px;">
                            <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.3.0
                            </desc>
                            <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
                            <path fill="none" stroke="#3c8dbc"
                                d="M137.1125,234.74166666666667A84.74166666666667,84.74166666666667,0,0,0,217.28133096048992,177.4610380698334"
                                stroke-width="2" opacity="0"
                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path>
                            <path fill="#3c8dbc" stroke="#ffffff"
                                d="M137.1125,237.74166666666667A87.74166666666667,87.74166666666667,0,0,0,220.11944475199118,178.43320580561272L252.6355567882328,189.57127754511785A122.11250000000001,122.11250000000001,0,0,1,137.1125,272.1125Z"
                                stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                            <path fill="none" stroke="#f56954"
                                d="M217.28133096048992,177.4610380698334A84.74166666666667,84.74166666666667,0,0,0,61.1101908741805,112.51935063278893"
                                stroke-width="2" opacity="1"
                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path>
                            <path fill="#f56954" stroke="#ffffff"
                                d="M220.11944475199118,178.43320580561272A87.74166666666667,87.74166666666667,0,0,0,58.41957908489002,111.19247151269886L23.109036311270756,93.7790259491834A127.11250000000001,127.11250000000001,0,0,1,257.3657464407349,191.19155710475007Z"
                                stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                            <path fill="none" stroke="#00a65a"
                                d="M61.1101908741805,112.51935063278893A84.74166666666667,84.74166666666667,0,0,0,137.08587762069266,234.74166248483309"
                                stroke-width="2" opacity="0"
                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path>
                            <path fill="#00a65a" stroke="#ffffff"
                                d="M58.41957908489002,111.19247151269886A87.74166666666667,87.74166666666667,0,0,0,137.0849351429121,237.74166233678903L137.07413722733992,272.11249397398973A122.11250000000001,122.11250000000001,0,0,1,27.59338929342158,95.99049114933354Z"
                                stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text
                                x="137.1125" y="140" text-anchor="middle" font-family="&quot;Arial&quot;"
                                font-size="15px" stroke="none" fill="#000000"
                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 15px; font-weight: 800;"
                                font-weight="800" transform="matrix(1.4523,0,0,1.4523,-62.1158,-68.2105)"
                                stroke-width="0.6885515394664946">
                                <tspan style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);" dy="5.999995231628418">
                                    In-Store Sales</tspan>
                            </text><text x="137.1125" y="160" text-anchor="middle" font-family="&quot;Arial&quot;"
                                font-size="14px" stroke="none" fill="#000000"
                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 14px;"
                                transform="matrix(1.9444,0,0,1.9444,-129.5948,-143.5556)"
                                stroke-width="0.5142857142857143">
                                <tspan style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);" dy="4.8000030517578125">30
                                </tspan>
                            </text>
                        </svg></div>
                </div>

            </div>
        </div>
    </div>
</section>


<script>
$(function() {
    var admin_count = "";
    var teacher_count = "";
    var student_count = "";
    //ajax code to get the count from the backend

    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieChart = new Chart(pieChartCanvas)
    var PieData = [{
            value: admin_count,
            color: '#f56954',
            highlight: '#f56954',
            label: 'Admin'
        },
        {
            value: teacher_count,
            color: '#00a65a',
            highlight: '#00a65a',
            label: 'Teacher'
        },
        {
            value: student_count,
            color: '#f39c12',
            highlight: '#f39c12',
            label: 'Student'
        }
    ]
    var pieOptions = {
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke: true,
        //String - The colour of each segment stroke
        segmentStrokeColor: '#fff',
        //Number - The width of each segment stroke
        segmentStrokeWidth: 2,
        //Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 50, // This is 0 for Pie charts
        //Number - Amount of animation steps
        animationSteps: 100,
        //String - Animation easing effect
        animationEasing: 'easeOutBounce',
        //Boolean - Whether we animate the rotation of the Doughnut
        animateRotate: true,
        //Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale: false,
        //Boolean - whether to make the chart responsive to window resizing
        responsive: true,
        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: true,
        //String - A legend template
        legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions)
});
</script>

<!-- Morris Donut Chart -->
<script>
$(function() {
    var admin_count = "";
    var teacher_count = "";
    var student_count = "";
    
    //DONUT CHART
    var donut = new Morris.Donut({
        element: 'sales-chart',
        resize: true,
        colors: ["#3c8dbc", "#f56954", "#00a65a"],
        data: [{
                label: "Download Sales",
                value: 12
            },
            {
                label: "In-Store Sales",
                value: 30
            },
            {
                label: "Mail-Order Sales",
                value: 20
            }
        ],
        hideHover: 'auto'
    });
});
</script>