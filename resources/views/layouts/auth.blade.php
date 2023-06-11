<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Herkobi Panel</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body class="auth">
    <div class="wrapper align-items-center justify-content-center auth-wrapper">
        @yield('content')
    </div>
    <footer class="footer-area text-center pt-5 pb-3">
        <a href="#" class="text-decoration-none text-muted small">Gizlilik Politikası</a> - <a href="#" class="text-decoration-none text-muted small">Kullanım Sözleşmesi</a>
    </footer>
    <script>
    /*
    * Show/Hide Password
    */
    function password_show_hide() {
        const x = document.getElementById("password");
        const show_eye = document.querySelector(".showpassword");
        const hide_eye = document.querySelector(".hidepassword");
        hide_eye.classList.remove("d-none");
        if (x.type === "password") {
            x.type = "text";
            show_eye.style.display = "none";
            hide_eye.style.display = "block";
        } else {
            x.type = "password";
            show_eye.style.display = "block";
            hide_eye.style.display = "none";
        }
    }

    function password_conf_show_hide() {
        const y = document.getElementById("password_confirmation");
        const show_conf_eye = document.querySelector(".showpassword_conf");
        const hide_conf_eye = document.querySelector(".hidepassword_conf");
        hide_conf_eye.classList.remove("d-none");
        if (y.type === "password") {
            y.type = "text";
            show_conf_eye.style.display = "none";
            hide_conf_eye.style.display = "block";
        } else {
            y.type = "password";
            show_conf_eye.style.display = "block";
            hide_conf_eye.style.display = "none";
        }
    }
    </script>
</body>
</html>
