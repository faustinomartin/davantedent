<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>DavanteDent · Gestión de citas</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <svg width="44" height="44" viewBox="0 0 44 44" aria-label="Logo DavanteDent"><circle cx="22" cy="22" r="22" fill="#0b3a94"/><path d="M12 14c0-3 3-4 5-3 2 1 3 1 5 0 2-1 5 0 5 3 0 5-2 6-2 11 0 4-1 7-3 7s-2-4-2-6-1 6-2 6-3-3-3-7c0-5-3-6-3-11z" fill="#fff"/></svg>
  <h1>DavanteDent</h1>
</header>

<main>
  <form id="form" novalidate>
    <input type="hidden" id="id">
    <fieldset>
      <legend>Fecha de la cita</legend>
      <label>Día<select id="dia"><option value="">—</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select></label>
      <label>Mes<select id="mes"><option value="">—</option><option value="1">Enero</option><option value="2">Febrero</option><option value="3">Marzo</option><option value="4">Abril</option><option value="5">Mayo</option><option value="6">Junio</option><option value="7">Julio</option><option value="8">Agosto</option><option value="9">Septiembre</option><option value="10">Octubre</option><option value="11">Noviembre</option><option value="12">Diciembre</option></select></label>
      <label>Año<select id="anio"><option value="">—</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option></select></label>
      <label>Hora<select id="hora"><option value="">—</option><option value="8">08</option><option value="9">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option></select></label>
      <label>Minuto<select id="minuto"><option value="">—</option><option value="0">00</option><option value="5">05</option><option value="10">10</option><option value="15">15</option><option value="20">20</option><option value="25">25</option><option value="30">30</option><option value="35">35</option><option value="40">40</option><option value="45">45</option><option value="50">50</option><option value="55">55</option></select></label>
    </fieldset>
    <fieldset>
      <legend>Datos del paciente</legend>
      <label>Nombre<input id="nombre"></label>
      <label>Apellidos<input id="apellidos"></label>
      <label>DNI<input id="dni" placeholder="12345678Z"></label>
      <label>Teléfono<input id="telefono" inputmode="tel"></label>
      <label>Fecha de nacimiento<input id="nacimiento" type="date"></label>
    </fieldset>
    <label class="obs">Observaciones<textarea id="observaciones" rows="3"></textarea></label>
    <button type="submit" id="guardar">Guardar cita</button>
  </form>

  <table>
    <thead>
      <tr><th>Nº</th><th>Fecha</th><th>Hora</th><th>Nombre</th><th>Apellidos</th><th>DNI</th><th>Teléfono</th><th>Nacimiento</th><th>Observaciones</th><th>Acciones</th></tr>
    </thead>
    <tbody id="tbody"></tbody>
  </table>
</main>

<footer>
  DavanteDent · C/ Ejemplo 1, 46001 Valencia · Tel. 960 000 000 · info@davantedent.example
</footer>
<script src="app.js"></script>
</body>
</html>
