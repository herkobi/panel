<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>{{ Setting::get('title') }}</title>
    <link rel="shortcut icon" href="{{ Setting::get('favicon') }}" type="image/png">
    @vite(['resources/sass/auth.scss', 'resources/js/auth.js'])
    @yield('css')
</head>

<body class="auth">
    <div class="container">
        @yield('content')
    </div>
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
