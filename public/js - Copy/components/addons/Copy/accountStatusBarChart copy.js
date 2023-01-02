/*
 *
 *
 *
 */

class accountStatusBarChart {

    constructor() {

        const data = this.prepareBarData();
        this.generateBarGraph('graphBarChart', data);

    }

    prepareBarData() {
		var snapshotData = [
	      	// {name: "Completed", value: $('#TW_COMPL_NUM').val(), className: "completed"},
            // {name: "Not Completed", value: $('#TW_COMPL_NUM').val(), className: "notCompleted"},
            {name: "Completed", value: 40, className: "completed"},
            {name: "Not Completed", value: 60, className: "notCompleted"},
	     ];
		 return snapshotData;
    }

    generateBarGraph(id, sourceCsv) {

		var parentWidth = $("#"+id).width();

		//set the dimensions and margins of the graph
	    var margin = {top: 20, right: 20, bottom: 150, left: 100},
	        width = parentWidth - margin.left - margin.right - 180,
	        height = 500 - margin.top - margin.bottom;

	 	// set the ranges
	    var x = d3.scaleBand()
	        .range([0, width])
	        .padding(0.1);

	    var y = d3.scaleLinear()
			.range([height, 0]);

	    // append the svg object to the body of the page
	    // append a 'group' element to 'svg'
	    // moves the 'group' element to the top left margin
	    var svg = d3.select("#"+id).append("svg")
	        .attr("width", width + margin.left + margin.right)
	        .attr("height", height + margin.top + margin.bottom)
	      .append("g")
	        .attr("transform",
	              "translate(" + margin.left + "," + margin.top + ")");

	    // get the data
	    d3.csv(sourceCsv, function(d) {
		  return {
			month : d["MONTH NAME"],
			inScope : d["IN SCOPE"],
		    completed : +d["COMPL NUM"],
		    overdue : +d["OVER NUM"],
		    inProgress : +d["IN PROGRESS"]
		  };
	    }, function(error, data) {

	      if (error && error.target.status === 404) {
    	      console.log("File not found");
    	  }

    	  if (data.length === 0){
    		  console.log("File empty");
		  }

	      // Scale the range of the data in the domains
	      x.domain(data.map(function(d) { return d.month; }));
	      y.domain([0, d3.max(data, function(d) { return +d.inScope; })]);

	      // append the rectangles for the bar chart
	      svg.selectAll(".bar-inProgress")
		    .data(data)
		    .enter().append("rect")
		      .attr("class", "bar-inProgress")
		      .attr("x", function(d) { return x(d.month); })
		      .attr("y", function(d) { return y(d.inProgress); })
		      .attr("width", x.bandwidth() / 4)
		      .attr("height", function(d) { return height - y(d.inProgress); });

	      svg.selectAll(".bar-overdue")
		    .data(data)
		    .enter().append("rect")
		      .attr("class", "bar-overdue")
		      .attr("x", function(d) { return x(d.month) + ((x.bandwidth() / 4) + 2); })
		      .attr("y", function(d) { return y(d.overdue); })
		      .attr("width", x.bandwidth() / 4)
		      .attr("height", function(d) { return height - y(d.overdue); });

	      svg.selectAll(".bar-completed")
		    .data(data)
		    .enter().append("rect")
		      .attr("class", "bar-completed")
		      .attr("x", function(d) { return x(d.month) + 2 * ((x.bandwidth() / 4) + 2); })
		      .attr("y", function(d) { return y(d.completed); })
		      .attr("width", x.bandwidth() / 4)
		      .attr("height", function(d) { return height - y(d.completed); });

	      svg.selectAll(".bar-inScope")
		    .data(data)
		    .enter().append("rect")
		      .attr("class", "bar-inScope")
		      .attr("x", function(d) { return x(d.month) + 3 * ((x.bandwidth() / 4) + 2); })
		      .attr("y", function(d) { return y(d.inScope); })
		      .attr("width", x.bandwidth() / 4)
		      .attr("height", function(d) { return height - y(d.inScope); });

	      // add the x Axis
	      svg.append("g")
	      .attr("class", "axis")
	      .attr("transform", "translate(0," + height + ")")
	      .call(d3.axisBottom(x).ticks(10))
	      .selectAll("text")
	        .style("text-anchor", "end")
	        .attr("dx", "-.8em")
	        .attr("dy", ".15em")
	        .attr("transform", "rotate(-65)");

	      // add the y Axis
	      svg.append("g")
	      	  .attr("class", "axis")
	          .call(d3.axisLeft(y));
	    });

	    var legendData = [
	    	{name: "In progress", className: "inProgress"},
	    	{name: "Overdue", className: "overdue"},
	    	{name: "Complete", className: "complete"},
	    	{name: "In scope", className: "inScope"}
	    ];

	    var legend = d3.select("#"+id).append('div')
			.attr('class', 'legend')
			.style('margin-top', '30px');

		var keys = legend.selectAll('.key')
			.data(legendData)
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
			.text(d => `${d.name}`);

		keys.exit().remove();
	}
}

export { accountStatusBarChart as default };
