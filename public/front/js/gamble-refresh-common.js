var refresh_second = 30;
//秒數倒數
/*window.timer = setInterval(function () {
    var el = document.getElementById("sec");
    sec = el.innerHTML;
    sec = parseInt(sec) - 1;
    el.innerHTML = sec;
    if (sec === 0) {
        el.innerHTML = refresh_second;
    }
}, 1000);*/

//點擊下注
function clickBet(element){
    game_id = element.data('gameid');//玩法id
    gamble = element.data('gamble');//選擇的項目id
    line = element.data('line');//賠率
    betstatus = element.data('betstatus');//下注狀態

    if(betstatus == '1'){
        $.fancybox.open({
            padding : 0,
            href:APP_URL+"/game/sport/gamble/"+game_id+"/bet/"+gamble+"/"+line,
            type: 'iframe',
            'width': 384,
            'height': 500,
            fitToView: false,
            autoSize: false,
            autoDimensions: false,
        });
    }
}


//更新玩法資料
function refreshGames(sport_id,tbody){

    $.ajax({
        url: APP_URL + "/game/sport/gamble/refresh/"+sport_id,
        type: "GET",
        success: function(result) {
            var data = JSON.parse(result);
            console.log(result)
            game_content = '';
            for (var key in data) {
                switch(key)
                {
                    case 'spread':
                      game_data =  refreshSpreadGame(data[key])
                      break;
                    case 'overunder':
                      game_data =refreshOverunderGame(data[key])
                      break;
                    default:    
                }

                game_content += game_data;
            };      

            tbody.html(game_content)
            
        },
        error: function(xhr) {
            swal("Failed", '系統發生問題，請聯繫網站人員', 'error');
        }
    });
}

//更新大小玩法資訊
function refreshOverunderGame(game){         

    content = '<tr>';
    content += '<td>大小</td>';

    //主
    content += '<td><div data-type="'+game.type+'" data-typename="'+game.typename+'" data-gameid="'+game.gameid+'" data-betstatus="'+game.betstatus+'"';
    content += 'data-gamble="'+game.home_data.gamble+'" data-line="'+game.home_data.line+'" data-homeline="'+game.home_data.line+'" data-awayline="'+game.away_data.line+'"  data-point="'+game.point+'" data-gamblename="'+game.home_data.gamblename+'"';
    content += 'class="bet">';
    content += '<div class="point" >'+game.home_data.show_point+'</div>'+game.home_data.gamblename;
    content += '<span class="line" >'+game.home_data.line+'</span></div></td>';
    
    //客
    content += '<td><div data-type="'+game.type+'" data-typename="'+game.typename+'" data-gameid="'+game.gameid+'" data-betstatus="'+game.betstatus+'"';
    content += 'data-gamble="'+game.away_data.gamble+'" data-line="'+game.away_data.line+'"  data-homeline="'+game.home_data.line+'" data-awayline="'+game.away_data.line+'"  data-point="'+game.point+'" data-gamblename="'+game.away_data.gamblename+'"';
    content += 'class="bet">';
    content += '<div class="point" >'+game.away_data.show_point+'</div>'+game.away_data.gamblename;
    content += '<span class="line" >'+game.away_data.line+'</span></div></td>';
    content += '</tr>';

    return content;

}

//更新讓分玩法資訊
function refreshSpreadGame(game){

    content = '<tr>';
    content += '<td>讓分</td>';
    
    //主
    content += '<td><div data-type="'+game.type+'" data-typename="'+game.typename+'" data-gameid="'+game.gameid+'" data-betstatus="'+game.betstatus+'"';
    content += 'data-gamble="'+game.home_data.gamble+'" data-line="'+game.home_data.line+'" data-homeline="'+game.home_data.line+'" data-awayline="'+game.away_data.line+'" data-point="'+game.point+'" data-gamblename="'+game.home_data.gamblename+'"';
    content += 'data-headteam="'+game.headteam+'" class="bet">';
    content += '<div class="point" >'+game.home_data.show_point+'</div>';
    content += '<span class="line" >'+game.home_data.line+'</span></div></td>';
    
    //客
    content += '<td><div data-type="'+game.type+'" data-typename="'+game.typename+'" data-gameid="'+game.gameid+'" data-betstatus="'+game.betstatus+'"';
    content += 'data-gamble="'+game.away_data.gamble+'" data-line="'+game.away_data.line+'" data-homeline="'+game.home_data.line+'" data-awayline="'+game.away_data.line+'"  data-point="'+game.point+'" data-gamblename="'+game.away_data.gamblename+'"';
    content += 'data-headteam="'+game.headteam+'" class="bet">';
    content += '<div class="point" >'+game.away_data.show_point+'</div>';
    content += '<span class="line" >'+game.away_data.line+'</span></div></td>';
    content += '</tr>';

    return content;


}