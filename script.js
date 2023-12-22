document.addEventListener('DOMContentLoaded', function () {
    var buttonComment = document.getElementById('showComment');
    var divComment = document.getElementById('commentaire');

    buttonComment.addEventListener('click', function () {
        if (divComment.style.display === "block") {
            divComment.style.display = "none";
        } else {
            divComment.style.display = "block";
        }
    });

    var bouttonPagePrecedente = document.getElementById('retourPagePrecedente')

    bouttonPagePrecedente.addEventListener('click', function () {
        retourPagePrecedente();
    })
    function retourPagePrecedente() {
        // Récupérer l'URL de la page précédente
        var pagePrecedente = document.referrer;

        // Rediriger vers la page précédente
        window.location.href = pagePrecedente;
    }
});
