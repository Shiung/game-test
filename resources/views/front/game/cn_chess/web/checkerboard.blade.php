<!--棋盤-->
<div id="bet_checkerboard">
   
    <div id="bet_start">
        <img class="m-checkerboard-bg" src="{{ asset('front/img/chess/phone/start_01.png') }}">
    </div>
    
    <div id="bet_end">
        <img class="m-checkerboard-bg" src="{{ asset('front/img/chess/phone/start_02.gif') }}">
    </div>
   
    <img class="checkerboard-bg" src="{{ asset('front/img/chess/web/back_03.png') }}">
    
    <div class="row checkerboard-row-first"></div>
    
    <!--棋盤第一列-->   
    <div class="row checkerboard-row">
        
        <!--棋子區域-->
        <div class="col-xs-3 checkerboard-col">
            
            <!--棋子下注點擊-->
            <div class="chess chess_number chess-link" data-number="car" id="chess_car"><div id="chess_car_chips" class="chess_chip_part"></div></div>
            
            <!--棋子背景-->
            <img class="m-chess-bg" src="{{ asset('front/img/chess/phone/chess_black_06.png') }}">
            
            <!--棋子文字-->
            <div class="chess_number">車</div>
            
            <!--金幣-->
            <div id="chip_area_car_1" class="chip-area chip-area-gold">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gold_01.png') }}">
                <span id="mount_car_1" class="chip-mount"></span>
            </div>
            
            <!--娛樂幣-->
            <div id="chip_area_car_3" class="chip-area chip-area-ulg">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_ulg_01.png') }}">
                <span id="mount_car_3" class="chip-mount"></span>
            </div>
            
            <!--紅利-->
            <div id="chip_area_car_4" class="chip-area chip-area-red">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_red_01.png') }}">
                <span id="mount_car_4" class="chip-mount"></span>
            </div>
            
            <!--禮券-->
            <div id="chip_area_car_2" class="chip-area chip-area-gift">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gift_01.png') }}">
                <span id="mount_car_2" class="chip-mount"></span>
            </div>
            
            
        </div>
        
        <!--將帥棋子區域-->
        <div class="col-xs-6 checkerboard-col">
            
            <!--棋子下注點擊-->
            <div class="chess chess_number chess-link-king" data-number="king" id="chess_king"><div id="chess_king_chips" class="chess_chip_part"></div></div>
            
            <!--棋子背景-->
            <img class="m-chess-bg-b" src="{{ asset('front/img/chess/phone/chess_black_01.png') }}">
            <img class="m-chess-bg-r" src="{{ asset('front/img/chess/phone/chess_red_01.png') }}">
            
            <!--棋子文字-->
            <div class="chess_number">將帥</div>
            
            <!--金幣-->
            <div id="chip_area_king_1" class="chip-area chip-area-gold">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gold_01.png') }}">
                <span id="mount_king_1" class="chip-mount"></span>
            </div>
            
            <!--娛樂幣-->
            <div id="chip_area_king_3" class="chip-area chip-area-ulg">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_ulg_01.png') }}">
                <span id="mount_king_3" class="chip-mount"></span>
            </div>
            
            <!--紅利-->
            <div id="chip_area_king_4" class="chip-area chip-area-red">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_red_01.png') }}">
                <span id="mount_king_4" class="chip-mount"></span>
            </div>
            
            <!--禮券-->
            <div id="chip_area_king_2" class="chip-area chip-area-gift">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gift_01.png') }}">
                <span id="mount_king_2" class="chip-mount"></span>
            </div>
            
        </div>
        
        <!--棋子區域-->
        <div class="col-xs-3 checkerboard-col">
            
            <!--棋子下注點擊-->
            <div class="chess chess_number chess-link" data-number="rook" id="chess_rook"><div id="chess_rook_chips" class="chess_chip_part"></div></div>
            
            <!--棋子背景-->
            <img class="m-chess-bg" src="{{ asset('front/img/chess/phone/chess_red_06.png') }}">
            
            <!--棋子文字-->
            <div class="chess_number">俥</div>
            
            <!--金幣-->
            <div id="chip_area_rook_1" class="chip-area chip-area-gold">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gold_01.png') }}">
                <span id="mount_rook_1" class="chip-mount"></span>
            </div>
            
            <!--娛樂幣-->
            <div id="chip_area_rook_3" class="chip-area chip-area-ulg">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_ulg_01.png') }}">
                <span id="mount_rook_3" class="chip-mount"></span>
            </div>
            
            <!--紅利-->
            <div id="chip_area_rook_4" class="chip-area chip-area-red">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_red_01.png') }}">
                <span id="mount_rook_4" class="chip-mount"></span>
            </div>
            
            <!--禮券-->
            <div id="chip_area_rook_2" class="chip-area chip-area-gift">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gift_01.png') }}">
                <span id="mount_rook_2" class="chip-mount"></span>
            </div>
        </div>
        
    </div>
    
    <!--棋盤第二列-->   
    <div class="row checkerboard-row">
        
        <!--棋子區域-->
        <div class="col-xs-3 checkerboard-col">
            
            <!--棋子下注點擊-->
            <div class="chess chess_number chess-link" data-number="horse" id="chess_horse"><div id="chess_horse_chips" class="chess_chip_part"></div></div>
            
            <!--棋子背景-->
            <img class="m-chess-bg" src="{{ asset('front/img/chess/phone/chess_black_04.png') }}">
            
            <!--棋子文字-->
            <div class="chess_number">馬</div>
            
            <!--金幣-->
            <div id="chip_area_horse_1" class="chip-area chip-area-gold">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gold_01.png') }}">
                <span id="mount_horse_1" class="chip-mount"></span>
            </div>
            
            <!--娛樂幣-->
            <div id="chip_area_horse_3" class="chip-area chip-area-ulg">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_ulg_01.png') }}">
                <span id="mount_horse_3" class="chip-mount"></span>
            </div>
            
            <!--紅利-->
            <div id="chip_area_horse_4" class="chip-area chip-area-red">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_red_01.png') }}">
                <span id="mount_horse_4" class="chip-mount"></span>
            </div>
            
            <!--禮券-->
            <div id="chip_area_horse_2" class="chip-area chip-area-gift">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gift_01.png') }}">
                <span id="mount_horse_2" class="chip-mount"></span>
            </div>
            
        </div>
        
        <!--棋子區域-->
        <div class="col-xs-3 checkerboard-col">
            
            <!--棋子下注點擊-->
            <div class="chess chess_number chess-link" data-number="guard" id="chess_guard"><div id="chess_guard_chips" class="chess_chip_part"></div></div>
            
            <!--棋子背景-->
            <img class="m-chess-bg" src="{{ asset('front/img/chess/phone/chess_black_02.png') }}">
            
            <!--棋子文字-->
            <div class="chess_number">士</div>
            
            <!--金幣-->
            <div id="chip_area_guard_1" class="chip-area chip-area-gold">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gold_01.png') }}">
                <span id="mount_guard_1" class="chip-mount"></span>
            </div>
            
            <!--娛樂幣-->
            <div id="chip_area_guard_3" class="chip-area chip-area-ulg">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_ulg_01.png') }}">
                <span id="mount_guard_3" class="chip-mount"></span>
            </div>
            
            <!--紅利-->
            <div id="chip_area_guard_4" class="chip-area chip-area-red">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_red_01.png') }}">
                <span id="mount_guard_4" class="chip-mount"></span>
            </div>
            
            <!--禮券-->
            <div id="chip_area_guard_2" class="chip-area chip-area-gift">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gift_01.png') }}">
                <span id="mount_guard_2" class="chip-mount"></span>
            </div>
            
        </div>
        
        <!--棋子區域-->
        <div class="col-xs-3 checkerboard-col">
            
            <!--棋子下注點擊-->
            <div class="chess chess_number chess-link" data-number="advisor" id="chess_advisor"><div id="chess_advisor_chips" class="chess_chip_part"></div></div>
            
            <!--棋子背景-->
            <img class="m-chess-bg" src="{{ asset('front/img/chess/phone/chess_red_02.png') }}">
            
            <!--棋子文字-->
            <div class="chess_number">仕</div>
            
            <!--金幣-->
            <div id="chip_area_advisor_1" class="chip-area chip-area-gold">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gold_01.png') }}">
                <span id="mount_advisor_1" class="chip-mount"></span>
            </div>
            
            <!--娛樂幣-->
            <div id="chip_area_advisor_3" class="chip-area chip-area-ulg">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_ulg_01.png') }}">
                <span id="mount_advisor_3" class="chip-mount"></span>
            </div>
            
            <!--紅利-->
            <div id="chip_area_advisor_4" class="chip-area chip-area-red">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_red_01.png') }}">
                <span id="mount_advisor_4" class="chip-mount"></span>
            </div>
            
            <!--禮券-->
            <div id="chip_area_advisor_2" class="chip-area chip-area-gift">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gift_01.png') }}">
                <span id="mount_advisor_2" class="chip-mount"></span>
            </div>
            
        </div>
        
        <!--棋子區域-->
        <div class="col-xs-3 checkerboard-col">
            
            <!--棋子下注點擊-->
            <div class="chess chess_number chess-link" data-number="knight" id="chess_knight"><div id="chess_knight_chips" class="chess_chip_part"></div></div>
            
            <!--棋子背景-->
            <img class="m-chess-bg" src="{{ asset('front/img/chess/phone/chess_red_04.png') }}">
            
            <!--棋子文字-->
            <div class="chess_number">傌</div>
            
            <!--金幣-->
            <div id="chip_area_knight_1" class="chip-area chip-area-gold">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gold_01.png') }}">
                <span id="mount_knight_1" class="chip-mount"></span>
            </div>
            
            <!--娛樂幣-->
            <div id="chip_area_knight_3" class="chip-area chip-area-ulg">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_ulg_01.png') }}">
                <span id="mount_knight_3" class="chip-mount"></span>
            </div>
            
            <!--紅利-->
            <div id="chip_area_knight_4" class="chip-area chip-area-red">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_red_01.png') }}">
                <span id="mount_knight_4" class="chip-mount"></span>
            </div>
            
            <!--禮券-->
            <div id="chip_area_knight_2" class="chip-area chip-area-gift">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gift_01.png') }}">
                <span id="mount_knight_2" class="chip-mount"></span>
            </div>
            
        </div>
        
    </div>
    
    <!--棋盤第三列-->   
    <div class="row checkerboard-row">
        
        <!--棋子區域-->
        <div class="col-xs-3 checkerboard-col">
            
            <!--棋子下注點擊-->
            <div class="chess chess_number chess-link" data-number="bag" id="chess_bag"><div id="chess_bag_chips" class="chess_chip_part"></div></div>
            
            <!--棋子背景-->
            <img class="m-chess-bg" src="{{ asset('front/img/chess/phone/chess_black_05.png') }}">
            
            <!--棋子文字-->
            <div class="chess_number">包</div>
            
            <!--金幣-->
            <div id="chip_area_bag_1" class="chip-area chip-area-gold">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gold_01.png') }}">
                <span id="mount_bag_1" class="chip-mount"></span>
            </div>
            
            <!--娛樂幣-->
            <div id="chip_area_bag_3" class="chip-area chip-area-ulg">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_ulg_01.png') }}">
                <span id="mount_bag_3" class="chip-mount"></span>
            </div>
            
            <!--紅利-->
            <div id="chip_area_bag_4" class="chip-area chip-area-red">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_red_01.png') }}">
                <span id="mount_bag_4" class="chip-mount"></span>
            </div>
            
            <!--禮券-->
            <div id="chip_area_bag_2" class="chip-area chip-area-gift">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gift_01.png') }}">
                <span id="mount_bag_2" class="chip-mount"></span>
            </div>
            
        </div>
        
        <!--棋子區域-->
        <div class="col-xs-3 checkerboard-col">
            
            <!--棋子下注點擊-->
            <div class="chess chess_number chess-link" data-number="elephant" id="chess_elephant"><div id="chess_elephant_chips" class="chess_chip_part"></div></div>
            
            <!--棋子背景-->
            <img class="m-chess-bg" src="{{ asset('front/img/chess/phone/chess_black_03.png') }}">
            
            <!--棋子文字-->
            <div class="chess_number">象</div>
            
            <!--金幣-->
            <div id="chip_area_elephant_1" class="chip-area chip-area-gold">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gold_01.png') }}">
                <span id="mount_elephant_1" class="chip-mount"></span>
            </div>
            
            <!--娛樂幣-->
            <div id="chip_area_elephant_3" class="chip-area chip-area-ulg">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_ulg_01.png') }}">
                <span id="mount_elephant_3" class="chip-mount"></span>
            </div>
            
            <!--紅利-->
            <div id="chip_area_elephant_4" class="chip-area chip-area-red">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_red_01.png') }}">
                <span id="mount_elephant_4" class="chip-mount"></span>
            </div>
            
            <!--禮券-->
            <div id="chip_area_elephant_2" class="chip-area chip-area-gift">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gift_01.png') }}">
                <span id="mount_elephant_2" class="chip-mount"></span>
            </div>
            
        </div>
        
        <!--棋子區域-->
        <div class="col-xs-3 checkerboard-col">
            
            <!--棋子下注點擊-->
            <div class="chess chess_number chess-link" data-number="minister" id="chess_minister"><div id="chess_minister_chips" class="chess_chip_part"></div></div>
            
            <!--棋子背景-->
            <img class="m-chess-bg" src="{{ asset('front/img/chess/phone/chess_red_03.png') }}">
            
            <!--棋子文字-->
            <div class="chess_number">相</div>
            
            <!--金幣-->
            <div id="chip_area_minister_1" class="chip-area chip-area-gold">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gold_01.png') }}">
                <span id="mount_minister_1" class="chip-mount"></span>
            </div>
            
            <!--娛樂幣-->
            <div id="chip_area_minister_3" class="chip-area chip-area-ulg">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_ulg_01.png') }}">
                <span id="mount_minister_3" class="chip-mount"></span>
            </div>
            
            <!--紅利-->
            <div id="chip_area_minister_4" class="chip-area chip-area-red">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_red_01.png') }}">
                <span id="mount_minister_4" class="chip-mount"></span>
            </div>
            
            <!--禮券-->
            <div id="chip_area_minister_2" class="chip-area chip-area-gift">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gift_01.png') }}">
                <span id="mount_minister_2" class="chip-mount"></span>
            </div>
            
        </div>
        
        <!--棋子區域-->
        <div class="col-xs-3 checkerboard-col">
            
            <!--棋子下注點擊-->
            <div class="chess chess_number chess-link" data-number="canoon" id="chess_canoon"><div id="chess_canoon_chips" class="chess_chip_part"></div></div>
            
            <!--棋子背景-->
            <img class="m-chess-bg" src="{{ asset('front/img/chess/phone/chess_red_05.png') }}">
            
            <!--棋子文字-->
            <div class="chess_number">砲</div>
            
            <!--金幣-->
            <div id="chip_area_canoon_1" class="chip-area chip-area-gold">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gold_01.png') }}">
                <span id="mount_canoon_1" class="chip-mount"></span>
            </div>
            
            <!--娛樂幣-->
            <div id="chip_area_canoon_3" class="chip-area chip-area-ulg">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_ulg_01.png') }}">
                <span id="mount_canoon_3" class="chip-mount"></span>
            </div>
            
            <!--紅利-->
            <div id="chip_area_canoon_4" class="chip-area chip-area-red">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_red_01.png') }}">
                <span id="mount_canoon_4" class="chip-mount"></span>
            </div>
            
            <!--禮券-->
            <div id="chip_area_canoon_2" class="chip-area chip-area-gift">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gift_01.png') }}">
                <span id="mount_canoon_2" class="chip-mount"></span>
            </div>
            
        </div>
        
    </div>
	
	<!--棋盤第四列-->   
    <div class="row checkerboard-row">
        
        <!--棋子區域-->
        <div class="col-xs-6 checkerboard-col">
           
            <!--棋子下注點擊-->
            <div class="chess chess_number chess-link-king" data-number="black" id="chess_black"><div id="chess_black_chips" class="chess_chip_part"></div></div>
           
            <!--棋子背景-->
            <img class="m-chess-bg-color" src="{{ asset('front/img/chess/phone/chess_black.png') }}">
            
            <!--棋子文字-->
            <div class="chess_number">黑</div>
            
            <!--金幣-->
            <div id="chip_area_black_1" class="chip-area chip-area-gold">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gold_01.png') }}">
                <span id="mount_black_1" class="chip-mount"></span>
            </div>
            
            <!--娛樂幣-->
            <div id="chip_area_black_3" class="chip-area chip-area-ulg">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_ulg_01.png') }}">
                <span id="mount_black_3" class="chip-mount"></span>
            </div>
            
            <!--紅利-->
            <div id="chip_area_black_4" class="chip-area chip-area-red">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_red_01.png') }}">
                <span id="mount_black_4" class="chip-mount"></span>
            </div>
            
            <!--禮券-->
            <div id="chip_area_black_2" class="chip-area chip-area-gift">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gift_01.png') }}">
                <span id="mount_black_2" class="chip-mount"></span>
            </div>
            
        </div>
        
        <!--棋子區域-->
        <div class="col-xs-6 checkerboard-col">
            
            <!--棋子下注點擊-->
            <div class="chess chess_number chess-link-king" data-number="red" id="chess_red"><div id="chess_red_chips" class="chess_chip_part"></div></div>
            
            <!--棋子背景-->
            <img class="m-chess-bg-color" src="{{ asset('front/img/chess/phone/chess_red.png') }}">
            
            <!--棋子文字-->
            <div class="chess_number">紅</div>
            
            <!--金幣-->
            <div id="chip_area_red_1" class="chip-area chip-area-gold">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gold_01.png') }}">
                <span id="mount_red_1" class="chip-mount"></span>
            </div>
            
            <!--娛樂幣-->
            <div id="chip_area_red_3" class="chip-area chip-area-ulg">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_ulg_01.png') }}">
                <span id="mount_red_3" class="chip-mount"></span>
            </div>
            
            <!--紅利-->
            <div id="chip_area_red_4" class="chip-area chip-area-red">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_red_01.png') }}">
                <span id="mount_red_4" class="chip-mount"></span>
            </div>
            
            <!--禮券-->
            <div id="chip_area_red_2" class="chip-area chip-area-gift">
                <img class="chip-img" src="{{ asset('front/img/chess/phone/currency_other_gift_01.png') }}">
                <span id="mount_red_2" class="chip-mount"></span>
            </div>
            
        </div>
        
    </div>
	
</div>
<!--/.棋盤-->
