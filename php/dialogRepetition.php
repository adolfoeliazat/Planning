<script type="text/javascript">
var	rep_days;
var	rep_end_month;
var	rep_end_day;
var	rep_start_year;
var	rep_start_month;
var	rep_start_day;

function resetEvents()
{
  $(".nameMember.focusable").each(function(index)
{
  $(this).removeClass('focusable').removeClass('focused');
});

  $(".dayNumber.focusable").each(function(index)
{
  $(this).removeClass('focusable').removeClass('focused');
});
}

$(document).ready(function () {
  $("#dialogRepetition").dialog({
    autoOpen: false,
      modal: false,
      minWidth: 400,
      buttons: {
	"Suivant": function() {
	  $.ajax(
	    {
	      type: "POST",
		url: "api/createPlanning.php",
		data: $('#frmCreatePlanning').serialize(),
		success: function(xml)
		{
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
	  loadDialog('dialogRepetitionRules');
	},
	  "Annuler": function() {
	    $(this).dialog( "close" );
	  }
      },
	close: function() {
	  rep_days = $("#rep_days").val();
	  resetEvents();
	}
  }).draggable();

  // Setup events
  $(".nameMember").each(function(index) { 
    $(this).addClass('focusable');
    $(this).on('click', function() {
      $(this).toggleClass('focused');
    });
  });
  $(".dayNumber").each(function(index) { 
    $(this).addClass('focusable');
    $(this).on('click', function() {
      if ($(".dayNumber.focusable.focused").length > 0)
	$(".dayNumber.focusable.focused").removeClass('focused');
      $(this).addClass('focused');
    });
  });

});
</script>

<div id="dialogRepetition" class="ui-widget" title="Action : Répétition">
	<form id="frmRepetition">
		<span>- Selectionnez les personnes</span></br></br>
		<span>- Selectionnez la date de depart</span></br></br>
		<span>Intervalle (Jours) : <input type="number" value="7" name="rep_days" id="rep_days" min="1" max="9999" class="text ui-widget-content ui-corner-all" /></span></br></br>
		<span>Durée : <input type="number" name="rep_end_month" id="rep_end_month" value="0" min="0" max="12" class="text ui-widget-content ui-corner-all" /> Mois 
		<input type="number" value="0" name="rep_day" id="rep_day" min="0" max="31" class="text ui-widget-content ui-corner-all" /> Jours</span></br>
	</form>
</div>