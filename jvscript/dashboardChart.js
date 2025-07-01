document.addEventListener("DOMContentLoaded", () => {
  let rawData = {};

  function createCheckboxFilters(containerId, data, onChange) {
    const container = document.getElementById(containerId);
    container.innerHTML = "";
    Object.keys(data).forEach(key => {
      const label = document.createElement("label");
      label.style.marginRight = "15px";
      label.style.cursor = "pointer";
      label.innerHTML = `<input type="checkbox" value="${key}" checked> ${formatLabel(key, containerId)}`;
      container.appendChild(label);
      label.querySelector("input").addEventListener("change", onChange);
    });
  }

  function formatLabel(key, containerId) { 
    if(containerId === "filters-genero") { // esta a ser criado pq a informacao vem como M e F e nao masculino e feminino
      return key === "M" ? "Masculino" : "Feminino";
    }
    // Para cargo,nacionalidade, retorna direto
    return key;
  }

  function filterData(data, containerId) {
    const container = document.getElementById(containerId);
    const checkboxes = container.querySelectorAll("input[type=checkbox]");
    let filtered = {};
    checkboxes.forEach(chk => {
      if(chk.checked && data[chk.value] !== undefined) {
        filtered[chk.value] = data[chk.value];
      }
    });
    return filtered;
  }

  function generateColors(count, hueStart = 0, hueRange = 360) {
    const colors = [];
    for (let i = 0; i < count; i++) {
      const hue = Math.floor(hueStart + (hueRange / count) * i) % 360;
      colors.push(`hsl(${hue}, 70%, 60%)`);
    }
    return colors;
  }

  function renderChart(containerId, title, filteredData, type="column", colorMap = {}) {
    const labels = Object.keys(filteredData);
    const values = Object.values(filteredData);

    const chart = new CanvasJS.Chart(containerId, {
      animationEnabled: true,
      theme: "light2",
      title: { text: title },
      axisY: (type === "column") ? { title: "Quantidade" } : undefined,
      data: [{
        type: type,
        startAngle: (type === "pie") ? 240 : undefined,
        indexLabel: (type === "pie") ? "{label}: {y}" : undefined,
        dataPoints: labels.map(label => ({
          label: formatLabel(label, "filters-" + containerId.replace("Chart","")),
          y: filteredData[label],
          color: colorMap[label] || "#999"
        }))
      }]
    });
    chart.render();
  }

  function onGeneroChange() {
    const filtered = filterData(rawData.genero, "filters-genero");
    renderChart("generoChart", "Distribuição por Gênero", filtered, "pie", { M: "#36A2EB", F: "#FF6384" });
  }

  function onCargoChange() {
    const filtered = filterData(rawData.cargo, "filters-cargo");
    const labels = Object.keys(filtered);

    // Paleta para Cargo: azul-esverdeado (hue 150-210)
    const cargoColorsArray = generateColors(labels.length, 150, 60);
    const cargoColors = {};
    labels.forEach((label, i) => {
      cargoColors[label] = cargoColorsArray[i];
    });

    renderChart("cargoChart", "Distribuição por função", filtered, "bar", cargoColors);
  }

  function onNacionalidadeChange() {
    const filtered = filterData(rawData.nacionalidade, "filters-nacionalidade");
    const labels = Object.keys(filtered);

    // Paleta para Nacionalidade: tons quentes (hue 0-60)
    const nacionalidadeColorsArray = generateColors(labels.length, 0, 60);
    const nacionalidadeColors = {};
    labels.forEach((label, i) => {
      nacionalidadeColors[label] = nacionalidadeColorsArray[i];
    });

    renderChart("nacionalidadeChart", "Distribuição por Nacionalidade", filtered, "pie", nacionalidadeColors);
  }


  function calculateAverageAge(dataNascimento) {
    const today = new Date();
    let totalAge = 0;
    let totalPeople = 0;

    for (const birthDateStr in dataNascimento) {
        const count = dataNascimento[birthDateStr];
        const birthDate = new Date(birthDateStr);

        if (isNaN(birthDate)) continue; // skip a datas invalidas

        const age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        const dayDiff = today.getDate() - birthDate.getDate();

        // Ajustar udade se o aniversario nao tiver ocorrido ainda
        const exactAge = (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) ? age - 1 : age;

        totalAge += exactAge * count;
        totalPeople += count;
    }

    return totalPeople > 0 ? (totalAge / totalPeople).toFixed(2) : 0;
}

  
  // Fetch de dados e inicialização
  fetch("../BLL/dashboard_bll.php")
    .then(res => 
      res.json()  // Use .json() para obter os dados como JSON
    )
    .then(data => {
      rawData = data;
      

      createCheckboxFilters("filters-genero", rawData.genero, onGeneroChange);
      createCheckboxFilters("filters-cargo", rawData.cargo, onCargoChange);
      createCheckboxFilters("filters-nacionalidade", rawData.nacionalidade, onNacionalidadeChange);

      onGeneroChange();
      onCargoChange();
      onNacionalidadeChange();

      const averageAge = calculateAverageAge(data.dataNascimento);
      document.getElementById('average-age-value').textContent = `${averageAge} anos`;

      console.log("Average Age:", averageAge);
    })
    .catch(err => console.error("Erro ao carregar dados:", err));
});
