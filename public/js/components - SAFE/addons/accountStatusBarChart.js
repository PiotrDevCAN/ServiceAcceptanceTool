/*
 *
 *
 *
 */

class accountStatusBarChart {

    x;
    y;

    width;
    height;

    constructor(checklistId) {
        this.generateBarGraph('graphBarChart', checklistId);
    }

    //mouseover event handler function
    onMouseOver(d, i) {
        var $this = this;
        d3.select(this).attr('class', 'highlight');
        d3.select(this)
            .transition()     // adds animation
            .duration(400)
            .attr('width', $this.x.bandwidth() + 5)
            .attr("y", function (d) { return $this.y(d.value) - 10; })
            .attr("height", function (d) { return $this.height - $this.y(d.value) + 10; });

        g.append("text")
            .attr('class', 'val')
            .attr('x', function () {
                return $this.x(d.year);
            })
            .attr('y', function () {
                return $this.y(d.value) - 15;
            })
            .text(function () {
                return ['$' + d.value];  // Value of the text
            });
    }

    //mouseout event handler function
    onMouseOut(d, i) {
        var $this = this;
        // use the text label class to remove label on mouseout
        d3.select(this).attr('class', 'bar');
        d3.select(this)
            .transition()     // adds animation
            .duration(400)
            .attr('width', $this.x.bandwidth())
            .attr("y", function (d) { return $this.y(d.value); })
            .attr("height", function (d) { return $this.height - $this.y(d.value); });

        d3.selectAll('.val')
            .remove();
    }

    generateBarGraph(id, checklistId) {

        var $this = this;

        var margin = 20,
            width = $("#graphBarChart").width() - margin,
            height = 300 - margin;

        $this.width = width;
        $this.height = height;

        var svg = d3.select("#" + id)
            .append("svg")
            .attr('class', 'barChart')
            .attr("width", width)
            .attr("height", height + 250);

        // svg.append("text")
        //     .attr("transform", "translate(100,0)")
        //     .attr("x", 50)
        //     .attr("y", 50)
        //     .attr("font-size", "24px");
        // .text("XYZ Foods Stock Price");

        var xScale = d3.scaleBand().range([0, width]).padding(0.4),
            yScale = d3.scaleLinear().range([height, 0]);

        $this.x = xScale;
        $this.y = yScale;

        var g = svg.append("g")
            .attr("transform", "translate(" + 20 + "," + 20 + ")");

        var $this = this;

        d3.json(window.appUrl + '/api/checklist/calculation/' + checklistId, function (error, data) {
            if (error) {
                throw error;
            }

            var data = data.calculation;

            xScale.domain(data.map(function (d) { return d.name; }));
            yScale.domain([0, d3.max(data, function (d) {
                return parseInt(d.services_completed) + parseInt(d.services_not_completed);
            })]);

            // add the x Axis
            g.append("g")
                .attr("class", "axis")
                .attr("transform", "translate(0," + height + ")")
                .call(d3.axisBottom(xScale).ticks(10))
                .selectAll("text")
                .style("text-anchor", "end")
                .attr("dx", "-.8em")
                .attr("dy", ".15em")
                .attr("transform", "rotate(-90)");

            // g.append("g")
            //     .attr("transform", "translate(0," + height + ")")
            //     .call(d3.axisBottom(xScale))
            //     .append("text")
            //     // .attr("y", height - 250)
            //     // .attr("x", width - 100)
            //     .attr("y", 50)
            //     .attr("x", 200)
            //     .attr("text-anchor", "end")
            //     .attr("stroke", "black")
            //     .text("Category Name");

            // add the y Axis
            g.append("g")
                .call(d3.axisLeft(yScale).tickFormat(function (d) {
                    return d;
                })
                    .ticks(7))
                .append("text")
                .attr("transform", "rotate(-90)")
                .attr("y", 6)
                .attr("dy", "-5.1em")
                .attr("text-anchor", "end")
                .attr("stroke", "black")
                .text("Completed / Not Completed");

            g.selectAll(".bar-completed")
                .data(data)
                .enter().append("rect")
                .attr("class", "bar-completed")
                .attr("class", "completed")
                // .on("mouseover", $this.onMouseOver) //Add listener for the mouseover event
                // .on("mouseout", $this.onMouseOut)   //Add listener for the mouseout event
                .attr("x", function (d) { return xScale(d.name); })
                .attr("y", function (d) { return yScale(d.services_completed); })
                .attr("width", xScale.bandwidth())
                .attr("height", function (d) { return height - yScale(d.services_completed); });

            g.selectAll(".bar-not-completed")
                .data(data)
                .enter().append("rect")
                .attr("class", "bar-completed")
                .attr("class", "notCompleted")
                // .on("mouseover", $this.onMouseOver) //Add listener for the mouseover event
                // .on("mouseout", $this.onMouseOut)   //Add listener for the mouseout event
                .attr("x", function (d) { return xScale(d.name); })
                .attr("y", function (d) { return yScale(d.services_completed) - (height - yScale(d.services_not_completed)); })
                .attr("width", xScale.bandwidth())
                .attr("height", function (d) { return height - yScale(d.services_not_completed); });
        });
    }
}

export { accountStatusBarChart as default };
