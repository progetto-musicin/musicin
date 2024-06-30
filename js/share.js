document.addEventListener('DOMContentLoaded', function() {
    const copyButtons = document.querySelectorAll('.copy-link-btn');

    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const link = this.getAttribute('data-link');

            navigator.clipboard.writeText(link).then(() => {
                alert('Link copiato negli appunti!');
            }).catch(err => {
                console.error('Errore nel copiare il link: ', err);
            });
        });
    });
});
