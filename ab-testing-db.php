<?php
include_once('ab-testing-db-connection.php');
//Create table in the database
$sql_create = "CREATE TABLE IF NOT EXISTS `exads_testing` (".
    "`design_id` int(11) AUTO_INCREMENT,".
    "`design_name` VARCHAR(255) NOT NULL DEFAULT '',".
    "`design_url` VARCHAR(255) NOT NULL DEFAULT '',".
    "`split_percent` DECIMAL(4,2) UNSIGNED NOT NULL DEFAULT 0.0,".
    "`actual_hit` DECIMAL(4,2) UNSIGNED NOT NULL DEFAULT 0.0,".
    "primary key (design_id)".
    ");";

// Running the query
if ($mysqli->query($sql_create)) {
    echo "Table created.";
} else {
    echo "Error \n" . mysqli_error($mysqli);
}

// Defining the business logic of design here
$testModel[0]=array("Design_name", "Design_url", "split_percent");
$testModel[1]=array("Design 1", "https://design1.com", 50);
$testModel[2]=array("Design 2", "https://design2.com", 25);
$testModel[3]=array("Design 3", "https://design3.com", 25);

$values = array();
$fields = implode(', ', array_shift($testModel));
foreach ($testModel as $rowValues) {
    foreach ($rowValues as $key => $rowValue) {
         $rowValues[$key] = "'".$mysqli->real_escape_string($rowValues[$key])."'";
    }

    $values[] = "(" . implode(', ', $rowValues) . ")";
}

// Inserting the design pages into db
$sql_insert = "INSERT INTO `exads_testing` ($fields) VALUES " . implode (', ', $values);
echo $sql_insert;
if($result = $mysqli->query($sql_insert)){
    printf ("\n Table created \n");
} else {
    printf("\n Error \n %s",mysqli_error($mysqli) );
}
?>