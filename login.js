

const forma = document.getElementById("forma");
const divGreska = document.getElementById("greska");

forma.addEventListener('submit', function(ev) {

    let username = document.getElementById("username");
    let password = document.getElementById("password");

    let usernameText = username.value.trim();
    let passwordText = password.value.trim();

    if(usernameText === "" || usernameText.length < 3 || usernameText > 20)
    {
        divGreska.textContent = "Username error!";

        username.focus();

        ev.preventDefault();

        username.classList += " is-invalid";

        return false;
    } else{
        username.classList += " is-valid";
    }

    if(passwordText === "" || passwordText.length < 3 || passwordText.length > 20)
    {
        divGreska.textContent = "Password error!";

        password.focus();

        ev.preventDefault();

        password.classList += " is-invalid";

        return false;
    } else{

        password.classList += " is-valid";
    }

    divGreska.textContent = "";

    return true;


});