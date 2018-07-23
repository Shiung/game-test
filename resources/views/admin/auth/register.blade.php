

<h1>註冊會員</h1>
<form id="Form" aciton="{{ route('admin.adduser.process') }}" method="POST">
    <div class="row">
      <div class="col-sm-6">
        <fieldset class="form-group">
          <label for="username">帳號 *</label>
          <input type="text" class="form-control" name="username" id="username" value="">
        </fieldset>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <fieldset class="form-group">
          <label for="password">密碼 *</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="">
        </fieldset>
      </div>
      <div class="col-sm-6">
        <fieldset class="form-group">
          <label for="password_confirm">確認密碼 *</label>
          <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="">
        </fieldset>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">

          <fieldset class="form-group">
            <label for="name">名稱 *</label>
            <input type="text" class="form-control" name="name" id="name" value="">
          </fieldset>    

      </div>
      <div class="col-sm-6">

          <fieldset class="form-group">
            <label for="email">信箱*</label>
            <input type="text" class="form-control" name="email" id="email" placeholder="">
          </fieldset>

      </div>
    </div>


    <!-- 額外資訊 -->
    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}"> 

    <center>
         <button type="submit" class="btn btn-primary">送出</button>
    </center>

</form> 

