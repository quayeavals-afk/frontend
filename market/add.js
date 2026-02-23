// ПОИСК ПО КЛЮЧЕВЫМ СЛОВАМ (ОБНОВЛЕНИЕ ПРИ ИЗМЕНЕНИИ В ПОЛЕ ВВОДА)
const store = document.querySelector('.table .store'); 

const sort__new = document.querySelector('.table .table__header .search_sistem .sort__box .sort-new');
const sort__old = document.querySelector('.table .table__header .search_sistem .sort__box .sort-old');
const sort__cheap = document.querySelector('.table .table__header .search_sistem .sort__box .sort-cheap');
const sort__expensive = document.querySelector('.table .table__header .search_sistem .sort__box .sort-expensive');

let globalAds = []; // массив всех объявлений
let filteredAds = []; // переменная для хранения отфильтрованных объявлений

// ФУНКЦИЯ ДЛЯ ПОЛУЧЕНИЯ ОБЪЯВЛЕНИЙ С СЕРВЕРА И ОТОБРАЖЕНИЯ ИХ НА СТРАНИЦЕ
async function getAds() {
  const response = await fetch('ads.php');
  const ads = await response.json(); // ads - массив всех объявлений. последный элемент стал первым
  globalAds = ads; // сохраняем в глобальную переменную
  filteredAds = [...ads]; // копируем в отфильтрованный массив

  ads.forEach(ad => {

    // СОЗДАЕМ ССЫЛКУ-ОБЕРТКУ
    let link = document.createElement("a");
    link.href = `ad.php?id=${ad.id}`;  // id из базы данных
    link.target = "_self";            // открывать в этой же вкладке
    link.style.textDecoration = "none";
    link.style.color = "inherit";
    link.style.display = "block";      // чтобы ссылка занимала весь блок
    link.style.height = "100%";
    link.style.width = "100%";

    let box = document.createElement("div");
    box.classList.add("products")

    let img = document.createElement("img");
    img.src = ad.img;    
    
    let name = document.createElement("h1");
    name.classList.add("name")
    name.textContent = ad.name;

    let description = document.createElement("p");
    description.classList.add("description");
    
    let text = ad.description || ''; // если description нет, то пустая строка
    description.textContent = text.length > 67 ? text.slice(0, 67) + '...' : text;

    let tags = document.createElement("p");
    tags.classList.add("tags")
    tags.innerHTML = ad.tags + '<br>' + ad.period + '<br>' + ad.delivery;
    
    let price = document.createElement("h2");
    price.classList.add("price")
    price.textContent = "Цена: " + ad.price + "р";

    store.append(box); 
    link.append(img, name, description, tags, price);
    box.append(link);
  });
  
  // Инициализируем поиск после загрузки объявлений
  initSearch();
}
getAds();

// ФУНКЦИЯ ДЛЯ ОТОБРАЖЕНИЯ ОБЪЯВЛЕНИЙ НА СТРАНИЦЕ
async function renderAds(a){
  let store = document.querySelector('.table .store');
  store.remove();
  let newStore = document.createElement("div");
  newStore.classList.add("store");
  document.querySelector('.table').append(newStore);

  a.forEach(ad => {

    // СОЗДАЕМ ССЫЛКУ-ОБЕРТКУ
    let link = document.createElement("a");
    link.href = `ad.php?id=${ad.id}`;  // id из базы данных
    link.target = "_blank";            // открывать в новой вкладке
    link.style.textDecoration = "none";
    link.style.color = "inherit";
    link.style.display = "block";      // чтобы ссылка занимала весь блок
    link.style.height = "100%";
    link.style.width = "100%";

    let box = document.createElement("div");
    box.classList.add("products")

    let img = document.createElement("img");
    img.src = ad.img;
    
    let name = document.createElement("h1");
    name.classList.add("name")
    name.textContent = ad.name;

    let description = document.createElement("p");
    description.classList.add("description");
    
    let text = ad.description || ''; // если description нет, то пустая строка
    description.textContent = text.length > 67 ? text.slice(0, 67) + '...' : text;

    let tags = document.createElement("p");
    tags.classList.add("tags")
    tags.innerHTML = ad.tags + '<br>' + ad.period + '<br>' + ad.delivery;

    let price = document.createElement("h2");
    price.classList.add("price")
    price.textContent = "Цена: " + ad.price + "р";

    newStore.append(box); 
    link.append(img, name, description, tags, price);
    box.append(link);
  });
}













// ПОИСК ПО КЛЮЧЕВЫМ СЛОВАМ (ПРИ ИЗМЕНЕНИИ В ПОЛЕ ВВОДА)
let inputField = document.querySelector('#input__field__text');
// Функция для инициализации поиска
function initSearch() {
  // Пробуем разные возможные селекторы для поля поиска

  
  // Если нашли поле ввода
  if (inputField) {    
    // Функция поиска по ключевым словам (ТОЛЬКО ПО НАЗВАНИЮ)
    function searchByKeywords() {
      const searchText = inputField.value.toLowerCase().trim();
      
      // Если поле поиска пустое, показываем все объявления
      if (searchText === '') {
        renderAds(globalAds);
        filteredAds = [...globalAds];
        return;
      }
      
      // Фильтруем объявления ТОЛЬКО по названию
      const searchResults = globalAds.filter(ad => {
        // Проверяем только название
        const nameMatch = ad.name && ad.name.toLowerCase().includes(searchText);
        
        return nameMatch; // возвращаем только результат проверки по названию
      });
      
      filteredAds = [...searchResults];
      renderAds(searchResults);
    }
    
    // Добавляем обработчик события input (срабатывает при каждом изменении в поле ввода)
    inputField.addEventListener('input', searchByKeywords);
    
    // Добавляем обработчик для очистки поля (крестик в поле ввода)
    inputField.addEventListener('search', searchByKeywords);
    
  } else {
    console.log('Поле поиска не найдено, повторная попытка через 500мс...');
    setTimeout(initSearch, 500); // пробуем снова через полсекунды
  }
}




















// ПЕРЕСОРТИРОВКА МАССИВА ОБЪЯВЛЕНИЙ 
if (sort__new) {
  sort__new.addEventListener('click', () => {
    const adsToSort = filteredAds.length ? filteredAds : globalAds;
    adsToSort.sort((a, b) => new Date(b.date) - new Date(a.date)); // сортируем по дате, от новых к старым
    renderAds(adsToSort)
  });
}

if (sort__old) {
  sort__old.addEventListener('click', () => {
    const adsToSort = filteredAds.length ? filteredAds : globalAds;
    adsToSort.sort((a, b) => new Date(a.date) - new Date(b.date)); // сортируем по дате, от старых к новым
    renderAds(adsToSort)
  });
}

if (sort__cheap) {
  sort__cheap.addEventListener('click', () => {
    const adsToSort = filteredAds.length ? filteredAds : globalAds;
    adsToSort.sort((a, b) => a.price - b.price); // сортируем по цене, от дешевых к дорогим
    renderAds(adsToSort)
  });
}

if (sort__expensive) {
  sort__expensive.addEventListener('click', () => {
    const adsToSort = filteredAds.length ? filteredAds : globalAds;
    adsToSort.sort((a, b) => b.price - a.price); // сортируем по цене, от дорогих к дешевым
    renderAds(adsToSort)
  });
}

// ФИЛЬТРАЦИЯ ПО ТЕГАМ
const applyButton = document.querySelector('.apply');
if (applyButton) {
  applyButton.addEventListener('click', () => {
    const selectedValues = [];
    const periodboxes = [];
    const deliveryboxes = [];

    const selectedValuess = document.querySelectorAll('input[name="tags"]:checked');
    if (selectedValuess.length === 0) {
      const allselectedValuess = document.querySelectorAll('input[name="tags"]');
      allselectedValuess.forEach(checkbox => {
        selectedValues.push(checkbox.value);
      });
    } else {
      selectedValuess.forEach(checkbox => {
        selectedValues.push(checkbox.value);
      });
    }
    
    const periodboxess = document.querySelectorAll('input[name="period"]:checked');
    if (periodboxess.length === 0) {
      const allperiodboxess = document.querySelectorAll('input[name="period"]');
      allperiodboxess.forEach(checkbox => {
        periodboxes.push(checkbox.value);
      });
    } else {
      periodboxess.forEach(checkbox => {
        periodboxes.push(checkbox.value);
      });
    }

    const deliveryboxess = document.querySelectorAll('input[name="delivery"]:checked');
    if (deliveryboxess.length === 0) {
      const alldeliveryboxess = document.querySelectorAll('input[name="delivery"]');
      alldeliveryboxess.forEach(checkbox => {
        deliveryboxes.push(checkbox.value);
      });
    } else {
      deliveryboxess.forEach(checkbox => {
        deliveryboxes.push(checkbox.value);
      });
    }

    let globalAds1 = [];
    selectedValues.forEach(value => {
      globalAds.forEach(ad => {
        if (ad.tags.includes(value)) {
          globalAds1.push(ad);
        }
      });
    });

    let globalAds2 = [];
    periodboxes.forEach(value => {
      globalAds1.forEach(ad => {
        if (ad.period.includes(value)) {
          globalAds2.push(ad);
        }
      });
    });

    let globalAds3 = [];
    deliveryboxes.forEach(value => {
      globalAds2.forEach(ad => {
        if (ad.delivery.includes(value)) {
          globalAds3.push(ad);
        }
      });
    });
    
    // Удаляем дубликаты (если объявление подходит под несколько тегов)
    globalAds3 = globalAds3.filter((ad, index, self) => 
      index === self.findIndex(a => a.id === ad.id)
    );
    
    filteredAds = [...globalAds3]; // сохраняем отфильтрованные объявления
    renderAds(globalAds3);
  });
}

// СБРОС ФИЛЬТРОВ
const resetButton = document.querySelector('.reset'); 
if (resetButton) {
  resetButton.addEventListener('click', () => {
    // Сбрасываем фильтры и поиск
    filteredAds = []; // очищаем отфильтрованные объявления
    if (inputField) {
      inputField.value = ''; // очищаем поле поиска
    }
    
    // Сбрасываем все чекбоксы
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
      checkbox.checked = false;
    });
    
    renderAds(globalAds);
  });
}