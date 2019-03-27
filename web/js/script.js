
$(document).ready(function() {
    $('.delete_form').on('beforeSubmit', function (e) {
        return confirm('Подтвердите удаление');
    });
});


