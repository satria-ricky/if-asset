const ctx = document.getElementById('myChart');

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    datasets: [{
      label: 'Aset',
      data: [12, 19, 3, 5, 2, 3],
      borderWidth: 1
    }]
  },
  backgroundColor: 'rgba(75, 192, 192, 0.2)',
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
