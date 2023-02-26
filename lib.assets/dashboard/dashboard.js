/* globals Chart:false, feather:false */

(() => {
  'use strict'
  const ctx = document.getElementById('sync-chart')

  const data = {
    labels: labels,
    datasets: [
      {
        type: 'bar',
        label: 'Database',
        backgroundColor: '#6CB372',
        data: dataDatabase,
        yAxisID: 'y-axis-1'
      },
      {
        type: 'bar',
        label: 'File',
        backgroundColor: '#00a8db',
        data: dataFile,
        yAxisID: 'y-axis-2'
      }
    ]
  };
  const config = {
    type: 'bar',
    data: data,
    options: {
      tooltips: {
        mode: 'index',
        intersect: false,
        callbacks: {
          label: function (t, d) {
            return t.yLabel + ' push';
          }
        }
      },
      scales: {
        yAxes: [{
          id: "y-axis-1",
          position: "left"
        }, {
          id: "y-axis-2",
          position: "right"
        }]
      },
    },
  };
  const myChart = new Chart(ctx, config)
})()
