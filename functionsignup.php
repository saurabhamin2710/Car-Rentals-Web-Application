<?php
error_reporting(1);
	function ExecuteQuery ($SQL)
	{	
		$con=mysqli_connect ("localhost", "root","");
		mysqli_select_db ($con,"accounts");
		
		$rows = mysqli_query ($con,$SQL);
		
		mysqli_close ($con);
		
		return $rows;
	}
	
	function ExecuteNonQuery ($SQL)
	{
		$con=mysqli_connect ("localhost", "root","");
		mysqli_select_db ($con,"accounts");
		
		$result = mysqli_query ($con,$SQL);
		
		mysqli_close ($con);
		
		return $result;
	}
?>