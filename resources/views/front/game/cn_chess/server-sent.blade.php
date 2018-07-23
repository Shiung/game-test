<!-- js -->


<script type="text/javascript">

    //SSE
    //
    //flag of events
    var open_number_flag = 0;
    var bet_result_flag = 0;
    var result_status = 0;
    var open_number_animation = 2;
    
    if(typeof(EventSource) !== "undefined") {

        //header 計時
        var source = new EventSource("{!! action('Front\Game\CnChessSSEController@header') !!}");
        source.onmessage = function(event) {

            //即時更新view資訊
            var chess = JSON.parse(event.data)
            //$("#result").html(chess['sec']);
            $("#sport_number").html(chess['number']);
            //$("#showbox2").html(chess['datetime']);
            $("#sport_id").val(chess['sport_id']);

            if(chess['sec'] < 0){
                chess['sec'] = {{ $chessService->info("interval_sec") }} + chess['sec'];
                $('#countdown').css('display','none'); 
            }

            //誤差3秒進行修正
            if(chess['sec'] - $("#js_count").html()>=3 || chess['sec'] - $("#js_count").html()<=-3){
                stopCount()
                console.log('adjust_sec:'+chess['sec']);
                startCount(chess['sec'])
            }
            

            /////開獎////
            // 0~90秒進行開獎 只開一次 
            if(chess['sec'] <=0 || chess['sec'] >= {{ $chessService->info("start_count") }} ){
                //尚未開獎
                if(open_number_flag==0){
                    newest_lottery();
                    open_number_flag = 1;
                }         
            //其餘秒數重置    
            }else{
                open_number_flag = 0;
            }

            ///開始結算提示
            if(chess['sec'] >= 285){
                $('#bet_end').css('display','block'); 
                
            }else{
                $('#bet_end').css('display','none'); 
                
            }
        
            //歷史紀錄可顯示時間
            if(chess['sec'] < 285 && chess['sec'] >= 5){
                document.getElementById("history_lottery_part").classList.remove('hide');
            }else{
                document.getElementById("history_lottery_part").classList.add('hide');
            }
        
            //顯示小計
            if(chess['sec'] < 285 && chess['sec'] >= 225){
                //ajax for bet result
                if(bet_result_flag==0){
                    bet_result();
                    bet_result_flag = 1;
                }
                
                if(result_status==0){
                    $('#latest_count').css('display','block'); 
                    $('#count_bg').css('display','block');
                }
                else{
                    $('#latest_count').css('display','none'); 
                    $('#count_bg').css('display','none');
                }
                
            }else{
                bet_result_flag = 0;
                result_status = 0;
                $('#latest_count').css('display','none'); 
                $('#count_bg').css('display','none');
            }
        
            //顯示開始下注
            if(chess['sec'] < 285 && chess['sec'] >= 280){
                $('#bet_start').css('display','block'); 
            }else{
                $('#bet_start').css('display','none'); 
            }
        
            //278秒以上最新一期開獎的棋子打開
            if(chess['sec'] > 278 && open_number_animation == 1){
                $("#lottery_close").css('display','none');
                $("#lottery_open").css('display','block');
            }
        
            //278秒時把最新一期開獎的棋子翻回來
            if(chess['sec'] == 278){
                $("#lottery_open").find('div').addClass( "lottery-animate-close" );
                open_number_animation = 0;
            }
        
            //276秒以下最新一期開獎的棋子蓋著
            if(chess['sec'] < 276){
                $("#lottery_close").css('display','block');
                $("#lottery_open").css('display','none');
            }
        
        
            ///關閉下注動畫
            if(chess['sec'] == 5){
                $('#countdown').css('display','block'); 
            }

        };

        //近五期紀錄
        var source_last_five = new EventSource("{!! action('Front\Game\CnChessSSEController@last_five_lottery') !!}");
        source_last_five.onmessage = function(event) {
            //即時更新view資訊
            var chess_five = JSON.parse(event.data)
            var chess_five_html = "";
            for (var i = 0, len = chess_five.length; i < len; i++) {
                //console.log(chess_five[i]);
                chess_five_html += '<tr class="history-tr"><td>'+chess_five[i]['sport_number']+'</td><td><div class="chesstd">'+chess_five[i][0]+' '+chess_five[i][1]+' '+chess_five[i][2]+' '+chess_five[i][3]+' '+chess_five[i][4]+'<div></td></tr>';
            }
            $("#history_lottery").html(chess_five_html);
        };
        

        //最新餘額
        var source_balance = new EventSource("{!! action('Front\Game\CnChessSSEController@balance') !!}");
        source_balance.onmessage = function(event) {
            //即時更新view資訊
            var balance = JSON.parse(event.data)
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
            
        };

        //數字格式化KM
        function nFormatter(num) {
            num = num.replace(/,/g,'');
            num = parseInt(num);

            if(num >= 100000000){
                if (num >= 1000) {
                    num = Math.floor(num/1000);
                    return number_format(num.toFixed(0).replace(/\.0$/, '')) + 'K';
                }
            }
            
            return number_format(num);
        }
        //千分位
        function number_format(n) {
            n += "";
            var arr = n.split(".");
            var re = /(\d{1,3})(?=(\d{3})+$)/g;
            return arr[0].replace(re,"$1,") + (arr.length == 2 ? "."+arr[1] : "");
        }


        //十筆下注紀錄
        // var source_bet = new EventSource("{!! action('Front\Game\CnChessSSEController@bet') !!}");
        // source_bet.onmessage = function(event) {
        //     //即時更新view資訊
        //     var bets = JSON.parse(event.data)
        //     var bets_html = "";
        //     for (var i = 0, len = bets.length; i < len; i++) {
        //         //console.log(chess_five[i]);
        //         bets_html += "<tr><td>"+bets[i]['sport_number']+'</td><td><div class="latest-bet-record-img bet-record-currency-'+bets[i]['account_type']+'"></div></td><td>'+bets[i]['amount']+'</td><td><div class="latest-bet-record-img bet-record-gamble-'+bets[i]['gamble']+'"></div></td></tr>';
        //     }
        //     $("#bets").html(bets_html);
        // };

    } else {
        $("#result").html("Sorry, your browser does not support server-sent events...");
    }
    

    $(function() {
        //newest_lottery();
        //console.log("ready");
        var nowtime = Math.floor(Date.now() / 1000);
        var start_sec = {{ $chessService->info("sec") }};
        startCount(start_sec);
        
        
    });

 
    var c=210
    var t;
    var timer_is_on = 0;
    function timedCount(sec)
    {
        
        $("#js_count").html(sec)
        p=sec/3
        $('.progress-bar').css('width', p+'%');
        c=sec-1
        if(c<0){
            c={{ $chessService->info("interval_sec") }}-1
        }
        console.log('count_sec:'+c+'  open_number_animation:'+open_number_animation);
        t=setTimeout("timedCount(c)",1000)
    }

    function startCount(ss) {
        if (!timer_is_on) {
            console.log('start_sec:'+ss);
            timer_is_on = 1;
            timedCount(ss);
        }
    }

    function stopCount() {
        console.log('stop_sec:'+t);
        clearTimeout(t);
        timer_is_on = 0;
    }

    

    //開獎
    function newest_lottery()
    {
        //抓取開獎號碼ajax
        $.ajax({
            url: "{!! action('Front\Game\CnChessSSEController@last_lottery') !!}",
            type: "GET",
            success: function(msg) {
                console.log('success');
                
                var data = JSON.parse(msg);
                
                $("#lottery_sport_number").html(data['sport_number']);
               // $("#lottery_close").css('display','none');
                $("#lottery_open").html('<div class="lottery_open_'+data['1']+' lottery-open-img-area lottery-animate1"></div>'+'<div class="lottery_open_'+data['2']+' lottery-open-img-area lottery-animate2"></div>'+'<div class="lottery_open_'+data['3']+' lottery-open-img-area lottery-animate3"></div>'+'<div class="lottery_open_'+data['4']+' lottery-open-img-area lottery-animate4"></div>'+'<div class="lottery_open_'+data['5']+' lottery-open-img-area lottery-animate5"></div>');
               // $("#lottery_open").css('display','block');
                open_number_animation = 1;
                console.log('newest_lottery的open_number_animation:'+open_number_animation);                //
                console.log(msg);
            },
            beforeSend: function() {
                //console.log('process');
            },
            error: function(xhr){
                console.log(xhr);
            }
            
        });

        //開獎動畫 --- for ladybug ----
    }


     //下注結果 
    function bet_result()
    {
        
        $.ajax({
            url: "{!! action('Front\Game\CnChessSSEController@chess_bet_one') !!}",
            type: "GET",
            success: function(msg) {
                console.log('success_bet');
                console.log(msg);
                var data = JSON.parse(msg);
                console.log(data);
                var sum_result = 0;
                
                //success
                if(data['result']==1){

                    //inital each account result
                    $("#bet_account_1").html(0);
                    $("#bet_account_2").html(0);
                    $("#bet_account_3").html(0);
                    $("#bet_account_4").html(0);

                    for (i = 0; i < data['detail'].length; i++) { 
                        var result_number = Number(data['detail'][i]['sum_result']);
                        console.log(result_number);
                        sum_result += result_number;
                        switch(data['detail'][i]['account_type']) {
                            case 1:
                                $("#bet_account_1").html(result_number);
                                console.log(result_number);
                            break;

                            case 2:
                                $("#bet_account_2").html(result_number);
                                console.log(result_number);
                            break;

                            case 3:
                                $("#bet_account_3").html(result_number);
                                console.log(result_number);
                            break;

                            case 4:
                                $("#bet_account_4").html(result_number);
                                console.log(result_number);
                            break;
                        }
                    }
                    $("#sum_result").html(sum_result);
                }
                //
            },
            beforeSend: function() {
                //console.log('process');
            },
            error: function(xhr){
                console.log(xhr);
            }
            
        });

        //開獎動畫 --- for ladybug ----
    }
</script>
