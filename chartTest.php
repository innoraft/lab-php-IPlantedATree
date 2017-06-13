<?php

$date = new DateTime();
$currTime = $date->getTimestamp();
$currHours =  $date->format('H');
$currMins = $date->format('i');
$currSeconds = $date->format('s');
$prevWeekTimestamp = $currTime - ($currHours*60*60 + $currMins*60 + $currSeconds + 518400); //518400=no of seconds in 6 days
//$prevWeekTimestamp gets timestamp one week ago from 00:00 hours.
$date->setTimestamp($prevWeekTimestamp);
// $timeStampArray = array("7" => $prevWeekTimestamp + 0 * 86400,"6" => $prevWeekTimestamp + 1 * 86400,"5" => $prevWeekTimestamp + 2 * 86400,"4" => $prevWeekTimestamp + 3 * 86400, "3" => $prevWeekTimestamp + 4 * 86400, "2" => $prevWeekTimestamp +  5 * 86400, "1" => $prevWeekTimestamp + 6 * 86400);
// $i = 1;

?>
<?php
include('conn.php');
$sql = "SELECT timestamp from userContent WHERE timestamp >= $prevWeekTimestamp
 ORDER BY timestamp ASC";
$rs = $conn->query($sql);
$day = 2;
$firstTimestamp = $prevWeekTimestamp;
$secondTimestamp = $firstTimestamp + 86400;
$count=0;
$noOfDays = 6;
$timeStampArray = array();

// if(mysqli_num_rows($rs) = 0)

while($row = mysqli_fetch_array($rs)){
    array_push($timeStampArray,$row['timestamp']);
}

$arrayPos = 0;
$posted = false;
$postCount = array();
for($j=$noOfDays; $j>=0; $j--){
    $count = 0;
    while(($timeStampArray[$arrayPos]>=$firstTimestamp) && ($timeStampArray[$arrayPos]<$secondTimestamp) && ($arrayPos<sizeof($timeStampArray)-1)){
        $posted = true;
        $count++;
        $arrayPos++;
    }
    $postCount[$j] = array("day"=>$firstTimestamp,"posts"=>$count);
    $firstTimestamp = $secondTimestamp;
    $secondTimestamp = $secondTimestamp + 86400;
}
// $row = mysqli_fetch_array($rs);
// echo ($row['timestamp']);
// var_dump($timeStampArray);
/*
2nd attempt
for($i=7; $i>=1; $i--){
    echo "First = ".$firstTimestamp."  Second = ".$secondTimestamp."<br>";
    $flagChanged = 0;
    while($row = mysqli_fetch_array($rs)){
        $flagChanged = 1;
        if(($row['timestamp'] >= $firstTimestamp) && ($row['timestamp'] < $secondTimestamp)){
            $count++;
        }
        else{
            $timeStampArray[$i] = array("day"=>$firstTimestamp,"posts"=>$count);
            break;
        }
    }

    if($flagChanged == 0){
        $timeStampArray[$i] = array("day"=>$firstTimestamp,"posts"=>0);
    }
    $firstTimestamp = $secondTimestamp;
    $secondTimestamp = $firstTimestamp + 86400;
    mysqli_data_seek($rs,0);
    $count = 0;     
}
*/

/* main code
while($row = mysqli_fetch_array($rs)){
    // $x = $date->setTimestamp($firstTimestamp);
    // echo $x->format("d/M/y")."<br>";
    if(($row['timestamp'] >= $firstTimestamp) && ($row['timestamp'] <= $secondTimestamp)){
        $count++;
    }
    else{
        $days = $date->setTimestamp($firstTimestamp);
        $timeStampArray[$i] = array("day"=>$days->getTimestamp(),"posts"=>$count);
        var_dump($timeStampArray[$i]);
        $count = 1; //since $row['timestamp'] is already equal to the next value
        $day++;
        $firstTimestamp = $secondTimestamp;
        $secondTimestamp = $prevWeekTimestamp + ($day) * 86400;
        $i--;
    }
}

if($i > 1){
    while($i >= 1){
        $days = $date->setTimestamp($firstTimestamp);
        $days->format('d/M/y');
        $timeStampArray[$i] = array("day"=>$days->format('d/m/y'),"posts"=>0);
        // echo $i." = ".$timeStampArray[$i]["day"]."<br>";
        // $timeStampArray[$i] = array("day"=>$firstTimestamp,"posts"=>0);
        $day++;
        $firstTimestamp = $secondTimestamp;
        $secondTimestamp = $prevWeekTimestamp + ($day) * 86400;
        $i--;
    }
}
var_dump($timeStampArray);
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>jQuery Shield UI Demos</title>
    <link id="themecss" rel="stylesheet" type="text/css" href="//www.shieldui.com/shared/components/latest/css/light/all.min.css" />
    <script type="text/javascript" src="//www.shieldui.com/shared/components/latest/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="//www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
</head>
<body class="theme-light">
<div id="chart"></div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#chart").shieldChart({
            theme: "light",
            primaryHeader: {
                text: "All Users Post Status"
            },
            exportOptions: {
                image: false,
                print: false
            },
            axisX: {
                categoricalValues: [<?php 
                    for($i=$noOfDays;$i>=0;$i--){
                        $date->setTimestamp($postCount[$i]['day']);
                        echo "\"".$date->format('d/M/y')."\",";
                    }
                ?>]
            },
            tooltipSettings: {
                chartBound: true,
                axisMarkers: {
                    enabled: true,
                    mode: 'x'
                }                    
            },
            dataSeries: [{
                seriesType: 'bar',
                collectionAlias: "Number of Posts",
                data: [
                    <?php
                        for($i=$noOfDays;$i>=0;$i--){
                            echo $postCount[$i]['posts'].",";
                        }
                    ?>
                ]
            }]
        });
    });
</script>
</body>
</html>