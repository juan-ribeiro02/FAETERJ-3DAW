// Caminho para a pasta Banco a partir de qualquer página
// index.html  -> Banco/
// Pages/*.html -> ../Banco/
const BASE = document.querySelector('meta[name="base"]')?.content ?? '';

// --- Utilitários ---
function showToast(msg) {
  const t = document.getElementById('toast');
  if (!t) return;
  t.textContent = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 3000);
}

function setLoading(btn, loading) {
  btn.disabled = loading;
  btn.dataset.orig = btn.dataset.orig || btn.textContent;
  btn.textContent = loading ? 'Aguarde...' : btn.dataset.orig;
}

// --- Sessão ao carregar a página ---
async function checkSessao() {
  try {
    const res  = await fetch(BASE + 'Banco/sessao.php');
    const data = await res.json();
    if (data.logado) onLoginSuccess(data);
  } catch (_) {}
}

// --- Chamada quando login/cadastro retorna sucesso ---
function onLoginSuccess(data) {
  // Atualiza nav: troca "Entrar" por nome do usuário
  const btnEntrar = document.querySelector('.nav-btn-entrar');
  if (btnEntrar) {
    btnEntrar.textContent = data.nome;
    btnEntrar.onclick = () => { window.location.href = BASE + 'Pages/minha-conta.html'; return false; };
  }

  // Fecha modal se estiver aberto
  const overlay = document.getElementById('modalOverlay');
  if (overlay) overlay.classList.remove('open');
  document.body.style.overflow = '';

  showToast('Bem-vindo(a), ' + data.nome + '! ✓');
}

// --- LOGIN ---
async function handleLogin() {
  const email = document.getElementById('loginEmail').value.trim();
  const senha = document.getElementById('loginPassword').value;
  const btn   = document.querySelector('#formLogin .form-submit');

  if (!email || !senha) { showToast('Preencha e-mail e senha.'); return; }

  setLoading(btn, true);
  try {
    const res  = await fetch(BASE + 'Banco/login.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email, senha }),
    });
    const data = await res.json();
    if (data.erro) { showToast(data.erro); return; }
    onLoginSuccess(data);
  } catch (_) {
    showToast('Erro de conexão.');
  } finally {
    setLoading(btn, false);
  }
}

// --- CADASTRO ---
async function handleRegister() {
  const nome      = document.getElementById('regNome').value.trim();
  const sobrenome = document.getElementById('regSobrenome').value.trim();
  const email     = document.getElementById('regEmail').value.trim();
  const telefone  = document.getElementById('regTel').value.trim();
  const senha     = document.getElementById('regPassword').value;
  const conf      = document.getElementById('regPasswordConf').value;
  const btn       = document.querySelector('#formRegister .form-submit');

  if (!nome || !email || !senha) { showToast('Preencha todos os campos.'); return; }
  if (senha !== conf)            { showToast('As senhas não coincidem.'); return; }
  if (senha.length < 8)         { showToast('Senha deve ter ao menos 8 caracteres.'); return; }

  setLoading(btn, true);
  try {
    const res  = await fetch(BASE + 'Banco/cadastro.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ nome, sobrenome, email, telefone, senha }),
    });
    const data = await res.json();
    if (data.erro) { showToast(data.erro); return; }
    onLoginSuccess(data);
  } catch (_) {
    showToast('Erro de conexão.');
  } finally {
    setLoading(btn, false);
  }
}

// --- LOGOUT ---
async function logout() {
  await fetch(BASE + 'Banco/logout.php');
  showToast('Até logo!');
  setTimeout(() => window.location.href = BASE + 'index.html', 800);
}

// Verifica sessão ao carregar qualquer página
document.addEventListener('DOMContentLoaded', checkSessao);