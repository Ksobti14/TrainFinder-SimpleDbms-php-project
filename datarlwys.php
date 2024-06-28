<?php 
$conn=mysqli_connect("localhost","root","","timetable");
if(!$conn){
       die("error detected".mysqli_error($conn));
}
else{
    echo "connected successfully <br>";
}
$emailaddress=$_POST['email'];
$password=$_POST['password'];
$sql="INSERT INTO `login`(`emailaddress`, `password`) VALUES ('$emailaddress','$password')";
$result=mysqli_query($conn,$sql);
if($result){
    echo"THANK YOU FOR SIGNING IN AND FIND THE BEST POSSIBLE DETAILS OF TRAINSs";
}
else{
    echo "data not submitted";
}