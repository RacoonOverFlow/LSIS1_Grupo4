<!DOCTYPE html>
<html lang="en">

 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/styleDashboard.css" />
    <title>Bootstrap Example</title>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script src="../jvscript/dashboardChart.js" defer></script>
  
</head>
<body>

  <div id="generoChart"></div>
  <div id="circulo"></div>

  <h2>Filtro por Gênero</h2>
  <div id="filters-genero"></div>
  <div id="generoChart" style="height: 400px;"></div>

  <h2>Filtro por Cargo</h2>
  <div id="filters-cargo"></div>
  <div id="cargoChart" style="height: 400px;"></div>

  <h2>Filtro por Nacionalidade</h2>
  <div id="filters-nacionalidade"></div>
  <div id="nacionalidadeChart" style="height: 400px;"></div>

  <!-- Example Code Start-->
  <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
    <input type="checkbox" class="btn-check" id="btncheck1" autocomplete="off">
    <label class="btn btn-outline-primary" for="btncheck1">Checkbox 1</label>

    <input type="checkbox" class="btn-check" id="btncheck2" autocomplete="off">
    <label class="btn btn-outline-primary" for="btncheck2">Checkbox 2</label>

    <input type="checkbox" class="btn-check" id="btncheck3" autocomplete="off">
    <label class="btn btn-outline-primary" for="btncheck3">Checkbox 3</label>
  </div>

</body>
</html>
