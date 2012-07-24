"use strict";

/**
 * Events to do when mouse hovers over an element
 **/
function mouseOnElement(node) {
	//only show hovered labels if user wants it and we're not showing sunburst for individual divisions
	if($("#show_label").attr("checked") == "checked") {
		var label_content = node.label;
		
		//show label
		$("#hovered_over_node").html(label_content).fadeIn("slow");
		//position the name of the node close to the mouse pointer
		$("#hovered_over_node").css("top", (mouseY-20)+"px");
		$("#hovered_over_node").css("left", (mouseX+100)+"px");
		$("#hovered_over_node").fadeIn("fast");
	}
}

/**
 * Click event for elements
 **/
function elementClickEvent(node) {
	last_clicked_node = node;

	//magnify
	magnify(node, 1250);
}


/**
 * magnify
 */
function magnify(node, tween_duration) {
	//$("#loading").show();
	if (parent = node.parent) { //i.e. for all nodes except the center one, which we don't care about for now
		var parent,
			x = parent.x,
			min_expand,
			max_expand;
			
		//reposition this node and all its siblings
		parent.children.forEach(function(sibling) {
			var scale_factor;
   
   			//for the node we just clicked
			if(sibling === node) {
				var node_dx_last = node.dx;
				//console.log("node's dx before resizing: " + node.dx);
				
				//this is our formula.	We scale the size of our arc by this much
				//val = (parent.dx * k / node.value); //beautiful (cos of the neg. scale factor probably)
				//scale_factor = (node.dx * k / node.value); //problem with this is that the increase is a % of the node's dx, hence not constant for all and throughout
				//var sibling_dx_temp = sibling.value * scale_factor;
  				
  				//we're increasing a constant value (10% of the circle) each time by just upping the node's dx
  				var percent = 10;
  				var sibling_dx_temp = sibling.dx + (parent.children.length/100*10);
  				
  				//it means we've done a 360 for the clicked node, so return
				if(sibling_dx_temp > parent.dx) {
				
				//if >80%, we've gone over, since we're using 5% for siblings
				//var percent = node.dx / parent.dx;
				////console.log("this node as a % of pie's total area is [" + node.label + "]: " + percent + " :: rest of the pie: " + parent.dx);
				//if(percent > 0.8) {
					//console.log("we've gone over johnny!! (clicked node block)");
				}
				else {
					sibling.dx = sibling_dx_temp;
				}
				
				sibling.x = x;
	  			x += sibling.dx;
			}
			//for the node's homies
			else {
				var sibling_dx_last = sibling.dx;
				//val = parent.dx * (1-k) / (parent.value - node.value); //beautiful
				//aah ok, we do parent.value - node.value since node is the one we expanded (clicked on) 
				//and parent is the entire 6.2 or so width of our circle
				//then we slice up remaining area between the siblings
				
				//this is good, but it assumes that all siblings are of same size, must take their current size into account
				//console.log("sibling's dx before resizing: " + sibling.dx);
				//var sibling_dx_temp = ((parent.dx - node.dx) / (parent.value - node.value));
				
				//gives us percentage of siblings' total area that this sibling occupies
				//instead of decreasing all siblings by same amount, we should decrease each by an amount relative to its size
				//so we know what % of the whole this sibling is
				
				var percent = sibling.dx / parent.dx;
				//console.log("this sibling as a % of siblings' total area is [" + sibling.label + "]: " + percent + " :: rest of the pie: " + parent.dx);

				//this is all that was needed you stupid idiot; no need for all the rest of the mess
				//just take the percentage increase (10%), divide by the number of elements - 1 (i.e. not counting the clicked node)
				//and decrease each sibling's dx by that much
				var sibling_dx_temp = sibling.dx - (parent.children.length/100*2.5);
				var percent_after = sibling_dx_temp / parent.dx;
				
				//it means we've done a 360 for the clicked node, so return
				//if(sibling_dx_temp < 0) {
				if(percent_after < 0.01) {
					//console.log("we've gone too low, johnny!! (sibling block)");
					//sibling.dx = 0.1;
				}
				else {
					sibling.dx = sibling_dx_temp;
				}

				sibling.x = x;
	  			x += sibling.dx;
			}
	  		
			//console.log("=====================" + sibling.label);
			//console.log("---------------------scale_factor for clicked node in magnify(): " + scale_factor);
			//console.log("---------------------parent.dx in magnify: " + parent.dx);
			//console.log("---------------------parent.value in magnify: " + parent.value);
			//console.log("---------------------sibling.dx in magnify: " + sibling.dx);
			//console.log("---------------------sibling.value in magnify: " + sibling.value);
			//console.log("");
		});
	}
  
	$("#width_post").html(node.dx);

	path.transition()
		.duration(tween_duration)
		.attrTween("d", arcTween);
}


function magnify_all(tween_duration) {
	//$("#loading").show();
	
	var x = 0,
		dx_total=0;
	
	for(var i=1;i<partition_nodes.length;i++) {
		//console.log(i + " node: " + partition_nodes[i].label);
		//console.log("dx: " + partition_nodes[i].dx);
		//console.log("x: " + x);
		//console.log("");
		dx_total += partition_nodes[i].dx;
		
		partition_nodes[i].x = x;
	  	x += partition_nodes[i].dx;
	}
  
  	//console.log("dx_total: " + dx_total);
  
	path.transition()
		.duration(tween_duration)
		.attrTween("d", arcTween);
}


/**
 * Interpolate the arcs in data space
 **/
function arcTween(a) {
  var i = d3.interpolate({x: a.x0, dx: a.dx0}, a);
  return function(t) {
	var b = i(t);
	a.x0 = b.x;
	a.dx0 = b.dx;
	return arc(b);
  };
}


/**
 * Stash the old values for transition
 **/
function stash(d) {
  d.x0 = d.x;
  d.dx0 = d.dx;
}


/**
 * Swap and redraw sunburst if unabstracting
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
				.attr("transform", "translate(" + w / 2 + "," + h / 2 + ")");
	
		//store the filename
		data_file_path = "data_files/data-" + data_file + ".json";
		data_file_name = data_file;
		
		var json_data = "data_files_local_cache['data-"+data_file+"']";
		
		if(debug_mode == 1)   //console.log("loading data from local cache :: " + json_data);

		//var g = svg.data([json_data]).selectAll("g")
		partition_nodes = partition.nodes(eval(json_data));
		var g = svg.data([eval(json_data)]).selectAll("g")
			.data(partition_nodes)
			//.enter().append("svg:g")
			.enter().insert("svg:g")
			.attr("display", function(d) { return d.depth ? null : "none"; }) // hide inner ring
			
		//actually draw the arcs for the given dataset and store in variable  
		//path = g.append("svg:path")
		path = g.insert("svg:path")
			.attr("d", arc)
			.style("fill", function(d, index) {
				return getColor(d, true);
			}) 
			.style("stroke", function(d, index) {
				return "#ffffff";
			})
			.style("stroke-width", function(d) { return "2"; }) //changed to strings for IE
			.attr("id", function(d) {
				return d.name;
			})
			//.on("click", elementClickEvent)
			.on("mousemove", mouseOnElement)
			.on("mousemove", mouseOnElement)
			.on("mouseover", function(d) {
				d3.select(this).style("fill", d3.hsl(getColor(d, true)).brighter(0.3));
			})
			.on("mouseout", function(d) {
					d3.select(this).style("fill", d.currentColor ? d.currentColor : getColor(d, true));
			})
			.each(stash);
			
			//fade in new sunburst
			setTimeout(function() {
				$("#sunburst_container").fadeIn(100);
				$("#loading").fadeOut("slow");
			}, 200);
			
			var endTime = new Date().getTime();
  		//}); //end json load
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
	
	//optimization step (v6.2/6.3)
	getDataFiles();
	
	update_slider_vals();
	
});
//end document.ready


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
		
		//if(debug_mode == 1)   //console.log("caching data :: data_files/"+arr_data_files[i]+".json");
			
		var path = "data_files/"+data_file_path+".json";
			
		d3.json(path, function(json_data) {
			data_files_local_cache[data_file_path] = json_data;					
		});
				
		i++;

		if(i == arr_data_files.length) {
			window.clearInterval(intervalId);
				
			//add 1s delay to avoid race condition
			setTimeout(function(){
					redraw("abstracted");
			}, 500);
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
					//don't check when page first loads
					if($("#"+currently_active_slider).slider("option", "value") != initial_val_of_currently_active_slider) {
						//$("#"+currently_active_slider).slider("option", "value", initial_val_of_currently_active_slider); //change value back to old value
					}
					
					//update_slider_vals();
					return;
				}
				
				//
				update_ratios_and_redraw();
			}
	});
	
	$(".slider").slider({
		max: 100,
		start: function(event, ui) {
			initial_val_of_currently_active_slider = ui.value;
			currently_active_slider = event.currentTarget.id;
		}
	});
	
	$("#ssn_percent").slider({
		max: 100,
		slide: function(event, ui) {
			var str = ui.value;
			$("#ssn_val").html(str);
			update_total_val();
		}
	});
	
	$("#edu_percent").slider({
		max: 100,
		slide: function(event, ui) {
			var str = ui.value;
			$("#edu_val").html(str);
			update_total_val();
		}
	});
	
	$("#med_percent").slider({
		max: 100,
		slide: function(event, ui) {
			var str = ui.value;
			$("#med_val").html(str);
			update_total_val();
		}
	});
	
	$("#def_percent").slider({
		max: 100,
		slide: function(event, ui) {
			var str = ui.value;
			$("#def_val").html(str);
			update_total_val();
		}
	});
	
	$("#ins_percent").slider({
		max: 100,
		slide: function(event, ui) {
			var str = ui.value;
			$("#ins_val").html(str);
			update_total_val();
		}
	});

	
	$("#ssn_percent").slider("option", "value", 25);
	$("#edu_percent").slider("option", "value", 5);
	$("#med_percent").slider("option", "value", 30);
	$("#def_percent").slider("option", "value", 30);
	$("#ins_percent").slider("option", "value", 10);
}


function update_total_val() {
	var total = getTotalPercentageValues();
	$("#total_val").html(total);
	if(total != 100) {
		$("#total_val").css("color", "red");
		$("#update_button").css("color", "#cccccc");
		$("#update_button").attr("disabled", "disabled");
	}
	else {
		$("#total_val").css("color", "#3b3b3b");
		$("#update_button").css("color", "black");
		$("#update_button").removeAttr("disabled");
	}
}

function update_ratios_and_redraw() {
	//skip node at 0 (center)
	for(var i=1;i<partition_nodes.length;i++) {
		//DEBUG, REMOVE LATER
		//if(i>1) continue;
	
		//get node
		var node = partition_nodes[i];
		
		//1. get percent for each sector
		var percent = getPercentValueForSectorById(i);
		//console.log("percent for " + partition_nodes[i].label + " is " + percent);
		
		//2. calculate dx for the node
		var new_dx = node.parent.dx * percent;
		
		//3. update dx of node
		partition_nodes[i].dx = new_dx;
	}
	
	//4. once done with all, call magnify_all
	magnify_all(1250);
}


function getPercentValueForSectorById(i) {
	if(i == 1)
		return $("#ssn_val").html()/100;
	else if(i == 2)
		return $("#edu_val").html()/100;
	else if(i == 3)
		return $("#med_val").html()/100;
	else if(i == 4)
		return $("#def_val").html()/100;
	else if(i == 5)
		return $("#ins_val").html()/100;
}


function getTotalPercentageValues() {
	return parseInt($("#ssn_val").html())
		+ parseInt($("#edu_val").html())
		+ parseInt($("#med_val").html())
		+ parseInt($("#def_val").html())
		+ parseInt($("#ins_val").html())
}


var MAX_DEPTH = 12,
	PARTITIONS = 7,
	mouseX,
	mouseY,
	data_file_path,
	data_file_name,
	nodeLastClicked,
	svg,
	w = 760,
	h = 760,
	r = 300,
	color = d3.scale.category20(),
	inverseColor = d3.scale.ordinal(),
	path,
	last_clicked_node;

var min_percent = 60,
	max_percent = 100,
	node_constant_k = "",
	lead_parent_constant_k = 45,
	hide_childless = 0,
	debug_mode = 0;
	
var partition = d3.layout.partition()
	.size([2 * Math.PI, r])
	.value(function(d) { return d.size; })
	.sort(null); //don't sort, use same order as in datafile

var arc = d3.svg.arc()
	.startAngle(function(d) { return d.x; })
	.endAngle(function(d) { return d.x + d.dx; })
	.innerRadius(function(d) { return d.y  -145; })
	.outerRadius(function(d) { return d.y + d.dy; });

var	the_division_im_inside_the_bloody_intestines_of,
	division_name_short_form;

var partition_nodes;

var initial_val_of_currently_active_slider,
	currently_active_slider;

//for caching (added in v6.2)
var arr_data_files;
var data_files_local_cache = {} //new Object();