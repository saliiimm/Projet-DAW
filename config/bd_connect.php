<?php 

//on se connecte à notre base de donnée en insérant le host,le nom d'utilisateur le mot de passe ainsi que le nom de notre databse dans cet ordre
$conn = mysqli_connect('localhost','Salim&Ramzy','1234','projet_daw');

//Par la suite on verifie si l'on s'est bien connecté à la DB:
if(!$conn){
    echo 'connection error: ' . mysqli_connect_error();
}    


?>