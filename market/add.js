const store = document.querySelector('.table .store'); 



const sort__new = document.querySelector('.table .table__header .search_sistem .sort__box .sort-new');
const sort__old = document.querySelector('.table .table__header .search_sistem .sort__box .sort-old');
const sort__cheap = document.querySelector('.table .table__header .search_sistem .sort__box .sort-cheap');
const sort__expensive = document.querySelector('.table .table__header .search_sistem .sort__box .sort-expensive');

let globalAds = []; // ← создай переменную здесь

async function getAds() {
  const response = await fetch('ads.php');
  const ads = await response.json(); // ads - массив всех объявлений. последный элемент стал первым
  globalAds = ads; // ← сохрани в глобальную переменную

  ads.forEach(ad => {

    // СОЗДАЕМ ССЫЛКУ-ОБЕРТКУ
    let link = document.createElement("a");
    link.href = `ad.php?id=${ad.id}`;  // ← id из базы данных
    link.target = "_self ";            // ← открывать в новой вкладке (можно изменить на "_blank", если хочешь открывать в новой вкладке)
    link.style.textDecoration = "none";
    link.style.color = "inherit";
    link.style.display = "block";      // ← чтобы ссылка занимала весь блок
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
}






async function renderAds(a){
  let store = document.querySelector('.table .store');
  store.remove();
  let newStore = document.createElement("div");
  newStore.classList.add("store");
  document.querySelector('.table').append(newStore);

  
  a.forEach(ad => {

    // СОЗДАЕМ ССЫЛКУ-ОБЕРТКУ
    let link = document.createElement("a");
    link.href = `ad.php?id=${ad.id}`;  // ← id из базы данных
    link.target = "_blank";            // ← открывать в новой вкладке
    link.style.textDecoration = "none";
    link.style.color = "inherit";
    link.style.display = "block";      // ← чтобы ссылка занимала весь блок
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

getAds();






// ПЕРЕСОРТИРОВКА МАССИВА ОБЪЯВЛЕНИЙ 
sort__new.addEventListener('click', () => {
  globalAds.sort((a, b) => new Date(b.date) - new Date(a.date)); // сортируем по дате, от новых к старым
  renderAds(globalAds)
});
sort__old.addEventListener('click', () => {
  globalAds.sort((a, b) => new Date(a.date) - new Date(b.date)); // сортируем по дате, от старых к новым
  renderAds(globalAds)
});
sort__cheap.addEventListener('click', () => {
  globalAds.sort((a, b) => a.price - b.price); // сортируем по цене, от дешевых к дорогим
  renderAds(globalAds)
});
sort__expensive.addEventListener('click', () => {
  globalAds.sort((a, b) => b.price - a.price); // сортируем по цене, от дорогих к дешевым
  renderAds(globalAds)
});



const applyButton = document.querySelector('.apply');
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
  }else{
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
  }else{
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
  }else{
    deliveryboxess.forEach(checkbox => {
      deliveryboxes.push(checkbox.value);
    });
  }










  globalAds1 = [];
  selectedValues.forEach(value => {// фильтруем массив объявлений, чтоб в нем остались только те, у которых есть хотя бы один тег из выбранных
    globalAds.forEach(ad => {
      if (ad.tags.includes(value)){
        globalAds1.push(ad);
      }
    });
  });

  globalAds2 = [];
  periodboxes.forEach(value => {// фильтруем массив объявлений, чтоб в нем остались только те, у которых есть хотя бы один тег из выбранных
    globalAds1.forEach(ad => {
      if (ad.period.includes(value)){
        globalAds2.push(ad);
      }
    });
  });

  globalAds3 = [];
  deliveryboxes.forEach(value => {// фильтруем массив объявлений, чтоб в нем остались только те, у которых есть хотя бы один тег из выбранных
    globalAds2.forEach(ad => {
      if (ad.delivery.includes(value)){
        globalAds3.push(ad);

      }
    });
  });
 // сохраняем отфильтрованный массив в глобальную переменную, чтобы при сортировке сортировались только отфильтрованные объявления
  renderAds(globalAds3);

});


const resetButton = document.querySelector('.reset'); 
const tags__btn = document.querySelector('.table .table__header .search_sistem .tags__box');
resetButton.addEventListener('click', () => {
  renderAds(globalAds);
});


