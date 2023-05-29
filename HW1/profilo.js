
function cancellaAccount(event){
    event.preventDefault();
    console.log('allora vuoi cancellarlo davvero?');

    fetch("cancella_utente.php").then(onResponse).then(onJson);
    window.location.assign("logout.php");
}


function onResponse(response){
    console.log('Risposta ricevuta');
    console.log(response.json);
    return response.json();
}

function onJson(json){
    console.log(json);
}

function CambioSchermata(event){
    event.preventDefault();

    console.log("cambio schermata");
    const riq = document.querySelector('#riquadro');
    riq.classList.add('hidden');

    const credenziali = document.querySelector('.nascosto');
    credenziali.classList.remove('nascosto');
    credenziali.setAttribute("id", "riquadro");
}

function checkUsername(event){
    console.log("focus perso");

    const input = event.currentTarget;
    //controllo per vedere se rispetta le condizioni
    if(!/^[a-zA-Z0-9_]{1,20}$/.test(input.value))
    {
        input.parentNode.querySelector('span').textContent ='Sono ammesse lettere e numeri per un massimo di 20 caratteri';
        input.parentNode.classList.add('errorSU');
        formStatus.username = false;
    }else
    {
        fetch("usernamedb.php?q=" + encodeURIComponent(input.value)).then(fetchResponse).then(jsonControllaUsername);
    }
}


function fetchResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

function jsonControllaUsername(json)
{
    
    if(!json.exists)
    {
        document.querySelector('.username').classList.remove('errorSU');
        console.log("okay facciamo il cambio");
    }
    else
    {
        document.querySelector('.username span').textContent = "Nome utente già in uso";
        document.querySelector('.username').classList.add('errorSU');
    }
}




const formStatus = {'upload': true};

const username = document.querySelector('.username input')
username.addEventListener('blur', checkUsername); 

const cancella = document.querySelector('#cancella');
cancella.addEventListener('click', cancellaAccount);

const cambio = document.querySelector('#cambioUser');
cambio.addEventListener('click', CambioSchermata);

