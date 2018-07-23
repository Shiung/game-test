@inject('MenuPresenter','App\Presenters\MenuPresenter')
<section class="sidebar">
    <!-- Menu Header-->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ asset('admin/img/user.png') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p> {{ Auth::guard('admin')->user()->name }}</p>
            <!-- Status -->
            <a href="#"><i class="fa fa-circle text-success"></i> </a>
        </div>
    </div>
    <!-- Menu -->
    <ul class="sidebar-menu">
        
        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','sport-preview'),'')) 
        <!--遊戲管理-->
        <li class="header">遊戲</li>
        <li class="treeview  @if($menu_title == '美國職棒(MLB)') active @endif">
            <a href="#">
                <span>美國職棒(MLB)</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu @if($menu_title == '美國職棒(MLB)')menu-open @endif" @if($menu_title != '美國職棒(MLB)') style="display: none;"@endif>
                <li>
                    <a href="{{ route('admin.game.sport.index',1) }}">
                        <span> 未打完賽程 </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.game.sport.gambles',1) }}">
                        <span> 賭盤列表 </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.game.sport.history',1) }}">
                        <span> 歷史賽程 </span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="treeview @if($menu_title == 'NBA') active @endif">
            <a href="#">
                <span>NBA</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu  @if($menu_title == 'NBA') menu-open @endif" @if($menu_title != 'NBA')  style="display: none;" @endif>
                <li>
                    <a href="{{ route('admin.game.sport.index',2) }}">
                        <span> 未打完賽程 </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.game.sport.gambles',2) }}">
                        <span> 賭盤列表 </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.game.sport.history',2) }}">
                        <span> 歷史賽程 </span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="treeview @if($menu_title == '足球') active @endif">
            <a href="#">
                <span>足球</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu  @if($menu_title == '足球') menu-open @endif" @if($menu_title != '足球')  style="display: none;" @endif>
                <li>
                    <a href="{{ route('admin.game.sport.index',5) }}">
                        <span> 未打完賽程 </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.game.sport.gambles',5) }}">
                        <span> 賭盤列表 </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.game.sport.history',5) }}">
                        <span> 歷史賽程 </span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="treeview @if($menu_title == '彩球539') active @endif">
            <a href="{{ route('admin.game.lottery539.index') }}">
                <span> 彩球539 </span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu @if($menu_title == '彩球539') menu-open @endif" @if($menu_title != '彩球539')style="display: none;" @endif>
                <li>
                    <a href="{{ route('admin.game.lottery539.index') }}">
                        <span> 未開獎 </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.game.lottery539.history') }}">
                        <span> 歷史開獎紀錄 </span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="treeview @if($menu_title == '象棋') active @endif">
            <a href="#">
                <span> 象棋 </span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu @if($menu_title == '象棋') menu-open @endif" @if($menu_title != '象棋')style="display: none;" @endif>
                <li>
                    <a href="{{ route('admin.game.cn_chess.history') }}">
                        <span> 象棋場次列表 </span>
                    </a>
                </li>
            </ul>
        </li>
        <!--/.遊戲管理-->
        @endif
        
        
        <li class="header">商城</li>
        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','product-preview'),''))
        <!--商品管理-->
        <li class="treeview @if($menu_title == '商品管理') active @endif">
            <a href="#">
                <span>商品管理</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu @if($menu_title == '商品管理')   menu-open @endif" @if($menu_title != '商品管理') style="display: none;"@endif>
                
                <li>
                    <a href="{{ route('admin.shop.product.register_card.index') }}" >
                        <span>邀請卡</span>  
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.shop.product.member_card.index') }}" >
                        <span>VIP卡</span> 
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.shop.product.account_transfer.index') }}" >
                        <span>紅包卡</span>    
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.shop.product.share.index') }}" >
                        <span>娛樂幣</span>    
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.shop.product.own_share.index') }}" >
                        <span>專屬娛樂幣</span>    
                    </a>
                </li>  
                <li>
                    <a href="{{ route('admin.shop.product.auction.index') }}" >
                        <span>拍賣卡</span>    
                    </a>
                </li> 
            </ul>
        </li>
        <!--/.商品管理-->
        @endif

         @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','share-transaction-preview'),''))
        <li>
            <a href="{{ route('admin.shop.share_transaction.index') }}" >
                <span>娛樂幣掛單紀錄</span>    
            </a>
        </li>
        @endif

        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','transaction-preview'),''))
        <li>
            <a href="{{ route('admin.shop.transaction') }}" >
                <span>商品交易紀錄</span>    
            </a>
        </li>
        @endif

        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','product-use-record-preview'),''))
        <li>
            <a href="{{ route('admin.shop.product_use_record') }}" >
                <span>商品使用紀錄</span>    
            </a>
        </li>
        @endif

        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','give-product-preview'),''))
        <li>
            <a href="{{ route('admin.shop.give_product.index') }}" >
                <span>贈送商品</span>    
            </a>
        </li>
        @endif
        
        
        <li class="header">會員</li>
        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','member-preview'),''))
        <li>
            <a href="{{ route('admin.member.index') }}" >
                <span>會員管理</span>    
            </a>
        </li>
        @endif

        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','member-account-preview'),''))
        <li>
            <a href="{{ route('admin.member.account.search') }}" >
                <span>會員帳戶明細查詢</span>    
            </a>
        </li>
        @endif

        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','member-betrecord-preview'),''))
        <li>
            <a href="{{ route('admin.member.bet_record.search') }}" >
                <span>會員下注紀錄</span>    
            </a>
        </li>
        @endif

        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','organization-betrecord-preview'),''))
        <li>
            <a href="{{ route('admin.member.organization_bet_record.search') }}" >
                <span>組織下注歷程</span>    
            </a>
        </li>
        @endif

        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','transfer-ownership-record-preview'),''))
        <li>
            <a href="{{ route('admin.member.transfer_ownership_record.index') }}" >
                <span>會員帳號更名申請列表</span>    
            </a>
        </li>
        @endif

        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','subs-delete-record-preview'),''))
        <li>
            <a href="{{ route('admin.member.subs_delete_record.index') }}" >
                <span>好友帳戶刪除申請列表</span>    
            </a>
        </li>
        @endif

        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','statistic-preview'),''))
        <li class="header">統計報表</li>
        <li>
            <a href="{{ route('admin.statistic.shop_revenue.summary') }}" >
                <span>商城營收</span>    
            </a>
        </li>
        <li>
            <a href="{{ route('admin.statistic.manage_account.summary') }}" >
                <span>禮券支出</span>    
            </a>
        </li>
        <li>
            <a href="{{ route('admin.statistic.interest_account.summary') }}" >
                <span>紅利點數支出</span>    
            </a>
        </li>
        <li>
            <a href="{{ route('admin.statistic.cash_account.summary') }}" >
                <span>金幣增減</span>    
            </a>
        </li>
        @endif

        <li class="header">系統</li>
        <li class="treeview @if($menu_title == '網站內容管理') active @endif">
            <a href="#">
                <span>網站內容管理</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu @if($menu_title == '網站內容管理') menu-open @endif"@if($menu_title != '網站內容管理') style="display: none;"@endif>
                
                @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','banner-preview'),''))
                <li>
                    <a href="{{ route('admin.banner.index') }}" >
                        <span>banner管理</span>
                        
                    </a>
                </li>
                @endif

                @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','news-preview'),''))
                <li>
                    <a href="{{ route('admin.news.system-alert.index') }}" >
                        <span>彈跳公告管理</span>    
                    </a>
                </li>
                @endif

                @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','news-preview'),''))
                <li>
                    <a href="{{ route('admin.news.index') }}" >
                        <span>最新消息</span>
                    </a>
                </li>
                @endif

                @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','marquee-preview'),''))
                <li>
                    <a href="{{ route('admin.marquee.index') }}" >
                        <span>跑馬燈管理</span>    
                    </a>
                </li>
                @endif

                @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','page-preview'),''))
                <li>
                    <a href="{{ route('admin.page.index') }}" >
                        <span>頁面內容管理</span>    
                    </a>
                </li>
                @endif

                @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','board-message-preview'),''))
                <li>
                    <a href="{{ route('admin.board_message.index') }}" >
                        <span>留言板管理</span>    
                    </a>
                </li>
                @endif

            </ul>
        </li>

        @if(Auth::guard('admin')->user()->ability(array('super-admin','master-admin','company-transfer-preview'),''))  
        <li>
            <a href="{{ route('admin.system.company_transfer.index') }}" >
                <span>公司發紅包</span>    
            </a>
        </li>
        @endif


        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','parameter-preview'),''))
        <li>
            <a href="{{ route('admin.parameter.index') }}">
                <span> 參數設定 </span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.cn_chess_chip.index') }}">
                <span> 象棋籌碼參數設定 </span>
            </a>
        </li>
        @endif

        @if(Auth::guard('admin')->user()->ability(array('super-admin','master-admin','admin-activity-preview'),''))  
        <li>
            <a href="{{ route('admin.admin_activity.index') }}">
                <span> 後台操作紀錄 </span>
            </a>
        </li>
        @endif

        @if(Auth::guard('admin')->user()->ability(array('super-admin','master-admin','schedule-record-preview'),''))  
        <li>
            <a href="{{ route('admin.schedule_record.index') }}">
                <span> 排程執行紀錄 </span>
            </a>
        </li>
        @endif

        @if(Auth::guard('admin')->user()->ability(array('super-admin','master-admin','login-record-preview'),''))  
        <li>
            <a href="{{ route('admin.login_record.index') }}">
                <span> 會員登入紀錄 </span>
            </a>
        </li>
        @endif

        @if(Auth::guard('admin')->user()->ability(array('super-admin','master-admin'),''))  
        <li>
            <a href="{{ route('admin.admin.index') }}">
                <span> 管理員列表 </span>
            </a>
        </li>
        @endif

        </ul><!-- /.sidebar-menu -->
    </section><!-- /.sidebar -->