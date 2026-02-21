const add__button = document.querySelector('.add1'); 
const store = document.querySelector('.store'); 
let x = 0;






const more__button = document.querySelector('.more__button'); 
const menu = document.querySelector('#sidebar');
let isModalOpen = false;
more__button.addEventListener('click', () => { 
    isModalOpen = !isModalOpen; 
    console.log(isModalOpen);
    if(isModalOpen == false){
        menu.style.left = '-100%';
    } if(isModalOpen == true){
        menu.style.left = '0';
    }
});

const chats__button = document.querySelector('.header__right .chats__button'); 
const chats__window= document.querySelector(".chats__window");
let isChatslOpen = false;
chats__button.addEventListener('click', () => { 
    isChatslOpen = !isChatslOpen
    console.log(isChatslOpen);
    if(isChatslOpen == false){
        chats__window.style.display = 'none';
    } if(isChatslOpen == true){
        chats__window.style.display = 'block';
    }
});










