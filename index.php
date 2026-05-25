<?php
    $cookie_email = isset($_COOKIE['sv_email']) ? $_COOKIE['sv_email'] : '';
    $cookie_password = isset($_COOKIE['sv_password']) ? $_COOKIE['sv_password'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shinigami Vault</title>

    <!-- stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="icon" href="assets/logo.png" />
</head>

<body>

    <!-- header -->
    <?php include "header.php"; ?>

    <!-- toast -->
    <div class="toast-msg" id="toast-msg">
        <i id="toast-icon" class="bi bi-x-circle-fill"></i>
        <span id="toast-text" class="toast-text"></span>
    </div>

    <!-- auth-container -->
    <div class="auth-container">
        <div class="auth-login-container col-4">
            <h2 class="auth-heading">Login</h2>
            <div class="auth-field-container d-flex justify-content-center w-100">
                <fieldset class="fieldset">

                    <div class="input-wrapper">
                        <input type="email" id="l_email" placeholder=" " value="<?php echo $cookie_email; ?>"/>
                        <label for="l_email">Email</label>
                    </div>

                    <div class="input-wrapper">
                        <input type="password" id="l_password" placeholder=" " 
                            style="letter-spacing: 8px;" maxlength="8" value="<?php echo $cookie_password; ?>" />
                        <label for="l_password">Password</label>
                        <button class="show-pw-btn" onclick="showPwLogin();">
                            <i id="l_password_icon" class="bi bi-eye-slash"></i>
                        </button>
                    </div>

                </fieldset>
            </div>

            <div class="auth-btn-container"><br>
                <a class="ms-3" type="button" onclick="showFP();">Forgot your password ?</a>
                <div class="d-flex justify-content-center w-100 mt-5">
                    <div class="col-10">
                        <button class="primary-btn" onclick="handleLogin()">Login</button>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <a type="button" onclick="showRegister();">create account</a>
                </div>
            </div>

        </div>
        <div class="auth-register-container d-none col-4">
            <h2 class="auth-heading">Register</h2>
            <div class="auth-field-container d-flex justify-content-center w-100">
                <fieldset class="fieldset">

                    <div class="input-wrapper">
                        <input type="text" id="r_name" placeholder=" " />
                        <label for="r_name">Full name</label>
                    </div>

                    <div class="input-wrapper">
                        <input type="email" id="r_email" placeholder=" " />
                        <label for="r_email">Email</label>
                    </div>

                    <div class="input-wrapper">
                        <input type="password" id="r_password" placeholder=" " 
                            style="letter-spacing: 8px;" maxlength="8" />
                        <label for="r_password">Password</label>
                        <button class="show-pw-btn" onclick="showPwRegister();">
                            <i id="r_password_icon" class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    <small style="color: #888; font-size: 0.7rem; padding-left: 1rem;">
                        password must be 5-8 characters
                    </small>

                </fieldset>
            </div>

            <div class="auth-btn-container"><br>
                <div class="d-flex justify-content-center w-100 mt-3">
                    <div class="col-10">
                        <button class="primary-btn" onclick="handleRegister()">Create Account</button>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <a type="button" onclick="showLogin();">Back to Login</a>
                </div>
            </div>

        </div>
        <div class="auth-fp-container d-none col-5">
            <h2 class="auth-heading">reset your account password</h2> <br>
            <div class="auth-field-container d-flex justify-content-center w-100">
                <fieldset class="fieldset">

                    <div class="input-wrapper">
                        <input type="email" id="fp_email" placeholder=" " />
                        <label for="fp_email">Email</label>
                    </div>

                </fieldset>
            </div>

            <div class="auth-btn-container"><br>
                <div class="d-flex justify-content-center w-100 mt-3">
                    <div class="col-7">
                        <button class="primary-btn">reset</button>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <a type="button" onclick="showLogin();">remember your password?</a>
                </div>
            </div>

        </div>
        <div class="auth-newpw-container d-none col-4">
            <h2 class="auth-heading">setup new password</h2>
            <div class="auth-field-container d-flex justify-content-center w-100">
                <fieldset class="fieldset">

                    <div class="input-wrapper">
                        <input type="email" id="n_email" placeholder=" " />
                        <label for="n_email">Email</label>
                    </div>

                    <div class="input-wrapper">
                        <input type="password" id="n_password" placeholder=" " style="letter-spacing: 8px;" />
                        <label for="n_password">new password</label>
                        <button class="show-pw-btn" onclick="showPwNewPw1();">
                            <i id="n_password_icon" class="bi bi-eye-slash"></i>
                        </button>
                    </div>

                    <div class="input-wrapper">
                        <input type="password" id="n_repassword" placeholder=" " style="letter-spacing: 8px;" />
                        <label for="n_repassword">re-type your password</label>
                        <button class="show-pw-btn" onclick="showPwNewPw2();">
                            <i id="n_repassword_icon" class="bi bi-eye-slash"></i>
                        </button>
                    </div>

                    <div class="input-wrapper">
                        <input type="text" id="n_vcode" placeholder=" " />
                        <label for="n_vcode">verification code</label>
                    </div>

                </fieldset>
            </div>

            <div class="auth-btn-container"><br>
                <div class="d-flex justify-content-center w-100 mt-3">
                    <div class="col-10">
                        <button class="primary-btn">save password</button>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <a type="button" onclick="showLogin();">resend otp</a>
                </div>
            </div>

        </div>
    </div>

    <!-- footer -->
    <?php include "footer.php"; ?>

    <!-- js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script>
        // ============== Login ==============
        function showPwLogin() { // login
            var pw = document.getElementById("l_password");
            var pwicon = document.getElementById("l_password_icon");

            if (pw.type == "password") {
                pw.type = "text";
                pwicon.className = "bi bi-eye";
            } else {
                pw.type = "password";
                pwicon.className = "bi bi-eye-slash";
            }
        }
        function showPwRegister() { // register
            var pw = document.getElementById("r_password");
            var pwicon = document.getElementById("r_password_icon");

            if (pw.type == "password") {
                pw.type = "text";
                pwicon.className = "bi bi-eye";
            } else {
                pw.type = "password";
                pwicon.className = "bi bi-eye-slash";
            }
        }
        function showPwNewPw1() { // new password | new pw
            var pw = document.getElementById("n_password");
            var pwicon = document.getElementById("n_password_icon");

            if (pw.type == "password") {
                pw.type = "text";
                pwicon.className = "bi bi-eye";
            } else {
                pw.type = "password";
                pwicon.className = "bi bi-eye-slash";
            }
        }
        function showPwNewPw2() { // new password | new repw
            var pw = document.getElementById("n_repassword");
            var pwicon = document.getElementById("n_repassword_icon");

            if (pw.type == "password") {
                pw.type = "text";
                pwicon.className = "bi bi-eye";
            } else {
                pw.type = "password";
                pwicon.className = "bi bi-eye-slash";
            }
        }

        // ============== Login ==============
        function handleLogin() {
            const email = document.getElementById("l_email").value.trim();
            const password = document.getElementById("l_password").value;

            if(!email) {
                showToast("⚠ Please enter your email!");
                document.getElementById("l_email").focus();
                return;
            }
            if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                showToast("⚠ Please enter a valid email!");
                document.getElementById("l_email").focus();
                return;
            }
            if(!password) {
                showToast("⚠ Please enter your password!");
                document.getElementById("l_password").focus();
                return;
            }
            if(password.length < 5) {
                showToast("⚠ Password must be at least 5 characters!");
                document.getElementById("l_password").focus();
                return;
            }

            var form = new FormData();
            form.append("email", email);
            form.append("password", password);

            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    var response = request.responseText;
                    if(response == "success") {
                        showToast("Login successful! ✓", "success");
                        setTimeout(() => window.location.href = "home.php", 1500);
                    } else if(response == "invalid") {
                        showToast("⚠ Invalid email or password!");
                    } else {
                        showToast("⚠ Something went wrong!");
                    }
                }
            }
            request.open("POST", "processes/customerLoginProcess.php", true);
            request.send(form);

        }

        // ============== Register ==============
        function handleRegister() {
            const name = document.getElementById("r_name").value.trim();
            const email = document.getElementById("r_email").value.trim();
            const password = document.getElementById("r_password").value;

            if(!name) {
                showToast("⚠ Please enter your full name!");
                document.getElementById("r_name").focus();
                return;
            }
            if(!email) {
                showToast("⚠ Please enter your email!");
                document.getElementById("r_email").focus();
                return;
            }
            if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                showToast("⚠ Please enter a valid email!");
                document.getElementById("r_email").focus();
                return;
            }
            if(!password) {
                showToast("⚠ Please enter a password!");
                document.getElementById("r_password").focus();
                return;
            }
            if(password.length < 5) {
                showToast("⚠ Password must be at least 5 characters!");
                document.getElementById("r_password").focus();
                return;
            }

            var form = new FormData();
            form.append("name", name);
            form.append("email", email);
            form.append("password", password);

            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    var response = request.responseText;
                    if(response == "success") {
                        showToast("Account created! ✓", "success");
                        setTimeout(() => showLogin(), 1500);
                    } else if(response == "exists") {
                        showToast("⚠ Email already registered!");
                    } else {
                        showToast("⚠ Something went wrong!");
                    }
                }
            }
            request.open("POST", "processes/customerRegisterProcess.php", true);
            request.send(form);
        }
    </script>
</body>

</html>

<style>
    .auth-container {
        width: 100%;
        min-height: 87vh;
        padding-left: 1rem;
        padding-right: 1rem;
        padding-top: 3rem;
        background-color: var(--white);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .auth-heading {
        text-align: center;
        font-family: 'header';
        color: var(--black);
        margin-bottom: 2.7rem;
        text-transform: uppercase;
    }

    .auth-btn-container a {
        color: var(--black);
        font-size: 0.8rem;
        text-decoration: underline;
    }

    
</style>

