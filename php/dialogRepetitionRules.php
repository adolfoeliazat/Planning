<script type="text/javascript">
var	exceptions = [];
$(document).ready(function () {
  $("#dialogRepetitionRules").dialog({
    autoOpen: false,
      modal: false,
      minWidth: 400,
      buttons: {
	"Finir": function() {
	  $.ajax(
	    {
	      type: "POST",
		url: "api/action_repetition.php",
		data: {'members' : members, 'exceptions' : exceptions, 'rep_days' : rep_days, 'rep_end_month' : rep_end_month, 'rep_end_day' : rep_end_day, 'rep_start_year' : rep_start_year, 'rep_start_month' : rep_start_month, 'rep_start_day' : rep_start_day, 'rep_type' : rep_type},
		success: function(xml)
		{
		  console.log(xml);
		  return ;
		  var racine = xml.firstChild;
		  if (racine.nodeName == "success")
		  {
		    // loadPlannings();
		  }
		  else
		  {
		    displayPopup("error", racine.firstChild.nodeValue);
		  }
		}
	    });
	  $(this).dialog( "close" );
	},
	  "Annuler": function() {
	    $(this).dialog( "close" );
	  }
      },
	close: function() {
	}
  }).draggable();

  $("#addException").on('click', function()
{
  var	ex = [$(".legendPlanningItem.focused").data('id'), $("#ex_day").val()];
  exceptions.push(ex);
  $(this).next().next().after("<span>" + $(".legendPlanningItem.focused").children().eq(0).html() + " - Jours " + ex[1] + "</span></br>");
});
});
</script>

<div id="dialogRepetitionRules" class="ui-widget" title="Répétition : Exception">
	<form id="frmRepetition">
		<span>Voulez-vous ajouter des exceptions à la répétition ?</span></br></br>
		<span>- Selectionnez le type</span></br>
		<span>Jours : <input type="number" name="ex_day" id="ex_day" value="0" min="-31" max="31" class="text ui-widget-content ui-corner-all" /> </span> <input style="float:right;" id="addException" type="button" value="Ajouter"/></br></br>
	</form>
</div>
