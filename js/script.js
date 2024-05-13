let accountBox = document.querySelector(".header .account-box");
let popup = document.getElementById('popup');

document.querySelector("#user-btn").onclick = () => {

    accountBox.classList.toggle('active')
    
}

function openPopup() {

    popup.classList.add('open-popup')

    
}

function closePopup() {

    popup.classList.remove('open-popup')

}


