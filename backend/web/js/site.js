$(function () {

    $(".confirm-btn").click('on', function () {
        let value = prompt('Сколько яблок сгенерировать?', 1);

        $.ajax({
            method: "POST",
            url: $(this).data('href'),
            data: {
                size: parseInt(value)
            },
            success: function (data) {
                console.log(data);
                if (data) window.location.href = data;
            }
        })
    })

})