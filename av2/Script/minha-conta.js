const BASE = document.querySelector('meta[name="base"]')?.content ?? '../';

const ICONES = {
  'Cabelo':      '✂',
  'Barbeiro':    '🪒',
  'Manicure':    '💅',
  'SPA':         '🌿',
  'Sobrancelha': '✏️',
};

// ── Carrega página ────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', async () => {
  await verificarLogin();
  await carregarAgendamentos();
});

async function verificarLogin() {
  const res  = await fetch(BASE + 'Banco/sessao.php');
  const data = await res.json();
  if (!data.logado) {
    window.location.href = BASE + 'index.html';
    return;
  }
  // Preenche perfil
  document.getElementById('userName').textContent  = data.nome;
  document.getElementById('userEmail').textContent = data.email;
  const iniciais = data.nome.split(' ').map(p => p[0]).slice(0,2).join('').toUpperCase();
  document.getElementById('avatarInitials').textContent = iniciais;

  // Preenche campos do formulário de edição
  const partes = data.nome.split(' ');
  document.getElementById('editNome').value      = partes[0] ?? '';
  document.getElementById('editSobrenome').value = partes.slice(1).join(' ');
  document.getElementById('editEmail').value     = data.email;
}

// ── Agendamentos ──────────────────────────────────────────────
async function carregarAgendamentos() {
  try {
    const res  = await fetch(BASE + 'Banco/agendamentos.php?acao=listar');
    const lista = await res.json();
    if (lista.erro) return;

    const proximos   = lista.filter(a => a.status === 'confirmado');
    const concluidos = lista.filter(a => a.status === 'concluido');
    const cancelados = lista.filter(a => a.status === 'cancelado');

    renderTab('tab-proximos',   proximos,   true);
    renderTab('tab-concluidos', concluidos, false);
    renderTab('tab-cancelados', cancelados, false);
  } catch(_) {}
}

function renderTab(tabId, lista, podeCancelar) {
  const el = document.getElementById(tabId);
  if (!lista.length) {
    el.innerHTML = '<p class="mc-empty">Nenhum agendamento.</p>';
    return;
  }
  el.innerHTML = lista.map(a => {
    const icone = ICONES[a.categoria] ?? '📌';
    const data  = new Date(a.data + 'T00:00').toLocaleDateString('pt-BR', { day:'2-digit', month:'long', year:'numeric' });
    const preco = parseFloat(a.preco).toLocaleString('pt-BR', { style:'currency', currency:'BRL' });
    const badge = {
      confirmado: '<span class="mc-badge mc-badge-upcoming">Confirmado</span>',
      concluido:  '<span class="mc-badge mc-badge-done">Concluído</span>',
      cancelado:  '<span class="mc-badge mc-badge-cancelled">Cancelado</span>',
    }[a.status];
    const btnCancelar = podeCancelar
      ? `<button class="mc-cancel-btn" onclick="cancelarAgendamento(${a.id}, this)">Cancelar</button>`
      : '';
    return `
      <div class="mc-appointment-card ${a.status === 'cancelado' ? 'mc-appt-cancelled' : ''}" id="appt-${a.id}">
        <div class="mc-appt-icon">${icone}</div>
        <div class="mc-appt-info">
          <h3>${a.servico}</h3>
          <p>📅 ${data} — ${a.horario.slice(0,5)}</p>
          <p>⏱ ${a.duracao} min &nbsp;·&nbsp; ${preco}</p>
        </div>
        <div class="mc-appt-right">${badge}${btnCancelar}</div>
      </div>`;
  }).join('');
}

// ── Cancelar agendamento ──────────────────────────────────────
async function cancelarAgendamento(id, btn) {
  if (!confirm('Deseja cancelar este agendamento?')) return;
  try {
    const res  = await fetch(BASE + 'Banco/agendamentos.php?acao=cancelar', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id }),
    });
    const data = await res.json();
    if (data.erro) { showToast(data.erro); return; }
    const card = document.getElementById('appt-' + id);
    card.style.transition = 'opacity 0.3s';
    card.style.opacity    = '0';
    setTimeout(() => { card.remove(); showToast('Agendamento cancelado.'); }, 300);
  } catch(_) { showToast('Erro de conexão.'); }
}

// ── Tabs ──────────────────────────────────────────────────────
function filterTab(tab, btn) {
  ['proximos','concluidos','cancelados'].forEach(t =>
    document.getElementById('tab-'+t).classList.add('hidden')
  );
  document.querySelectorAll('.mc-tab').forEach(b => b.classList.remove('active'));
  document.getElementById('tab-'+tab).classList.remove('hidden');
  btn.classList.add('active');
}

// ── Editar perfil ─────────────────────────────────────────────
function toggleEdit() {
  document.getElementById('editSection').classList.toggle('hidden');
}

async function saveEdit() {
  const nome      = document.getElementById('editNome').value.trim();
  const sobrenome = document.getElementById('editSobrenome').value.trim();
  const email     = document.getElementById('editEmail').value.trim();
  const telefone  = document.getElementById('editTel').value.trim();
  const senha     = document.getElementById('editSenha').value;
  const conf      = document.getElementById('editSenhaConf').value;
  const btn       = document.querySelector('.mc-edit-actions .agenda-btn');

  if (!nome || !email) { showToast('Nome e e-mail são obrigatórios.'); return; }
  if (senha && senha !== conf) { showToast('As senhas não coincidem.'); return; }

  btn.disabled = true; btn.textContent = 'Salvando...';
  try {
    const res  = await fetch(BASE + 'Banco/agendamentos.php?acao=editar_perfil', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ nome, sobrenome, email, telefone, senha }),
    });
    const data = await res.json();
    if (data.erro) { showToast(data.erro); return; }

    document.getElementById('userName').textContent  = nome + ' ' + sobrenome;
    document.getElementById('userEmail').textContent = email;
    const iniciais = (nome[0] + (sobrenome[0] ?? '')).toUpperCase();
    document.getElementById('avatarInitials').textContent = iniciais;
    toggleEdit();
    showToast('Perfil atualizado ✓');
  } catch(_) {
    showToast('Erro de conexão.');
  } finally {
    btn.disabled = false; btn.textContent = 'Salvar alterações';
  }
}

// ── Logout ────────────────────────────────────────────────────
async function logout() {
  await fetch(BASE + 'Banco/logout.php');
  showToast('Até logo!');
  setTimeout(() => window.location.href = BASE + 'index.html', 800);
}

function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg; t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 3000);
}