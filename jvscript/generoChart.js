document.addEventListener("DOMContentLoaded", () => {
  fetch("../BLL/dashboard_bll.php")
    .then(response => {
      if (!response.ok) throw new Error("HTTP error " + response.status);
      return response.json();
    })
    .then(data => {
      // Handle Genero
      const generoLabels = Object.keys(data.genero);
      const generoValues = Object.values(data.genero);

      const generoChart = new CanvasJS.Chart("generoChart", {
        animationEnabled: true,
        theme: "light2",
        title: { text: "Distribuição por Gênero" },
        axisY: { title: "Quantidade" },
        data: [{
          type: "column",
          dataPoints: generoLabels.map((label, i) => ({
            label: label === 'M' ? 'Masculino' : 'Feminino',
            y: generoValues[i],
            color: label === 'M' ? "#36A2EB" : "#FF6384"
          }))
        }]
      });
      generoChart.render();

      const nacionalidadeLabels = Object.keys(data.nacionalidade);
      const nacionalidadeValues = Object.values(data.nacionalidade);

      // Cores dinâmicas para múltiplas nacionalidades
      const colors = ["#36A2EB", "#FF6384", "#FFCE56", "#4BC0C0", "#9966FF", "#FF9F40"];

      const circuloChart = new CanvasJS.Chart("circulo", {
        animationEnabled: true,
        theme: "light2",
        title: {
          text: "Distribuição por Nacionalidade - Pizza"
        },
        data: [{
          type: "pie",
          startAngle: 240,
          indexLabel: "{label}: {y}",
          dataPoints: nacionalidadeLabels.map((label, i) => ({
            label: label,
            y: nacionalidadeValues[i],
            color: colors[i % colors.length]  // Alterna cores
          }))
        }]
      });

      circuloChart.render();


      // Handle Cargo
      const cargoLabels = Object.keys(data.cargo);
      const cargoValues = Object.values(data.cargo);

      const cargoChart = new CanvasJS.Chart("cargoChart", {
        animationEnabled: true,
        theme: "light2",
        title: { text: "Distribuição por Cargo" },
        axisY: { title: "Quantidade" },
        data: [{
          type: "bar",
          dataPoints: cargoLabels.map((label, i) => ({
            label: label,
            y: cargoValues[i]
          }))
        }]
      });
      cargoChart.render();
    })
    .catch(error => {
      console.error("Erro ao carregar dados:", error);
    });
});
