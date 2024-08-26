<?php
// $DateTime= date_create("2024-07-03",timezone_open("Africa/Lagos"));
// echo date_format($DateTime,"Y-m-d H:i:sP");

 date_default_timezone_set("Africa/Lagos");
 $CurrentTime=time();
 $DateTime= strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
 echo $DateTime;