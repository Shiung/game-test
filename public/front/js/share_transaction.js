//取得操作成功標題
function getSuccessTitle(success_type){
    switch(success_type) {
        case 'company_buy':
            return '交易成功'
            break;
        case 'member_buy':
            return '交易成功'
            break;
        case 'sell':
            return '上架成功'
            break;
    } 
}
//取得操作成功資訊導向
function getSuccessMessage(quantity,total,success_type,info={}){
    switch(success_type) {
        case 'company_buy':
            return companyMessage(quantity,total)
            break;
        case 'member_buy':
            return memberMessage(quantity,total)
            break;
        case 'sell':
            return sellMessage(quantity,total,info)
            break;
    } 
}

//跟公司購買娛樂幣成功資訊
function companyMessage(quantity,total){
    var content = '<hr style="border-top:2px solid #B0B0B0; margin-top:5px; margin-bottom:5px;"><div class="success-unit">'+toThousands(quantity)+'</div><div class="success-price"><div class="success-price-icon"></div><div class="success-price-info">'+(total/quantity)+'</div></div><hr style="border-top:2px solid #B0B0B0; margin-top:5px; margin-bottom:5px;"><div class="check-coin-use"><div class="check-coin-use-icon"></div>－'+toThousands(total)+'</div>';  
    return content;    
}

//跟會員購買娛樂幣成功資訊
function memberMessage(quantity,total){
    var content = '<hr style="border-top:2px solid #B0B0B0; margin-top:5px; margin-bottom:5px;"><div class="success-unit">'+toThousands(quantity)+'</div><div class="success-price"><div class="success-price-icon"></div><div class="success-price-info">'+(total/quantity)+'</div></div><hr style="border-top:2px solid #B0B0B0; margin-top:5px; margin-bottom:5px;"><div class="check-coin-use"><div class="check-coin-use-icon"></div>－'+toThousands(total)+'</div>';  
    return content;    
}

//掛賣成功資訊
function sellMessage(quantity,total,info){
    var content = '<hr style="border-top:2px solid #B0B0B0; margin-top:5px; margin-bottom:5px;"><div class="success-unit">'+toThousands(quantity)+'</div><div class="success-price"><div class="success-price-icon"></div><div class="success-price-info">'+(total/quantity)+'</div></div><hr style="border-top:2px solid #B0B0B0; margin-top:5px; margin-bottom:5px;"><p style="color: #E60B35; margin-top:10px;">★交易成功將會收取'+info['fee_percent']+'% 手續費用</p><p style="color: #E60B35;">★成功上架後'+info['expire_day']+'日到期系統自動下架</p>';  
    return content;    
}

//餘額不足警示內容
function getInsufficientMessage(type){
    switch(type) {
        case 'company_buy':
            return cashInsufficientMessage()
            break;
        case 'member_buy':
            return cashInsufficientMessage()
            break;
        case 'sell':
            return shareInsufficientMessage()
            break;
    } 
}

//現金不足
function cashInsufficientMessage(){
    swal({
        title: "購買交易失敗",
        text: '<hr style="border-top:2px solid #B0B0B0; margin-top:5px; margin-bottom:5px;"><div class="cancel-alert-title">\\ 注意 /</div><div class="cancel-alert-info">輸入錯誤或餘額不足</br>請再次確認</br>或前往商城儲值購買</div>',
        html:true,
        type: "warning",
        confirmButtonText: "確認",
    }); 
}

//娛樂幣不足
function shareInsufficientMessage(){
    swal({
        title: "購買交易失敗",
        text: '<hr style="border-top:2px solid #B0B0B0; margin-top:5px; margin-bottom:5px;"><div class="cancel-alert-title">\\ 注意 /</div><div class="cancel-alert-info">輸入錯誤或餘額不足</br>請再次確認</br>或前往商城儲值購買</div>',
        html:true,
        type: "warning",
        confirmButtonText: "確認",
    }); 
}

//操作確認
function shareTransactionConfirm(sendUri,sendData,quantity,total,success_type,info={}){

    $.ajax({
        url: sendUri,
        data: sendData,
        type: 'POST',
        success: function(msg) {
            
            HoldOn.close();
            var data = JSON.parse(msg);
            if (data.result == 1) {
                swal({
                    title: getSuccessTitle(success_type),
                    text: getSuccessMessage(quantity,total,success_type,info),
                    type: "success",
                    html:true,
                    confirmButtonText: "確認",
                },function(){
                    window.parent.location.reload();
                });

            } else {
                if (data.error_code == 'INSUFFICIENT_BALANCE'){
                    getInsufficientMessage(success_type)
                } else {
                    swal("Failed", data.error_msg, 'error');
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

//千份位
function toThousands(num) {
    var num = parseInt(num);
    num = (num || 0).toString(), result = '';
    while (num.length > 3) {
        result = ',' + num.slice(-3) + result;
        num = num.slice(0, num.length - 3);
    }
    if (num) { result = num + result; }
    return result;
}

