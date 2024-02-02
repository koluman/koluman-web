document.addEventListener("DOMContentLoaded", function () {
    getshowroom();
    getapiusers();
    $("#appointment_date").change(function () {
        function getdate() {
            // Seçilen tarihi al
            var selectedDate = $("#appointment_date").val();
            var selectedCar = $("#car_id").val();
            $.ajax({
                type: 'POST',
                url: 'https://mobiloby.app/koluman/web/testdriveschedules',
                data: {
                    selectedDate: selectedDate,
                    selectedCar,
                    selectedCar,
                    _token: csrfToken, // CSRF token'ını gönder
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success == 1) {
                       /* var option = "<option value='0'>Lütfen Seçim Yapınız</option>";
                        // Tüm saatleri döngüye al ve dolu olanları işaretle
                        var allTimes = ["09:00", "09:30", "10:00", "10:30", "11:00", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00"];
        
                        for (var i = 0; i < allTimes.length; i++) {
                            var time = allTimes[i];
                            var isTimeOccupied = data.schedules.some(schedule => schedule.appointment_time === time);
        
                            if (isTimeOccupied) {
                                option += "<option value='" + time + "'>" + time + "</option>";
                            } else {
                                option += "<option value='" + time + "'>" + time + "</option>";
                            }
                        }
                        console.log(option);
                        $('#appointment_time').html('');
                        $('#appointment_time').html(option);*/
                        var choicesArray = [];
                        // Tüm saatleri döngüye al ve dolu olanları işaretle
                        var allTimes = ["09:00", "09:30", "10:00", "10:30", "11:00", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00"];
    
                        for (var i = 0; i < allTimes.length; i++) {
                            var time = allTimes[i];
                            var isTimeOccupied = data.schedules.some(schedule => schedule.appointment_time === time);
    
                            var choice = {
                                value: time,
                                label: time,
                                disabled: isTimeOccupied
                            };
    
                            choicesArray.push(choice);
                        }
                        console.log(choicesArray);
                        eventCategoryChoice3.clearChoices();
                        eventCategoryChoice3.setChoices(choicesArray, 'value', 'label', true);
                   
                 
        
                    }
        
                }
            });
        };
    });
});

var csrfToken = $('meta[name="csrf-token"]').attr('content');

function getshowroom() {
    $.ajax({
        type: 'GET',
        url: 'https://mobiloby.app/koluman/web/getshowroomcars',
        dataType: 'json',
        success: function (data) {
            if (data.success == 1) {
                var option = "<option value='0'>Lütfen Seçim Yapınız</option>";
                for (i = 0; i < data.showroomcars.length; ++i) {
                    option += "<option value='" + data.showroomcars[i]["car_id"] + "'>" + data.showroomcars[i]["car_name"] + "</option>";

                }
                $('#car_id').html('');
                $('#car_id').html(option);
            }
        }
    });
}

function getapiusers() {
    $.ajax({
        type: 'POST',
        url: 'https://mobiloby.app/koluman/web/getapiusers',
        data: {
            _token: csrfToken, // CSRF token'ını gönder
        },
        dataType: 'json',
        success: function (data) {
            if (data.success == 1) {
                var option = "<option value='0'>Lütfen Seçim Yapınız</option>";
                for (i = 0; i < data.usersall.length; ++i) {
                    option += "<option value='" + data.usersall[i]["user_id"] + "'>" + data.usersall[i]["user_name"] + "</option>";
                }
                $('#user_id').html('');
                $('#user_id').html(option);
            }

        }
    });

}
