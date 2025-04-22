document.getElementById("icon-menu").addEventListener("click",mostrar_menu); /*Esto es para mostrar el menu cuando la pestaña este pequeña*/

function mostrar_menu(){

    document.getElementById("move-content") .classList.toggle('move-container-all'); /*Esto es solo para que el contenido se mueva cada que abramos menu*/
    document.getElementById("show-menu") .classList.toggle('show-lateral'); /*es para que el menu se mueva tambien*/

}

