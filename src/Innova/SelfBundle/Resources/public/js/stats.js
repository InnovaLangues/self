$(function() {
    $('input#search').quicksearch('#data-table tbody tr');
    chartHandler.init(chartHandler.generateChart);
});

var chartHandler = {
    type: $("#data-table").data("chart-type"),
    labels:  $("#data-table").data("labels"),
    numbers: $("#data-table").data("numbers"),
    aggregate: $("#data-table").data("aggregate") ==  1 ? true : false,
    datas: { label: [], number: [], color: [] },

    init: function(callback){
        var aggregate = chartHandler.aggregate;
        $(".chart-data").each(function(){
            var label = $(this).data(chartHandler.labels);
            var number = $(this).data(chartHandler.numbers);
            var idx = chartHandler.datas.label.indexOf(label);
            if (aggregate && idx != -1) {
                chartHandler.datas.number[idx] += number;
            } else {
                chartHandler.datas.label.push(label);
                chartHandler.datas.number.push(number);
                chartHandler.datas.color.push(chartHandler.dynamicColors());
            }
        });

        callback();
    },

    getItems: function(){
        return $(".chart-data");
    },


    dynamicColors: function() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);

        return "rgb(" + r + "," + g + "," + b + ")";
    },


    generateChart: function(){
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
        type: chartHandler.type,
        data: {
            labels: chartHandler.datas.label,
            datasets: [{
                data: chartHandler.datas.number,
                backgroundColor: chartHandler.datas.color,
                borderWidth: 1
            }]
            },
            options: {
                scales: {
                   xAxes: [{
                       display: false
                   }],
                },
                legend: {
                    display: false,
                },
                responsive: true,
            }
        });
    },
}
