<?php

function redirect($path){
    header("Location:  " . BASE_URL . $path);
    exit;


}

function loginUser($pdo,$login,$password){
    #Qeury 2
    $sql = "
    SELECT
          user_id,
          user_email,
          user_username,
          user_role
    FROM users 
    WHERE user_email = :login 
       OR user_username = :login 
    LIMIT 1

    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':login' => $login]);

    $user = $stmt->fetch();

    if(!$user){
    }
    if(!$password_verfy($passwword, $user['user_password'])){
       return false;
       }

   $_SESSION['user_id']=$user['user_id'];
   $_SESSION['user_email']=$user['user_email'];
   $_SESSION['user_username']=$user['user_username'];
   $_SESSION['user_role']=$user['user_role'];
    
   return true;
   }

  function requirelogin() {
    if(!isset($_SESSION['user_id'])){
        header('Location: ' . BASE_URL . 'logim.php');
        exit;
    }
  }

  function requireRole($role) {
   requireLogin();

   if($_SESSION['user_role']  !== $role){
    http_reponse_code(403);
    die('Acces denied.');
    
   }
  }
?>