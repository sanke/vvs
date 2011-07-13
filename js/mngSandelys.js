/**
 *
 * @access public
 * @return void
 **/

$(document).ready(function() {

  $(function() {
    $("input:submit").button();
    $( "#in-WH-ValidDate" ).datepicker({
      dateFormat : 'yy-mm-dd',
      defaultDate : '+1'
    });

    $( "#in-WH-ValidDate" ).val(getDate());

    $("#dlg-WH-NewSandProd" ).dialog({
      autoOpen:false,
      resizable:false,
      title: 'Naujas sandėlio produktas',
      modal: true
    });

    $("#dlg-WH-NewProd" ).dialog({
      autoOpen:false,
      resizable:false,
      title: 'Naujas produktas',
      position: 'center',
      modal: true
    });

    $("#tblWarehouse tr").hover(
      function() {
        $(this).children("td").addClass("tbl-hover");
      },
      function() {
        $(this).children("td").removeClass("tbl-hover");
      }
      );

    $("#tblWarehouse tr").tooltip();
    $(".wildCard").tooltip();
  });


  /*
  $("#btnNewProd1").click(function() {
  		var params = new Array();

  	 	params[0] = $("#prodSaras :selected").val();
  		params[1] = $("input#kiekis").val();
  	  	dataString = makeDataStr(11,params);

  		if(!validateInput())
  		{
  			return false;

  		}

  	  	$.ajax({
   			type: "POST",
    			url: "functions/process.php",
    			data: dataString,
    			success: function(msg) {

    			$("#sandSaras").html(msg);
      		$("#info").html("Produkto kiekis atnaujintas").show();
      		}
      	});
  	  	return false;
  });
*/
  $('#btn-WH-RemWareProd').unbind('click').bind('click',function() {
    var params = new Array();
    params[0] = $("input[name='selWh']:checked").val();

    if(!params[0]) {
      error("Pasirinkite sandėlio produktą");
      return false;
    }

    dataString = makeDataStr(16,params);



    $.ajax({
      type: "POST",
      url: "include/process.php",
      data: dataString,
      success: function(msg) {
        $("input[name='selWh']:checked").parent().parent().remove();
        info("Produktas išregistruotas iš sandėlio");
      }
    });
    return false;
  });

  $("#btn-WH-AddWareProd").unbind('click').bind('click',function() {
    $("#dlg-WH-NewSandProd").dialog("open");
    return false;
  });

  $("#tblWarehouse tr").unbind('click').bind('click',function() {
    $("input[name='selWh']",this).attr('checked','checked');
    return false;
  });

  $("#btn-wh-close-prod-dlg").unbind('click').bind('click',function() {
    $("#dlg-WH-NewSandProd").dialog("close");
    return false;
  });

  $("#btn-WH-NewProd").unbind('click').bind('click',function() {
    var params=new Array();

    params[0]=	$("input#in-WH-ProdName").val();
    params[1]=	$("#lst-WH-Units :selected").val();
  
    if(params[0].length < 3) {
      error("Produkto pavadinimas turi būti ne mažiau 3 simbolių");
      return;
    }
    var dataString = makeDataStr(2,params);

    $.ajax({
      type: "POST",
      url: "include/process.php",
      data: dataString,
      success: function(msg) {
        info(msg);
      }
    });

    return false;
  });

  $("#btn-WH-RemProd").unbind('click').bind('click',function() {
    var params=new Array();

    params[0]=	$("#lst-wh-Prod-list :selected").val();

    var dataString = makeDataStr(4,params);

    $.ajax({
      type: "POST",
      url: "include/process.php",
      data: dataString,
      success: function(msg) {
        if(!msg) {
          info("Produktas pašalintas");
          $("#lst-wh-Prod-list :selected").remove();
        }
        else
          error(msg);
      }
    });

    return false;
  });

  $("#btn-WH-AddProd").unbind('click').bind('click',function() {

    var params=new Array();

    params[2]=	$("input#in-WH-ValidDate").val();
    params[1]=	$("input#in-WH-Count").val();
    params[0]=	$("#lst-WH-Prod :selected").val();
   
    if(isNaN(params[1])) {
      error("Įveskite kiekį skaičiais");
      return;
    }
    
    var dataString = makeDataStr(17,params);

    $.ajax({
      type: "POST",
      url: "include/process.php",
      data: dataString,
      success: function(msg) {
        if(!msg)
          info("Produktas užregistruotas sandėlyje");
        else
          error(msg);
        var $tabs = $('#tabs').tabs();
        var selected = $tabs.tabs('option', 'selected');
        $('#tabs').tabs("load", selected);
      }
    });

    return false;
  });


  $("#btn-WH-NewProdDlg").unbind('click').bind('click',function() {
    $("#dlg-WH-NewProd").dialog("open");
    return false;
  });

  $("#btn-wh-close-wh-prod-dlg").click(function() {
    $("#dlg-WH-NewProd").dialog("close");
    return false;
  });

  $("#btn-wh-print").unbind('click').bind('click',function() {
    PrintContent("#tblWarehouse");
    return false;
  });

});