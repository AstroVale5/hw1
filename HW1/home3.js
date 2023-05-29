function jsonApod(json) {
    console.log('JSON ricevuto');
    console.log(json);

    if(json.media_type === "video")
    {
      console.log(json.media_type);
      

      const box = document.querySelector('#box');
      box.innerHTML = '';

      
      const card =document.createElement('div');

      const video = document.createElement('iframe');
      video.src = json.url;

      card.appendChild(video);
      box.appendChild(card);
  
    } else if(json.media_type === "image")
    {
      //creo una box e la svuoto (ripulisco quando effetto una nuova ricerca)
    const box = document.querySelector('#box');
    box.innerHTML = '';
    
    const card =document.createElement('div');
    card.dataset.title = json.title;
    card.dataset.image = json.url;
    card.classList.add('pic');

    const info = document.createElement('div');
    info.classList.add('info');
    card.appendChild(info);

    //creazione del titolo
    const titolo = document.createElement('span');
    titolo.textContent = json.title;

    //creazione dell'immagine
    const img = document.createElement('img');
    img.src = json.url;
    info.appendChild(img);

    //aggiungo l'eventListener per la funzione di apertura della modale
    img.addEventListener('click', apriModale);

    //creo l'elemento (icona) che appenderò al div
    const save = document.createElement('div');
    save.value = '';
    save.classList.add("save");
   
    
    card.appendChild(save);
    //associo un event listener per la funzione di salvataggio
    save.addEventListener('click', saveApod);

    //appendo titolo ed immagine al div 
    card.appendChild(titolo);
    card.appendChild(img);

    //appendo il div al box con il bordo 
    box.appendChild(card); 
    }
    
    
  }



function onResponse(response) {

    console.log('Risposta ricevuta');
    console.log(response.json);
    return response.json();
  }


function Ricerca(event)
{   
  event.preventDefault();
  //leggo il tipo e il contenuto da cercare e mando tutto alla pagina php
  const form = new FormData(document.querySelector("#esperimento"));
  //Mando le specifiche della richiesta alla pagina PHP, che prepara la richiesta e la inoltra
  fetch("search_content.php?q="+encodeURIComponent(form.get('content'))).then(onResponse).then(jsonApod);
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


const form = document.querySelector('#esperimento');
form.addEventListener('submit', Ricerca);

const modale = document.querySelector('#modale');
window.addEventListener('keydown', chiudiModale);

