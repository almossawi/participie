"use strict";

var radians = Math.PI / 180;

function getURLParameter(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
    );
}

/**
 * Events to do when mouse hovers over an element
 **/
function mouseOnElement(node) {
	$("#moreinfo_container").html($("#" + node.name + "_moreinfo").val());
	
	$("#the_slice_im_on").html(node.label);

	//$("#receipt").html(setReceiptContent(json_data, d.label));	
	$(".receipt_line_item").css("font-weight", "normal");
	$("#receipt_li_" + node.name).css("font-weight", "bold");
	$("#receipt_li_val_" + node.name).css("font-weight", "bold");


	if (node.label == "Unallocated") var label_content = node.label;
	else {
		if(data_file_to_load == "data_files/data-talkingpoints.json")
			var label_content = "<strong>" + node.label + "</strong><br />" + Math.round(node.size * 100) / 100 + "%";
		else
			var label_content = "<strong>" + node.label + "</strong><br />$" + addCommas(Math.round(TOTAL_BUDGET * (node.size / 100))) + " billion (" + Math.round(node.size * 100) / 100 + "%)";
	}

	$("#hovered_over_node").html(label_content).fadeIn("fast");
	//position the name of the node close to the mouse pointer
	$("#hovered_over_node").css("top", (mouseY + 10) + "px");
	$("#hovered_over_node").css("left", (mouseX + 30) + "px");
	$("#hovered_over_node").fadeIn("fast");
}


function mouseOnElementMini(node) {
	if (node.label != "Unallocated") {
		if(data_file_to_load == "data_files/data-talkingpoints.json")
			var label_content = "<strong>" + node.label + "</strong><br />" + Math.round(node.size * 100) / 100 + "%";
		else
			var label_content = "<strong>" + node.label + "</strong><br />$" + addCommas(Math.round(TOTAL_BUDGET * (node.size / 100))) + " billion (" + Math.round(node.size * 100) / 100 + "%)";

		$("#hovered_over_node").html(label_content).fadeIn("fast");
		//position the name of the node close to the mouse pointer
		$("#hovered_over_node").css("top", (mouseY + 20) + "px");
		$("#hovered_over_node").css("left", (mouseX + 30) + "px");
		$("#hovered_over_node").fadeIn("fast");
	}
}

function mouseOnElementArbitrary(node) {//console.log(node);
	if (node.label != "Unallocated") {
		if(node.which_pie == "tp")
			var label_content = "<strong>" + node.label + "</strong><br />" + Math.round(node.size * 100) / 100 + "%";
		else if(node.which_pie == "fb")
			var label_content = "<strong>" + node.label + "</strong><br />$" + addCommas(Math.round(TOTAL_BUDGET * (node.size / 100))) + " billion (" + Math.round(node.size * 100) / 100 + "%)";

		$("#hovered_over_node").html(label_content).fadeIn("fast");
		//position the name of the node close to the mouse pointer
		$("#hovered_over_node").css("top", (mouseY + 20) + "px");
		$("#hovered_over_node").css("left", (mouseX + 30) + "px");
		$("#hovered_over_node").fadeIn("fast");
	}
}


function magnify_all(tween_duration) {
	//$("#loading").show();
	var x = 0,
		dx_total = 0;

	for (var i = 1; i < partition_nodes.length; i++) {
		dx_total += partition_nodes[i].dx;
		partition_nodes[i].x = x;
		x += partition_nodes[i].dx;
	}

	path.transition().duration(tween_duration).attrTween("d", arcTween);
}


/**
 * Interpolate the arcs in data space (Bostock)
 **/
function arcTween(a) {
	//a.innerRadius = 0;
	//var i = d3.interpolate({x: a.x0, dx: a.dx0, innerRadius: 0}, a);
	var i = d3.interpolate({
		x: a.x0,
		dx: a.dx0
	}, a);
	return function (t) {
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

function formatNumberLength(num, length) {
	var r = "" + num;
	while (r.length < length) {
		r = "0" + r;
	}
	return r;
}

function drawArbitraryPie(json, container_id, w, h, r) {
	//console.log(json);
	json = eval(json);
	
	var color = d3.scale.category20b(),
	inverseColor = d3.scale.ordinal(),
	path,
	partition_nodes;

var partition = d3.layout.partition()
	.sort(null)
	.size([2 * Math.PI, r * r])
	.value(function(d) { return d.size; });

	var vis = d3.select("#"+container_id)
	 .append("g")
     .attr("transform", "translate(" + w / 2 + "," + h / 2 + ")");

	vis.selectAll("path")
		.data(partition.nodes(json))
		.enter().append("path")
			.attr("d", arc)
			.attr("display", function(d) { return d.depth ? null : "none"; }) // hide inner ring
		    .style("fill", function(d, index) {
				return d3.hsl(getColor(d)).rgb().toString();
			})
			.style("fill-opacity", "1")
			.style("stroke", function(d, index) { return d3.hsl(getColor(d)).darker(0.6).rgb().toString(); })
			.style("stroke-width", function(d) { return "1"; }) //changed to strings for IE
			.on("mousemove", mouseOnElementArbitrary);
}

function drawMiniPies() {
	var w = 180,
		h = 180,
		r = 9,
		color = d3.scale.category20b(),
		inverseColor = d3.scale.ordinal(),
		path, partition_nodes;

	var partition = d3.layout.partition().sort(null).size([2 * Math.PI, r * r]).value(function (d) {
		return d.size;
	});

	$('input').each(function (index) {
		//#pi_data_22 => #minipie_22
		var str = $(this).attr("id").split("_")[1];
		var vis = d3.select("#minipie_" + str).append("g").attr("transform", "translate(" + w / 2 + "," + h / 2 + ")");

		var json = eval('(' + $(this).val() + ')');

		vis.selectAll("path").data(partition.nodes(json)).enter().append("path").attr("d", arc).attr("display", function (d) {
			return d.depth ? null : "none";
		}) // hide inner ring
		.style("fill", function (d, index) {
			$("#f" + d.name + "_color").css("background-color", getColor(d)).show();
			$("#f" + d.name + "_color_proportional").css("background-color", getColor(d)).show();
			return d3.hsl(getColor(d)).rgb().toString();
		}).style("fill-opacity", "1").style("stroke", function (d, index) {
			return d3.hsl(getColor(d)).darker(0.6).rgb().toString();
		}).style("stroke-width", function (d) {
			return "1";
		}) //changed to strings for IE
		.on("mousemove", mouseOnElementMini);
	});
}


/**
 * Redraw
 **/
function redraw(data_file) {
	$("#loading").show();

	$("#sunburst_container").fadeOut(100, function () {
		d3.selectAll("g").remove();
		d3.selectAll("path").remove();

		svg = d3.selectAll("#sunburst_container").insert("svg:svg").attr("width", w).attr("height", h).append("svg:g").attr("id", "container").attr("transform", "translate(" + w / 2 + "," + h / 2 + ")")
		var filter = svg.append("filter").attr("id", "dropshadow").attr("height", "130%");
		var blur = filter.append("feGaussianBlur").attr("in", "SourceAlpha").attr("stdDeviation", "15").append("feOffset").attr("dx", "0").attr("dy", "0").attr("result", "offsetblur");
		var femerge = blur.append("feMerge").append("feMergeNode");
		var femerge2 = femerge.append("feMergeNode").attr("in", "SourceGraphic")
		var bg_circle_blurred = svg.append("circle").attr("id", "bg_circle_blurred").attr("cx", 0).attr("cy", 0).attr("r", 263).attr("z-index", -1).attr("fill-opacity", 0.3).style("filter", "url(#dropshadow)");

		//draw bg circle
		var bg_circle = svg.append("circle").attr("id", "bg_circle").attr("cx", 0).attr("cy", 0).attr("r", 263).attr("z-index", -1)
				.style("stroke", "#cccccc").style("stroke-width", 1).style("fill", function (d, i) {
		
			return "#f6f5e4";
		})
		
		svg.append("image").attr("width", "129").attr("height", "316").attr("x", "250").attr("y", "-160").attr("xlink:href", "../images/guides.png");
		
		var path = data_file;
		d3.json(path, function (json_data) {			
			//if pie id is set, get the particular pie from the db and use that json instead
			//of the default; if anything goes wrong, we continue to use the default, hence
			//why this block is inside and done after the data_file json is retrieved
			if(getURLParameter("p") != "null") {
				var actionMethod;
				if(document.URL.indexOf("federalbudget") != -1) actionMethod = 'getFederalBudgetPieById';
				else if(document.URL.indexOf("talkingpoints") != -1) actionMethod = 'getTalkingPointsPieById';

				var invalid_pie_from_db = false;
				
				$.ajax({ url: '../dataaccess/global.php',
		        	data: {action: actionMethod, id: getURLParameter("p")},
		        	type: 'post',
		        	async: false,
			    	success: function(output) {
			    		//console.log(output);
			    		if(output != "0") { //if id doesn't exist or some other error occurred, just use default pie
	                    	json_data = eval('(' + output + ')');
	                    	//console.log(json_data);
	                    }
	                    else {
	                    	invalid_pie_from_db = true;
	                    }
                    	//console.log("DONE WITH AJAX CALL");
                	}
				});
			}
			else {
				invalid_pie_from_db = true;
			}
			
			
			if(invalid_pie_from_db) {
				//equal slices for all except federal budget
				if(data_file_to_load != "data_files/data-2012.json") {
					for (var i = 0; i < json_data.children.length; i++) {
						//if (json_data.children[i].name != "_unallocated") json_data.children[i].size = 100 / (json_data.children.length - 1);
						json_data.children[i].size = 100 / (json_data.children.length);
					}
					update(json_data);
				}
			}
			
			//json_data = eval(json_data);
			
			var unallocated = {
				size: 0,
				label: "Unallocated",
				name: "_unallocated"
			};
			json_data.children.push(unallocated);

			partition_nodes = partition.nodes(json_data);
			var arcs_data;
			
			for (var i = 0; i < json_data.children.length; i++) {
				var d = json_data.children[i];
				//$("#f"+d.name+"_data").html(Math.round(d.size) + "%");
				
				if(data_file_to_load == "data_files/data-talkingpoints.json")
					$("#f" + d.name + "_data").html(Math.round(d.size) + "%");
				else
					$("#f" + d.name + "_data").html(Math.round(d.size) + "% ($" + addCommas(Math.round(TOTAL_BUDGET * (d.size / 100))) + "b)");
					
				$("#f" + d.name + "_d").val(formatNumberLength(Math.round(TOTAL_BUDGET * (d.size / 100)), 4)); //console.log(80*(d.size/100));
				$("#f" + d.name + "_color_proportional").css("width", 80 * (d.size / 100) + "px"); //60px is the real estate we have for each bar, but we'll use 100px
			}

			if ($.browser.mozilla) {
				arcs_data = svg.select("#container").data([json_data]).selectAll("g").data(partition_nodes).enter().insert("g").attr("class", "node").attr("visibility", function (d) {
					return d.depth ? null : "hidden";
				}) // hide inner ring
			} else {
				arcs_data = svg.data([json_data]).selectAll("#container").data(partition_nodes).enter().insert("g").attr("class", "node").attr("display", function (d) {
					return d.depth ? null : "none";
				}) // hide inner ring
			}

			//draw the arcs for the given dataset and store in variable  
			path = arcs_data.append("svg:path").attr("d", arc).style("fill", function (d, index) {
				$("#f" + d.name + "_color").css("background-color", getColor(d)).show();
				$("#f" + d.name + "_color_proportional").css("background-color", getColor(d)).show();
				return d3.hsl(getColor(d)).rgb().toString();
			}).style("fill-opacity", "1").style("stroke", function (d, index) {
				return d3.hsl(getColor(d)).darker(0.6).rgb().toString();
			}).style("stroke-width", function (d) {
				return "1";
			}) //changed to strings for IE
			.attr("id", function (d) {
				return "f" + d.name;
			}).on("mousemove", mouseOnElement).on("click", mouseOnElement).on("mouseover", function (d) {
				$("#moreinfo_container").html($("#" + d.name + "_moreinfo").val());
				
				$("#f" + d.name).css("font-weight", "bold");
				$("#f" + d.name + "_data").css("background-image", "url(../images/arrow.png)").css("background-position", "right center").css("background-repeat", "no-repeat").css("font-weight", "bold");

				//$("#receipt").html(setReceiptContent(json_data, d.label));	
				$(".receipt_line_item").css("font-weight", "normal");
				$("#receipt_li_" + d.name).css("font-weight", "bold");
				$("#receipt_li_val_" + d.name).css("font-weight", "bold");

			}).on("mouseout", function (d) {
				$("#moreinfo_container").html('Mouse over a budget category to see more info about it here, including the budget functions that it consolidates, if applicable.  Details of the spending for each budget function are from <a href="http://budget.house.gov/BudgetProcess/BudgetFunctions.htm" target="_blank">here</a>.');
			
				d3.select(this).style("fill", d.currentColor ? d.currentColor : getColor(d));
				$("#the_slice_im_on").html("");

				$("#f" + d.name).css("font-weight", "normal");
				$("#f" + d.name + "_data").css("background-image", "none").css("font-weight", "normal");

				$(".receipt_line_item").css("font-weight", "normal");
			}).each(stash);

			// Add resize handles. Note: we don't allow the unallocated budget to be dragged!
			var handle = arcs_data.filter(function (d) {
				return d !== unallocated;
			}).append("g").attr("class", "handle").call(d3.behavior.drag().on("drag", function (d, i) {
				d3.selectAll("#f" + d.name).style("fill", d3.hsl(getColor(d)).brighter(0.3).rgb().toString());

				var a = d.x + d.dx + Math.PI / 2,
					// D3 offsets arcs by 90° so we compensate
					start = [-d.y * Math.cos(a), -d.y * Math.sin(a)],
					m = [d3.event.x, d3.event.y],
					delta = Math.atan2(cross(start, m), dot(start, m));

				unallocated.size = 0;
				d.size = 0;
				// Work out the total allocation excluding the current segment.
				var rest = d3.sum(json_data.children, function (d) {
					return d.size;
				});
				// Convert the new angular width (in radians) into a
				// percentage between 0 and 100 - rest.
				d.size = Math.min(100 - rest, Math.max(0, 100 * (d.dx + delta) / (2 * Math.PI)));

				//constaint min size of arc
				if (d.size <= 0.75) d.size = 0.75;

				// Update the unallocated size.
				unallocated.size = 100 - rest - d.size;
				update(json_data);

				data_snapshot = json_data;

				if(data_file_to_load == "data_files/data-talkingpoints.json")
					$("#f" + d.name + "_data").html(Math.round(d.size) + "%");
				else
					$("#f" + d.name + "_data").html(Math.round(d.size) + "% ($" + addCommas(Math.round(TOTAL_BUDGET * (d.size / 100))) + "b)");
					
				$("#f" + d.name + "_d").val(formatNumberLength(Math.round(TOTAL_BUDGET * (d.size / 100)), 4));
				$("#f" + d.name + "_color_proportional").css("width", 80 * (d.size / 100) + "px"); //60px is the real estate we have for each bar, but we'll use 100px

				if(data_file_to_load == "data_files/data-talkingpoints.json")
					$("#receipt").html(setReceiptContentTalkingPoints(json_data, d.label));
				else
					$("#receipt").html(setReceiptContent(json_data, d.label));

				$('.container').sortElements(function (a, b) {
					a = a.firstChild.nextSibling.value + " " + $(a).text().trim(); //appending text so that they don't jump around crazily when values ($s) are the same
					b = b.firstChild.nextSibling.value + " " + $(b).text().trim();
					return (a < b) ? 1 : -1;
				});

				//for receipt
				$('.container_receipt').sortElements(function (a, b) {
					a = $(a).text().trim();
					b = $(b).text().trim();
					return a > b ? 1 : -1;
				});
				$('.container_receipt').sortElements(function (a, b) {
				//console.log(":::::::::" +  + ":::::::::");
					//var bits = $(a).text().trim().split("$");//console.log(":::::::::" + bits[1] + ":::::::::");
					a = parseInt($(a).text().replace(",","").match(/\d[^ ]+/));

					//bits = $(b).text().trim().split("$");
					b = parseInt($(b).text().replace(",","").match(/\d[^ ]+/));

					return (a < b) ? 1 : -1;
				});
			}))

			.attr("transform", handleTransform);
			handle.append("rect").attr("width", 20).attr("height", 35).attr("y", -15);
			handle.append("path").attr("d", "M0,-1L10,-1L5,-10Z").attr("fill", "#c62f0c"); //left arrow
			handle.append("path").attr("d", "M0,1L10,1L5,10Z").attr("fill", "#177701"); //right arrow
			handle.append("path").attr("d", "M-250,-1L0,-1L0,-10Z").attr("fill", "#fff").attr("opacity", "0.1"); //overlayed area
			//handle.append("text")
			//	.attr("text-anchor", "top")
			//	.attr("font-size", "8pt")
			//	.attr("fill", "#fff")
			//	.attr("dy", function(d) { return "-0.2em"; })
			//	.attr("dx", function(d) { return -250; })
			//	.text(function(d) { return d.label; }) 
			//	.attr("class", "tooltip");
			handle.on("mouseover", function (d) {
				$("#f" + d.name).css("font-weight", "bold");
				$("#f" + d.name + "_data").css("background-image", "url(../images/arrow.png)").css("background-position", "right center").css("background-repeat", "no-repeat").css("font-weight", "bold");

				d3.selectAll("#f" + d.name).style("fill", d3.hsl(getColor(d)).brighter(0.3).rgb().toString());
			}).on("mouseout", function (d) {
				d3.selectAll("#f" + d.name).style("fill", d.currentColor ? d.currentColor : getColor(d));
				$("#f" + d.name).css("font-weight", "normal");
				$("#f" + d.name + "_data").css("background-image", "none").css("font-weight", "normal");
			}).on("mousemove", mouseOnElement)

			data_snapshot = json_data;
			
			if(data_file_to_load == "data_files/data-talkingpoints.json")
					$("#receipt").html(setReceiptContentTalkingPoints(data_snapshot, ""));
				else
					$("#receipt").html(setReceiptContent(data_snapshot, ""));
			

			//fade in new sunburst
			$("#sunburst_container").fadeIn(500);

			//for lhs budget info
			$('.container').sortElements(function (a, b) {
				a = $(a).text().trim();
				b = $(b).text().trim();
				return a > b ? 1 : -1;
			});
			$('.container').sortElements(function (a, b) {
				a = a.firstChild.nextSibling.value + " " + $(a).text().trim(); //appending text so that they don't jump around crazily when values ($s) are the same
				b = b.firstChild.nextSibling.value + " " + $(b).text().trim();
				return (a < b) ? 1 : -1;
			});

			//for receipt
			$('.container_receipt').sortElements(function (a, b) {
				a = $(a).text().trim();
				b = $(b).text().trim();
				return a > b ? 1 : -1;
			});
			$('.container_receipt').sortElements(function (a, b) {
				//var bits = $(a).text().trim().split("$");
				a = parseInt($(a).text().replace(",","").match(/\d[^ ]+/));

				//bits = $(b).text().trim().split("$");
				b = parseInt($(b).text().replace(",","").match(/\d[^ ]+/));

				return (a < b) ? 1 : -1;
			});


			$("#budget_overview").fadeIn();

			$("#loading").fadeOut("slow");
		}); //end fadeout callback
	});
}


function setReceiptContent(pie, label) {
	var receipt_content = "";
	receipt_content += "<div style='position:relative;top:40px;width:275px;height:40px;font-weight:bold;text-align:center;font-size:12pt'>Your receipt<br /><span style='font-size:8pt'>Federal budget per capita expenditure</span></div>";

	var sum = 0;
	for (var i = 0; i < pie.children.length; i++) {
		if (pie.children[i].name != "_unallocated") {
			var n = (TOTAL_BUDGET * (pie.children[i].size / 100)) / 311591917 * 1000000000;
			sum += n;

			receipt_content += "<div class='container_receipt'>";
			receipt_content += "<div class='receipt_line_item' style='width:180px;float:left' id='receipt_li_" + pie.children[i].name + "'>";
			//if(pie.children[i].label == label)   receipt_content += "<strong>";
			receipt_content += pie.children[i].label;
			//if(pie.children[i].label == label)   receipt_content += "</strong>";
			receipt_content += "</div>";

			receipt_content += "<div class='receipt_line_item' style='width:50px;left:-30px;float:right;text-align:right' id='receipt_li_val_" + pie.children[i].name + "'>";
			//if(pie.children[i].label == label)   receipt_content += "<strong>";
			receipt_content += "$" + addCommas(n.toFixed(2)) + "<br />"; //par capita
			//if(pie.children[i].label == label)   receipt_content += "</strong>";
			receipt_content += "</div>";
			receipt_content += "</div>";
		}
	}

	receipt_content += "<div id='receipt_total'>Total: $" + addCommas(Math.round(sum)) + "</div>";
	receipt_content += "</div>";

	return receipt_content;
}

function setReceiptContentTalkingPoints(pie, label) {
	var receipt_content = "";
	receipt_content += "<div style='position:relative;top:50px;width:275px;height:40px;font-weight:bold;text-align:center;font-size:12pt'>Your receipt</div>";

	var sum = 0;
	for (var i = 0; i < pie.children.length; i++) {
		if (pie.children[i].name != "_unallocated") {
			var n = (60 * (pie.children[i].size / 100));
			sum += n;

			receipt_content += "<div class='container_receipt'>";
			receipt_content += "<div class='receipt_line_item' style='width:180px;float:left' id='receipt_li_" + pie.children[i].name + "'>";
			//if(pie.children[i].label == label)   receipt_content += "<strong>";
			receipt_content += pie.children[i].label;
			//if(pie.children[i].label == label)   receipt_content += "</strong>";
			receipt_content += "</div>";

			receipt_content += "<div class='receipt_line_item' style='width:80px;left:-15px;float:right;text-align:right' id='receipt_li_val_" + pie.children[i].name + "'>";
			//if(pie.children[i].label == label)   receipt_content += "<strong>";
			receipt_content += n.toFixed(2) + " mins<br />"; //par capita
			//if(pie.children[i].label == label)   receipt_content += "</strong>";
			receipt_content += "</div>";
			receipt_content += "</div>";
		}
	}

	receipt_content += "<div id='receipt_total'>Total: " + addCommas(Math.round(sum)) + " mins</div>";
	receipt_content += "</div>";

	return receipt_content;
}


// Updates the sunburst using the given data.
// Note: only updates; no exit or entering handled here.
function update(data) {
	var g = svg.selectAll("g.node").data(partition.nodes(data));
	g.select("path").attr("d", arc);
	g.select("g.handle").attr("transform", handleTransform);

	if (debug_mode == 1) console.log(data);
	data_snapshot = data;
}

// Computes the transform attribute for a resize handle.
function handleTransform(d) {
	// We place the handle at the *end* of each segment (hence we add d.dx).
	// We also offset the radius by a little bit (+ 1).
	return "rotate(" + ((d.x + d.dx) / radians - 90) + ")translate(" + (1 + d.y + d.dy) + ")";
}

function cross(a, b) {
	return a[0] * b[1] - a[1] * b[0];
}

function dot(a, b) {
	return a[0] * b[0] + a[1] * b[1];
}

function addCommas(nStr) {
	nStr += '';
	var x = nStr.split('.');
	var x1 = x[0];
	var x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

/**
 * Get color
 **/
function getColor(d) {
	if (d.label == "Unallocated") return "#fff"; //return "#3c3c3c";
	else {
		if (d.color == undefined) {
			var c = d3.hsl(color(d.name));
			return c.rgb().toString(); //for IE
		} else {
			var c = d3.hsl(d.color);
			//c.s += 0.2; //increase saturation a bit
			return c.rgb().toString(); //for IE;
		}
	}
}

/**
 * Called after page is loaded
 **/
$(document).ready(function () {

	$("select, textarea, input:checkbox, input:radio, input:file").uniform();
	$("#intro_box_content").corner();
	$("#video_box").corner();
	$("#submission_box").corner();
	$("#submission_pre_box").corner();
	$(".minipie_container").corner();

	$(".corner").corner();

	$("#loading").show();
	assignEventListeners();
	$("#hovered_over_node").corner();
	$("#hovered_over_node").hide();
	$("#hovered_over_node_fixed").corner();
	$("button").button();
	
	$("#overview_box").animate({
    	height: '15px'
  		}, 400, function() {
    		// Animation complete.
	});

	//getDataFiles();
	if (typeof (data_file_to_load) != "undefined") {
		redraw(data_file_to_load);
	}

	//show intro box only on first visit on first page
	if (typeof (repeat_visitor) != "undefined") {
		setTimeout(function () {
			if (repeat_visitor != "1") {
				$(".dim").fadeIn();
				$("#intro_box").fadeIn("slow");
			}
		}, 3000);
	}


	//enforce maxlength on comment textarea
	var txts = document.getElementsByTagName('TEXTAREA')
	for (var i = 0, l = txts.length; i < l; i++) {
		if (/^[0-9]+$/.test(txts[i].getAttribute("maxlength"))) {
			var func = function () {
					var len = parseInt(this.getAttribute("maxlength"), 10);

					if (this.value.length > len) {
						//alert('Maximum length exceeded: ' + len); 
						this.value = this.value.substr(0, len);
						return false;
					}
				}

			txts[i].onkeyup = func;
			txts[i].onblur = func;
		}
	}
});

//Adjust height of overlay to fill screen when browser gets resized  
$(window).bind("resize", function () {
	$("#fuzz").css("height", $(window).height());
});


/*function gefilta_function() {
	$("#loader").show();
	
		var dataString = 'filter=' + $("#show_filter").val();
		$.ajax({
			type: "POST",
			url: "wallofpies_handler.php",
			data: dataString,
			success: function (data) {
				$("#allpies").hide().html(data).fadeIn("slow");
				drawMiniPies();
				$("#loader").fadeOut();
			}
		});
}*/

/**
 * Assign our event listeners
 **/
function assignEventListeners() {
	$(document).mousemove(function (e) {
		mouseX = e.pageX;
		mouseY = e.pageY;
		//console.log(mouseX + ", " + mouseY);
	});

	$("#overview_box").mouseenter(function (e) {
		$("#overview_box").animate({
    		height: '230px'
  			}, 400, function() {
    			// Animation complete.
		});
	});
	
	$("#overview_box").mouseleave(function (e) {
		$("#overview_box").animate({
    		height: '15px'
  			}, 200, function() {
    			// Animation complete.
		});
	});
	
	$("#sunburst_container").mouseleave(function (e) {
		$("#hovered_over_node").fadeOut("fast");
	});
	
	$(".average_pie").mouseleave(function (e) {
		$("#hovered_over_node").fadeOut("fast");
	});

	$(".minipie_container").mouseleave(function (e) {
		$("#hovered_over_node").fadeOut("fast");
	});

	$("select").click(function (e) {
		$("#hovered_over_node").fadeOut("slow");
	});


	$("#playvideo").click(function (e) {
		$(".dim").fadeIn();
		$("#video_box").fadeIn("slow");
	});

	$("#close").click(function (e) {
		$("#intro_box").fadeOut();
		$(".dim").fadeOut();
	});

	$(".dim").click(function (e) {
		$("#intro_box").fadeOut();
		$("#submission_box").fadeOut();
		$(".dim").fadeOut();
	});

	$("#close_overlayed").click(function (e) {
		$("#submission_box").fadeOut();
		$(".dim").fadeOut();
	});

	$("#close_video_box").click(function (e) {
		$("#video_box").fadeOut();
		$(".dim").fadeOut();
	});

	$("#submit_load_button").click(function (e) {
		$(".dim").fadeIn();
		$("#submission_box").fadeIn("fast", "swing");
	});
	
	$("#show_filter").change(function (e) {
		$("#loader").show();
	
		var dataString = 'filter=' + $("#show_filter").val();
		$.ajax({
			type: "POST",
			url: "wallofpies_handler.php",
			data: dataString,
			success: function (data) {
				$("#allpies").html(data);
				$(".minipie_container").corner();
				drawMiniPies();
				$("#loader").fadeOut();
			}
		});
		
		return false;
	});

	$("#submit_button").click(function (e) {
		if ($("input[@name=politics]:checked").val() == undefined) {
			alert("We'll need to know where you are on the political spectrum if that's ok!");
			return false;
		}
		if ($("#state").val() == "") {
			alert("Oops, you forgot to choose a state");
			return false;
		}
		if ($("#gender").val() == "") {
			alert("Oops, you forgot to choose a gender");
			return false;
		}
		if ($("#age").val() == "") {
			alert("Oops, you forgot to choose an age range");
			return false;
		}

		//show loading
		$("#submit_button").hide();
		$('#message').html("<span style='position:relative;left:15px'>Working on your pie...</span>");
		$('#message').show();

		//set the snapshot to our form so that we can save it in the db
		for(var i = 0; i<data_snapshot.children.length-1;i++) {
			//console.log(data_snapshot.children[i].name);
			$("#slice_"+data_snapshot.children[i].name.toLowerCase()).val(data_snapshot.children[i].size);
			//console.log(":::::::---->"+$("#slice_"+data_snapshot.children[i].name).val());
			//console.log(data_snapshot.children[i]);
		}
		
		
		if (debug_mode == 1) console.log(data_snapshot);
		var data = JSON.stringify(clean(data_snapshot));
		if (debug_mode == 1) console.log(data);
		$("#pie").val(data);

		//submit it
		var dataString = 'pie=' + data + '&politics=' + $("input[@name=politics]:checked").val() + '&age=' + $("#age").val() + '&gender=' + $("#gender").val() + '&state=' + $("#state").val() + '&zip=' + $("#zip").val() + '&comment=' + $("#comment").val();
		
		//create data string for particular pie
		if(data_file_to_load == "data_files/data-2012.json")
			dataString += '&slice_def=' + $("#slice_def").val() + '&slice_hel=' + $("#slice_hel").val() + '&slice_sci=' + $("#slice_sci").val() + '&slice_agr=' + $("#slice_agr").val() + '&slice_crd=' + $("#slice_crd").val() + '&slice_soc=' + $("#slice_soc").val() + '&slice_edu=' + $("#slice_edu").val() + '&slice_tra=' + $("#slice_tra").val() + '&slice_ene=' + $("#slice_ene").val() + '&slice_inc=' + $("#slice_inc").val() + '&slice_oth=' + $("#slice_oth").val(); //for federal budget pie
		else if(data_file_to_load == "data_files/data-talkingpoints.json") 
			dataString += '&slice_war=' + $("#slice_war").val() + '&slice_gay=' + $("#slice_gay").val() + '&slice_mar=' + $("#slice_mar").val() + '&slice_edu=' + $("#slice_edu").val() + '&slice_hel=' + $("#slice_hel").val() + '&slice_eco=' + $("#slice_eco").val() + '&slice_gun=' + $("#slice_gun").val() + '&slice_pri=' + $("#slice_pri").val() + '&slice_glo=' + $("#slice_glo").val(); //for talking points pie
			
		$.ajax({
			type: "POST",
			url: "addpie.php",
			data: dataString,
			success: function (data) {
				var pie_category;
				if(data_file_to_load == "data_files/data-2012.json") pie_category = "federalbudget";
				else if(data_file_to_load == "data_files/data-talkingpoints.json") pie_category = "talkingpoints";
				
				var permalink = "http%3A%2F%2Fwww%2Eparticipie%2Ecom%2Fwip%2F" + pie_category + "%2F%3Fp%3D"+data;
				var permalink_decoded = "http://www.participie.com/wip/" + pie_category + "/?p="+data;
				
				$('#permalink').attr("href", permalink_decoded);
				
				$('#message').fadeOut();
				setTimeout(function () {
					$('#message').html("<img src='../images/check.png' style='width:50px;height:43px;float:left;padding-right:5px;padding-left:6px' />Nice one<br /><span style='font-size:80%'>We received your pie!</span>");
					$("#sharebox_post_submit").fadeIn("slow");
					$('#message').fadeIn();
					
					//update permalinks
					var twitter_content = '<a href="https://twitter.com/share" class="twitter-share-button" data-url="' + permalink_decoded + '" data-text="Check out the pie I made on Participie.com!" data-count="none">Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
					$(".twitter").html(twitter_content);
					
					var facebook_content = "<iframe src='//www.facebook.com/plugins/like.php?href=" + permalink + "&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21&amp;appId=310995648970748' scrolling='no' frameborder='0' style='border:none; overflow:hidden; width:100px; height:21px;' allowTransparency='true'></iframe>";
					$(".facebook").html(facebook_content);
					
					var linkedin_content = "<script src='http://platform.linkedin.com/in.js' type='text/javascript'></script><script type='IN/Share' data-url='" + permalink + "'></script>";
					$(".linkedin").html(linkedin_content);
					
					/*$("#canonical").attr("href", permalink);
					var googleplus_content = "<g:plusone size='medium'></g:plusone><script type='text/javascript'>(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();</script>";
					$(".googleplus").html(googleplus_content);*/
					
					var pinterest_content = '<a href="http://pinterest.com/pin/create/button/?url=' + permalink +'&media=http%3A%2F%2Fwww.participie.com%2Fwip%2Fimages%2Fpie_medium.png&description=Check%20out%20the%20pie%20I%20made%20on%20Participie.com" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>';
					$(".pinterest").html(pinterest_content);
				}, 500);
			}
		});
	});
}

function clean(d) {
	var a = {};
	for (var k in d) {
		if (k === "parent" || k === "data") continue; // ignore cycles
		a[k] = k === "children" ? d[k].map(clean) : d[k];
	}
	return a;
}


//remove circulatability (yeah don't think that's a real word), so that we can stringify the object
//http://stackoverflow.com/questions/191881/serializing-to-json-in-jquery
function prepareObjectForStringify(pie) {
	var pie_modded = Array();
	for (var i = 0; i < pie.children.length; i++) {
		if (pie.children[i].name != "_unallocated") {
			pie_modded[i] = [pie.children[i].name, pie.children[i].label, pie.children[i].size];
		}
	}

	return pie_modded;
}

/**
 * jQuery.fn.sortElements
 * --------------
 * @author James Padolsey (http://james.padolsey.com)
 * @version 0.11
 * @updated 18-MAR-2010
 * --------------
 * @param Function comparator:
 * Exactly the same behaviour as [1,2,3].sort(comparator)
 *
 * @param Function getSortable
 * A function that should return the element that is
 * to be sorted. The comparator will run on the
 * current collection, but you may want the actual
 * resulting sort to occur on a parent or another
 * associated element.
 *
 * E.g. $('td').sortElements(comparator, function(){
 * return this.parentNode;
 * })
 *
 * The <td>'s parent (<tr>) will be sorted instead
 * of the <td> itself.
 */
jQuery.fn.sortElements = (function () {

	var sort = [].sort;

	return function (comparator, getSortable) {

		getSortable = getSortable ||
		function () {
			return this;
		};

		var placements = this.map(function () {

			var sortElement = getSortable.call(this),
				parentNode = sortElement.parentNode,

				// Since the element itself will change position, we have
				// to have some way of storing it's original position in
				// the DOM. The easiest way is to have a 'flag' node:
				nextSibling = parentNode.insertBefore(
				document.createTextNode(''), sortElement.nextSibling);

			return function () {

				if (parentNode === this) {
					throw new Error("You can't sort elements if any one is a descendant of another.");
				}

				// Insert before flag:
				parentNode.insertBefore(this, nextSibling);
				// Remove flag:
				parentNode.removeChild(nextSibling);

			};

		});

		return sort.call(this, comparator).each(function (i) {
			placements[i].call(getSortable.call(this));
		});

	};

})();

function showFullComment(comment, container) {
	if (comment.length > 35) {
		$("#hovered_over_node").fadeOut("fast");
		$(container).append("<div class='full_comment_overlay'>" + comment + "</div>");

		//position the name of the node close to the mouse pointer
		//$("#hovered_over_node").css("top", (mouseY+20)+"px");
		//$("#hovered_over_node").css("left", (mouseX-80)+"px");
		//$("#hovered_over_node").html(comment).fadeIn("fast");
	}
}

function hideFullComment(comment) {
	//$("#hovered_over_node").fadeOut("fast");
	$(".full_comment_overlay").remove();
}

var mouseX, mouseY, svg, w = 570,
	h = 580,
	r = 250,
	color = d3.scale.category20b(),
	inverseColor = d3.scale.ordinal(),
	path,
	//grips,
	currently_active_slider, partition_nodes, data_snapshot, debug_mode = 0;

var arc = d3.svg.arc().startAngle(function (d) {
	return d.x;
}).endAngle(function (d) {
	return d.x + d.dx;
}).innerRadius(function (d) {
	return 2;
}).outerRadius(function (d) {
	return d.y + d.dy;
});

var partition = d3.layout.partition().size([2 * Math.PI, r]).value(function (d) {
	return d.size;
}).sort(null); //don't sort, use same order as in datafile
var data_file_local_cache = {} //new Object();
var arr_data_files = ["data-2012"];
var TOTAL_BUDGET = 3669.54;