"use strict";

/**
 * Events to do when mouse hovers over an element
 **/
function mouseOnElement(node) {
	//only show hovered labels if user wants it and we're not showing sunburst for individual divisions
	var label_content = node.label;
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

		partition_nodes = partition.nodes(eval(json_data));
		var arcs_data = svg.data([eval(json_data)]).selectAll("#container")
			.data(partition_nodes)
			.enter().insert("svg:g")
			.attr("display", function(d) { return d.depth ? null : "none"; }) // hide inner ring

		//draw the arcs for the given dataset and store in variable  
		path = arcs_data.append("svg:path")
			.attr("d", arc)
			.style("fill", function(d, index) { return getColor(d, true); }) 
			.style("stroke", function(d, index) { return "#ffffff"; })
			.style("stroke-width", function(d) { return "2"; }) //changed to strings for IE
			.attr("id", function(d) { return d.name; })
			.on("mousemove", mouseOnElement)
			.on("mousemove", mouseOnElement)
			.on("mouseover", function(d) { d3.select(this).style("fill", d3.hsl(getColor(d, true)).brighter(0.3)); })
			.on("mouseout", function(d) { d3.select(this).style("fill", d.currentColor ? d.currentColor : getColor(d, true)); })
			.each(stash);
    	
			//fade in new sunburst
			setTimeout(function() {
				$("#sunburst_container").fadeIn(500);
				$("#loading").fadeOut("slow");
			}, 200);
	});//end fadeout callback
}


/**
 * Get color
 **/
function getColor(d, highlight) {
	return highlight ? d3.hsl(color(d.name)).darker(1).rgb().toString() : d3.hsl(inverseColor(d.name)).rgb().toString(); //for IE
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
	
	update_slider_vals();
	
});


function update_slider_vals() {
	//display text
	$("#ssn_val").html($("#ssn_percent").slider("option","value"));
	$("#edu_val").html($("#edu_percent").slider("option","value"));
	$("#med_val").html($("#med_percent").slider("option","value"));
	$("#def_val").html($("#def_percent").slider("option","value"));
	$("#ins_val").html($("#ins_percent").slider("option","value"));
	
	update_total_val();
}


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
	
	$("#update_button").click(function(e) {
		//i.e. don't run it when page first loads and sunburst is still being loaded
			if(partition_nodes != undefined) {
				if(getTotalPercentageValues() > 100) {
					//update_slider_vals();
					return;
				}
				
				update_ratios_and_redraw();
			}
	});
	
	//update the percentages on slide for each slider
	$(".slider").slider({
		max: 100,
		slide: function(event, ui) {
			$("#" + d3.select(this).attr("id").substr(0,3)+"_val").html(ui.value);
			update_total_val();
		}
	});
	
	$("#ssn_percent").slider("option", "value", 25);
	$("#edu_percent").slider("option", "value", 5);
	$("#med_percent").slider("option", "value", 30);
	$("#def_percent").slider("option", "value", 30);
	$("#ins_percent").slider("option", "value", 10);
}


/**
 * Update total percentage label
 **/
function update_total_val() {
	var total = getTotalPercentageValues();
	$("#total_val").html(total);
	if(total != 100) {
		$("#total_val").css("color", "red");
		$("#update_button.ui-state-default").css("color", "#cccccc");
		$("#update_button").attr("disabled", "disabled");
	}
	else {
		$("#total_val").css("color", "#3b3b3b");
		$("#update_button.ui-state-default").css("color", "#a71e32");
		$("#update_button").removeAttr("disabled");
	}
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


function getTotalPercentageValues() {
	return parseInt($("#ssn_val").html())
		+ parseInt($("#edu_val").html())
		+ parseInt($("#med_val").html())
		+ parseInt($("#def_val").html())
		+ parseInt($("#ins_val").html())
}


var mouseX,
	mouseY,
	svg,
	w = 760,
	h = 760,
	r = 300,
	color = d3.scale.category20(),
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