$(function() {
    // Used to display PDF in modal
    $('#material-list').on('click', '#preview-link', function() {
        $('#preview-frame').attr('src', $('#preview-link').data('src'));
        // console.log($('#preview-frame').attr('src'));
    });
});