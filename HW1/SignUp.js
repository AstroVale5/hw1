//Validazione lato client: lunghezza password, caratteri speciali, username già in uso
function ControllaNome(event)
{
    const input = event.currentTarget;

    if(formStatus[input.name] = input.value.length > 0)
    {
        input.parentNode.classList.remove('errorSU');
    }
    else
    {
        input.parentNode.classList.add('errorSU');
    }
}



function ControllaCognome(event)
{
    const input = event.currentTarget;

    if(formStatus[input.name] = input.value.length > 0)
    {
        input.parentNode.classList.remove('errorSU');
    }
    else
    {
        input.parentNode.classList.add('errorSU');
    }
}


function jsonControllaUsername(json)
{
    if(!json.exists)
    {
        document.querySelector('.username').classList.remove('errorSU');
    }
    else
    {
        document.querySelector('.username span').textContent = "Nome utente già in uso";
        document.querySelector('.username').classList.add('errorSU');
    }
}


function jsonControllaEmail(json) {
    // Controllo il campo exists ritornato dal JSON
    if (!json.exists) {
        document.querySelector('.email').classList.remove('errorSU');
    } else {
        document.querySelector('.email span').textContent = "Email già in uso";
        document.querySelector('.email').classList.add('errorSU');
    }

}

function fetchResponse(response) {
    if (!response.ok) return null;
    return response.json();
}


function ControllaEmail(event)
{
    //questa funzione deve controllare che non ci sia una email nel database, quindi farà una fetch
    const input = document.querySelector('.email input');

    //controllo per i caratteri speciali
    if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(input.value).toLowerCase())) {
        document.querySelector('.email span').textContent = "Email non valida";
        document.querySelector('.email').classList.add('errorSU');
        formStatus.email = false;

    } else {
        fetch("emaildb.php?q="+encodeURIComponent(String(input.value).toLowerCase())).then(fetchResponse).then(jsonControllaEmail);
    }

}

function ControllaUsername(event)
{
    const input = event.currentTarget;
    //controllo per vedere se rispetta le condizioni
    if(!/^[a-zA-Z0-9_]{1,20}$/.test(input.value))
    {
        input.parentNode.querySelector('span').textContent ='Inserisci fino a 20 caratteri';
        input.parentNode.classList.add('errorSU');
        formStatus.username = false;
    }else
    {
        fetch("usernamedb.php?q=" + encodeURIComponent(input.value)).then(fetchResponse).then(jsonControllaUsername);
    }

}

function ControllaPassword(event)
{
    const input = document.querySelector('.password input');
    //controllo della lunghezza della password
    if(formStatus.password = input.value.length >= 8)
    {
        document.querySelector('.password').classList.remove('errorSU');
    }
    else
    {
        document.querySelector('.password').classList.add('errorSU');
    }
}


function ControllaConferma(event)
{
    const input = document.querySelector('.confirm_password input');

    //controllo che la password sia uguale a quella messa prima
    if(formStatus.confirmPassword = input.value === document.querySelector('.password input').value)
    {
        document.querySelector('.password').classList.remove('errorSU');
    }
    else 
    {
        document.querySelector('.confirm_password').classList.add('errorSU');
    }
}


const formStatus = {'upload': true};

document.querySelector('.name input').addEventListener('blur', ControllaNome);
document.querySelector('.surname input').addEventListener('blur', ControllaCognome);
document.querySelector('.username input').addEventListener('blur', ControllaUsername);
document.querySelector('.email input').addEventListener('blur', ControllaEmail);
document.querySelector('.password input').addEventListener('blur', ControllaPassword);
document.querySelector('.confirm_password input').addEventListener('blur', ControllaConferma);