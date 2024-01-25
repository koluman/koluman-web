$("#loginbutton").click(function () {
    var email = $("#username").val();
    var password = $("#password-input").val();
    $.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/login',
        data: {
            email: email,
            password: password,
        },
        dataType: 'json',
        success: function (data) {
          console.log(data);
            /*if (data.success == 1) {
                window.location.href = "https://mobiloby.app/koluman/web/" + data.redirectRoute;
            } else {
                alert(data.message);
            }*/
        }

    });
});
