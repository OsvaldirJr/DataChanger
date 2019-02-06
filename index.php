<?php
include 'classData.php';

$objectdata= new DataChanger('10/05/2018 20:00','+', 4000);

print_r($objectdata->process());