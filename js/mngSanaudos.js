$(document).ready(function() {
  $(function() {
    $("input:submit").button();
    $( "#in-consumed-filter" ).val(getDate());
    $( "#in-consumed-filter" ).datepicker({
      dateFormat : 'yy-mm-dd',
      onSelect: function(dateText, inst) {
        var params=new Array();
        params[0]=	dateText;

        dataString = makeDataStr(20,params);
        $("#tbl-consumed-prod").empty().html('<img src="img/loading.gif" />');
        $.ajax({
          type: "POST",
          url: "include/process.php",
          data: dataString,
          success: function(msg) {
            $("#tbl-consumed-prod").html(msg);
            $("#tbl-consumed-title").html("Produktų sąnaudos: " + dateText);
          }
        });
      }
    });  
  });
  
  $("#btn-consumed-showall").unbind('click').bind('click',function() {
    dataString = "&ID=21";

    $.ajax({
      type: "POST",
      url: "include/process.php",
      data: dataString,
      success: function(msg) {
        $("#tbl-consumed-prod").html(msg);
      }
    });
    return false;
  });
  
  $("#btn-consumed-print").unbind('click').bind('click',function() {
    PrintContent("#tbl-consumed-prod");
    return false;
  });
});