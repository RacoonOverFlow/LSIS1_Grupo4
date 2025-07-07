document.addEventListener("DOMContentLoaded", () => {
  let rawData = {};
  const teamFilter = document.getElementById("teamFilter");

  //CRIAR O CHECKBOX DOS FILTROS. ELE VAI BUSCAR A DATA E ADICIONA O CHECKBOX COM ESTE CODIGO
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


  //FILTROS
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

  // PARA AS CORES DE GRAFICOS QUE NAO TEEM CORES JA PREDEFENIDAS POR NOS
  function generateColors(count, hueStart = 0, hueRange = 360) {
    const colors = [];
    for (let i = 0; i < count; i++) {
      const hue = Math.floor(hueStart + (hueRange / count) * i) % 360;
      colors.push(`hsl(${hue}, 70%, 60%)`);
    }
    return colors;
  }

  // PARA DAR RENDER NO CHART, COLORMAP {} ASSIM VAZIO PQ NAO ESTAMOS A DEFENIR NOS AS CORES
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
  
  /////////////////////////////////////

  //                             !!!!GENERO GRAFICO PIZZA/PIE!!!!
  function onGeneroChange(filteredGenero = null) {
    const dataToUse = filteredGenero || aggregateByKey(rawData.genero, "genero", teamFilter.value);
    renderChart("generoChart", "Distribuição por Gênero", dataToUse, "pie", { M: "#36A2EB", F: "#FF6384" });
  }

  /////////////////////////////////

  //                             !!!!CARGO GRAFICO BARRAS!!!!
  function onCargoChange(filteredCargo = null) {
    // Usa os dados filtrados recebidos, ou recalcula com filtro da equipa
    const dataToUse = filteredCargo || aggregateByKey(rawData.cargo, "cargo", teamFilter.value);

    // Aplica o filtro dos checkboxes (se houver)
    //const finalData = filterData(dataToUse, "filters-cargo");
    
    const labels = Object.keys(dataToUse);

    // Paleta para Cargo: azul-esverdeado (hue 150-210)
    const cargoColorsArray = generateColors(labels.length, 150, 60);
    const cargoColors = {};
    labels.forEach((label, i) => {
      cargoColors[label] = cargoColorsArray[i];
    });

    renderChart("cargoChart", "Distribuição por função", dataToUse, "bar", cargoColors);
}


  //////////////////////////

  //                        !!!!NACIONALIDADE GRAFICO PIZZA/PIE!!!!
  function onNacionalidadeChange(filteredNacionalidade = null) {
    const dataToUse = filteredNacionalidade || aggregateByKey(rawData.nacionalidade, "nacionalidade", teamFilter.value);
    
    //const finalData = filterData(dataToUse, "filters-nacionalidade");

    const labels = Object.keys(dataToUse);

    // Paleta para Nacionalidade: tons quentes (hue 0-60)
    const nacionalidadeColorsArray = generateColors(labels.length, 0, 60);
    const nacionalidadeColors = {};
    labels.forEach((label, i) => {
      nacionalidadeColors[label] = nacionalidadeColorsArray[i];
    });

    renderChart("nacionalidadeChart", "Distribuição por Nacionalidade", dataToUse, "pie", nacionalidadeColors);
  }

  //////////////////////////

  //                           !!!!GREOGRAFIA/DISTRITO GRAFICO BARRAS!!!!

  function onDistritoChange(filteredDistrito = null) {

    const dataToUse = filteredDistrito || aggregateByKey(rawData.moradaFiscal, "cargo", teamFilter.value);
    
    //const finalData = filterData(dataToUse, "filters-moradaFiscal");
    
    const labels = Object.keys(dataToUse);

    // Paleta para Cargo: azul-esverdeado (hue 150-210)
    const moradaFiscalColorsArray = generateColors(labels.length, 150, 60);
    const moradaFiscalColors = {};
    labels.forEach((label, i) => {
      moradaFiscalColors[label] = moradaFiscalColorsArray[i];
    });

    renderChart("moradaFiscalChart", "Distribuição por geografia", dataToUse, "bar", moradaFiscalColors);
  }


  ///////////////////////////////////

  //                           !!!!IDADE MEDIA GRAFICO LINEAR!!!!

  //CALCULAR A IDADE MÉDIA 
  function calculateAverageAge(dataNascimento, filterTeam = null) {
    const today = new Date();
    let totalAge = 0;
    let totalPeople = 0;
    const ageByYear = {};

    for (const id in dataNascimento) {
      const entry = dataNascimento[id];
      const birthDateStr = entry.dataNascimento;
      const teams = entry.teams || [];

      if (filterTeam === "no-team") {
        if (teams.length !== 0) continue; // só entra se a pessoa NÃO tiver equipa
      } else if (filterTeam !== null && filterTeam !== "all") {
        const teamFilterInt = parseInt(filterTeam, 10);
        const teamIds = teams.map(t => parseInt(t, 10));
        if (!teamIds.includes(teamFilterInt)) continue;
      }


      const birthDate = new Date(birthDateStr);
      if (isNaN(birthDate)) continue;

      let age = today.getFullYear() - birthDate.getFullYear();
      const monthDiff = today.getMonth() - birthDate.getMonth();
      const dayDiff = today.getDate() - birthDate.getDate();

      if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
        age -= 1;
      }

      totalAge += age;
      totalPeople++;

      const birthYear = birthDate.getFullYear();
      ageByYear[birthYear] = (ageByYear[birthYear] || 0) + 1;
    }

    const averageAge = totalPeople > 0 ? (totalAge / totalPeople).toFixed(2) : 0;

    return {
      averageAge: parseFloat(averageAge),
      ageByYear
    };
  }


  
  // Função externa para formatar o conteúdo do tooltip  !!AGE!!
  function formatAgeTooltip(e) {
    const today = new Date();
    const year = e.entries[0].dataPoint.x.getFullYear();
    const idade = today.getFullYear() - year;

    let content = `<strong>Ano de nascimento:</strong> ${year}<br/>`;
    e.entries.forEach(entry => {
      content += `<span style="color:${entry.dataSeries.color}">●</span> <strong>${entry.dataSeries.name}:</strong> ${entry.dataPoint.y}<br/>`;
    });

    // Adicionando uma bolinha personalizada antes da idade hoje
    content += `<span style="color:#6666cc">●</span> <strong>Idade hoje:</strong> ${idade} anos`;

    return content;
  }



  // Função principal para renderizar o gráfico         !!AGE!!
  function renderAgeChart(averageAge, ageByYear) { //nao posso tirar averageAge usada para mostrar a idade média fora do gráfico numa <div>
    const dataPoints = Object.entries(ageByYear)
      .sort((a, b) => a[0] - b[0])
      .map(([year, count]) => ({
        x: new Date(`${year}-01-01`),
        y: count
      }));

    const chart = new CanvasJS.Chart("ageChartContainer", {
      animationEnabled: true,
      theme: "light2",
      title: {
        text: "Distribuição de Idades e Idade Média"
      },
      axisX: {
        title: "Ano de Nascimento",
        valueFormatString: "YYYY"
      },
      axisY: {
        title: "Quantidade",
        includeZero: true
      },
      toolTip: {
        shared: true,
        contentFormatter: formatAgeTooltip // usa a função externa
      },
      legend: {
        cursor: "pointer",
        itemclick: e => {
          e.dataSeries.visible = !e.dataSeries.visible;
          chart.render();
        }
      },
      data: [
        {
          type: "line",
          name: "Quantidade por Ano",
          showInLegend: true,
          dataPoints: dataPoints
        }
      ]
    });

    chart.render();
  }

  //////////////////////////////////////////////////

  //                                 !!!!TEMPO MEDIO NA EMPRESA!!!!


  function calculateAverageContractDuration(tempoDeContrato, filterTeam = null) {
    let totalDuration = 0;
    let totalPeople = 0;

    for (const id in tempoDeContrato) {
      const contrato = tempoDeContrato[id];
      const start = new Date(contrato.dataInicioDeContrato);
      const end = new Date(contrato.dataFimDeContrato);
      const teams = contrato.teams || [];

      // Apply team filter if needed
      if (filterTeam !== null && filterTeam !== "all") {
        if (filterTeam === "no-team") {
          if (teams.length !== 0) continue; // só passa contratos sem equipa
        } else {
          const teamFilterInt = parseInt(filterTeam, 10);
          const teamIds = teams.map(t => parseInt(t, 10));
          if (!teamIds.includes(teamFilterInt)) continue;
        }
      }


      if (isNaN(start) || isNaN(end)) continue;
      if (end < start) continue; // skip invalid contracts

      const durationMs = end - start;
      const durationYears = durationMs / (1000 * 60 * 60 * 24 * 365.25);

      totalDuration += durationYears;
      totalPeople += 1;
    }

    const averageTempo = totalPeople > 0 ? (totalDuration / totalPeople).toFixed(2) : 0;
    return parseFloat(averageTempo);
  }


  
  function groupContractYears(tempoDeContrato) {
    const inicioPorAno = {};
    const fimPorAno = {};

    for (const id in tempoDeContrato) {
      const contrato = tempoDeContrato[id];
      const total = 1; // Cada contrato representa 1 pessoa

      const inicioAno = new Date(contrato.dataInicioDeContrato).getFullYear();
      const fimAno = new Date(contrato.dataFimDeContrato).getFullYear();

      if (!isNaN(inicioAno)) {
        inicioPorAno[inicioAno] = (inicioPorAno[inicioAno] || 0) + total;
      }

      if (!isNaN(fimAno)) {
        fimPorAno[fimAno] = (fimPorAno[fimAno] || 0) + total;
      }
    }

    return { inicioPorAno, fimPorAno };
  }


  function renderTempoMedioChart(tempoDeContrato, averageTempo) {
    const { inicioPorAno, fimPorAno } = groupContractYears(tempoDeContrato);

    const allYears = Array.from(
      new Set([
        ...Object.keys(inicioPorAno),
        ...Object.keys(fimPorAno)
      ])
    ).sort((a, b) => a - b);

    const inicioDataPoints = allYears.map(year => ({
      x: new Date(`${year}-01-01`),
      y: inicioPorAno[year] || 0
    }));

    const fimDataPoints = allYears.map(year => ({
      x: new Date(`${year}-01-01`),
      y: fimPorAno[year] || 0
    }));

    const chart = new CanvasJS.Chart("tempoMedioChartContainer", {
      animationEnabled: true,
      theme: "light2",
      title: {
        text: "Distribuição de Início e Fim de Contrato (por Ano)"
      },
      /*subtitles: [
        {
          text: `Tempo médio de contrato: ${averageTempo} anos`
        }
      ],*/
      axisX: {
        title: "Ano",
        valueFormatString: "YYYY"
      },
      axisY: {
        title: "Número de Contratos",
        includeZero: true
      },
      legend: {
        cursor: "pointer",
        itemclick: function (e) {
          e.dataSeries.visible = !e.dataSeries.visible;
          chart.render();
        }
      },
      toolTip: {
        shared: true,
      },
      data: [
        {
          type: "line",
          name: "Início de Contrato",
          showInLegend: true,
          xValueFormatString: "YYYY",
          dataPoints: inicioDataPoints
        },
        {
          type: "line",
          name: "Fim de Contrato",
          showInLegend: true,
          xValueFormatString: "YYYY",
          dataPoints: fimDataPoints
        }
      ]
    });

    chart.render();
  }


  //                    !!!!REMUNERACAO MEDIA!!!!

  
  // Calcula a média de remuneração (baseado nas keys = valores, values = contagem)
  function calculateAverageRemuneracao(dataRemuneracao) {
    let totalRemuneracao = 0;
    let totalItens = 0;

    for (const key in dataRemuneracao) {
      const valor = parseFloat(key);       // key é o valor da remuneração
      const count = parseInt(dataRemuneracao[key], 10);  // count é a quantidade de pessoas com essa remuneração

      if (isNaN(valor) || isNaN(count)) continue;

      totalRemuneracao += valor * count;  // soma valor * quantidade
      totalItens += count;                 // soma total de pessoas
    }

    const averageRemuneracao = totalItens > 0 ? (totalRemuneracao / totalItens) : 0;
    return { averageRemuneracao };
  }

  // Renderiza o gráfico de remuneração
  function renderRemuneracaoChart(dataRemuneracao) {
    if (!dataRemuneracao || typeof dataRemuneracao !== 'object') {
      console.error("Dados de remuneração inválidos:", dataRemuneracao);
      return;
    }

    // Transforma os dados para dataPoints, ordenando pelos valores (remuneração)
    const dataPoints = Object.entries(dataRemuneracao)
      .map(([key, count]) => ({
        x: parseFloat(key), // aqui pode usar x como valor da remuneração (número)
        y: count            // quantidade de pessoas
      }))
      .sort((a, b) => a.x - b.x);

    const chart = new CanvasJS.Chart("remuneracaoChartContainer", {
      animationEnabled: true,
      theme: "light2",
      title: {
        text: "Distribuição de Remuneração"
      },
      axisX: {
        title: "Remuneração (euros)",
        labelFormatter: e => e.value.toFixed(2),
        includeZero: false
      },
      axisY: {
        title: "Quantidade",
        includeZero: true
      },
      data: [{
        type: "column",
        dataPoints: dataPoints
      }]
    });

    chart.render();
  }



 fetch("../BLL/dashboard_bll.php")
  .then(res => res.json())
  .then(data => {
    rawData = data; // Keep rawData as a const to avoid accidental overwrite
    console.log("Dados recebidos:", data);

    const teamFilter = document.getElementById("teamFilter");

    function getAllTeams(dataCategory) {
      const teamsSet = new Set();
      for (const id in dataCategory) {
        const teams = dataCategory[id].teams || [];
        teams.forEach(teamId => {
          if (teamId || teamId === 0) teamsSet.add(teamId);  // Allow 0 as valid team id
        });
      }
      return Array.from(teamsSet);
    }

    const allTeams = getAllTeams(rawData.genero);

    teamFilter.innerHTML = '<option value="all">Todas as Equipas</option>';
    allTeams.forEach(teamId => {
      teamFilter.innerHTML += `<option value="${teamId}">Equipa ${teamId}</option>`;
    });
    

    // Verifica se há pelo menos uma pessoa sem equipa
    const hasNoTeam = Object.values(rawData.dataTempoDeContrato).some(contrato => 
      Array.isArray(contrato.teams) && contrato.teams.length === 0
    );

    if (hasNoTeam) {
      teamFilter.innerHTML += '<option value="no-team">Sem Equipa</option>';
    }


    function aggregateByKey(data, keyName, filterTeam = null) {
      const result = {};

      for (const id in data) {
        const entry = data[id];
        if (!entry || !Array.isArray(entry.teams)) continue;

        const teamIds = entry.teams.map(t => parseInt(t, 10));

        if (filterTeam === "no-team") {
          if (teamIds.length !== 0) continue; // Ignora se tem equipa
        } else if (filterTeam !== null && filterTeam !== "all") {
          const teamFilterInt = parseInt(filterTeam, 10);
          if (!teamIds.includes(teamFilterInt)) continue;
        }

        const key = entry[keyName];
        if (!key) continue;

        result[key] = (result[key] || 0) + 1;
      }

      return result;
    }

    function updateCharts(selectedTeam) {
      // Use rawData to avoid overwriting the original data object
      const genero = aggregateByKey(rawData.genero, "genero", selectedTeam);
      const cargo = aggregateByKey(rawData.cargo, "cargo", selectedTeam);
      const nacionalidade = aggregateByKey(rawData.nacionalidade, "nacionalidade", selectedTeam);
      const moradaFiscal = aggregateByKey(rawData.moradaFiscal, "moradaFiscal", selectedTeam);

      //createCheckboxFilters("filters-genero", genero, onGeneroChange); //comentados na pagina mas pq é que ao tirar param de funcionar
      //createCheckboxFilters("filters-cargo", cargo, onCargoChange);
      //createCheckboxFilters("filters-nacionalidade", nacionalidade, onNacionalidadeChange);
      //createCheckboxFilters("filters-moradaFiscal", moradaFiscal, onDistritoChange);

      // DO NOT overwrite rawData properties here!

      onGeneroChange(genero);
      onCargoChange(cargo);
      onNacionalidadeChange(nacionalidade);
      onDistritoChange(moradaFiscal);

      // Use rawData for these calculations (unfiltered)
       const { averageAge, ageByYear } = calculateAverageAge(rawData.dataNascimento,selectedTeam);
       document.getElementById('average-age-value').textContent = `${averageAge} anos`;
       renderAgeChart(averageAge, ageByYear);
       console.log("averare idade:",averageAge);

      // const { averageRemuneracao } = calculateAverageRemuneracao(rawData.dataRemuneracao);
      // document.getElementById("average-remuneracao-value").innerText = `Média: ${averageRemuneracao.toFixed(2)}`;
      // renderRemuneracaoChart(rawData.dataRemuneracao);

      // necessario porque estava a ser mandado rawdata no renderchart e nao atualizava com os filtros das equipas
      const filteredContractData = Object.values(rawData.dataTempoDeContrato).filter((contrato) => {
        if (!selectedTeam || selectedTeam === "all") return true;

        if (selectedTeam === "no-team") {
          return contrato.teams.length === 0;  // only contracts with empty teams array
        }

        return contrato.teams.includes(parseInt(selectedTeam));
      });


      const avgContractDuration = calculateAverageContractDuration(filteredContractData, selectedTeam);
      document.getElementById("average-tempo-value").innerText = `Média: ${avgContractDuration.toFixed(2)}`;

      renderTempoMedioChart(filteredContractData, avgContractDuration); 
      console.log("average tempo:", avgContractDuration);


    }

    // Initial load with all teams
    

    if (!teamFilter) {
      console.error("Dropdown #teamFilter not found");
      return;
    }
    updateCharts("all");
    teamFilter.addEventListener("change", (e) => {
      console.log("Selected team:", e.target.value);
      updateCharts(e.target.value);
    });
    
    
  })
  .catch(err => console.error("Erro ao carregar dados:", err));

});

