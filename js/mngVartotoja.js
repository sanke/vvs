



$(document).ready(function() {
  $(function() {
    $("input:submit").button();
    $("#dlg-cook-RegCook" ).dialog({
      autoOpen:false,
      title: 'Naujas varotojas',
      resizable:false,
      modal: true
    });

    for(var i=0;i<51;i++)
    {
      $("#in-cook-Years").append("<OPTION>" + i + "</OPTION>");
    }
  });

  $("#btn-cook-AddCook").unbind('click').bind('click', function() {

    var params = new Array();
    params[0] = $("input#in-cook-login").val();
    params[1] = $("input#in-cook-pass").val();
    params[2]= $("input#in-cook-Name").val();
    params[3] = $("input#in-cook-Surname").val();
    params[4] = $("#sel-cook-user-level :selected").val();

    if(params[1] != $("input#in-cook-pass-rep").val()){
      error("Slaptažodžiai nesutampa");
      return;
    }
    
    if(params[0].length < 3 || params[2] < 3 || params[3] < 3) {
      error("Varotojo vardas, Vardas, Pavardė turi būti ilgesni nei 2 simboliai");
      return;
    }
    
    dataString = makeDataStr(1,params);

    $.ajax({
      type: "POST",
      url: "include/process.php",
      data: dataString,
      success: function(msg) {
        info("Vartotojas užregistruotas");
      }
    });

    return false;
  });

  $("#btn-cook-NewCookDlg").unbind('click').bind('click',function() {
    $( "#dlg-cook-RegCook" ).dialog("open");
    return false;
  });

  $("#btn-cook-RemCook").unbind('click').bind('click',function() {
    var params = new Array();

    params[0]= $("#lst-cook-list :selected").val();

    dataString = makeDataStr(5,params);

    $.ajax({
      type: "POST",
      url: "include/process.php",
      data: dataString,
      success: function(msg) {
        $("#lst-cook-list :selected").remove();
      }
    });
    return false;
  });

});