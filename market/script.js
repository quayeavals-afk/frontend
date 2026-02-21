const more__button = document.querySelector('.more__button'); 
const menu = document.querySelector('#sidebar');
let isModalOpen = false;
more__button.addEventListener('click', () => { 
    isModalOpen = !isModalOpen; 
    console.log(isModalOpen);
    if(isModalOpen == false){
        menu.style.left = '-400%';
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

const sort__button = document.querySelector('.table .table__header .search_sistem .button__sort');
const sort__window = document.querySelector('.table .table__header .search_sistem .sort__box');
const sort__buttons = document.querySelectorAll('.table .table__header .search_sistem .sort__box button');
let isSortlOpen = false;
function toggleSortWindow() {
    isSortlOpen = !isSortlOpen
    console.log(isSortlOpen);
    if(isSortlOpen == false){
        sort__window.style.display = 'none';
    } if(isSortlOpen == true){
        sort__window.style.display = 'block';
    }
}
sort__button.addEventListener('click', toggleSortWindow);
sort__buttons.forEach(button => {
    button.addEventListener('click', toggleSortWindow);
})



const tags__button = document.querySelector('.table .table__header .search_sistem .button__tags');
const tags__window = document.querySelector('.table .table__header .search_sistem .tags__box');
const reset__Button = document.querySelector('.reset'); 
const apply__Button = document.querySelector('.apply')
let isTagslOpen = false;
function toggleTagsWindow() {
    isTagslOpen = !isTagslOpen
    console.log(isTagslOpen);
    if(isTagslOpen == false){
        tags__window.style.display = 'none';
    } if(isTagslOpen == true){
        tags__window.style.display = 'block';
    }
}
tags__button.addEventListener('click', toggleTagsWindow);
reset__Button.addEventListener('click', toggleTagsWindow);
apply__Button.addEventListener('click', toggleTagsWindow);



const tags__Location__button = document.querySelector('.table .table__header .search_sistem .tags__box .location__button');
const tags__Location__window = document.querySelector('.table .table__header .search_sistem .tags__box .location__box');
const tags__Period__button = document.querySelector('.table .table__header .search_sistem .tags__box .period__button');
const tags__Period__window = document.querySelector('.table .table__header .search_sistem .tags__box .period__box');
const tags__Delivery__button = document.querySelector('.table .table__header .search_sistem .tags__box .delivery__button');
const tags__Delivery__window = document.querySelector('.table .table__header .search_sistem .tags__box .delivery__box');
let isLocationBoxOpen = false;
let isPeriodBoxOpen = false;
let isDeliveryBoxOpen = false;

tags__Location__button.addEventListener('click', () => { 
    isLocationBoxOpen = !isLocationBoxOpen
    console.log(isLocationBoxOpen);
    if(isLocationBoxOpen == false){
        tags__Location__window.style.display = 'none';
    } if(isLocationBoxOpen == true){
        tags__Location__window.style.display = 'grid';
    }
});
tags__Period__button.addEventListener('click', () => { 
    isPeriodBoxOpen = !isPeriodBoxOpen
    console.log(isPeriodBoxOpen);
    if(isPeriodBoxOpen == false){
        tags__Period__window.style.display = 'none';
    } if(isPeriodBoxOpen == true){
        tags__Period__window.style.display = 'grid';
    }
});
tags__Delivery__button.addEventListener('click', () => { 
    isDeliveryBoxOpen = !isDeliveryBoxOpen
    console.log(isDeliveryBoxOpen);
    if(isDeliveryBoxOpen == false){
        tags__Delivery__window.style.display = 'none';
    } if(isDeliveryBoxOpen == true){
        tags__Delivery__window.style.display = 'grid';
    }
});