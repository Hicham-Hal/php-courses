<?php
$errors = [];
define('REQUIRED_FIELD_ERROR' , 'This field is require');
$username = '';
$password_confirm= '';
$password = '';
$email = '';
$cv_url = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){

//    echo '<pre>';
//    var_dump($_POST);
//    echo '</pre>';
    $username = post_data('username');
    $email = post_data('email');
    $password = post_data('password');
    $password_confirm = post_data('password_confirm');
    $cv_url = post_data('cv_url');
    //echo '<pre>';
    //var_dump($username , $email , $password , $password_confirm , $cv_url);
    //echo '</pre>';
    if(!$username){
        $errors['username'] = REQUIRED_FIELD_ERROR;
    }elseif (strlen($username) < 6 || strlen($username) > 16){
        $errors['username'] = 'the username must be in between 6 and 16';
    }
    if(!$email){
        $errors['email'] = REQUIRED_FIELD_ERROR;
    }else if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'This field must be valid email address';
    }
    if(!$password){
        $errors['password'] = REQUIRED_FIELD_ERROR;
    }
    if(!$password_confirm){
        $errors['password_confirm'] = 'You must repeat the password';
    }
    if(strcmp($password , $password_confirm) !== 0){
        $errors['password_confirm'] = 'The input must be equal to tha password';
    }
    if(!$cv_url){
        $errors['cv_url'] = 'You must give us a url of your cv';
    }
    if($cv_url && !filter_var($cv_url , FILTER_VALIDATE_URL)){
        $errors['cv_url'] = 'must be a validate URL';
    }
}
    function post_data($field){
        $_POST[$field] ??= false;
        $result = htmlspecialchars(stripslashes($_POST[$field]));
        return $result;
    }


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body style="padding: 50px;">

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" novalidate>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label>Username</label>
                <input class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : '' ?>"
                       name="username" value="<?php echo $username ?>">
                <small class="form-text text-muted">Min: 6 and max 16 characters</small>
                <div class="invalid-feedback">
                    <?php echo $errors['username'] ?? '' ?>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : '' ?>"
                       name="email" value="<?php echo $email ?>">
                <div class="invalid-feedback">
                    <?php echo $errors['email'] ?? '' ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : '' ?>"
                       name="password" value="<?php echo $password ?>">
                <div class="invalid-feedback">
                    <?php echo $errors['password'] ?? '' ?>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label>Repeat Password</label>
                <input type="password"
                       class="form-control <?php echo isset($errors['password_confirm']) ? 'is-invalid' : '' ?>"
                       name="password_confirm"
                       value="<?php
                            if(isset($errors['password_confirm'])){
                                echo $password_confirm = '';
                            }else{
                                echo $password_confirm;
                            }
                            ?>"
                >
                <div class="invalid-feedback">
                    <?php echo $errors['password_confirm'] ?? '' ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-group">
            <label>Your CV link</label>
            <input type="text" class="form-control <?php echo isset($errors['cv_url']) ? 'is-invalid' : '' ?>"
                   name="cv_url" value="<?php echo $cv_url ?>" placeholder="https://www.example.com/my-cv"/>
            <div class="invalid-feedback">
                <?php echo $errors['cv_url'] ?? '' ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <button class="btn btn-primary">Register</button>
    </div>
</form>

</body>
</html>

