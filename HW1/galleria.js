function fetchApod(){
    fetch("fetch_apod.php").then(fetchResponse).then(fetchApodJson);
}


function fetchResponse(response){

    console.log("prova");
    if (!response.ok) {return null};
    return response.json();
}


function fetchApodJson(json)
{
    console.log("sto Fetchando...");
    console.log(json);
    
    for(let titolo of json){

        const container = document.getElementById('results');
        
        const card = document.createElement('div');
        card.classList.add('carta');

    
        const title = document.createElement('span');
        title.innerHTML = titolo.content.title;


        const img = document.createElement('img');
        img.src = titolo.content.image;
        img.addEventListener('click', apriModale);

        const controllo = titolo.commento;

        if (controllo !== null)
        {  
            const com = document.createElement('span');
            com.innerHTML = titolo.commento;
            com.classList.add('bordo');

            const button = document.createElement('button');
            button.textContent = "Cancella commento";
            button.addEventListener('click', CancellaCommento);
         
            card.appendChild(title);
            card.appendChild(img);
            card.appendChild(com);
            //card.appendChild(button1);
            card.appendChild(button);

            //creo l'elemento (icona) che appenderò al div
            const save = document.createElement('div');
            save.value = '';
            save.classList.add("salvata");
            card.appendChild(save);
            save.addEventListener('click', removeApod);

            container.appendChild(card);
        }else if(controllo === null)
        {   
            const commento = document.createElement('input');
            commento.setAttribute("id", "commentInput");
            commento.placeholder = 'Commenta...';
            commento.classList.add('commento');

            const button1 = document.createElement('button');
            button1.textContent = "Invia commento";
            button1.addEventListener('click', Commenta);

            const button = document.createElement('button');
            button.textContent = "Cancella commento";
            button.addEventListener('click', CancellaCommento);
         
            card.appendChild(title);
            card.appendChild(img);
            card.appendChild(commento);
            card.appendChild(button1);
            card.appendChild(button);

            //creo l'elemento (icona) che appenderò al div
            const save = document.createElement('div');
            save.value = '';
            save.classList.add("salvata");
            card.appendChild(save);
            save.addEventListener('click', removeApod);

            container.appendChild(card);
        }
        
    }

}

function Commenta(event){
    event.preventDefault();
    
    const card = event.currentTarget.parentNode;

    const com = card.querySelector('input').value;
    console.log(com);


    const title = card.querySelector('span').textContent;
    console.log(title);

    card.dataset.titolo=title;
    card.dataset.commento=com;

    fetch("salva_commento.php?comment=" + com + "&title=" + title).then(Risposta);

    /* rimuovo la barra per commentare */
    const barra = card.querySelector('input');
    card.removeChild(barra);

    window.location.assign("galleria.php");
}

/* funzione salva commento */
function Risposta(response){
    console.log(response);
    return response.json();
}



function CancellaCommento(event){
    console.log('Eliminazione commento');
    const card = event.currentTarget.parentNode;

    const com = card.querySelector('.bordo').textContent;
    console.log(com);

    const title = card.querySelector('span').textContent;
    console.log(title);

    fetch("elimina_commento.php?comment=" +com + "&title="+ title).then(Resp);
    window.location.assign("galleria.php");
}

function Resp(response){
    console.log(response);
    return response.json();
}

function apriModale(event) {
	//creo un nuovo elemento img
	const image = document.createElement('img');
	//setto l'ID di questo img come immagine_post, a cui attribuisco alcune caratteristiche CSS
	image.id = 'immagine_post';
	//associo all'attributo src, l'src cliccato
	image.src = event.currentTarget.src;
	//appendo quest'immagine alla view modale
	modale.appendChild(image);
	//rendo la modale visibile
	modale.classList.remove('hidden');
	//blocco lo scroll della pagina
	document.body.classList.add('no-scroll');
}


function chiudiModale(event) {
	console.log(event);
	if(event.key === 'Escape')
	{
		//aggiungo la classe hidden 
		console.log(modale);
		modale.classList.add('hidden');
		//prendo il riferimento dell'immagine dentro la modale
		img = modale.querySelector('img');
		//e la rimuovo 
		img.remove();
		//riabilito lo scroll
		document.body.classList.remove('no-scroll');
	}
}

function saveApod(event){
    console.log("Salvataggio dati");
  
    const sav = event.currentTarget;
    sav.removeEventListener('click', saveApod);
    sav.addEventListener('click', removeApod);
    sav.classList.remove("save");
    sav.classList.add("salvata");
    
    //get parent di card (il genitore degli elementi che mi interessano)
    const card = event.currentTarget.parentNode;
    //Preparo i dati da mandare al server e invio la richiesta
    const title = card.querySelector('span').textContent;
    const image = card.querySelector('img').src;
    fetch("save_apod.php?title=" + title + "&image=" + image).then(Risposta).then(Er);
    console.log(title);
    console.log(image);
    event.stopPropagation();
  }

/* funzioni per il salvataggio */
function Risposta(response){
    console.log(response);
    return response.json();
}
  
function Er(json){
    console.log(json);
    if (!json.ok) 
    {
      alert("elemento già presente, impossibile salvare");
    }
};


function removeApod(event){
    console.log("Eliminando");

    const sav = event.currentTarget;
    sav.classList.remove("salvata");
    sav.classList.add("save");
    sav.removeEventListener('click', removeApod);
    sav.addEventListener('click', saveApod);

    const card = event.currentTarget.parentNode;
    //Preparo i dati da mandare al server e invio la richiesta
    const title = card.querySelector('span').textContent;
    console.log(title);
    fetch("remove_apod.php?title="+ title).then(onResponse);
}


function onResponse(response){
    console.log(response);
    return response.json();
}


const modale = document.querySelector('#modale');
window.addEventListener('keydown', chiudiModale);


fetchApod();