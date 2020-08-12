/*!
 * Amaretti v2.0.0
 * https://foxythemes.net
 *
 * Copyright (c) 2018 Foxy Themes
 */

var App = (function () {
	'use strict';

	App.ChartJs = function( ){

    var randomScalingFactor = function() {
      return Math.round(Math.random() * 100);
    };

		function lineChart(){
			//Set the chart colors
			var color1 = tinycolor( App.color.primary );
			var color2 = tinycolor( App.color.primary ).lighten( 22 );

      //Get the canvas element
			var ctx = document.getElementById("line-chart");
			
			var lineChartData = {
	      labels: ["January", "February", "March", "April", "May", "June", "July"],
	      datasets: [{
	        label: "My First dataset",
	        borderColor: color1.toString(),
	        backgroundColor: color1.setAlpha(.8).toString(),
	        data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
	      }, {
	        label: "My Second dataset",
	        borderColor: color2.toString(),
	        backgroundColor: color2.setAlpha(.5).toString(),
	        data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
	      }]
	    };

	    var line = new Chart(ctx, {
        type: 'line',
        data: lineChartData
      });
		}

		function barChart(){
			//Set the chart colors
      var color1 = tinycolor( App.color.primary );
			var color2 = tinycolor( App.color.primary ).lighten( 22 );

      //Get the canvas element
			var ctx = document.getElementById("bar-chart");
			
			var data = {
	      labels: ["January", "February", "March", "April", "May", "June", "July"],
	      datasets: [{
	        label: "Credit",
	        borderColor: color1.toString(),
	        backgroundColor: color1.setAlpha(.8).toString(),
	        data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
	      }, {
	        label: "Debit",
	        borderColor: color2.toString(),
	        backgroundColor: color2.setAlpha(.5).toString(),
	        data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
	      }]
	    };

	    var bar = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
          elements: {
            rectangle: {
              borderWidth: 2,
              borderColor: 'rgb(0, 255, 0)',
              borderSkipped: 'bottom'
            }
          },
        }
      });
		}
		// lineChart();
		 barChart();
	};

	return App;
})(App || {});