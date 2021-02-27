<?php

//fetch.php

include("database_connection.php");

$query = "SELECT * FROM job";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();
$output = '
<table class="table table-striped table-bordered">
	<tr>
		<th>Title</th>
		<th>Salary</th>
		<th>Day</th>
		<th>City</th>
		<th>Zip Code</th>
		<th colspan="2">Actions</th>
		
	</tr>
';
if($total_row > 0)
{
	foreach($result as $row)
	{
		$output .= '
		<tr>
			<td width="40%">'.$row["Title"].'</td>
			<td width="40%">'.$row["Salary"].'</td>
			<td width="40%">'.$row["Day"].'</td>
			<td width="40%">'.$row["City"].'</td>
			<td width="40%">'.$row["Zip_Code"].'</td>
			<td width="10%">
				<button type="button" name="edit" class="btn btn-primary btn-xs edit" id="'.$row["Job_id"].'">Edit</button>
			</td>
			<td width="10%">
				<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["Job_id"].'">Delete</button>
			</td>
		</tr>
		';
	}
}
else
{
	$output .= '
	<tr>
		<td colspan="4" align="center">Data not found</td>
	</tr>
	';
}
$output .= '</table>';
echo $output;
?>