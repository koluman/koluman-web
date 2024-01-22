$( "#loginbutton" ).click(function() {
    var gelen=false;
    var gelen=validation();

    if(gelen==true){
       var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var email = $("#email").val();
        var password = $("#password").val();
        $.ajax({
          type: 'POST',
          url: 'https://mobiloby.app/koluman/web/login',
          data: {
            email: email,
            password: password,
              _token: csrfToken, // CSRF token'ını gönder
          },
          dataType: 'json',
          success: function (data) {
            if (data.success == 1) {
              window.location.href = "https://mobiloby.app/koluman/web/"+data.redirectRoute; 
            } else {
                alert(data.message); // SMS gönderimi başarısızsa kullanıcıya bir uyarı göster
            }
          }
      });
    
    }
  });
