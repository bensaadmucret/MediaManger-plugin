// language javascript
// create function ajax methode post jquery


(function ($) {
    $(document).ready(function () {
        console.log("hello word");
        $('#form-ajax').submit(function (e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var data = $(this).serialize();
            $.post(url, data, function (response) {
                $('#form-ajax').html(response);
            });
        });
    })
})