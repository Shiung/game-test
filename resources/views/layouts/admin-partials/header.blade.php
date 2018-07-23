<!-- Header Navbar -->
<nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
  <!-- Navbar Right Menu -->
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!--線上儲值-->
      @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','charge-preview'),''))
      <li class="hidden-xs">
        <a class="nav-link" href="{{ route('admin.charge.index') }}" >線上儲值列表</a>
      </li>
      @endif

      <!--紅包群發-->
      @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','withdrawal-preview'),''))
      <li class="hidden-xs">
        <a class="nav-link" href="{{ route('admin.withdrawal.index') }}" >紅包群發紀錄</a>
      </li>
      @endif

      <!--娛樂幣發行-->
      @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','share-preview'),''))
      <li class="hidden-xs">
        <a class="nav-link" href="{{ route('admin.share_record.index') }}" >娛樂幣發行</a>
      </li>
      @endif

      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i></a>
        <ul class="dropdown-menu">
          <!--線上儲值-->
          @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','charge-preview'),''))
          <li class="visible-xs">
            <a class="nav-link" href="{{ route('admin.charge.index') }}" >線上儲值列表</a>
          </li>
          @endif

          <!--紅包群發-->
          @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','withdrawal-preview'),''))
          <li class="visible-xs">
            <a class="nav-link" href="{{ route('admin.withdrawal.index') }}" >紅包群發紀錄</a>
          </li>
          @endif

          <!--娛樂幣發行-->
          @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','share-preview'),''))
          <li class="visible-xs">
            <a class="nav-link" href="{{ route('admin.share_record.index') }}" >娛樂幣發行</a>
          </li>
          @endif
          <li><a href="{{ route('admin.logout.process') }}">登出</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>