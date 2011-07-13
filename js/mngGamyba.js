$(document).ready(function() {
  $(function() {
    $("input:submit").button();

    $( "#in-prod-date-filter" ).datepicker({
      dateFormat : 'yy-mm-dd',
      onSelect: function(dateText, inst) {
        var params=new Array();
        params[0]=	dateText;

        dataString = makeDataStr(13,params);

        $.ajax({
          type: "POST",
          url: "include/process.php",
          data: dataString,
          success: function(msg) {
            $("#tbl-prod-list").html(msg);
            rebindHover("#tbl-prod-list tr");
            $("#tbl-prod-title").html("Gaminami patiekalai: " + dateText);
          }
        });
      }
    });
    $( "#in-prod-date-filter" ).val(getDate());
    $("#in-prod-date-pick").val(getDate());
    $("#in-prod-date-pick").datepicker({
      dateFormat : 'yy-mm-dd'
    });

    $("#dlg-prod-new-prod" ).dialog({
      autoOpen:false,
      resizable:false,
      modal: true,
      minWidth: 400,
      title: "Naujas įrašas"
    } );

    $("#tbl-prod-list tr").hover(
      function() {
        $(this).children("td").addClass("tbl-hover");
      },
      function() {
        $(this).children("td").removeClass("tbl-hover");
      });


  });

  $("#tbl-prod-list tr").live('click',function() {
    $("input[name='selPD']",this).attr('checked','checked');
    return false;
  });


  $("#btn-prod-new-prod-dlg").unbind('click').bind('click',function() {
    $("#dlg-prod-new-prod").dialog("open");
    return false;
  });



  $("#btn-prod-add-prod").unbind('click').bind('click',function() {
    var params = new Array();

    params[0] = $("#lst-prod-dishes :selected").val();
    params[1] = $("#lst-prod-cooks :selected").val();
    params[2] = $("input#in-prod-count").val();
    params[3] = $("input#in-prod-date-pick").val();
    
    if(isNaN(params[2]) || params[2] <= 0) {
      error("Įveskite kiekį skaičiais didesnį už nulį");
      return;
    }
    
    dataString = makeDataStr(12,params);

    if(!validateInput())
    {
      return false;

    }

    $.ajax({
      type: "POST",
      url: "include/process.php",
      data: dataString,
      success: function(msg) {
        if(!msg)
          info("Patiekalas užregistruotas gamybai");
        else
          error(msg);
        reloadCurrentTab();
      }
    });
    return false;

  });

  $("#btn-prod-rem-prod").unbind('click').bind('click',function() {
    var params = new Array();
    params[0] = $("input[name='selPD']:checked").val();

    if(!params[0]) {
      error("Pasirinkite sandėlio produktą");
      return false;
    }

    dataString = makeDataStr(19,params);



    $.ajax({
      type: "POST",
      url: "include/process.php",
      data: dataString,
      success: function(msg) {
        if(!msg) {
          info("Produktas išregistruotas iš sandėlio");
          $("input[name='selPD']:checked").parent().parent().remove();
        }
        else
          error(msg);
      }
    });
    return false;
  });

  $("#btn-prod-showall").unbind('click').bind('click',function() {
    dataString = "&ID=14";

    $.ajax({
      type: "POST",
      url: "include/process.php",
      data: dataString,
      success: function(msg) {
        $("#tbl-prod-list").html(msg);
        rebindHover("#tbl-prod-list tr");
      }
    });
    return false;
  });

  $("#btn-prod-print").unbind('click').bind('click',function() {
    PrintContent("#tbl-prod-list");
    return false;
  });

});