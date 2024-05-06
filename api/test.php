<?php 
session_start();
print_r($_SESSION['Load']);
echo "<br><br>";


echo($_SESSION['Load']['SES']['Function']). "=";
echo($_SESSION['Load']['SES']['Value']); 

echo "<br>";

echo($_SESSION['Load']['SLBA']['Function']). "=";
echo($_SESSION['Load']['SLBA']['Value']);

echo "<br>";

echo($_SESSION['Load']['SUBA']['Function']). "=";
echo($_SESSION['Load']['SUBA']['Value']);
