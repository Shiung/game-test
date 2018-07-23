<div class="row">
    <div class="col-sm-10">
        <div class="input-group">
            <input type="date" class="form-control" name="start" id="start" value="{{ $start }}">
            <span class="input-group-addon">~</span>
            <input type="date" class="form-control" name="end" id="end" value="{{ $end }}">
        </div>
    </div>
    <div class="col-sm-2">
        <input type="button" class="btn btn-info btn-block" id="search" value="查詢" >
    </div>
</div>
<input type="hidden" id="period_type" name="period_type" value="d" >