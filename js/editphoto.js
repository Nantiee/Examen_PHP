$(document).ready(function() {
    $(".photo_preview").click(function () {
        $("#edit_photo").trigger('click');
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.photo_preview').css('background-image', 'url('+e.target.result+')');
                pValid = '<p class="valid">Votre profil a été mis jour !</p>';
                function divers(){};
                jacqueline(1000, pValid, celuila, divers);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#edit_photo").change(function(){
        readURL(this);
        celuila = $('#edit-profil input[type=submit]');
        celuila.hide();
    });

     $('#edit_photo').fileupload({
        dataType: 'json',
        url: 'inc/photo.inc.php',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                // $('<p/>').text(file.name).appendTo(document.body);
            });
        }
    });



});