$(document).ready(function() {
  $("input:submit").button();

  $("#inPassword").keyup(function(event){
    if(event.keyCode == 13){
      $("#btnLogin").click();
    }
  });

  $("#btnLogin").unbind('click').bind('click', function() {
    var params = new Array();

    params[0]= $("input#inName").val();
    params[1] = $("input#inPassword").val();

    dataString = makeDataStr(15,params);

    $.ajax({
      type: "POST",
      url: "include/process.php",
      data: dataString,
      success: function(msg) {
        if(msg) {
          error(msg);
          return false;
        }
        location.reload();
      }
    });

    return false;
  });
});