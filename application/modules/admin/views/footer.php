<script src="<?=base_url()?>application/jquery/jquery.min.js"></script>
<script src="<?=base_url()?>application/jquery/choosen/chosen.jquery.js" type="text/javascript"></script>
<script src="<?=base_url()?>application/jquery/choosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=base_url()?>application/jquery/choosen/docsupport/init.js" type="text/javascript" charset="utf-8"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<!-- Additional files for the Highslide popup effect -->
<script src="https://www.highcharts.com/media/com_demo/js/highslide-full.min.js"></script>
<script src="https://www.highcharts.com/media/com_demo/js/highslide.config.js" charset="utf-8"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>


<script>

$(document).ready(function() {
    
    $.getJSON('<?=base_url()?>admin/User/visitdata', function(data) {
        
        console.log(data);
        $('#containers').highcharts({

            chart: {
                scrollablePlotArea: {
                    minWidth: 700
                }
            },
        
        
            title: {
                text: 'Daily sessions at www.highcharts.com'
            },
        
            subtitle: {
                text: 'Source: Google Analytics'
            },
            
            yAxis: {
                title: {
                    text: 'View'
                }
            },
            
           xAxis: {
              type: 'datetime',
              categories: data.date
            },
    

          series: [{"name":'Video Viewer' ,"data":data.count}]

        });
    });
    
    
    
    Highcharts.chart('container', {
        chart: {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 15,
                beta: 15,
                viewDistance: 25,
                depth: 50
            }
        },
    
        title: {
            text: ''
        },
    
        xAxis: {
            // categories: ['04-10-2018', '05-10-2018', '06-10-2018', '07-10-2018', '08-10-2018'],
            categories: ['statistic'],
            labels: {
                skew3d: true,
                style: {
                    fontSize: '14px'
                }
            }
        },
    
        yAxis: {
            title: {
                text: 'time in minute',
                skew3d: true
            }
        },
    
        // tooltip: {
        //     headerFormat: '<b>{point.key}</b><br>',
        //     pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
        // },
        

        //     column: {
        //         stacking: 'normal',
        //         depth: 50
        //     }
        // },
    
        series: <?=json_encode($video)?>
        
        // [{
        //     name: 'John',
        //     data: [5, 3],
        //     stack: 'male'
        // }, {
        //     name: 'Joe',
        //     data: [3, 4],
        //     stack: 'male'
        // }, {
        //     name: 'Jane',
        //     data: [2, 5],
        //     stack: 'female'
        // }, {
        //     name: 'Janet',
        //     data: [3, 0],
        //     stack: 'female'
        // }]
    });
});
</script>


</body>
