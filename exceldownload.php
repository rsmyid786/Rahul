
<?php 

include('usersession.php');



$setExcelName = "Customer_excel";

$setSql = "select customer.cus_name,customer.companyname,customer.address,customer.city,customer.state,customer.phone,customer.email,team.team_name,executive.executive_name,customer.status,customer.curr_date from team LEFT JOIN customer ON team.email=customer.tl_username RIGHT JOIN executive ON customer.ex_username=executive.executive_email where customer.project_name='$adminproject' and team.project_name='$adminproject' and executive.admin='$adminproject'";

$setRec = mysqli_query($con,$setSql);




$setMainHeader = "Customer Name"."\t"."Company Name"."\t"."Address"."\t"."City"."\t"."State"."\t"."Phone"."\t"."Email"."\t"."Executive"."\t"."Team"."\t"."Status"."\t"."Entry Date"; 

while($rec = mysqli_fetch_row($setRec))  {
  $rowLine = '';
  foreach($rec as $value)       {
    if(!isset($value) || $value == "")  {
      $value = "\t";
    }   else  {
//It escape all the special charactor, quotes from the data.
      $value = strip_tags(str_replace('"', '""', $value));
      $value = '"' . $value . '"' . "\t";
    }
    $rowLine .= $value;
  }
  $setData .= trim($rowLine)."\n";
}
  $setData = str_replace("\r", "", $setData);

if ($setData == "") {
  $setData = "\n no matching records found\n";
}





//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$setExcelName."_Reoprt.xls");
header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n".$setData."\n";

//code end

?>