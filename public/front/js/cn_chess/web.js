//點擊籌碼
$(".chip").click(function(){
	$('#bet_chip .chip').removeClass('circle_active'+chip);
	$('#bet_chip .chip').addClass('circle');
    $('#bet_chip .bet-bg').addClass('display');
    $('#bet_chip .bet-select').removeClass('display');
	chip = $(this).data('type');
    $(this).addClass('circle_active'+chip);
    $(this).removeClass('circle');
    $(this).children('.bet-select').addClass('display');
    $(this).children('.bet-bg').removeClass('display');
});

//點擊金額
$(".investment").click(function(){
	//$('#bet_investment .investment').removeClass('circle_active');
	//$('#bet_investment  .investment').addClass('circle');
    $('#bet_investment .bet-bg').addClass('display');
    $('#bet_investment .bet-select').removeClass('display');
	amount = $(this).data('amount');
	investment = parseInt(amount);
    //$(this).addClass('circle_active');
    //$(this).removeClass('circle');
    $(this).children('.bet-select').addClass('display');
    $(this).children('.bet-bg').removeClass('display');
});

//點擊取消投注時，清空盤面上的資料
function emptyCheckboard(){
    bet_arr = {};
    //金幣動畫清除
    $('.bet_ani_1').remove();
    $('.bet_ani_2').remove();
    $('.bet_ani_3').remove();
    $('.bet_ani_4').remove();
    //投注額清除
    $('div[id^=chip_area_]').css('display','none'); 
    //取消點擊確認投注
    $('#confirm_bet_0').css('display','block'); 
    $('#confirm_bet').css('display','none'); 
    //取消點擊取消投注
    $('#cancel_bet_0').css('display','block'); 
    $('#cancel_bet').css('display','none'); 
}

//籌碼加到棋子上
function addChipToCheckerboard(number){	

	//alert('象棋div：'+'#chess_'+number+'_chips'+'\n'+'幣別：'+chip_arr[chip]+'  代號：'+chip+'\n'+'選擇的象棋代號：'+number+'\n'+'籌碼金額('+investment_name[investment]+')：'+investment+'\n'+'該幣別下注幾次：'+bet_arr[number][chip]['detail'][investment]+'\n'+'該幣別下注總額：'+bet_arr[number][chip]['total'])
	
    
     document.getElementById('chip_area_'+number+'_'+chip).style.display='block'; 
    document.getElementById('mount_'+number+'_'+chip).innerHTML=bet_arr[number][chip]['total'];
    
    
    //增加籌碼動畫
    var betAniDiv = document.createElement('div');
    var betAbiPosition = document.getElementById('chess_'+number);
    betAniDiv.className = 'bet_ani_'+bet_arr[number][chip]['detail'][investment];
    $(betAniDiv).insertAfter(betAbiPosition);
    
    
    
    
    
    
	/*console.log('這次選擇的象棋代號：'+number)
	console.log('象棋div：'+'#chess_'+number+'_chips')
	console.log('幣別：'+chip_arr[chip]+'  代號：'+chip);
	console.log('幣別籌碼單一圖片：'+chip+'_'+investment_to_id[investment]+'.png');
	console.log('幣別籌碼多個圖片：'+chip+'_'+investment_to_id[investment]+'_multi.png');
	console.log('籌碼金額：'+investment);
	console.log('籌碼名稱：'+investment_name[investment]);
	console.log('該幣別下注幾次：'+bet_arr[number][chip]['detail'][investment]);
	console.log('該幣別下注總額：'+bet_arr[number][chip]['total']);
	console.log('=====此象棋選項細目=====');
	console.log(bet_arr[number]);*/
	for(var i=1;i<5;i++ ){
		//console.log(chip_arr[i]+'細目');
		//console.log('總額：'+bet_arr[number][i]['total']);
		for(key in bet_arr[number][i]['detail']){
			console.log(key+'(籌碼上面要顯示的名字：'+investment_name[key]+') 下注次數：'+bet_arr[number][i]['detail'][key])
			if(bet_arr[number][i]['detail'][key] >3){
				//下注次數多於三次
				//console.log('應該用的圖片：'+i+'_'+investment_to_id[key]+'_multi.png');
			} else {
				//下注次數三次以下
				//console.log('應該用的圖片：'+i+'_'+investment_to_id[key]+'.png');
			}
		}
		console.log('=============');
	}

}


//下注
function goBet(sendUri,sendData,game_info){

    $.ajax({
        url: sendUri,
        data: sendData,
        type: 'POST',
        success: function(msg) {
            
            var data = JSON.parse(msg);
            if (data.result == 1) {
                HoldOn.close();
                loading = 0;
                swal({
                    title: "下注成功!",
                    text: getSuccessAccountRecords(data.detail.records,game_info),
                    type: "success",
                    html:true,
                    confirmButtonText: "確 認",
                },function(){
                    emptyCheckboard()
                });

            } else {
                console.log(data.error_code)
                if (data.error_code == 'INSUFFICIENT_BALANCE'){
                    HoldOn.close();
                    loading = 0;
                    member_info = '<table class="table"><tr style="border-top:2px solid #3c0000;border-bottom: 2px solid #3C0000;"><td>姓名</td><td>'+data.member_info.member_name+"</td><td>級別</td><td>"+data.member_info.level+'</td></tr><tr style="border-bottom: 2px solid #3C0000;"><td>帳號</td><td>'+data.member_info.username+"</td><td>ID</td><td>"+data.member_info.member_number+"</td></tr></table>";
                	account_info = '<div style="width:100%;height:2px; background-color:#3C0000;margin-bottom:3px;"></div><table style="width:100%;"><tr><td style="width:50%;"><div class="sweet-gold">'+numeral(data.account_info.cash).format('0,0')+'</div></td><td style="width:50%;"><div class="sweet-ulg">'+numeral(data.account_info.right).format('0,0')+'</div></td></tr><tr><td style="width:50%;"><div class="sweet-red">'+numeral(data.account_info.interest).format('0,0')+'</div></td><td style="width:50%;"><div class="sweet-gift">'+numeral(data.account_info.run).format('0,0')+'</div></td></tr></table><div style="width:100%;height:2px; background-color:#3C0000;margin-top:3px;margin-bottom:3px;"></div>';
                    deposit_link = '<div class="deposit-link" onclick="go_to_deposit();"></div>';
                    swal({
                        title: "餘額不足",
                        text: "<h4>請前往儲值更多金額</h4>"+account_info+deposit_link,
                        type: "error",
                        html:true,
                        confirmButtonText: "確 認",
                    });
                } else if(data.error_code == 'WRONG_TOKEN' || data.error_code == 'EXPIRED_TOKEN'){
                    $.ajax({
                        url:APP_URL + '/member-token',
                        type : "GET",
                        success:function(data){  
                            console.log(data)
                            goBet(sendUri,sendData,game_info);
                        }
                    }); 
                } else if(data.error_code == 'C_TOKEN_WRONG'){
                    $.get(APP_URL +'/refresh-csrf').done(function(csrf){
                        $('#_token').val(csrf);
                        sendData['_token'] = csrf;
                        goBet(sendUri,sendData,game_info);
                    });
                } else if(!data.error_code){
                    HoldOn.close();
                    loading = 0;
                } else {
                    HoldOn.close();
                    loading = 0;
                    swal("Failed", data.text, 'error');
                }
                
            }
        },
        beforeSend: function() {
            if(loading == 0){
                //顯示搜尋動畫
                HoldOn.open({
                    theme: 'sk-cube-grid',
                    message: "<h4>系統處理中，請勿關閉視窗</h4>"
                });
                loading = 1;
            }
        },
        error: function(xhr) {
            HoldOn.close();
            swal("Error", "系統發生錯誤，請聯繫工程人員", 'error');
            console.log(xhr);
        }
    });
}