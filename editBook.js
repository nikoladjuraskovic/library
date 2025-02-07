

console.log("UCITAO JS!");

const forma = document.getElementById("editForm");

forma.addEventListener('submit', function(ev) {

    let divGreska = document.getElementById("greska");

    let poljeTitle = document.getElementById("Title");

    let poljeAuthor = document.getElementById("Author");

    let poljeYear = document.getElementById("Year");

    let title = poljeTitle.value.trim();

    if(title === " " || title.length < 3 || title.length > 50)
    {
        divGreska.textContent = "Title is not valid!";

        poljeTitle.focus();

        poljeTitle.classList += " is-invalid";

        ev.preventDefault();

        return false;
    } else{
        poljeTitle.classList += " is-valid";
    }

    let author = poljeAuthor.value.trim();

    if(author === " " || author.length < 3 || author.length > 20)
    {
        divGreska.textContent = "Author name is not valid!";

        poljeAuthor.focus();

        poljeAuthor.classList += " is-invalid";

        ev.preventDefault();

        return false;
    } else{
        poljeAuthor.classList += " is-valid";
    }

    let year = parseInt(poljeYear.value.trim());

    const d = new Date();

    if(year < 1 || godina > d.getFullYear() || isNan(year))
    {
        divGreska.textContent = "Year is not valid";

        poljeYear.focus();

        poljeYear.classList += " is-invalid";

        ev.preventDefault();

        return false;
    } else{
        poljeYear.classList += " is-valid";
    }

    divGreska.textContent = "";
    return true;

});