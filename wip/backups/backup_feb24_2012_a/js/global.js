"use strict";

/**
 * Events to do when mouse hovers over an element
 **/
function mouseOnElement(node) {
	//don't show labels for abstracted elements
	//if(debug_mode != 1 && node.show !== 1 && node.depth > 1) {
	//	return;
	//}

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
			//x = parent.x,
			x = parent.x,
			min_expand,
			max_expand;
	
		//var k = 0.1; //beautiful
		
		//reposition this node and all its siblings
		parent.children.forEach(function(sibling) {
			var scale_factor;
   
   			//for the node we just clicked
			if(sibling === node) {
				var node_dx_last = node.dx;
				console.log("node's dx before resizing: " + node.dx);
				
				//this is our formula.	We scale the size of our arc by this much
				//val = (parent.dx * k / node.value); //beautiful (cos of the neg. scale factor probably)
				//scale_factor = (node.dx * k / node.value); //problem with this is that the increase is a % of the node's dx, hence not constant for all and throughout
				//var sibling_dx_temp = sibling.value * scale_factor;
  				
  				//we're increasing a constant value (10% of the circle) each time by just upping the node's dx
  				var sibling_dx_temp = sibling.dx + (parent.children.length/100*10);
  				
  				//it means we've done a 360 for the clicked node, so return
				if(sibling_dx_temp > parent.dx) {
				
				//if >80%, we've gone over, since we're using 5% for siblings
				//var percent = node.dx / parent.dx;
				//console.log("this node as a % of pie's total area is [" + node.label + "]: " + percent + " :: rest of the pie: " + parent.dx);
				//if(percent > 0.8) {
					console.log("we've gone over johnny!! (clicked node block)");
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
				//var sibling_dx_temp = (parent.dx - node.dx) / (parent.value - node.value);
				console.log("sibling's dx before resizing: " + sibling.dx);
				//var sibling_dx_temp = ((parent.dx - node.dx) / (parent.value - node.value));
				
				
				//gives us percentage of siblings' total area that this sibling occupies
				
				//instead of decreasing all siblings by same amount, we should decrease each by an amount relative to its size
				//so we know what % of the whole this sibling is
				/*var rest_of_the_pie = parent.dx - node.dx;
				var the_pie = parent.dx;
				*/
				
				var percent = sibling.dx / parent.dx;
				console.log("this sibling as a % of siblings' total area is [" + sibling.label + "]: " + percent + " :: rest of the pie: " + parent.dx);

				//now we just make sure the new dx is the same percent of the new area
				//var sibling_dx_temp = ((parent.dx - node.dx) * percent) + ((node.dx - node_dx_last) / (parent.value-node.value));
				//var sibling_dx_temp = ((parent.dx - node.dx) / (parent.value - node.value));
				
				//this is all that was needed you stupid idiot; no need for all the rest of the mess
				//just take the percentage increase (10%), divide by the number of elements - 1 (i.e. not counting the clicked node)
				//and decrease each sibling's dx by that much
				var sibling_dx_temp = sibling.dx - (parent.children.length/100*2.5);
				var percent_after = sibling_dx_temp / parent.dx;
				
				//it means we've done a 360 for the clicked node, so return
				//if(sibling_dx_temp < 0) {
				if(percent_after < 0.01) {
					console.log("we've gone too low, johnny!! (sibling block)");
					//sibling.dx = 0.1;
				}
				else {
					sibling.dx = sibling_dx_temp;
				}

				sibling.x = x;
	  			x += sibling.dx;
			}
	
	  		//val is the scale factor
			//console.log("++++++++++++++++ node width before reposition is: " + node.dx);
	    	
		  	//console.log("++++++++++++++++ node width after reposition is: " + node.dx);
	  		
			console.log("=====================" + sibling.label);
			console.log("---------------------scale_factor for clicked node in magnify(): " + scale_factor);
			console.log("---------------------parent.dx in magnify: " + parent.dx);
			console.log("---------------------parent.value in magnify: " + parent.value);
			console.log("---------------------sibling.dx in magnify: " + sibling.dx);
			console.log("---------------------sibling.value in magnify: " + sibling.value);
			console.log("");
		});
	}
  
	$("#width_post").html(node.dx);

	path.transition()
		.duration(tween_duration)
		.attrTween("d", arcTween);
	  
	//$("#loading").fadeOut("slow");
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


function _buildParentChain(node_name, depth) {
	var str = node_name;
	for(var i=0;i<depth;i++) {
		str += ".parent";
	}
	
	return str;
}



/**
 * Stash the old values for transition
 **/
function stash(d) {
  d.x0 = d.x;
  d.dx0 = d.dx;
}


/**
 * Faster implementation of indexOf (modified for two chars)
 * Suprisingly, works faster in FF and Chrome
 * Credit: http://jsperf.com/js-for-loop-vs-array-indexof/10
 **/
function indexOfFor(ar,v){
	for (var i = 0,l=ar.length; i < l-1; i++) {
		if (ar[i]+ar[i+1] === v) {
			return i;
		}
	}
	return -1;
}


function _getExpansionFactor(min, max, n, i) {
	//console.log("_getExpansionFactor: " + ((max - min) * 100 / n) * i + min);

	return ((max - min) / n) * i + min;
}


/**
 * Swap and redraw sunburst if unabstracting
 **/
function redraw(data_file) {
	var startTime = new Date().getTime();

	$("#loading").show();
	$("#fingerprint").css("opacity",0.4);

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
		
		//changed for optimization addition in v6.2, sheds about 400ms per VP call
		//doing it this way and then eval'ing below saves us around 100ms too (above value is inclusive of this)
		var json_data = "data_files_local_cache['data-"+data_file+"']";
		
		if(debug_mode == 1)   console.log("loading data from local cache :: " + json_data);

		//var g = svg.data([json_data]).selectAll("g")
		var partition_nodes = partition.nodes(eval(json_data));
		var g = svg.data([eval(json_data)]).selectAll("g")
			.data(partition_nodes)
			//.enter().append("svg:g")
			.enter().insert("svg:g")
			.attr("display", function(d) { return d.depth ? null : "none"; }) // hide inner ring
			
		//actually draw the arcs for the given dataset and store in variable  
		//path = g.append("svg:path")
			
		path = g.insert("svg:path")
			.attr("d", arc)
			//.attr("shape-rendering", "optimize-speed")
			.style("fill", function(d, index) {
				//d.currentColor = d3.hsl(getColor(d, index)).darker(0.3).rgb().toString();
				//return d3.hsl(getColor(d, index)).darker(0.3).rgb().toString();
				return getColor(d, true);
				
			}) 
			.style("stroke", function(d, index) {
				//return d3.hsl(getColor(d, index)).brighter(1).rgb().toString();
				return "#ffffff";
			})
			.style("stroke-width", function(d) { return "2"; }) //changed to strings for IE
			.attr("id", function(d) {
				return d.name;
			})
			.style("display", function(d) {
				console.log("---------------------sibling.dx of [" + d.label + "] is " + d.dx);
			
				//hide all childless elements for unabstracted elements
				//TODO don't hardcode in final version
				if((data_file_path == "data_files/data-M.json") || (data_file_path == "data_files/data-MP.json")
					&& d.show == "1" && hide_childless == 1)
					{
					if(d.children != null) return null;
					else return "none";
				}
			})
			.on("click", elementClickEvent)
			.on("mousemove", mouseOnElement)
			.on("mousemove", mouseOnElement)
			.on("mouseover", function(d) {
				d3.select(this).style("fill", d3.hsl(getColor(d, true)).brighter(0.3));
			})
			.on("mouseout", function(d) {
				if (d.show == 1 || d.depth <= 1) {
					d3.select(this).style("fill", d.currentColor ? d.currentColor : getColor(d, true));
				}
				else if(d.depth > 1) {
					//get the lead-parent of the node and highlight that element instead of "this" one.
					var str = _buildParentChain("d", d.depth-1);
					var division_details = getDivisionName(eval(str).name);
					var division = division_details[0];
					var division_name_short_form = division_details[1];
					d3.selectAll("#"+division_name_short_form).style("fill", d.currentColor ? d.currentColor : getColor(d, true));
				}
			})
			.each(stash);
	  
			//on click of an abstracted part, set size to default (fixed v6.3 bug)
			//there might be a better way; look into it
			if(last_clicked_node != undefined) {
				if(debug_mode == 1) {
					console.log("will magnify this node: ")
					console.log(partition_nodes[getNodeForVP(data_file)]);
				}
				
				magnify(partition_nodes[getNodeForVP(data_file)], 5);
				//elementClickEvent(partition_nodes[getNodeForVP(data_file)]);
			}
			
			//fade in new sunburst
			setTimeout(function() {
				$("#sunburst_container").fadeIn(100);
	   
				$("#fingerprint").css("opacity",0);
				$("#loading").fadeOut("slow");
			}, 200);
			
			var endTime = new Date().getTime();
			
			//console.log("redraw() time taken (ms): " + (endTime - startTime));
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
 * Normalize name of element
 * TODO use data key instead for data ids
 **/
function normalizeName(str) {
	return str.replace(/ /g,"_");	
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
});
//end document.ready



function update_ratios_and_redraw() {
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
				
			//add 1s delay to avoid race condition
			setTimeout(function(){
					redraw("abstracted");
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
		//redraw("abstracted");
		update_ratios_and_redraw();
	});
}


function update_ratios_and_redraw() {
	magnify("ALL", 1250);
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

	
//for caching (added in v6.2)
var arr_data_files;
var data_files_local_cache = {} //new Object();