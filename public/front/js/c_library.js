function createSms(url,element,phone){
    if(!phone){
        phone = 'default';
    } 
    $.ajax({
        url: url + "/verify/sms-create",
        data: {phone:phone},
        type: "POST",
        success: function(msg) {
            HoldOn.close();
            var data = JSON.parse(msg);
            console.log(data)
            if (data.result == 1) {
                element.val(data.id);
            } else {
                element.val(data.id);
            }
        },
        beforeSend: function() {
            //顯示搜尋動畫
            HoldOn.open({
                theme: 'sk-cube-grid',
                message: "<h4>簡訊碼寄出中，請勿關閉視窗</h4>"
            });
        },
        error: function(xhr) {
            console.log(xhr)
            HoldOn.close();
  
        }
    });
}


function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}