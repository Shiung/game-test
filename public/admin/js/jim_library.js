/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//系統ajax
function system_ajax(sendUri,sendData,sendType,exec_callback,fail_callback){
    $.ajax({
        url: sendUri,
        data: sendData,
        type: sendType,
        success: function(msg) {
         
            HoldOn.close();
            var data = JSON.parse(msg);
            console.log(msg);
            if (data.result == 1) {
                swal({
                        title: "Success!",
                        text: data.text,
                        type: "success",
                        confirmButtonText: "確認",
                    },function(){
                    exec_callback(data)
                    });

            } else {
                //fail_callback(data)
                swal("Failed", data.text, 'error');
            }
        },
        beforeSend: function() {
            //顯示搜尋動畫
            HoldOn.open({
                theme: 'sk-cube-grid',
                message: "<h4>系統處理中，請勿關閉視窗</h4>"
            });
        },
        error: function(xhr) {
            HoldOn.close();
            swal("Error", "系統發生錯誤，請聯繫工程人員", 'error');
            console.log(xhr);
        }
    });
}

//成功訊息自動fadeout ajax
function auto_fadeout_ajax(sendUri,sendData,sendType,successDiv){
    $.ajax({
        url: sendUri,
        data: sendData,
        type: sendType,
        success: function(msg) {

            HoldOn.close();
            var data = JSON.parse(msg);
            if (data.result == 1) {
                //成功訊息fade out
                $("."+successDiv).fadeIn(1000, function(){
                    $(this).fadeOut(4000); 
                });

            } else {
                swal("Failed", data.text, 'error');
            }
        },
        beforeSend: function() {
            //顯示搜尋動畫
            HoldOn.open({
                theme: 'sk-cube-grid',
                message: "<h4>系統處理中，請勿關閉視窗</h4>"
            });
        },
        error: function(xhr) {
            HoldOn.close();
            swal("Error", "系統發生錯誤，請聯繫工程人員", 'error');
            console.log(xhr);
        }
    });
}

function dateValidationCheck(dateString) {
    var regEx = /^\d{4}-\d{2}-\d{2}$/;
    if(!dateString.match(regEx)) {
      return false;
    } else {
      return true;
    }
 
}
