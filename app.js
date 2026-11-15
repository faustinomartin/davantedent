// ===== Modelo =====
class Cita {
  constructor(datos) { Object.assign(this, datos); }
  get fecha() { return new Date(this.anio, this.mes - 1, this.dia, this.hora, this.minuto); }
}

const $ = id => document.getElementById(id);
const pad = n => String(n).padStart(2, '0');
const CAMPOS = ['dia', 'mes', 'anio', 'hora', 'minuto', 'nombre', 'apellidos', 'dni', 'telefono', 'nacimiento', 'observaciones'];
const PREFIJO = 'cita_'; // una cookie por cita: cita_<id>

// ===== Almacenamiento en cookies =====
function guardarCookie(c) {
  document.cookie = PREFIJO + c.id + '=' + encodeURIComponent(JSON.stringify(c)) + ';max-age=31536000;path=/;SameSite=Lax';
}
function borrarCookie(id) {
  document.cookie = PREFIJO + id + '=;max-age=0;path=/';
}
function parseCookie(texto) {
  return new Cita(JSON.parse(decodeURIComponent(texto.split('=')[1])));
}
function leerCookie(id) {
  const c = document.cookie.split('; ').find(x => x.startsWith(PREFIJO + id + '='));
  return c ? parseCookie(c) : null;
}
function leerCitas() {
  return document.cookie.split('; ')
    .filter(x => x.startsWith(PREFIJO))
    .map(parseCookie)
    .sort((a, b) => a.fecha - b.fecha);
}

// ===== Validación =====
function validar(d) {
  const e = {}, num = k => /^\d+$/.test(d[k]);
  if (!num('dia')) e.dia = 'Selecciona el día';
  if (!num('mes')) e.mes = 'Selecciona el mes';
  if (!num('anio')) e.anio = 'Selecciona el año';
  if (!num('hora')) e.hora = 'Selecciona la hora';
  if (!num('minuto')) e.minuto = 'Selecciona los minutos';
  if (!e.dia && !e.mes && !e.anio && new Date(d.anio, d.mes - 1, d.dia).getDate() != d.dia) e.dia = 'Esa fecha no existe';
  const nombre = /^[\p{L}' -]{2,}$/u;
  if (!nombre.test(d.nombre)) e.nombre = 'Solo letras (mínimo 2)';
  if (!nombre.test(d.apellidos)) e.apellidos = 'Solo letras (mínimo 2)';
  if (!/^\d{8}[A-Za-z]$/.test(d.dni) || 'TRWAGMYFPDXBNJZSQVHLCKE'[d.dni.slice(0, 8) % 23] !== d.dni[8].toUpperCase())
    e.dni = 'DNI no válido (8 números y letra correcta)';
  if (!/^[6-9]\d{8}$/.test(d.telefono)) e.telefono = 'Teléfono de 9 cifras, solo números';
  if (!d.nacimiento || new Date(d.nacimiento) > new Date()) e.nacimiento = 'Fecha de nacimiento no válida';
  return e;
}
function mostrarErrores(e) {
  CAMPOS.forEach(k => {
    $(k).classList.toggle('err', !!e[k]);
    $('e-' + k).textContent = e[k] || '';
  });
}

// ===== Tabla =====
function pintar() {
  const tb = $('tbody'), citas = leerCitas();
  tb.innerHTML = '';
  if (!citas.length) {
    const td = tb.insertRow().insertCell();
    td.colSpan = 10;
    td.textContent = 'dato vacío';
    return;
  }
  citas.forEach((c, i) => {
    const tr = tb.insertRow();
    tr.dataset.id = c.id; // identificador oculto: no se muestra en ninguna columna
    [i + 1, `${pad(c.dia)}/${pad(c.mes)}/${c.anio}`, `${pad(c.hora)}:${pad(c.minuto)}`, c.nombre, c.apellidos,
     c.dni, c.telefono, c.nacimiento, c.observaciones].forEach(t => tr.insertCell().textContent = t);
    const acciones = tr.insertCell();
    [['Modificar', modificar], ['Eliminar', eliminar]].forEach(([texto, fn]) => {
      const b = document.createElement('button');
      b.type = 'button';
      b.textContent = texto;
      b.addEventListener('click', () => fn(tr.dataset.id));
      acciones.append(b);
    });
  });
}

// ===== Acciones =====
function modificar(id) {
  const c = leerCookie(id); // se carga desde la cookie, no desde la tabla HTML
  if (!c) return;
  CAMPOS.forEach(k => $(k).value = c[k]);
  $('id').value = c.id;
  $('guardar').textContent = 'Guardar cambios';
  mostrarErrores({});
  $('form').scrollIntoView({ behavior: 'smooth' });
}
function eliminar(id) {
  borrarCookie(id);
  pintar();
}
function reiniciarFormulario() {
  $('form').reset();
  $('id').value = '';
  $('guardar').textContent = 'Guardar cita';
  mostrarErrores({});
}

// ===== Eventos =====
CAMPOS.forEach(k => {
  const aviso = document.createElement('small');
  aviso.id = 'e-' + k;
  $(k).after(aviso);
  // al escribir se limpia el error de ese campo
  $(k).addEventListener('input', () => { $(k).classList.remove('err'); aviso.textContent = ''; });
});

$('form').addEventListener('submit', ev => {
  ev.preventDefault();
  const datos = {};
  CAMPOS.forEach(k => datos[k] = $(k).value.trim());
  const errores = validar(datos);
  mostrarErrores(errores);
  if (Object.keys(errores).length) return; // hay errores: no se crea la cita y se conservan los datos
  const cita = new Cita({ id: $('id').value || String(Date.now()), ...datos });
  guardarCookie(cita);
  pintar();
  reiniciarFormulario();
});

document.addEventListener('DOMContentLoaded', pintar);
