document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('showComment')) {
        var buttonComment = document.getElementById('showComment');
        var divComment = document.getElementById('commentaire');

        buttonComment.addEventListener('click', function () {
            if (divComment.style.display === "block") {
                divComment.style.display = "none";
            } else {
                divComment.style.display = "block";
            }
        });
    }
    if (document.getElementById('password')) {
        // Fonction pour basculer la visibilité du mot de passe
        function togglePasswordVisibility(passwordInputId) {
            var passwordInput = document.getElementById(passwordInputId);

            // Change le type de l'input entre "password" et "text"
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }

        // Ajout d'un gestionnaire d'événement pour chaque bouton œil
        document.querySelectorAll('.showPasswordButton').forEach(function (button) {
            button.addEventListener('click', function () {

                var passwordInputId = button.previousElementSibling.id;
                togglePasswordVisibility(passwordInputId);
            });
        });
    }


});