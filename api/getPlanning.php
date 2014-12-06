<?php
session_start();

header('content-type:text/html;charset=ISO-8859-15');

require '../class/Database.class.php';

if (isset($_SESSION['idUser'])){

  // $time_start = microtime(true);
  // $time_end = microtime(true);
  // $execution_time = ($time_end - $time_start);
  // echo $execution_time;

  require 'date.php';

  $db = Database::getInstance();

  $result = $db->getMembersByPlanning();

  $month = $_REQUEST['month'];
  $year = $_REQUEST['year'];

  initDateByYear($year);
  if (isNotWorkable(10, 11))
    echo "not workable";

  $arrayLabel = $db->getLabels($month, $year);

  $arrayType = $db->getTypes();

  $nbDays = cal_days_in_month(CAL_GREGORIAN, $month , $year);

  if($result != false)
  {
    $siDay = date("w", mktime (0, 0, 0, $month, 0, $year));
    $iDay = $siDay;
?>
<div class="planningContainer">
	<table class="headerPlanning">
<tr>
	<td class="calendar"><?php echo $_SESSION['currentPlanningName']; ?></td>
	<td class="month"><?php echo MoisFrancais($month)." ".$year; ?></td>
	<td class="navig"><span id="btnPreviousMonth" class="btnNavigate raph"><</span><span id="btnThisMonth" class="btnNavigate text">AUJOURD'HUI</span><span id="btnNextMonth" class="btnNavigate raph">=</span></td>
	</tr></table><div id="legendPlanning">
	<div class="legendPlanningItem" data-id="-2"><span>F�ri�</span><br/><span class="ferrie itemLegendColor"></span></div><div class="legendPlanningItem" data-id="-3"><span>Week End</span><br/><span class="itemLegendColor we"></span></div><?php 
    if ($_SESSION['guest'] != "true") {
	  echo "<div class=\"legendPlanningItem focused\" data-id=\"-1\"><span>Vide</span><br/><span class=\"itemLegendColor\"></span></div>"; }
	    if($arrayType[0] != "null")
	    {
	      for($i = 0; $i < sizeof($arrayType); $i++)
	      {
		echo "<div class=\"legendPlanningItem\" data-id=\"". $arrayType[$i]['id'] ."\"><span>".$arrayType[$i]['name']."</span><br/><span class=\"itemLegendColor\" style=\"background-color: ".$arrayType[$i]['color'].";\"></span></div>";
	      }
	    }
?>
</div>
<table class="planningTable" cellspacing="0" style="width:100%">
<thead>
<tr class="titleDay titleColumnContainer rowTablePlanning"><td class=""></td>
<?php
	    for ($i = 1;$i < $nbDays+1;$i++)
	    {
?>
<td data-number="<?php echo $i; ?>" class="titleColumn" style="min-width: 14px; height:10px;"><?php echo $aJour[($iDay++ % 7)]; ?></td>
<?php
	    }
	    if($_SESSION['guest'] == 'false')
	      echo '<td class=""></td>';
?>
	</tr>
	<tr class="titleColumnContainer rowTablePlanning">
	<td class="nameMemberTitle" style="height:10px;">Nom</td>
<?php
	    for ($i = 1;$i < $nbDays+1;$i++)
	    {
?>
	<td class="dayNumber" data-number="<?php echo $i; ?>" class="titleColumn" style="min-width: 14px; height:10px;"><?php echo $i; ?></td>
<?php
	    }
	    if($_SESSION['guest'] == 'false')
	      echo '<td class="actionMemberTitle" style="width: 66px; height:10px;">Actions</td>';
?>

		</tr>
	</thead>
	<tbody>
<?php
	    if($result[0] != "null")
	    {
	      for ($i = 0;$i < sizeof($result);$i++)
	      {
?>
<tr class="rowTablePlanning">
<td class="nameMember" style="height:10px;"><?php echo $result[$i]['name']; ?></td>
<?php
		$iDay = $siDay;
		for ($j = 1;$j < $nbDays+1;$j++)
		{
?>
<td data-number="<?php echo $j."\""; if(isset($arrayLabel[$result[$i]['name']][$j])) { echo 'data-colorlabel=\''.$arrayLabel[$result[$i]['name']][$j].'\''; } ?> 
class="dayField <?php if (isNotWorkable($j, $month)) echo 'ferrie '; else if (($iDay % 7) > 4) echo 'we'; ++$iDay; ?>" 
style="min-width: 14px; height:10px;"></td>

<?php
		}
		if($_SESSION['guest'] == 'false')
		  echo '<td><span class="raph btnAction modifyMember" href="#" style="margin-left: -4px; margin-top: -1px;">a</span><span class="raph btnAction deleteMember" href="#">&Acirc;</span></td>';
?>
</tr>
<?php
	      }
	    }
?>
						</tbody>
						</table><div id="toolPlanning"><?php
	    echo "<div class=\"toolPlanningPad\"><br/><span style=\"display: inline-block;height: 25px;\"> </span></div>";
	    if($_SESSION['guest'] == 'false')
	      echo '<span class="btnAddMember"><img class="resizedImgPlanning" src="img/user_add_32.png"/>Ajouter</span>';
	    ?><span class="btnPrint"><img class="resizedImgPlanning" src="img/iconprint.png"/>Imprimer</span><span class="btnPDF" enable="disable"><img class="resizedImgPlanning" src="img/pdficon.png"/>PDF</span></div></div><?php
  } else
    echo 'Erreur lors de la recherche du planning';
}
?>
