var doughnutOptions = {
  responsive: true
};

  var dosen1Data = {
      labels: ["Laki-Laki","Perempuan"],
      datasets: [{
          data: [17,4],
          backgroundColor: ["#2ba9e1", "#1cc09f"]
      }]
  } ;
  var dosen2Data = {
      labels: ["Laki-Laki","Perempuan"],
      datasets: [{
          data: [10,20],
          backgroundColor: ["#3ba3e1", "#1cc09f"]
      }]
  } ;


  var ctx1 = document.getElementById("dosen1Chart").getContext("2d");
  var ctx2 = document.getElementById("dosen2Chart").getContext("2d");
  new Chart(ctx1, {type: 'doughnut', data: dosen1Data, options:doughnutOptions});
  new Chart(ctx2, {type: 'doughnut', data: dosen2Data, options:doughnutOptions});