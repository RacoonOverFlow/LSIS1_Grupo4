document.addEventListener("DOMContentLoaded", () => {
  let rawData = {};
  const teamFilter = document.getElementById("teamFilter");

  function formatLabel(key, containerId) { 
    if(containerId === "filters-genero") { // esta a ser criado pq a informacao vem como M e F e nao masculino e feminino
      return key === "M" ? "Masculino" : "Feminino";
    }
    // Para cargo,nacionalidade, retorna direto
    return key;
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
  function renderChart(containerId, title, filteredData, type="bar", colorMap = {}) {
    const labels = Object.keys(filteredData);
    const values = Object.values(filteredData);

    const chart = new CanvasJS.Chart(containerId, {
      animationEnabled: true,
      theme: "light2",
      title: { text: title },
      axisY: (type === "bar") ? { 
        title: "Quantidade",
        interval: 1 
      } : undefined,
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
    renderChart("generoChart", "Género", dataToUse, "pie", { M: "#36A2EB", F: "#FF6384" });
  }

  /////////////////////////////////

  //                             !!!!CARGO GRAFICO BARRAS!!!!
  function onCargoChange(filteredCargo = null) {
    // Usa os dados filtrados recebidos, ou recalcula com filtro da equipa
    const dataToUse = filteredCargo || aggregateByKey(rawData.cargo, "cargo", teamFilter.value);
    
    const labels = Object.keys(dataToUse);

    // Paleta para Cargo: azul-esverdeado (hue 150-210)
    const cargoColorsArray = generateColors(labels.length, 150, 60);
    const cargoColors = {};
    labels.forEach((label, i) => {
      cargoColors[label] = cargoColorsArray[i];
    });

    renderChart("cargoChart", "Cargo", dataToUse, "bar", cargoColors);
}


  //////////////////////////

  //                        !!!!NACIONALIDADE GRAFICO PIZZA/PIE!!!!
  function onNacionalidadeChange(filteredNacionalidade = null) {
    const dataToUse = filteredNacionalidade || aggregateByKey(rawData.nacionalidade, "nacionalidade", teamFilter.value);
    
    const labels = Object.keys(dataToUse);

    // Paleta para Nacionalidade: tons quentes (hue 0-60)
    const nacionalidadeColorsArray = generateColors(labels.length, 0, 60);
    const nacionalidadeColors = {};
    labels.forEach((label, i) => {
      nacionalidadeColors[label] = nacionalidadeColorsArray[i];
    });

    renderChart("nacionalidadeChart", "Nacionalidade", dataToUse, "pie", nacionalidadeColors);
  }

  //////////////////////////

  //                           !!!!GREOGRAFIA/DISTRITO GRAFICO BARRAS!!!!

  function onDistritoChange(filteredDistrito = null) {

    const dataToUse = filteredDistrito || aggregateByKey(rawData.moradaFiscal, "moradaFiscal", teamFilter.value);

    
    const labels = Object.keys(dataToUse);

    // Paleta para Cargo: azul-esverdeado (hue 150-210)
    const moradaFiscalColorsArray = generateColors(labels.length, 150, 60);
    const moradaFiscalColors = {};
    labels.forEach((label, i) => {
      moradaFiscalColors[label] = moradaFiscalColorsArray[i];
    });

    renderChart("moradaFiscalChart", "Geografia", dataToUse, "bar", moradaFiscalColors);
  }


  ///////////////////////////////////

  //                           !!!!IDADE MEDIA GRAFICO COLUNA!!!!

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

  //    PARA AGRUPAR                         !!!!AGE!!!!
  function groupAgesIntoRanges(dataNascimento) {
    const today = new Date();
    const ageGroups = {
      "18-25": 0,
      "26-35": 0,
      "36-45": 0,
      "46-55": 0,
      "56-65": 0,
      "65+": 0
    };

    for (const personId in dataNascimento) {
      const dobString = dataNascimento[personId].dataNascimento;
      const dob = new Date(dobString);
      const age = today.getFullYear() - dob.getFullYear();

      if (age >= 18 && age <= 25) ageGroups["18-25"]++;
      else if (age >= 26 && age <= 35) ageGroups["26-35"]++;
      else if (age >= 36 && age <= 45) ageGroups["36-45"]++;
      else if (age >= 46 && age <= 55) ageGroups["46-55"]++;
      else if (age >= 56 && age <= 65) ageGroups["56-65"]++;
      else if (age > 65 && age < 120) ageGroups["65+"]++; // valid old ages
    }

    return ageGroups;
  }


  // Função principal para renderizar o gráfico         !!AGE!!
  function renderAgeGroupChart(ageGroups) {
  const dataPoints = Object.entries(ageGroups).map(([range, count]) => ({
    label: range,
    y: count
  }));
  const chart = new CanvasJS.Chart("ageChartContainer", {
    animationEnabled: true,
    theme: "light2",
    title: {
      text: "Distribuição por Faixa Etária"
    },
    axisX: {
      title: "Faixa Etária"
    },
    axisY: {
      title: "Quantidade",
      includeZero: true
    },
    data: [{
      type: "column",
      name: "Pessoas",
      showInLegend: false,
      dataPoints: dataPoints
    }]
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
      if (end < start) continue; // skip a contratos invalidos

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
        text: "Contrato"
      },
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

  function getMedian(arr) {
  const mid = Math.floor(arr.length / 2);
  return arr.length % 2 === 0
    ? (arr[mid - 1] + arr[mid]) / 2
    : arr[mid];
  }
  // Calcula a média de remuneração (baseado nas keys = valores, values = contagem)
  // fazer data points aqui devido a ser boxplot
  function dataChartBoxPlotRemuneracao(dataRemuneracao, filterTeam = null) {
    let totalRemuneracao = 0;
    let totalItens = 0;
    let dataIntermedia = {};
    let dataPoints = [];

    for (const id in dataRemuneracao) {
      const entry = dataRemuneracao[id];       // key é o valor da remuneração
      const salario = parseFloat(entry.remuneracao);
      const teams = entry.teams || [];
      const cargo = entry.cargo;
      

      if (filterTeam === "no-team") {
        if (teams.length !== 0) continue; // só entra se a pessoa NÃO tiver equipa
      } else if (filterTeam !== null && filterTeam !== "all") {
        const teamFilterInt = parseInt(filterTeam, 10);
        const teamIds = teams.map(t => parseInt(t, 10));
        if (!teamIds.includes(teamFilterInt)) continue; 
      }

<<<<<<< Updated upstream
      
=======
>>>>>>> Stashed changes
      if(!dataIntermedia[cargo]) {
        dataIntermedia[cargo] = [salario]
      }
      else {
        dataIntermedia[cargo].push(salario);
      }
      totalRemuneracao += salario;
      totalItens += 1;
    }

    for (const [cargo, listRem] of Object.entries(dataIntermedia)) {
      const sorted = [...listRem].sort((a, b) => a - b);
      const median = getMedian(sorted);
      const q1 = getMedian(sorted.slice(0, Math.floor(sorted.length / 2)));
      const q3 = getMedian(sorted.slice(Math.ceil(sorted.length / 2)));
      const iqr = q3 - q1;

      const lowerFence = q1 - 1.5 * iqr;
      const upperFence = q3 + 1.5 * iqr;

      const outliers = sorted.filter(val => val < lowerFence || val > upperFence);
      const inliers = sorted.filter(val => val >= lowerFence && val <= upperFence);

      dataPoints.push({
        label: cargo,
        y: [Math.min(...inliers), q1,median,q3,Math.max(...inliers)],
        color: "#4F81BC",
        outliers: outliers
      });
      
    }

    const averageRemuneracao = totalItens > 0 ? (totalRemuneracao / totalItens) : 0;
    return { dataPoints , averageRemuneracao };
  }

   
  function renderRemuneracaoChart(dataRemuneracao,dataIntermedia) {
    const boxDataPoints = dataIntermedia; // inclue label, y, color, outliers
    console.log(boxDataPoints);
    // scatter para outliers, sendo que o canva nao suporta
    const outlierPoints = [];

    boxDataPoints.forEach((point, index) => {
      (point.outliers || []).forEach(outlierValue => {
        outlierPoints.push({
          x: index , // pras labels
          y: outlierValue,
          markerColor: "red",
          markerSize: 6,
          toolTipContent: `Outlier: {y} (${point.label})`
        });
      });
    });

    const chart = new CanvasJS.Chart("remuneracaoChartContainer", {
      animationEnabled: true,
      theme: "light2",
      axisY: {
        title: "Remuneração (€)",
        includeZero: false
      },
      axisX: {
        title: "Cargos",
        interval: 1,
        labelFontSize: 14,
        labelAngle: -45, // tilt pq as labels sao comprimdas
        valueFormatString: "",
        type: "category" 
      },
      data: [
        {
          type: "boxAndWhisker",
          color: "#4F81BC",
          dataPoints: boxDataPoints
        },
        {
          type: "scatter",
          dataPoints: outlierPoints,
          markerType: "circle",
          showInLegend: false
        }
      ]
    });

    chart.render();
  }


 fetch("../BLL/dashboard_bll.php")
  .then(res => res.json())
  .then(data => {
    rawData = data; // raw data para avoid a overwrite acidental
    console.log("Dados recebidos:", data);

    const teamFilter = document.getElementById("teamFilter");

    function getAllTeams(dataCategory) {
      const teamsSet = new Set();
      for (const id in dataCategory) {
        const teams = dataCategory[id].teams || [];
        teams.forEach(teamId => {
          if (teamId || teamId === 0) teamsSet.add(teamId);  //  0 como uma team id valida
        });                                                  
      }
      return Array.from(teamsSet);
    }

    const allTeams = getAllTeams(rawData.genero);

    teamFilter.innerHTML = '<option value="all">Empresa</option>';
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
      
      const genero = aggregateByKey(rawData.genero, "genero", selectedTeam);
      const cargo = aggregateByKey(rawData.cargo, "cargo", selectedTeam);
      const nacionalidade = aggregateByKey(rawData.nacionalidade, "nacionalidade", selectedTeam);
      const moradaFiscal = aggregateByKey(rawData.moradaFiscal, "moradaFiscal", selectedTeam);


      onGeneroChange(genero);               //GENERO
      onCargoChange(cargo);                 //CARGO
      onNacionalidadeChange(nacionalidade); //NACIONALIDADE
      onDistritoChange(moradaFiscal);       //DISTRITO

      //IDADE!!!!!!
      // usar a raw data para os calculos 
       const { averageAge, ageByYear } = calculateAverageAge(rawData.dataNascimento,selectedTeam);
       document.getElementById('average-age-value').textContent = `${averageAge} anos`;
       const ageGroups = groupAgesIntoRanges(rawData.dataNascimento);
       if(renderAgeGroupChart(ageGroups)){
        console.log("ageGroup funciona");
       }; 
       console.log("averare idade:",averageAge);


       //REMUNERACAO!!!!!
      const filteredRemuneracaoData = Object.values(rawData.dataRemuneracao).filter((remuneracao) => {
        if (!selectedTeam || selectedTeam === "all") return true;

        if (selectedTeam === "no-team") {
          return remuneracao.teams.length === 0;  // so contratos com team arraty vazio
        }

        return remuneracao.teams.includes(parseInt(selectedTeam));
      });

       const { dataPoints, averageRemuneracao } = dataChartBoxPlotRemuneracao(filteredRemuneracaoData, selectedTeam);
       document.getElementById("average-remuneracao-value").innerText = `Média: ${averageRemuneracao.toFixed(2)}`;
       console.log("average remuneracao:", averageRemuneracao);
       renderRemuneracaoChart(filteredRemuneracaoData, dataPoints);
      
      
      //CONTRATO
      // necessario porque estava a ser mandado rawdata no renderchart e nao atualizava com os filtros das equipas
      const filteredContractData = Object.values(rawData.dataTempoDeContrato).filter((contrato) => {
        if (!selectedTeam || selectedTeam === "all") return true;

        if (selectedTeam === "no-team") {
          return contrato.teams.length === 0;  // so contratos com team arraty vazio
        }

        return contrato.teams.includes(parseInt(selectedTeam));
      });


      const avgContractDuration = calculateAverageContractDuration(filteredContractData, selectedTeam);
      document.getElementById("average-tempo-value").innerText = `Média: ${avgContractDuration.toFixed(2)}`;

      renderTempoMedioChart(filteredContractData, avgContractDuration); 
      console.log("average tempo:", avgContractDuration);


    }

    // PARA INICIALIZAR COM AS EQUIPAS TODAS
    

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

