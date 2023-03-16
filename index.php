<?php
session_start(
    [
        'cookie_lifetime'=>300,
    ]
    );
    $error = false;
    //session_destroy();

    $username = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING );
    $password = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );
    $fp = fopen("./data/user.txt", "r");
    if($username && $password){
        $_SESSION['loggedin']=false;
        $_SESSION['user']=false;
        $_SESSION['role']=false;
        while($data = fgetcsv($fp)){
            if($data[0] == $username && $data[1] == sha1($password)){
                $SESSION['loggedin'] = true;
                $SESSION['user'] = $username;
                $_SESSION['role'] = $data[2];
                header("location:index.php");
            }
        }
        if(!$_SESSION['loggedin']){
            $_error = true;
        }
    }
    if ( isset($_GET['logout'])){
        $_SESSION['loggedin'] = false;
        $_SESSION['user'] = false;
        $_SESSION['role']=false;
        session_destroy();
        header('location:index.php');
    }


    $_SESSION['loggedin'] = false;
    if(isset($_POST['username']) && isset($_POST['password'])){
        if('admin' ==$_POST['username'] && '87tyhfger5467uhjde45wrfdgj'==Sha1($_POST['password'])){
            $_SESSION['loggedin']=true;
        }else{
            $error = true;
            $_SESSION['loggedin']=false;
        }
    }
    if(isset($_POST['logout'])){
        $_SESSION['loggedin']=false;
        session_destroy();
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
</head>
<body>
    <h1>Simple Auth Example</h1>
    <?php
    echo sha1("rabbit") . "<br/>";
    if(true == $_SESSION['loggedin']){
        echo "Hello Admin,Welcome!";
    }
    else{
        echo "Hello Stranger,Login Below";
    }
    ?>
    <?php
    if($error){
        echo "<blockquate>Username and Password did not match</blockquate>";
    }
    if(false == $_SESSION['loggedin']):
    
    ?>
    <form method="post">
    <label for="username">Username</label><br>
    <input type="text" name='username'><br> <br>
    <label for="password">Password</label><br>
    <input type="text" name="password" id="password"><br>
    <button type="login" class="button-primary" name="login">Login</button><br>

</form>
<?php else:
?>
<form action="index.php?logout=true"method="post">
    <input type="hidden"name="logout"value="1">
    <button type="logout" class="button-primary" name="logout">Logout</button><br>
<?php
endif;
?>
    
</body>
</html>