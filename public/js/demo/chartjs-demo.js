$(function () {


    var barData = {
        labels: ["Masuk", "Izin", "Sakit", "Cuti", "Perjadin", "Tidak Masuk"],
        datasets: [
            {
                label: "Data 1",
                backgroundColor: 'rgba(140, 73, 28, 0.7)',
                pointBorderColor: "#fff",
                data: [65, 59, 80, 81, 56, 15]
            },
        ]
    };

    var barOptions = {
        responsive: true
    };


    var ctx2 = document.getElementById("barChart").getContext("2d");
    new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});

});