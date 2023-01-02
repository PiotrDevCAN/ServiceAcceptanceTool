/*
 *
 *
 *
 */

class accountStatusBarChart {

    constructor() {

        // const data = this.prepareBarData();
        var data = [120, 20, 50, 180];
        this.generateBarGraph('graphBarChart', data);

        // var svg_width = 300;
        // var svg_height = 300;
        // var svg = d3.select("#graphBarChart").append("svg")
        //     .attr("width", svg_width)
        //     .attr("height", svg_height)
        //     .attr("class", "bar-chart");

        // var data = [10, 50, 100, 140, 120, 20, 0, 170, 180];
        // var barPadding = 5;
        // var barWidth = (svg_width / data.length);
        // var barChart = svg.selectAll("rect")
        //     .data(data)
        //     .enter()
        //     .append("rect")
        //     .attr("y", function (d) {
        //         return svg_width - d
        //     })
        //     .attr("height", function (d) {
        //         return d;
        //     })
        //     .attr("width", barWidth - barPadding)
        //     .attr("transform", function (d, i) {
        //         var translate = [barWidth * i, 0];
        //         return "translate(" + translate + ")";
        //     });


    }

    preparePieData() {
        var snapshotData = [
            {
                serviceName: "General",
                completed: 4,
                notCompleted: 10
            },
            {
                serviceName: "Asset",
                completed: 6,
                notCompleted: 10
            },
            {
                serviceName: "Mainframe",
                completed: 2,
                notCompleted: 10
            },
            {
                serviceName: "Identity and Access Management",
                completed: 4,
                notCompleted: 10
            },
            {
                serviceName: "Monitoring",
                completed: 10,
                notCompleted: 10
            }
        ];
        return snapshotData;
    }

    generateBarGraph(id, sourceCsv){

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

    generateBarGraph_OOOO(id, data) {

        var parentWidth = $("#" + id).width();

        //set the dimensions and margins of the graph
        var margin = { top: 20, right: 20, bottom: 150, left: 100 },
            width = parentWidth - margin.left - margin.right - 180,
            height = 200 - margin.top - margin.bottom;

        // set the ranges
        var x = d3.scaleBand()
            .range([0, width])
            .padding(0.1);

        var y = d3.scaleLinear()
            .range([height, 0]);

        // append the svg object to the body of the page
        // append a 'group' element to 'svg'
        // moves the 'group' element to the top left margin
        var svg = d3.select("#" + id).append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform",
                "translate(" + margin.left + "," + margin.top + ")");



        var svg_width = 300;
        var svg_height = 300;
        // var svg = d3.select("#graphBarChart").append("svg")
        //     .attr("width", svg_width)
        //     .attr("height", svg_height)
        //     .attr("class", "bar-chart");

        var barPadding = 5;
        var barWidth = (svg_width / data.length);
        var barChart = svg.selectAll("rect")
            .data(data)
            .enter()
            .append("rect")
            .attr("y", function (d) {
                return svg_width - d
            })
            .attr("height", function (d) {
                return d;
            })
            .attr("width", barWidth - barPadding)
            .attr("transform", function (d, i) {
                var translate = [barWidth * i, 0];
                return "translate(" + translate + ")";
            });


        // ------------------------------------------------------------------
        // get the data
        // d3.csv(sourceCsv, function(d) {
        //   return {
        // 	month : d["MONTH NAME"],
        // 	inScope : d["IN SCOPE"],
        //     completed : +d["COMPL NUM"],
        //     overdue : +d["OVER NUM"],
        //     inProgress : +d["IN PROGRESS"]
        //   };
        // }, function(error, data) {


        // d3.json("data/contentWordCount.json", function (data)
        // {
        //     x.domain(data.map(function (d)
        //     {
        //         return d.name;
        //     }));

        //     y.domain([0, d3.max(data, function (d)
        //     {
        //         return d.wc;
        //     })]);

        //     svg.append("g")
        //         .attr("class", "x axis")
        //         .attr("transform", "translate(0, " + height + ")")
        //         .call(xAxis)
        //         .selectAll("text")
        //         .style("text-anchor", "middle")
        //         .attr("dx", "-0.5em")
        //         .attr("dy", "-.55em")
        //         .attr("y", 30)
        //         .attr("transform", "rotate(0)" );

        //     svg.append("g")
        //         .attr("class", "y axis")
        //         .call(yAxis)
        //         .append("text")
        //         .attr("transform", "rotate(-90)")
        //         .attr("y", 5)
        //         .attr("dy", "0.8em")
        //         .attr("text-anchor", "end")
        //         .text("Word Count");

        //     svg.selectAll("bar")
        //         .data(data)
        //         .enter()
        //         .append("rect")
        //         .style("fill", "orange")
        //         .attr("x", function(d)
        //         {
        //             return x(d.name);
        //         })
        //         .attr("width", x.rangeBand())
        //         .attr("y", function (d)
        //         {
        //             return y(d.wc);
        //         })
        //         .attr("height", function (d)
        //         {
        //             return height - y(d.wc);
        //         })
        // }
        // ------------------------------------------------------------------


        // ------------------------------------------------------------------
        // d3.json(data, function (data) {

        //     //   if (error && error.target.status === 404) {
        //     //       console.log("File not found");
        //     //   }

        //     //   if (data.length === 0){
        //     // 	  console.log("File empty");
        //     //   }

        //     // Scale the range of the data in the domains
        //     x.domain(data.map(function (d) { return d.name; }));
        //     y.domain([0, d3.max(data, function (d) { return +d.inScope; })]);

        //     x.domain(data.map(function (d) {
        //         return d.name;
        //     }));

        //     y.domain([0, d3.max(data, function (d) {
        //         return d.wc;
        //     })]);

        //     // append the rectangles for the bar chart
        //     svg.selectAll(".bar-value")
        //         .data(data)
        //         .enter().append("rect")
        //         .attr("class", "bar-value")
        //         .attr("x", function (d) { return x(d.name); })
        //         .attr("y", function (d) { return y(d.value); })
        //         .attr("width", x.bandwidth() / 4)
        //         .attr("height", function (d) { return height - y(d.value); });

        //     // add the x Axis
        //     svg.append("g")
        //         .attr("class", "axis")
        //         .attr("transform", "translate(0," + height + ")")
        //         .call(d3.axisBottom(x).ticks(10))
        //         .selectAll("text")
        //         .style("text-anchor", "end")
        //         .attr("dx", "-.8em")
        //         .attr("dy", ".15em")
        //         .attr("transform", "rotate(-65)");

        //     // add the y Axis
        //     svg.append("g")
        //         .attr("class", "axis")
        //         .call(d3.axisLeft(y));
        // });
        // ------------------------------------------------------------------

        var legendData = [
            { name: "In progress", className: "inProgress" },
            { name: "Overdue", className: "overdue" },
            { name: "Complete", className: "complete" },
            { name: "In scope", className: "inScope" }
        ];

        var legend = d3.select("#" + id).append('div')
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
