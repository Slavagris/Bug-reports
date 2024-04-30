<?php 
 $servername='localhost';
 $username='root';
 $password='';
 $dbname = "FloridaTestCase";
 $db=mysqli_connect($servername,$username,$password,"$dbname");
   if(!$db){
       die('Could not Connect MySql Server:');
     }
    
?>;