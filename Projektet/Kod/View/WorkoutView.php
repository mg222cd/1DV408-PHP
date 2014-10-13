<?php
namespace View;

class WorkoutView{
	
	public function userMenu($username){
		$html= "
		<div class='row'>
		<div class='col-xs-12 col-sm-12'>
		<div id ='usermenu'>
        <p>Inloggad som " . $username . " <a id='logoutlink' href='?action=".NavigationView::$actionSignOut."'>Logga ut</a></p>
        </div>
        </div>
        </div>";
		return $html;
	}

	public function workoutList($workoutList){
		$resultsrow='';
		foreach ($workoutList as $workout) {
			$resultsrow .= '<tr>
								<td>'.$workout->getDate().'</td>
								<td>'.$workout->getWorkoutTypeId().'</td>
								<td>'.$workout->getDistance().'</td>
								<td>'.$workout->getTime().'</td>
								<td>'.'ej klart'.'</td>
								<td>'.$workout->getComment().'</td>
							<tr>';
		}
		$html= "
			<div class 'row'>
			<div class='col-xs-12'>
			<div id='workoutTable' class='table-responsive'>
			<table class='table table-striped table-bordered'>
				<tr>
					<th>Datum</th>
					<th>Träningstyp</th>
					<th>Distans (km)</th>
					<th>Tid</th>
					<th>Snitt(/km)</th>
					<th>Kommentar</th>
				<tr>"
				.$resultsrow."
			</table>
			</div>
			</div>
			</div>
		";
		return $html;
	}
	
}