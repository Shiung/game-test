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
        
        <div class="model-alert-title">拍賣娛樂幣</div>
        <div class="model-alert-input">
            <input type="number" class="form-alert-input form-control form-amount-input" name="price" id="price" min="0"  placeholder="小數後兩位" @if($product_count == 0) disabled @endif> 
            <div class="model-alert-input-text">售價</div>
        </div>
        <div class="model-alert-input">
            <input type="number" class="form-alert-input form-control form-amount-input" name="unit" id="unit" @if($product_count == 0) disabled @endif>
            <div class="model-alert-input-text">X100</div>
        </div>

        <hr style="border-top:1.5px solid #848484; margin-top:5px; margin-bottom:5px;">
          
        <div class="model-alert-error-text" style="margin-top:10px;">拍賣卡不足，請前往商城購買</div>

        <a href="{{ route('front.shop.category.index') }}">
            <div class="go-to-shop"><img src="{{ asset('front/img/share/overage_icon_05_02.png') }}"/></div>
        </a>

      </div>
    </div>
  </div>
</div>
<!--/.拍賣視窗-->