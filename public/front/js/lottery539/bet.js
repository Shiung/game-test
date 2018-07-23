//取得下注單號資訊
function getSuccessAccountRecords(records,game_info=''){
    var content = game_info+'<table class="table"><thead><tr><th>單號</th><th>幣別</th><th>金額</th><th>時間</th></tr></thead>';  
    for (var key in records) {
        content += '<tr><td>'+records[key].bet_number+"</td><td>"+records[key].account_name+"</td><td>"+records[key].amount+'</td><td>'+records[key].created_at+'</td></tr>';
    };  
    content += '</table>'
    return content;    
}

//下注
function goBet(sendUri,sendData,game_info){

    $.ajax({
        url: sendUri,
        data: sendData,
        type: 'POST',
        success: function(msg) {
            HoldOn.close();
            var data = JSON.parse(msg);
            if (data.result == 1) {
                swal({
                    title: "下注成功!",
                    text: getSuccessAccountRecords(data.detail.records,game_info),
                    type: "success",
                    html:true,
                    confirmButtonText: "確認",
                },function(){
                    window.parent.location.reload();
                });

            } else {
                console.log(data.error_code)
                if(data.error_code == 'LINE_CHANGED'){
                    swal({
                        title: "賠率已改變！",
                        text: "請重新下注",
                        type: "warning",
                        confirmButtonText: "確認",
                    },function(){
                        window.parent.location.reload();
                    });
                } else if (data.error_code == 'INSUFFICIENT_BALANCE'){
                    swal({
                        title: "餘額不足",
                        text: "請前往儲值獲得更多金額",
                        type: "warning",
                        confirmButtonText: "確認",
                    });
                } else {
                    swal("Failed", data.text, 'error');
                }
                
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

//取得下注金額資料
function getBetAmount(t_cash,t_run,t_interest,t_right,account_data){
    cash = getRealBetAmount(t_cash);
    run = getRealBetAmount(t_run);
    interest = getRealBetAmount(t_interest);
    right = getRealBetAmount(t_right);

    var content =  '<p>'+account_data[1]['icon']+'<b>'+account_data[1]['name']+'：</b>'+numeral(cash).format('0,0')+'（餘額:'+numeral(account_data[1]['amount']).format('0,0')+'）</p>';
    content += '<p>'+account_data[3]['icon']+'<b>'+account_data[3]['name']+'：</b>'+numeral(right).format('0,0')+'（餘額:'+numeral(account_data[3]['amount']).format('0,0')+'）</p>';
    
    content += '<p>'+account_data[4]['icon']+'<b>'+account_data[4]['name']+'：</b>'+numeral(interest).format('0,0')+'（餘額:'+numeral(account_data[4]['amount']).format('0,0')+'）</p>';
    content += '<p>'+account_data[2]['icon']+'<b>'+account_data[2]['name']+'：</b>'+numeral(run).format('0,0')+'（餘額:'+numeral(account_data[2]['amount']).format('0,0')+'）</p>';
    return content;

}

//檢查金額
function checkBetAmount(t_cash,t_run,t_interest,t_right){
    cash = getRealBetAmount(t_cash);
    run = getRealBetAmount(t_run);
    interest = getRealBetAmount(t_interest);
    right = getRealBetAmount(t_right);

    if(cash == 0 && run == 0 && interest == 0 && right == 0){
        return false;
    } else {
        return true;
    }
}


//取得實際下注金額
function getRealBetAmount(amount){
    if(!amount){
        return 0;
    } else {
        return  parseInt(amount);
    }
}