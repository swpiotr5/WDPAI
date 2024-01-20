// Pobierz wszystkie divy z avatarami
const avatarDivs = document.querySelectorAll('.avatars .avatar');

// Dodaj zdarzenie click do każdego diva
avatarDivs.forEach(div => {
    div.addEventListener('click', function() {
        // Pobierz URL obrazka
        let imgSrc = this.querySelector('img').src;
        imgSrc = imgSrc.replace('http://localhost:8080', '');
        // Wyślij żądanie fetch
        fetch('/updateAvatar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ avatar: imgSrc }),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                } else {
                    // Sprawdź, czy odpowiedź nie jest pusta
                    if (response.headers.get('content-length') > 0) {
                        return response.json();
                    } 
                }
            })
            .then(data => {
                // Assuming data is a JSON object
                // Handle the data as needed
                console.log(data);
                window.location.reload();
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    });
});