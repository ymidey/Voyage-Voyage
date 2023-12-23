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


});
