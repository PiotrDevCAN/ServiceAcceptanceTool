/*
 *
 *
 *
 */

class accountStatusPieChart {

    constructor(checklistId) {
        this.generatePieChartGraph('graphPieChart', checklistId);
    }

    generatePieChartGraph(id, checklistId) {

        var $this = this;

        var margin = 20,
            width = $("#graphPieChart").width() - margin,
            height = 300 - margin,
            radius = Math.min(width, height) / 2;

        var svg = d3.select("#" + id)
            .append("svg")
            .attr('class', 'pie')
            .attr("width", width)
            // .attr("height", height + 250);
            .attr("height", height);

        var g = svg.append("g")
            .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

        var color = d3.scaleOrdinal(['#A50E8C', '#052F4F']);

        var pie = d3.pie().value(function (d) {
            return d.value;
        });

        var path = d3.arc()
            .outerRadius(radius - 10)
            .innerRadius(0);

        var label = d3.arc()
            .outerRadius(radius)
            .innerRadius(radius - 80);

        d3.json(window.appUrl + '/api/checklist/calculation/' + checklistId, function (error, data) {
            if (error) {
                throw error;
            }

            var data = [
                {
                    name: "Completed",
                    value: data.record.completed_pct,
                    className: "completed"
                },
                {
                    name: "Not Completed",
                    value: data.record.not_completed_pct,
                    className: "notCompleted"
                }
            ];

            console.log('Pie Chart data');
            console.log(data);

            var arc = g.selectAll(".arc")
                .data(pie(data))
                .enter().append("g")
                .attr("class", "arc");

            arc.append("path")
                .attr("d", path)
                .attr("fill", function (d) { return color(d.name); });

            console.log(arc);

            arc.append("text")
                .attr("transform", function (d) {
                    return "translate(" + label.centroid(d) + ")";
                })
                .text(function (d) { return d.name; });

            var legend = d3.select("#" + id).append('div')
                .attr('class', 'legend')
                .style('margin-top', '30px');

            var keys = legend.selectAll('.key')
                .data(data)
                .enter().append('div')
                .attr('class', 'key')
                .style('display', 'flex')
                .style('align-items', 'center')
                .style('margin-right', '20px');

            keys.append('div')
                .attr('class', 'symbol')
                .style('height', '10px')
                .style('width', '10px')
                .style('margin', '5px 5px')
                .attr('class', d => `${d.className}`);

            keys.append('div')
                .attr('class', 'name')
                .text(d => `${d.name} (${d.value} %)`);

        });

        // svg.append("g")
        //     .attr("transform", "translate(" + (width / 2 - 120) + "," + 20 + ")")
        //     .append("text")
        //     .text("Browser use statistics - Jan 2017")
        //     .attr("class", "title");
    }
}

export { accountStatusPieChart as default };
