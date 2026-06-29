const BASE = document.querySelector('meta[name="base"]')?.content ?? '../';

// Mapa nome -> id (deve bater com o INSERT do SQL)
const SERVICOS_ID = {
  'Corte de Cabelo':         1,
  'Pintura de Cabelo':       2,
  'Progressiva':             3,
  'Corte de Cabelo Masc.':   4,
  'Barba Simples':           5,
  'Corte + Barba':           6,
  'Barba Degradê':           7,
  'Banho de Fibra':          8,
  'Colocação de Unhas de Gel': 9,
  'Manutenção de Unhas de Gel': 10,
  'Massagem com Bambu':      11,
  'Banho Terapêutico':       12,
  'Pedras Quentes':          13,
  'Design de Sobrancelha':   14,
  'Sobrancelha Masculina':   15,
  'Henna na Sobrancelha':    16,
};

let agendaData = { service: '', serviceId: 0, duration: 0, price: 0, day: null, dayLabel: '', dayIso: '', time: '' };

// ── Abre modal ────────────────────────────────────────────────
function openAgenda(service, duration, price) {
  agendaData = {
    service, duration, price,
    serviceId: SERVICOS_ID[service] ?? 0,
    day: null, dayLabel: '', dayIso: '', time: ''
  };
  document.getElementById('agendaServiceName').textContent  = service;
  document.getElementById('agendaServiceName2').textContent = service;
  buildCalendar();
  goStep(1);
  document.getElementById('agendaOverlay').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeAgenda() {
  document.getElementById('agendaOverlay').classList.remove('open');
  document.body.style.overflow = '';
}

function closeAgendaOverlay(e) {
  if (e.target === document.getElementById('agendaOverlay')) closeAgenda();
}

function goStep(n) {
  [1,2,3,4].forEach(i => document.getElementById('step'+i).classList.add('hidden'));
  document.getElementById('step'+n).classList.remove('hidden');
  if (n === 3) fillConfirm();
}

// ── Calendário ────────────────────────────────────────────────
function buildCalendar() {
  const cal = document.getElementById('agendaCalendar');
  cal.innerHTML = '';
  ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'].forEach(d => {
    const el = document.createElement('div');
    el.className = 'cal-day-name'; el.textContent = d;
    cal.appendChild(el);
  });

  const today    = new Date(); today.setHours(0,0,0,0);
  const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
  for (let i = 0; i < firstDay.getDay(); i++) {
    const el = document.createElement('div');
    el.className = 'cal-day cal-empty'; cal.appendChild(el);
  }

  const daysInMonth = new Date(today.getFullYear(), today.getMonth()+1, 0).getDate();
  for (let d = 1; d <= daysInMonth; d++) {
    const date = new Date(today.getFullYear(), today.getMonth(), d);
    const el   = document.createElement('div');
    el.className = 'cal-day';
    el.textContent = d;
    if (date < today || date.getDay() === 0) {
      el.classList.add('cal-disabled');
    } else {
      el.addEventListener('click', () => selectDay(el, date, d));
    }
    cal.appendChild(el);
  }
  document.getElementById('btnStep2').disabled = true;
}

function selectDay(el, date, d) {
  document.querySelectorAll('.cal-day').forEach(e => e.classList.remove('cal-selected'));
  el.classList.add('cal-selected');
  const months = ['janeiro','fevereiro','março','abril','maio','junho','julho','agosto','setembro','outubro','novembro','dezembro'];
  agendaData.day      = date;
  agendaData.dayLabel = `${d} de ${months[date.getMonth()]}`;
  agendaData.dayIso   = date.toISOString().split('T')[0];
  document.getElementById('btnStep2').disabled = false;
}

// ── Horários (busca ocupados no backend) ──────────────────────
async function buildTimes() {
  const container = document.getElementById('agendaTimes');
  container.innerHTML = '<p style="color:var(--text-muted);font-size:.85rem">Carregando...</p>';
  document.getElementById('selectedDayLabel').textContent = agendaData.dayLabel;
  document.getElementById('btnStep3').disabled = true;

  let ocupados = [];
  try {
    const res = await fetch(`${BASE}Banco/horarios.php?servico_id=${agendaData.serviceId}&data=${agendaData.dayIso}`);
    ocupados  = await res.json();
  } catch(_) {}

  const slots = [];
  for (let h = 9; h <= 18; h++) {
    ['00','30'].forEach(m => {
      if (h === 18 && m === '30') return;
      slots.push(`${String(h).padStart(2,'0')}:${m}`);
    });
  }

  container.innerHTML = '';
  slots.forEach(t => {
    const busy = ocupados.includes(t);
    const el   = document.createElement('div');
    el.className = 'time-slot' + (busy ? ' time-busy' : '');
    el.textContent = t;
    if (!busy) el.addEventListener('click', () => selectTime(el, t));
    container.appendChild(el);
  });
}

function selectTime(el, t) {
  document.querySelectorAll('.time-slot').forEach(e => e.classList.remove('time-selected'));
  el.classList.add('time-selected');
  agendaData.time = t;
  document.getElementById('btnStep3').disabled = false;
}

// ── Confirma ──────────────────────────────────────────────────
function fillConfirm() {
  document.getElementById('cService').textContent  = agendaData.service;
  document.getElementById('cDate').textContent     = agendaData.dayLabel;
  document.getElementById('cTime').textContent     = agendaData.time;
  document.getElementById('cDuration').textContent = agendaData.duration + ' min';
  document.getElementById('cPrice').textContent    = 'R$ ' + agendaData.price.toFixed(2).replace('.',',');
}

async function confirmAgenda() {
  const btn = document.querySelector('#step3 .agenda-btn');
  btn.disabled = true; btn.textContent = 'Agendando...';

  try {
    const res  = await fetch(BASE + 'Banco/agendar.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        servico_id: agendaData.serviceId,
        data:       agendaData.dayIso,
        horario:    agendaData.time,
      }),
    });
    const data = await res.json();
    if (data.erro) {
      showToast(data.erro);
      // Se não estiver logado, abre modal de login
      if (data.erro.includes('logado')) openModal('login');
      return;
    }
    goStep(4);
  } catch(_) {
    showToast('Erro de conexão.');
  } finally {
    btn.disabled = false; btn.textContent = 'Confirmar ✓';
  }
}

// ── Step 2 com fetch ──────────────────────────────────────────
// Sobrescreve o onclick do botão "Próximo" do step1 para chamar buildTimes antes
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('btnStep2').addEventListener('click', async () => {
    await buildTimes();
    goStep(2);
  });
});

function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg; t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 3000);
}