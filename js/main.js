// ========== Switch Contents ==============
function showRegister() {
    document.querySelector('.auth-login-container').classList.add('d-none');
    document.querySelector('.auth-fp-container').classList.add('d-none');
    document.querySelector('.auth-newpw-container').classList.add('d-none');
    document.querySelector('.auth-register-container').classList.remove('d-none');
}
function showLogin() {
    document.querySelector('.auth-register-container').classList.add('d-none');
    document.querySelector('.auth-fp-container').classList.add('d-none');
    document.querySelector('.auth-newpw-container').classList.add('d-none');
    document.querySelector('.auth-login-container').classList.remove('d-none');
}
function showFP() {
    document.querySelector('.auth-register-container').classList.add('d-none');
    document.querySelector('.auth-login-container').classList.add('d-none');
    document.querySelector('.auth-newpw-container').classList.add('d-none');
    document.querySelector('.auth-fp-container').classList.remove('d-none');
}
function showNewPw() {
    document.querySelector('.auth-register-container').classList.add('d-none');
    document.querySelector('.auth-login-container').classList.add('d-none');
    document.querySelector('.auth-fp-container').classList.add('d-none');
    document.querySelector('.auth-newpw-container').classList.remove('d-none');
}


// goto
function gotoSearch() {
    window.location = "search.php";
}
function gotoHome() {
    window.location = "home.php";
}
function gotoProfile(){
    window.location = "customerProfile.php";
}
function gotoIndex(){
    window.location = "index.php";
}

// ============== Toast Box ===========
function showToast(msg, type = 'error') {
    const t = document.getElementById('toast-msg');
    const text = document.getElementById('toast-text');
    const icon = document.getElementById('toast-icon');

    text.textContent = msg;

    if (type === 'success') {
        t.style.backgroundColor = '#2a7a2a';
        icon.className = 'bi bi-check-circle-fill';
    } else {
        t.style.backgroundColor = 'var(--red)';
        icon.className = 'bi bi-x-circle-fill';
    }

    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3000);
}


