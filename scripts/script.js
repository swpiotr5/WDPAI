let loginButton = document.getElementById('loginButton');
let registerButton = document.getElementById('registerButton');

loginButton.onclick = function () {
	document.querySelector('#flipper').classList.toggle('flip');
};

registerButton.onclick = function () {
	document.querySelector('#flipper').classList.toggle('flip');
};
