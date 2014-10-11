<?php
namespace View;

class WorkoutView{
	
	public function userMenu($username){
		return "<p>Inloggad som " . $username . "</p>";
	}
}