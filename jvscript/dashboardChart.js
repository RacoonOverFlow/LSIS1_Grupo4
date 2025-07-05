document.addEventListener("DOMContentLoaded", () => {
  let rawData = {};


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
  function onGeneroChange() {
    const filtered = filterData(rawData.genero, "filters-genero");
    renderChart("generoChart", "Distribuição por Gênero", filtered, "pie", { M: "#36A2EB", F: "#FF6384" });
  }

  /////////////////////////////////

  //                             !!!!CARGO GRAFICO BARRAS!!!!
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

  //////////////////////////

  //                        !!!!NACIONALIDADE GRAFICO PIZZA/PIE!!!!
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

  //////////////////////////

  //                           !!!!GREOGRAFIA/DISTRITO GRAFICO BARRAS!!!!

  function onDistritoChange() {
    const filtered = filterData(rawData.moradaFiscal, "filters-moradaFiscal");
    const labels = Object.keys(filtered);

    // Paleta para Cargo: azul-esverdeado (hue 150-210)
    const moradaFiscalColorsArray = generateColors(labels.length, 150, 60);
    const moradaFiscalColors = {};
    labels.forEach((label, i) => {
      moradaFiscalColors[label] = moradaFiscalColorsArray[i];
    });

    renderChart("moradaFiscalChart", "Distribuição por geografia", filtered, "bar", moradaFiscalColors);
  }


  ///////////////////////////////////

  //                           !!!!IDADE MEDIA GRAFICO LINEAR!!!!

  //CALCULAR A IDADE MÉDIA 
  function calculateAverageAge(dataNascimento) { 
    const today = new Date();
    let totalAge = 0;
    let totalPeople = 0;
    const ageByYear = {};

    for (const birthDateStr in dataNascimento) {
        const count = dataNascimento[birthDateStr];
        const birthDate = new Date(birthDateStr);

        if (isNaN(birthDate)) continue;

        const age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        const dayDiff = today.getDate() - birthDate.getDate();

        // Ajustar udade se o aniversario nao tiver ocorrido ainda
        const exactAge = (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) ? age - 1 : age;

        totalAge += exactAge * count;
        totalPeople += count;

        const year = birthDate.getFullYear();
        ageByYear[year] = (ageByYear[year] || 0) + count;
    }

    const averageAge = totalPeople > 0 ? (totalAge / totalPeople).toFixed(2) : 0;// para agrupar diferentes data do mesmo ano, num so ano
    return { averageAge: parseFloat(averageAge), ageByYear };
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


  function calculateAverageContractDuration(tempoDeContrato) {
    let totalDuration = 0;
    let totalPeople = 0;

    for (const contrato of tempoDeContrato) {
      const start = new Date(contrato.inicio);
      const end = new Date(contrato.fim);
      const count = contrato.total || 1;

      if (isNaN(start) || isNaN(end)) continue;
      if (end < start) continue; // skip invalid cases

      // Calculate duration in years with decimals
      const durationMs = end - start;
      const durationYears = durationMs / (1000 * 60 * 60 * 24 * 365.25);

      totalDuration += durationYears * count;
      totalPeople += count;
    }

    const averageYears = totalPeople > 0 ? (totalDuration / totalPeople).toFixed(2) : 0;

    return parseFloat(averageYears);
  }

  
  function groupContractYears(tempoDeContrato) {
    const inicioPorAno = {};
    const fimPorAno = {};

    for (const contrato of tempoDeContrato) {
      const total = Number(contrato.total) || 1;

      const inicioAno = new Date(contrato.inicio).getFullYear();
      const fimAno = new Date(contrato.fim).getFullYear();

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
          dataPoints: inicioDataPoints
        },
        {
          type: "line",
          name: "Fim de Contrato",
          showInLegend: true,
          dataPoints: fimDataPoints
        }
      ]
    });

    chart.render();
  }



  /*
  // PARA DAR RENDER AO GRAFICO DO TEMPO DE INICIO E FIM
  function renderTempoChart(averageTempo, tempoByYear) { // nao posso tirar averageTempo usada para mostrar o tempo médio fora do gráfico numa <div>
    const dataPoints = Object.entries(tempoByYear)
      .sort((a, b) => a[0] - b[0])
      .map(([year, count]) => ({
        x: new Date(`${year}-01-01`),
        y: count
      }));

    const chart = new CanvasJS.Chart("tempoInicioChartContainer", {
      animationEnabled: true,
      theme: "light2",
      title: {
        text: "Distribuição de Data Inicio e Taxa Média"
      },
      axisX: {
        title: "Ano de Inicio",
        valueFormatString: "YYYY"
      },
      axisY: {
        title: "Quantidade",
        includeZero: true
      },
      toolTip: {
        shared: true,
        //contentFormatter: formatTempoTooltip // usa a função externa
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
  }*/


//ORIGINAL

  //                                 !!!!TAXA DE INICIO!!!!

  /*
  //CALCULAR A MEDIA DO TEMPO DO INICIO
  function calculateAverageTempoInicio(dataInicioDeContrato) {
    const today = new Date();
    let totalTempo = 0;
    let totalPeople = 0;
    const tempoByYear = {};

    for (const InicioContratoDateStr in dataInicioDeContrato) {
        const count = dataInicioDeContrato[InicioContratoDateStr];
        const InicioContratoDate = new Date(InicioContratoDateStr);

        if (isNaN(InicioContratoDate)) continue;

        const tempoInicio = today.getFullYear() - InicioContratoDate.getFullYear();
        const monthDiff = today.getMonth() - InicioContratoDate.getMonth();
        const dayDiff = today.getDate() - InicioContratoDate.getDate();

        // Ajustar udade se o aniversario nao tiver ocorrido ainda
        const exactTempo = (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) ? tempoInicio - 1 : tempoInicio;

        totalTempo += exactTempo * count;
        totalPeople += count;

        const year = InicioContratoDate.getFullYear();
        tempoByYear[year] = (tempoByYear[year] || 0) + count;
    }

    const averageTempo = totalPeople > 0 ? (totalTempo / totalPeople).toFixed(2) : 0;// para agrupar diferentes data do mesmo ano, num so ano
    return { averageTempo: parseFloat(averageTempo), tempoByYear };
  }



  //TOOLTIP PARA O GRAFICO DO TEMPO INICIO    !!!TEMPO DO INICIO!!
  function formatTempoTooltip(e) {
    const today = new Date();
    const year = e.entries[0].dataPoint.x.getFullYear();
    const idade = today.getFullYear() - year;

    let content = `<strong>Ano de Inicio:</strong> ${year}<br/>`;
    e.entries.forEach(entry => {
      content += `<span style="color:${entry.dataSeries.color}">●</span> <strong>${entry.dataSeries.name}:</strong> ${entry.dataPoint.y}<br/>`;
    });

    // Adicionando uma bolinha personalizada antes da idade hoje
    content += `<span style="color:#6666cc">●</span> <strong>Diferenca de anos:</strong> ${idade} anos`;

    return content;
  }
  
  //PARA DAR RENDER AO GRAFICO DO TEMPO DE INICIO
  function renderTempoChart(averageTempo, tempoByYear) { //nao posso tirar averageTempo usada para mostrar o tempo médio fora do gráfico numa <div>
    const dataPoints = Object.entries(tempoByYear)
      .sort((a, b) => a[0] - b[0])
      .map(([year, count]) => ({
        x: new Date(`${year}-01-01`),
        y: count
      }));

    const chart = new CanvasJS.Chart("tempoInicioChartContainer", {
      animationEnabled: true,
      theme: "light2",
      title: {
        text: "Distribuição de Data Inicio e Taxa Média"
      },
      axisX: {
        title: "Ano de Inicio",
        valueFormatString: "YYYY"
      },
      axisY: {
        title: "Quantidade",
        includeZero: true
      },
      toolTip: {
        shared: true,
        contentFormatter: formatTempoTooltip // usa a função externa
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
  }*/


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



  // Fetch de dados e inicialização
  fetch("../BLL/dashboard_bll.php")
    .then(res => 
      res.json()  // Use .json() para obter os dados como JSON
    )
    .then(data => {
      rawData = data;
      console.log("Dados recebidos:", data); 
      
      // VERIFICAR se tem dataRemuneracao aqui

      createCheckboxFilters("filters-genero", rawData.genero, onGeneroChange);
      createCheckboxFilters("filters-cargo", rawData.cargo, onCargoChange);
      createCheckboxFilters("filters-nacionalidade", rawData.nacionalidade, onNacionalidadeChange);
      createCheckboxFilters("filters-moradaFiscal", rawData.moradaFiscal, onDistritoChange);


      onGeneroChange();
      onCargoChange();
      onNacionalidadeChange();
      onDistritoChange();

      
      const { averageAge, ageByYear } = calculateAverageAge(data.dataNascimento);
      document.getElementById('average-age-value').textContent = `${averageAge} anos`;
      if (renderAgeChart(averageAge, ageByYear)){
        console.log("nao age");//debug
      };
    
      //AJSHFIUASHFA JA N ESTA A SER USADO
      /*const { averageTempo, tempoByYear } = calculateAverageTempoInicio(data.dataInicioDeContrato);
      document.getElementById('average-tempo-value').textContent = `${averageTempo} anos`;
      if (renderTempoChart(averageTempo, tempoByYear)){
        console.log("nao tempo inicio")
      };*/

      const { averageRemuneracao } = calculateAverageRemuneracao(data.dataRemuneracao);
      document.getElementById("average-remuneracao-value").innerText = `Média: ${averageRemuneracao.toFixed(2)}`;
      if (renderRemuneracaoChart(data.dataRemuneracao, averageRemuneracao)){
        console.log("nao remuneracao")        
      };

      console.log("Raw input:", data.dataTempoDeContrato);

      const avgContractDuration = calculateAverageContractDuration(data.dataTempoDeContrato);
      document.getElementById("average-tempo-value").innerText = `Média: ${avgContractDuration}`;
      if (renderTempoMedioChart(data.dataTempoDeContrato, avgContractDuration)){
        console.log("nao duracap")        
      };



      console.log("Average contract duration (years):", avgContractDuration);
      console.log("Average Age:", averageAge);
      //console.log("Average Tempo:", averageTempo);
      console.log("average remuneracao:", averageRemuneracao);    
    
    })
    .catch(err => console.error("Erro ao carregar dados:", err));
});

