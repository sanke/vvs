$(document).ready(function() {


  $(function() {
    $("#lst-Dish-Dish").trigger("change");
    $("input:submit,button").button();

    $("#dlg-Dish-Prod" ).dialog({
      autoOpen:false,
      resizable:false,
      modal: true
    });

    $("#dlg-Dish-New-Dish" ).dialog({
      autoOpen:false,
      resizable:false,
      modal: true,
      title: 'Naujas patiekalas'
    });



  });

  $("#btn-Dish-dlg").unbind('click').bind('click',function() {
    $("#dlg-Dish-New-Dish" ).dialog("open");
  });

  $("#btn-Dish-AddDish").unbind('click').bind('click',function() {
    var params=new Array();

    params[0]=	$("#in-Dish-Dish").val();

    if(params[0].length < 3) {
      error("Patiekalo pavadinimas turi būti ne mažiau 3 simbolių");
      return;
    }
    
    dataString = makeDataStr(6,params);

    $.ajax({
      type: "POST",
      url: "include/process.php",
      data: dataString,
      success: function(msg) {
        $("#lst-Dish-Dish").append("<OPTION value=\"" + msg + "\">" + params[0] + "</OPTION>");
        $("#lst-Dish-Dish").val(msg);
        $("#lst-Dish-Dish").trigger("change");
        info("Patiekalas užregistruotas");
      }
    });
    return false;
  });
  /**
   *btn-dish-close-dlg
   * @access public
   * @return void
   **/
  $("#btn-dish-close-dlg").unbind('click').bind('click',function() {
    $("#dlg-Dish-Prod" ).dialog("close");
  });


  $("#btn-Dish-RemDish").unbind('click').bind('click',function() {
    var params=new Array();

    params[0]=	$("#lst-Dish-Dish :selected").val();

    dataString = makeDataStr(7,params);

    $.ajax({
      type: "POST",
      url: "include/process.php",
      data: dataString,
      success: function(msg) {
        $("#lst-Dish-Dish :selected").remove();
        info("Patiekalas pašalintas");
      }
    });
    return false;
  });

  $("#btn-Dish-NewProdDlg").unbind('click').bind('click',function() {
    if($("#lst-Dish-Dish").val() == 0)
      return error("Pasirinkite patiekalą");

    $("#dlg-Dish-Prod").dialog("open");
    $("#dlg-Dish-Prod").dialog({
      title: 'Patiekalo ' + $("#lst-Dish-Dish :selected").text() + ' produktai'
    } );
    return false;
  });

  $("#btn-Dish-AddProd").unbind('click').bind('click',function() {
    var params=new Array();
    params[0]=	$("#lst-Dish-Prod :selected").val();
    params[1]=  $("#lst-Dish-Dish :selected").val();
    params[2]=	$("#in-Dish-Count").val();
    
    if(isNaN(params[2])) {
      error("Įveskite kiekį skaičiais");
      return;
    }
    
    dataString = makeDataStr(8,params);
    params = new Array();
    params[0] = $("#lst-Dish-Dish :selected").val();
    dataStringRefresh = makeDataStr(18,params);
    $.ajax({
      type: "POST",
      url: "include/process.php",
      data: dataString,
      success: function(msg) {
        $.ajax({
          type: "POST",
          url: "include/process.php",
          data: dataStringRefresh,
          success: function(msg) {
            $("#tbl-dish-prod").html(msg);
            $("#tbl-dish-prod td:first").html("Patiekalo " + $("#lst-Dish-Dish :selected").text() + " ingridientai");
          }
        });
      }
    });
    return false;
  });

  $("#btn-Dish-RemProd").unbind('click').bind('click',function() {
    var params=new Array();

    params[0]=	$("#lst-Dish-Dish :selected").val();
    params[1]=  $("input[name='selPPD']:checked").val();

    dataString = makeDataStr(10,params);

    $.ajax({
      type: "POST",
      url: "include/process.php",
      data: dataString,
      success: function(msg) {
        $("input[name='selPPD']:checked").parent().parent().remove();
      }
    });
    return false;
  });

  $("#tbl-dish-prod tr").live('click',function() {
    $("input[name='selPPD']",this).attr('checked','checked');
    return false;
  });


  $("#lst-Dish-Dish").unbind('change').bind('change',function() {
    var params=new Array();

    params[0]=	$("#lst-Dish-Dish :selected").val();

    if(!params[0])
    {
      return false;
    }

    dataString = makeDataStr(9,params);

    $.ajax({
      type: "POST",
      url: "include/process.php",
      data: dataString,
      success: function(msg) {
        $("#tbl-dish-prod").html(msg);
        $("#tbl-ppd-title").html("Patiekalo " + $("#lst-Dish-Dish :selected").text() + " ingridientai");
        rebindHover("#tbl-dish-prod tr");
      }
    });
    return false;
  });


  $("#btn-ppd-print").unbind('click').bind('click',function() {
    PrintContent("#tbl-dish-prod");
    return false;
  });


});