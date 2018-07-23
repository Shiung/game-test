var investment = 0;//下注金額
var chip = '1';//幣別籌碼
var chess_number = 'N';//選擇的象棋代碼
var bet_arr = {};
//幣別籌碼代碼對照
var chip_arr = {'1':'金','2':'禮','3':'娛','4':'紅'};
var investment_name = {};
var investment_to_id = {};
var bet_checkerboard = $('#bet_checkerboard');
var loading = 0;
//象棋
var chess_code_to_name = {
    'car':'車',
    'rook':'俥',
    'king':'將帥',
    'horse':'馬',
    'guard':'士',
    'advisor':'仕',
    'knight':'傌',
    'bag':'包',
    'canoon':'砲',
    'elephant':'象',
    'minister':'相',
    'black':'黑',
    'red':'紅',
};

//千轉K
function nFormatter(num) {
     if (num >= 1000000000) {
        return (num / 1000000000).toFixed(1).replace(/\.0$/, '') + 'G';
     }
     if (num >= 1000000) {
        return (num / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
     }
     if (num >= 1000) {
        return (num / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
     }
     return num;
}
//檢查物件是否為空
function isEmpty(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}

$(function(){

	//設置籌碼名稱
	config_data = JSON.parse($('#config_data').val());
	investment_name = config_data.investment_name;
	investment_to_id = config_data.investment_to_id;
	investment = parseInt(config_data.first_investment);


	//取消投注
	$("#cancel_bet").click(function(){
		bet_arr = {};
		$('#confirm_bet').attr('disabled', true);
		emptyCheckboard();
	});

	//確認投注
	$("#confirm_bet").click(function(){
		//檢查是否有先選擇選項
		if(isEmpty(bet_arr)){
			swal("Failed", '您尚未投注任何籌碼', 'error');
		}

        swal({
            title: '下注確認',
            text: getBetData(),
            type: 'warning',
            html:true,
            closeOnConfirm: true ,
            cancelButtonText: '取 消',
            confirmButtonText: '確 認',
            showCancelButton: true,
        },function(isConfirm){
            if (isConfirm) {

                $.ajax({
                    url: "/SSE/balance",
                }).done(function(data) {
                    var balance = JSON.parse(data)
                    //console.log(balance);
        
                    if(page_mode == 'web'){
                        $("#virtual_cash").html(balance['virtual_cash']);
                        $("#manage").html(balance['manage']);
                        $("#share").html(balance['share']);
                        $("#interest").html(balance['interest']);
                    } else {
                        $("#virtual_cash").html(nFormatter(balance['virtual_cash']));
                        $("#manage").html(nFormatter(balance['manage']));
                        $("#share").html(nFormatter(balance['share']));
                        $("#interest").html(nFormatter(balance['interest']));
                    }
                });

                sendUri = APP_URL + "/game/cn_chess/bet";
                sendData = {'sport_id':$('#sport_id').val(),'records':bet_arr,'_token':$('#_token').val()};
                goBet(sendUri,sendData);
            } 
            
        });

		
		
	});

    //取得下注內容
    function getBetData(){
        sport_number = $('#sport_number').text();
        s_arr = sport_number.split('-');
        var content = '<table class="table"><tr><td style="border-top:2px solid #3C0000; border-bottom:2px solid #3C0000; border-right:1px solid #3C0000;">期別</td><td style="border-top:2px solid #3C0000; border-bottom:2px solid #3C0000; border-right:1px solid #3C0000;">幣別</td><td style="border-top:2px solid #3C0000; border-bottom:2px solid #3C0000; border-right:1px solid #3C0000;">下注棋</td><td style="border-top:2px solid #3C0000; border-bottom:2px solid #3C0000;">金額</td></tr>';
        for (var key in bet_arr) {
            chess_item = bet_arr[key];
            for(var i=1;i<5;i++ ){
                if(chess_item[i]['total'] > 0){
                    content += '<tr><td style="vertical-align:middle; border-bottom:1px solid #3C0000; border-right:1px solid #3C0000;">'+s_arr[1]+'</td><td style="vertical-align:middle; border-bottom:1px solid #3C0000; border-right:1px solid #3C0000;"><div class="check_'+i+'"></div></td><td style="vertical-align:middle; border-bottom:1px solid #3C0000; border-right:1px solid #3C0000;"><div class="check_chess chess_'+key+'"></div></td><td style="vertical-align:middle; border-bottom:1px solid #3C0000;">'+numeral(chess_item[i]['total']).format('0,0')+'</td></tr>';
                }
            }
        }; 
        content += '</table>';
        return content;
    }

	//點擊棋子
    bet_checkerboard.on("click", ".chess", function(e) {

        e.preventDefault();
        
        //開放點擊確認投注及取消投注
        //$('#confirm_bet').attr('disabled', false);
        $('#confirm_bet_0').css('display','none'); 
        $('#confirm_bet').css('display','block'); 
        $('#cancel_bet_0').css('display','none'); 
        $('#cancel_bet').css('display','block');
        
		chip_data = {'1':{"total":0,"detail":{} },'2':{"total":0,"detail":{} },'3':{"total":0,"detail":{} },'4':{"total":0,"detail":{} }};
		number = $(this).data('number');
	    if(bet_arr.hasOwnProperty(number)){
	    	//棋子跟幣別都在物件裡
    		total = bet_arr[number][chip]['total'];
    		total = total+investment;
    		bet_arr[number][chip]['total'] = total;
    		//籌碼是否第一次新增
	    	if(bet_arr[number][chip]['detail'].hasOwnProperty(investment) ){
	    		investment_count = bet_arr[number][chip]['detail'][investment];
	    		investment_count = investment_count +1;
	    		bet_arr[number][chip]['detail'][investment] = investment_count;
	    	} else {
	    		//籌碼第一次新增
	    		investment_data = bet_arr[number][chip]['detail'];
	    		investment_data[investment] = 1;
	    		bet_arr[number][chip]['detail'] = investment_data;
	    	}
	    } else {

	    	//棋子第一次新增
	    	chip_data[chip]['total'] = investment;
	    	bet_arr[number] = chip_data;
	    	//細目
	    	chip_data[chip]['detail'][investment] = 1; 

	    }
	    addChipToCheckerboard(number)
	});
});


//取得下注單號資訊
function getSuccessAccountRecords(records,game_info=''){
    var content = game_info+'<table class="table" style="text-align:center;"><thead><tr><th style="text-align:center; vertical-align:middle; border-top:2px solid #3C0000; border-bottom:2px solid #3C0000; border-right:1px solid #3C0000;">幣別</th><th style="text-align:center; vertical-align:middle; border-top:2px solid #3C0000; border-bottom:2px solid #3C0000; border-right:1px solid #3C0000;">時間/單號</th><th style="text-align:center; vertical-align:middle; border-top:2px solid #3C0000; border-bottom:2px solid #3C0000;">金額</th></tr></thead>';  
    for (var key in records) {
        content += '<tr><td rowspan="2" style="vertical-align:middle; border-bottom:1px solid #3C0000; border-right:1px solid #3C0000;"><div class="'+records[key].account_name+'"></div></td><td style="vertical-align:middle; border-bottom:1px solid #3C0000; border-right:1px solid #3C0000;">'+records[key].created_at+'</td><td rowspan="2" style="vertical-align:middle; border-bottom:1px solid #3C0000;">'+records[key].amount+'</td></tr><tr><td style="vertical-align:middle; border-bottom:1px solid #3C0000; border-right:1px solid #3C0000;">'+records[key].bet_number+'</td></tr>';
    };  
    content += '</table>'
    return content;    
}


//取得下注金額資料
function getBetAmount(t_cash,t_run,t_interest,t_right,account_data){
    cash = getRealBetAmount(t_cash);
    run = getRealBetAmount(t_run);
    interest = getRealBetAmount(t_interest);
    right = getRealBetAmount(t_right);

    var content =  '<p>'+account_data[1]['icon']+'<b>'+account_data[1]['name']+'：</b>'+numeral(cash).format('0,0')+'</p>';
    content += '<p>'+account_data[2]['icon']+'<b>'+account_data[2]['name']+'：</b>'+numeral(run).format('0,0')+'</p>';
    content += '<p>'+account_data[4]['icon']+'<b>'+account_data[4]['name']+'：</b>'+numeral(interest).format('0,0')+'</p>';
    content += '<p>'+account_data[3]['icon']+'<b>'+account_data[3]['name']+'：</b>'+numeral(right).format('0,0')+'</p>';
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
