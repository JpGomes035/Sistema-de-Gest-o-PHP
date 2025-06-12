document.getElementById('contactForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('send_email.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('response').innerText = data;
        document.getElementById('contactForm').reset();
    })
    .catch(error => {
        document.getElementById('response').innerText = 'Ocorreu um erro ao enviar o e-mail.';
        console.error('Error:', error);
    });
});
