<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php


$date = date_create('2024-10-10 10:30:20');
$date1 = date_format($date,'d/m/Y') ;
echo $date1;
echo "<br>";
$date2 = date_format($date,'Y-m-d');
echo $date2;
echo "<br>";
$date3 = date_format($date,'\l\e\ d/m \à H:i:s');
echo $date3;
echo "<br>";
$date4 = date_format($date,"I\l\ \E\s\T \E\x\a\c\T\E\m\E\N\T H:i \E\T\ s \s\E\c\o\N\d\E");
echo $date4;
$second = date_format($date,'s');
$heure = date_format($date, 'H');

if ($second >= 1){
    echo '(s)';
}
$liste_date = array($date1,$date2,$date3,$date4);
echo "<br>";
print_r($liste_date);

echo "<br>";

if ($heure > 3 AND $heure <= 07){
    echo "Bon matin";
}
elseif ($heure > 07 AND $heure <= 15){
    echo "Bonjour";
}
elseif ($heure >16 AND $heure <= 21){
    echo "Bonjour";
}
elseif ($heure > 21 AND $heure < 24 OR $heure >= 0 AND $heure <= 3)

$une_semaine  = mktime(0, 0, 0, date("m")  , date("d")+7, date("Y"));
$une_semaine = date_format($une_semaine,'Y/m/d');
$un_mois = mktime(0, 0, 0, date("m")+1, date("d"),   date("Y"));
$un_an  = mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1);

echo $une_semaine;
echo "<br>";
echo $un_mois;
echo "<br>";
echo $un_an;
echo "<br>";




?>
</body>
</html>