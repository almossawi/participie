var position = 0;

var w = 960,
    h = 700,
    r = Math.min(w, h) / 1.8,
    s = .06,
    mouseX = 0,
    mouseY = 0;


var fill = d3.scale.linear()
    .range(["hsl(-180, 50%, 50%)", "hsl(180, 50%, 50%)"])
    .interpolate(d3.interpolateHsl);

var arc = d3.svg.arc()
    .startAngle(function(d) { return (d.value * 2 * Math.PI)-.2; })
    .endAngle(function(d) { return d.value * 2 * Math.PI; })
    .innerRadius(function(d) { return d.index * r; })
    .outerRadius(function(d) { return (d.index + s) * r; });

var vis = d3.select("#clock").append("svg")
    .attr("width", w)
    .attr("height", h)
  .append("g")
    .attr("transform", "translate(" + w / 2 + "," + h / 2 + ")");

var g = vis.selectAll("g")
    .data(fields)
  .enter().append("g");

g.append("path")
    .style("fill", function(d) { return fill(d.value); })
    .attr("d", arc);

g.append("text")
    .attr("text-anchor", "middle")
    .attr("dy", "1em")
    .text(function(d) { return d.text; });

// Update arcs
/*d3.timer(function() {
  var g = vis.selectAll("g")
      .data(fields);

  g.select("path")
      .style("fill", function(d) { return fill(d.value); })
      .attr("d", arc)
      .call(drag);

  g.select("text")
      .attr("dy", function(d) { return "-0.4em"; })
      .attr("transform", function(d) {
        return "rotate(" + 360 * d.value + ")"
            + "translate(-20," + (-(d.index + (s-.05) / 2) * r) + ")"
      })
      .text(function(d) { return d.text; });
});*/

function update_location() {	
	  var g = vis.selectAll("g")
      .data(fields)
      .call(drag);

  g.select("path")
      .style("fill", function(d) {
		//console.log("d.value: " + d.value);
      	return fill(d.value); 
      })
      .attr("d", arc)

  g.select("text")
      .attr("dy", function(d) { return "-0.4em"; })
      .attr("transform", function(d) {
        return "rotate(" + 360 * d.value + ")"
            + "translate(-20," + (-(d.index + (s-.05) / 2) * r) + ")"
      })
      .text(function(d) { return d.text; });
      
	//new location
	position = position + (1 / 60)
	//console.log("position: " + position);
}

// Generate the fields for the current date/time.
function fields() {
  return [
    {value: position,  index: .5, text: "<-->"}
  ];
}

var drag = d3.behavior.drag()
    .origin(Object)
    .on("drag", dragmove);
    
/*var circle = vis.append("circle")
    .data([{x: w / 2, y: h / 2}])
    .attr("r", 200)
    .style("fill", "#fff")
    .attr("cx", function(d) { return d.x; })
    .attr("cy", function(d) { return d.y; })
    //.call(drag);
*/

function dragmove(d) {
	//console.log(d3.event);
	//console.log(d3.event.dy);
	
	/*circle
      .attr("cx", d.x = Math.max(r, Math.min(w - r, d3.event.x)))
      .attr("cy", d.y = Math.max(r, Math.min(h - r, d3.event.y)));
	*/  
    
	update_location();
}



update_location();


