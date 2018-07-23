<!--拍賣視窗（拍賣卡足夠）-->
<div class="modal fade" id="buyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <!--手機顯示金幣餘額-->
                <div class="alert-coin-left">
                    <div class="coin-amount-icon">
                        <img src="{{ asset('front/img/icon/usercoin/user_bg_gold_01.png') }}"/>
                    </div>
                    <div class="coin-amount-font">
                        {{ number_format($cash_amount) }}
                    </div>
                </div>
                <div class="alert-coin-right">
                    <div class="coin-amount-icon">
                        <img src="{{ asset('front/img/icon/usercoin/user_bg_ulg_01.png') }}"/>
                    </div>
                    <div class="coin-amount-font">
                        {{ number_format($share_amount) }}
                    </div>
                </div>
               <!--
                <p>個人娛樂幣餘額：{{ number_format($share_amount) }}</p>
                <p>個人金幣餘額：{{ number_format($cash_amount) }}</p>
        -->
                <div class="model-alert-title">拍賣娛樂幣</div>
                <div class="model-alert-input">
                    <input type="number" class="form-alert-input form-control form-amount-input" name="price" id="price" min="0"  placeholder="小數後兩位" @if($product_count == 0) disabled @endif> 
                    <div class="model-alert-input-text">售價</div>
                </div>
                <div class="model-alert-input">
                    <input type="number" class="form-alert-input form-control form-amount-input" name="unit" id="unit" maxlength="7" @if($product_count == 0) disabled @endif>
                    <div class="model-alert-input-text">X100</div>
                </div>

                <hr style="border-top:1.5px solid #848484; margin-top:5px; margin-bottom:5px;">

                <div class="model-alert-info-text">交易成交後您將會收到</div>
                <div class="model-alert-coin-use">
                    <img src="{{ asset('front/img/icon/currency/currency_gold_02.png') }}"/>＋<span id="cash_total"></span>
                </div>

                <!--
                <p>總計掛賣娛樂幣數量：<span id="total"></span></p>

                <p>小計可獲得金幣：<span id="cash_total"></span></p>
                -->
                <input type="hidden" class="form-control" name="product_id" id="product_id" value="{{ $product->id }}" required>

                <div class="model-alert-info-text" style="margin-top:10px;">★交易成功將會收取{{ $fee_percent*100 }}% 手續費用</div>
                <div class="model-alert-info-text">★成功上架後{{ $expire_day }}日到期系統自動下架</div>

                <div class="model-btn-area">
                    <center><button type="button" class="btn btn-gray" data-dismiss="modal" style="margin-right:15px;">取 消</button>
                    <button class="btn btn-red" type="button" id="confirm">確 認</button></center>
                </div>

            </div>

        </div>
    </div>
</div>
<!--/.拍賣視窗-->