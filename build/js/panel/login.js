$( "#loginbutton" ).click(function() {
       var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var email = $("#username").val();
        var password = $("#password-input").val();
        $.ajax({
          type: 'POST',
          url: '/login',
          data: {
            email: email,
            password: password,
              _token: csrfToken, // CSRF token'ını gönder
          },
          dataType: 'json',
          success: function (data) {
            console.log(data);
            if (data.success == 1) {
              window.location.href = "/"+data.redirectRoute; 
            } else {
                alert(data.message); 
            }
          }
      });
  });
