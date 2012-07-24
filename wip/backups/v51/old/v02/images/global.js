"use strict";

var radians = Math.PI / 180;

/**
 * Events to do when mouse hovers over an element
 **/
function mouseOnElement(node) {
	if(node.label == "Unallocated")
		var label_content = node.label;
	else
		var label_content = "<strong>" + node.label + "</strong><br />$" + node.budget + " billion (" + node.size + "%)";
	
	$("#hovered_over_node").html(label_content).fadeIn("slow");
	//position the name of the node close to the mouse pointer
	$("#hovered_over_node").css("top", (mouseY-20)+"px");
	$("#hovered_over_node").css("left", (mouseX+100)+"px");
	$("#hovered_over_node").fadeIn("fast");
}


function magnify_all(tween_duration) {
	//$("#loading").show();
	var x = 0,
		dx_total=0;
	
	for(var i=1;i<partition_nodes.length;i++) {
		dx_total += partition_nodes[i].dx;
		partition_nodes[i].x = x;
	  	x += partition_nodes[i].dx;
	}

	path.transition()
		.duration(tween_duration)
		.attrTween("d", arcTween);
}


/**
 * Interpolate the arcs in data space (Bostock)
 **/
function arcTween(a) {
  //a.innerRadius = 0;
  
  //var i = d3.interpolate({x: a.x0, dx: a.dx0, innerRadius: 0}, a);
  var i = d3.interpolate({x: a.x0, dx: a.dx0}, a);
  return function(t) {
	var b = i(t);
	a.x0 = b.x;
	a.dx0 = b.dx;
	return arc(b);
  };
}


/**
 * Stash the old values for transition (Bostock)
 **/
function stash(d) {
  d.x0 = d.x;
  d.dx0 = d.dx;
}


/**
 * Redraw
 **/
function redraw(data_file) {
	$("#loading").show();

	$("#sunburst_container").fadeOut(100,function() {
		d3.selectAll("g").remove();
		d3.selectAll("path").remove();
		
		svg = d3.selectAll("#sunburst_container").insert("svg:svg")
			.attr("width", w)
			.attr("height", h)
			.append("svg:g")			
				.attr("id", "container")
				.attr("transform", "translate(" + w / 2 + "," + h / 2 + ")");
			
		var json_data = "data_files_local_cache['data-"+data_file+"']";
		
		if(debug_mode == 1)   console.log("loading data from local cache :: " + json_data);

		json_data = eval(json_data);
		var unallocated = {size: 0, label: "Unallocated", name: "_unallocated"};
		json_data.children.push(unallocated);

		partition_nodes = partition.nodes(json_data);
		var arcs_data;
		
		if ($.browser.mozilla) {
			arcs_data = svg.select("#container").data([json_data]).selectAll("g")
			.data(partition_nodes)
			.enter().insert("g")
			.attr("class", "node")
			.attr("visibility", function(d) { return d.depth ? null : "hidden"; }) // hide inner ring
		} 
		else {
			arcs_data = svg.data([json_data]).selectAll("#container")
			.data(partition_nodes)
			.enter().insert("g")
			.attr("class", "node")
			.attr("display", function(d) { return d.depth ? null : "none"; }) // hide inner ring
		}


		//draw the arcs for the given dataset and store in variable  
		path = arcs_data.append("svg:path")
			.attr("d", arc)
			.style("fill", function(d, index) { return d3.hsl(getColor(d)).rgb().toString(); }) 
			//.style("stroke", function(d, index) { return "#ffffff"; })
			.style("stroke", function(d, index) { return d3.hsl(getColor(d)).darker(0.9).rgb().toString(); })
			.style("stroke-width", function(d) { return "1"; }) //changed to strings for IE
			.attr("id", function(d) { return "f" + d.name; })
			.on("mousemove", mouseOnElement)
			.on("click", mouseOnElement)
			//.on("mouseover", function(d) { d3.select(this).style("fill", d3.hsl(getColor(d)).brighter(0.3)); })
			.on("mouseout", function(d) { d3.select(this).style("fill", d.currentColor ? d.currentColor : getColor(d)); })
			.each(stash);

		// Add resize handles. Note: we don't allow the unallocated budget to be dragged!
		var handle = arcs_data
			.filter(function(d) { return d !== unallocated; })
				.append("g")
			.attr("class", "handle")
			.call(d3.behavior.drag()
				.on("drag", function(d, i) {
					d3.selectAll("#f"+d.name).style("fill", d3.hsl(getColor(d)).brighter(0.3));
				
					var a = d.x + d.dx + Math.PI / 2, // D3 offsets arcs by 90° so we compensate
						start = [-d.y * Math.cos(a), -d.y * Math.sin(a)],
						m = [d3.event.x, d3.event.y],
						delta = Math.atan2(cross(start, m), dot(start, m));
				  unallocated.size = 0;
				  d.size = 0;
				  // Work out the total allocation excluding the current segment.
				  var rest = d3.sum(json_data.children, function(d) { return d.size; });
				  // Convert the new angular width (in radians) into a
				  // percentage between 0 and 100 - rest.
				  d.size = Math.min(100 - rest, Math.max(0, 100 * (d.dx + delta) / (2 * Math.PI)));
				  // Update the unallocated size.
				  unallocated.size = 100 - rest - d.size;
				  update(json_data);
				}))
		.attr("transform", handleTransform);
		handle.append("rect").attr("width", 10).attr("height", 10).attr("y", -5);
		handle.append("path").attr("d", "M0,-1L10,-1L5,-5Z");
		handle.append("path").attr("d", "M0,1L10,1L5,5Z");
    	
    	handle
	    	.on("mouseover", function(d) { d3.selectAll("#f"+d.name).style("fill", d3.hsl(getColor(d)).brighter(0.3)); })
			.on("mouseout", function(d) { d3.selectAll("#f"+d.name).style("fill", d.currentColor ? d.currentColor : getColor(d)); })
			.on("mousemove", mouseOnElement)
	
		//fade in new sunburst
		setTimeout(function() {
			$("#sunburst_container").fadeIn(500);
			$("#loading").fadeOut("slow");
		}, 200);
	});//end fadeout callback
}

// Updates the sunburst using the given data.
// Note: only updates; no exit or entering handled here.
function update(data) {
	var g = svg.selectAll("g.node")
		.data(partition.nodes(data));
	g.select("path")
		.attr("d", arc);
	g.select("g.handle")
		.attr("transform", handleTransform);
}

// Computes the transform attribute for a resize handle.
function handleTransform(d) {
	// We place the handle at the *end* of each segment (hence we add d.dx).
	// We also offset the radius by a little bit (+ 1).
	return "rotate(" + ((d.x + d.dx) / radians - 90) + ")translate(" + (1 + d.y + d.dy) + ")";
}

function cross(a, b) { return a[0] * b[1] - a[1] * b[0]; }
function dot(a, b) { return a[0] * b[0] + a[1] * b[1]; }

/**
 * Get color
 **/
function getColor(d) {
	if(d.label == "Unallocated")
		return "#3c3c3c";
	else
		return d3.hsl(color(d.name)).rgb().toString(); //for IE
}


/**
 * Called after page is loaded
 **/
$(document).ready(
	function() {
		$("#loading").show();
		assignEventListeners();
		$("#hovered_over_node").corner();
		$("#hovered_over_node").hide();
		$("#hovered_over_node_fixed").corner();
		$("button").button();
	
		//for scaling, just in case we get to that
		getDataFiles();
	}
);


/**
 * Get data files and cache locally
 **/
function getDataFiles() {
	//get data files	
	var i = 0;
	var intervalId = window.setInterval(function() {
		var data_file_path = arr_data_files[i];
		
		//if(debug_mode == 1)   console.log("caching data :: data_files/"+arr_data_files[i]+".json");
			
		var path = "data_files/"+data_file_path+".json";
		d3.json(path, function(json_data) {
			data_files_local_cache[data_file_path] = json_data;					
		});
				
		i++;

		if(i == arr_data_files.length) {
			window.clearInterval(intervalId);
			setTimeout(function(){
					redraw("2012");
			}, 1000);
		}
	}, 70);
}


/**
 * Assign our event listeners
 **/
function assignEventListeners() {
	$(document).mousemove(function(e) {
		mouseX = e.pageX;
		mouseY = e.pageY;
	});
	
	$("body").click(function(e) {
		$("#hovered_over_node").fadeOut("slow");
	});
}


/**
 * Update percentages
 **/
function update_ratios_and_redraw() {
	//skip node at 0 (center)
	for(var i=1;i<partition_nodes.length;i++) {
		var node = partition_nodes[i];
		var percent = $("#" + node.name.toLowerCase() + "_val").html()/100;
		//console.log("percent for " + partition_nodes[i].label + " is " + percent);
		var new_dx = node.parent.dx * percent;
		partition_nodes[i].dx = new_dx;
	}

	magnify_all(1000);
}


var mouseX,
	mouseY,
	svg,
	w = 640,
	h = 640,
	r = 300,
	color = d3.scale.category20b(),
	inverseColor = d3.scale.ordinal(),
	path,
	//grips,
	currently_active_slider,
	partition_nodes,
	debug_mode = 0;
	
var arc = d3.svg.arc()
		.startAngle(function(d) { return d.x; })
		.endAngle(function(d) { return d.x + d.dx; })
		.innerRadius(function(d) { return 2; })
		.outerRadius(function(d) { return d.y + d.dy; });
	
var partition = d3.layout.partition()
	.size([2 * Math.PI, r])
	.value(function(d) { return d.size; })
	.sort(null); //don't sort, use same order as in datafile

var data_files_local_cache = {} //new Object();
var arr_data_files = ["data-2012"];
