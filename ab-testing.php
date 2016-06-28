<?php
include_once('ab-testing-db-connection.php');
/*
 * NOTE: db structure is scripted in ab-testing-db.php
 * The code below goes on every design page
 * Below code goes on every design page
 * Generate an array from the fetched results
 */ 
$sql_fetch =   "SELECT * FROM `exads_testing`;";
if($result = $mysqli->query($sql_fetch) ){
    $rows = $result->fetch_all(MYSQLI_ASSOC);      
} else {
    echo "Error \n" . mysqli_error($mysqli);
}

$cumulativePercent = 0;
$rand = mt_rand(1,100);
$percentArray = array_column($rows,'split_percent');
foreach ($percentArray as $key => $value){
    $cumulativePercent += $percentArray[$key];
    //echo $cumulativePercent . "\n";
    if($rand <= $cumulativePercent){
        //Incrementing the result in the database
        $sql_increment =    "UPDATE `exads_testing` SET ".
                            "actual_hit = actual_hit + 1 WHERE ".
                            "design_id = ". ($key + 1) . ";";
        $result = $mysqli->query($sql_increment);
        
        // Redirecting using 301 (permanent redirect)
        $url = $rows[$key]['design_url'];
        header("Location:$url", TRUE, 301);
        break;
    }
}
?>