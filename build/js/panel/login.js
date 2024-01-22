$( "#loginbutton" ).click(function() {
       var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var email = $("#username").val();
        var password = $("#password-input").val();
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
                alert(data.message); 
            }
          }
      });
  });
  
function logout() {

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/logout',
        data: {
            _token: csrfToken, // CSRF token'ını gönder
        },
        dataType: 'json',
        success: function (data) {
          if (data.success == 1) {
            window.location.href = "https://mobiloby.app/koluman/web/"; 
          } else {
              alert(data.message); 
          }
        }
    });
  }