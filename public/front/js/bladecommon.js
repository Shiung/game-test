//refresh token
function refreshToken(call_url){
  $.ajax({
    url:APP_URL + call_url,
    type : "GET",
    success:function(data){  
        
    }
  }); 
}

//refresh csrf token
function refreshCsrfToken(csrfToken){
    $.get(APP_URL +'/refresh-csrf').done(function(csrf){
        $('meta[name="csrf_token"]').attr('content',csrf);
    });
}

//系統ajax
function system_ajax(sendUri,sendData,sendType,exec_callback,fail_callback){

    $.ajax({
        url: sendUri,
        data: sendData,
        type: sendType,
        success: function(msg) {
           // console.log(msg);
            HoldOn.close();
            var data = JSON.parse(msg);
            if (data.result == 1) {
                swal({
                    title: "操作成功",
                    text: data.text,
                    type: "success",
                    confirmButtonText: "確認",
                },function(){
                  exec_callback(data)
                });

            } else {
                swal({
                    title: "操作失敗",
                    text: data.text,
                    type: "error",
                    confirmButtonText: "確認",
                },function(){
                  fail_callback(data)
                });
            }
        },
        beforeSend: function() {
            HoldOn.open({
                theme: 'sk-cube-grid',
                message: "<h4>Loading</h4>"
            });
        },
        error: function(xhr) {
            HoldOn.close();
            swal("Error", "系統發生錯誤，請聯繫工程人員", 'error');
            //console.log(xhr);
        }
    });
}

//系統ajax
function system_ajax_no_alert(sendUri,sendData,sendType,exec_callback,fail_callback){

    $.ajax({
        url: sendUri,
        data: sendData,
        type: sendType,
        success: function(msg) {
            //console.log(msg);
            HoldOn.close();
            var data = JSON.parse(msg);
            if (data.result == 1) {
                exec_callback(data)

            } else {
                swal({
                    title: "操作失敗",
                    text: data.text,
                    type: "error",
                    confirmButtonText: "確認",
                },function(){
                  fail_callback(data)
                });
            }
        },
        beforeSend: function() {
            HoldOn.open({
                theme: 'sk-cube-grid',
                message: "<h4>Loading</h4>"
            });
        },
        error: function(xhr) {
            HoldOn.close();
            swal("Error", "系統發生錯誤，請聯繫工程人員", 'error');
            //console.log(xhr);
        }
    });
}

//檢查元素是否在陣列裡
function checkElementInArray(array, element) {
    index = array.indexOf(element);
    if (index > -1) {
        return true;
    } else {
        return false;
    }
}