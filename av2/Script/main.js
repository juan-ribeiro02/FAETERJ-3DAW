function openModal(tab) {
  switchTab(tab || 'login');
  document.getElementById('modalOverlay').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  document.getElementById('modalOverlay').classList.remove('open');
  document.body.style.overflow = '';
}

function handleOverlayClick(e) {
  if (e.target === document.getElementById('modalOverlay')) closeModal();
}

function switchTab(tab) {
  ['login', 'register'].forEach(t => {
    const key = t.charAt(0).toUpperCase() + t.slice(1);
    document.getElementById('tab' + key).classList.toggle('active', t === tab);
    document.getElementById('form' + key).classList.toggle('active', t === tab);
  });
}

// function showToast(msg) {
//   const t = document.getElementById('toast');
//   t.textContent = msg;
//   t.classList.add('show');
//   setTimeout(() => t.classList.remove('show'), 3000);
// }

// function handleLogin() {
//   const email = document.getElementById('loginEmail').value.trim();
//   const pass = document.getElementById('loginPassword').value;
//   if (!email || !pass) { showToast('Preencha todos os campos'); return; }
//   showToast('Login realizado! ✓');
//   setTimeout(closeModal, 800);
// }

// function handleRegister() {
//   const nome = document.getElementById('regNome').value.trim();
//   const email = document.getElementById('regEmail').value.trim();
//   const pass = document.getElementById('regPassword').value;
//   const conf = document.getElementById('regPasswordConf').value;
//   if (!nome || !email || !pass) { showToast('Preencha todos os campos'); return; }
//   if (pass !== conf) { showToast('As senhas não coincidem'); return; }
//   if (pass.length < 8) { showToast('Senha deve ter ao menos 8 caracteres'); return; }
//   showToast('Conta criada com sucesso! ✓');
//   setTimeout(closeModal, 800);
// }

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });