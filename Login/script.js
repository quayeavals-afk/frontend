document.querySelector('form').addEventListener('submit', async (e) => {
    e.preventDefault();

    const data = {
        username: document.getElementById('log-username').value,
        email: document.getElementById('log-email').value,
        password: document.getElementById('log-password').value,
        confirmPassword: document.getElementById('confirmPassword').value
    };
    if (data.password !== data.confirmPassword) {
        alert('Passwords do not match!');
        return;
    } else{
        console.log('Submitting data:', data);
        const result = await sendForm(data);
        console.log('Server response:', result);
    }
    
});

// отправка данных в БД
async function sendForm(data) { 
    const response = await fetch('./register.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    });

    const result = await response.json();
    
    // Обновляем страницу после успешной регистрации
    if (result.status === 'good') {
        location.reload();
    }
    
    return result;
}






const button__variant = document.querySelectorAll('.variant'); 
const registerationForm = document.querySelector('#registerationForm');
const loginForm = document.querySelector('#loginForm');

let registerationOpen = false;

function toggleSortWindow() {
    console.log('clicked');
    registerationOpen = !registerationOpen; 
    if(registerationOpen == true){
        registerationForm.style.display= 'block';
        loginForm.style.display = 'none';
    } if(registerationOpen == false){
        registerationForm.style.display= 'none';
        loginForm.style.display = 'block';
    }
}
button__variant.forEach(button => {
    button.addEventListener('click', toggleSortWindow);
});


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