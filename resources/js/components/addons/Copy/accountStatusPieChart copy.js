/*
 *
 *
 *
 */

class accountStatusPieChart {

    constructor() {
        const data = this.preparePieData();
        this.generatePieChartGraph('graphPieChart', data);
    }

    preparePieData() {
        var snapshotData = [
            {
                name: "Completed",
                value: $('#total_completed_pct').val(),
                className: "completed"
            },
            {
                name: "Not Completed",
                value: $('#total_not_completed_pct').val(),
                className: "notCompleted"
            }
        ];
        return snapshotData;
    }

    generatePieChartGraph(id, data) {

        var parentWidth = $("#" + id).width();

        //set the dimensions and margins of the graph
        var margin = { top: 20, right: 20, bottom: 150, left: 100 },
            // width = parentWidth / 2,
            width = parentWidth,
            height = 500 - margin.top - margin.bottom;

        var text = "";
        var thickness = 40;
        var duration = 750;
        var padding = 10;
        var opacity = .8;
        var opacityHover = 1;
        var otherOpacityOnHover = .8;
        var tooltipMargin = 13;

        var radius = Math.min(width - padding, height - padding) / 2;
        var color = d3.scaleOrdinal(d3.schemeCategory10);

        var svg = d3.select("#" + id)
            .append('svg')
            .attr('class', 'pie')
            .attr('width', width)
            .attr('height', height);

        var g = svg.append('g')
            .attr('transform', 'translate(' + (width / 2) + ',' + (height / 2) + ')');

        var arc = d3.arc()
            .innerRadius(0)
            .outerRadius(radius);

        var pie = d3.pie()
            .value(function (d) { return d.value; })
            .sort(null);

        var path = g.selectAll('path')
            .data(pie(data))
            .enter()
            .append("g")
            .append('path')
            .attr('d', arc)
            .attr('class', (d, i) => data[i].className)
            .style('opacity', opacity)
            .style('stroke', 'white')
            .on("mouseover", function (d) {
                d3.selectAll('path')
                    .style("opacity", otherOpacityOnHover);
                d3.select(this)
                    .style("opacity", opacityHover);

                var g = d3.select("svg")
                    .style("cursor", "pointer")
                    .append("g")
                    .attr("class", "tooltip")
                    .style("opacity", 0);

                g.append("text")
                    .attr("class", "name-text")
                    .text(`${d.data.name} (${d.data.value})`)
                    .attr('text-anchor', 'middle');

                var text = g.select("text");
                var bbox = text.node().getBBox();
                var padding = 2;
                g.insert("rect", "text")
                    .attr("x", bbox.x - padding)
                    .attr("y", bbox.y - padding)
                    .attr("width", bbox.width + (padding * 2))
                    .attr("height", bbox.height + (padding * 2))
                    .style("fill", "white")
                    .style("opacity", 0.75);
            })
            .on("mousemove", function (d) {
                var mousePosition = d3.mouse(this);
                var x = mousePosition[0] + width / 2;
                var y = mousePosition[1] + height / 2 - tooltipMargin;

                var text = d3.select('.tooltip text');
                var bbox = text.node().getBBox();
                if (x - bbox.width / 2 < 0) {
                    x = bbox.width / 2;
                }
                else if (width - x - bbox.width / 2 < 0) {
                    x = width - bbox.width / 2;
                }

                if (y - bbox.height / 2 < 0) {
                    y = bbox.height + tooltipMargin * 2;
                }
                else if (height - y - bbox.height / 2 < 0) {
                    y = height - bbox.height / 2;
                }

                d3.select('.tooltip')
                    .style("opacity", 1)
                    .attr('transform', `translate(${x}, ${y})`);
            })
            .on("mouseout", function (d) {
                d3.select("svg")
                    .style("cursor", "none")
                    .select(".tooltip").remove();
                d3.selectAll('path')
                    .style("opacity", opacity);
            })
            .on("touchstart", function (d) {
                d3.select("svg")
                    .style("cursor", "none");
            })
            .each(function (d, i) { this._current = i; });

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
            .text(d => `${d.name} (${d.value})`);

        keys.exit().remove();

    }
}

export { accountStatusPieChart as default };
