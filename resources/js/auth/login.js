/*
|--------------------------------------------------------------------------
| Parman Farm
| Login Page
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", () => {

    /*
    |--------------------------------------------------------------------------
    | Element
    |--------------------------------------------------------------------------
    */

    const form = document.querySelector(".login-form");

    const username = document.getElementById("email");

    const password = document.getElementById("password");

    const togglePassword = document.getElementById("togglePassword");

    const loginButton = document.getElementById("loginButton");


    /*
    |--------------------------------------------------------------------------
    | Auto Focus
    |--------------------------------------------------------------------------
    */

    if (username) {

        username.focus();

    }


    /*
    |--------------------------------------------------------------------------
    | Show / Hide Password
    |--------------------------------------------------------------------------
    */

    if (togglePassword && password) {

        togglePassword.addEventListener("click", () => {

            const isHidden = password.type === "password";

            password.type = isHidden ? "text" : "password";

            togglePassword.classList.toggle("active");

            const eyeOpen = document.getElementById("eyeOpen");
            const eyeClosed = document.getElementById("eyeClosed");
            if (eyeOpen && eyeClosed) {
                eyeOpen.style.display = isHidden ? "none" : "block";
                eyeClosed.style.display = isHidden ? "block" : "none";
            }

            togglePassword.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
        });

    }


    /*
    |--------------------------------------------------------------------------
    | Loading Button
    |--------------------------------------------------------------------------
    */

    if (form && loginButton) {

        form.addEventListener("submit", () => {

            loginButton.disabled = true;

            loginButton.innerHTML = "Sedang Masuk...";

            loginButton.classList.add("loading");

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Prevent Double Click
    |--------------------------------------------------------------------------
    */

    if (loginButton) {

        loginButton.addEventListener("dblclick", (e) => {

            e.preventDefault();

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Enter Submit
    |--------------------------------------------------------------------------
    */

    document.addEventListener("keydown", (event) => {

        if (event.key === "Enter") {

            if (document.activeElement === username || document.activeElement === password) {

                form.requestSubmit();

            }

        }

    });

});

