<?php 
$connstr="DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=" . realpath("d:/rtxserver/db/rtxdb.mdb"); 
$connid=odbc_connect($connstr,"","",SQL_CUR_USE_ODBC); 

$result = odbc_tables($connid);

$tables = array();

while (odbc_fetch_row($result)){

  if(odbc_result($result,"TABLE_TYPE")=="TABLE")

  	$table=odbc_result($result,"TABLE_NAME");
    echo"<br><b>".$table.'</b><br>';

	//$r=odbc_exec($connid,"select top 10 * from ".$table);
	
	$sql = 'SELECT * FROM '.$table;
	$rs = odbc_exec($connid,$sql);

	while (odbc_fetch_row($rs))
	{
	     for($j=1;$j<=odbc_num_fields($rs);$j++) 
	         echo odbc_field_name($rs,$j) . " = " .  odbc_result($rs,$j).'<br/>' ;
	   
	}

  }



?> 