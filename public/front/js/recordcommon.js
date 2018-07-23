//search for date range
function searchDateRange(start,end,url){
    if (Date.parse(start) > Date.parse(end) ) {
        swal("Error", "日期範圍有誤，請重新輸入", 'error');
        return false;
    }
    if (!start || !end) {
        swal("Error", "請輸入完整搜尋日期", 'error');
        return false;
    }
    if(!dateValidationCheck(start) ||  !dateValidationCheck(end)){
        swal("Failed", "日期格式有誤",'error');
        return false;
    }
    window.location.href = APP_URL+url+start+'/'+end;
}
//date format validate
function dateValidationCheck(dateString) {
    var regEx = /^\d{4}-\d{2}-\d{2}$/;
    if(!dateString.match(regEx)) {
      return false;
    } else {
      return true;
    }
 
}