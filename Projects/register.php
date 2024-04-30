<?php
require_once "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    $login = trim($_POST['name']);
    $password = trim($_POST['password']);
    $confimpassword = trim($_POST['confimpassword']);
    $email = trim($_POST['email']);
    $errors = array();

    if($query = $db->prepare("SELECT * FROM users WHERE login = ?")) {
        $errors[] = '';

        $query->bind_param('s', $login);
        $query->execute();

        $query->store_result();
            if ($query->num_rows > 0) {
                $errors[] = 'Ваш аккаунт уже есть в базе данных';
            }else {
                if(strlen($login) < 10){
                    $errors[] = 'Ваш логин должен быть больше 10 символов';
                }

                if(strlen($password) < 10) {
                    $errors[] =  'Ваш пароль должен бытьт больше 10 символов';
                }
                if(empty($confimpassword)) {
                    $errors[] = '<p>Повторите пароль, строка пустая</p>';
            
                }else {
                    if(empty($error) && ($password != $confimpassword)) {
                        $errors[] =  'Пароль не совпадает';
                    }
                }
                
                if (empty($error)) {
                    $insertQuery = $db->prepare("INSERT INTO users (login,password,email) VALUE (?,?,?,?);");
                    $insertQuery->bind_param("sss", $login, $password, $confimpassword, $email);
                    $result = $insertQuery->execute();
                    if ($result) {
                        $errors[] = 'Вы зарегистрированы';
                    }else{
                        $errors[] =  'Что-то не так';
                    }
                }
                
                
            }

    }
    $query->close();
    $insertQuery->close();
    $db->close();
}
?>
<!DOCTYPE html>
<html  lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="UTF-8" />
        <title>|Florida| Test-case</title>
        <link rel="icon" href="icons8-баг-50.png">
         
         <link rel="stylesheet" href="style.css">
        <body>
            <div>
                <div>
                    <header style="background-color: black; padding: 30px;">
                        <div>
                            <nav>
                                <ul>
                                    <li><a href="login">Вход</a></li>
                                    <li><a href="faq">FAQ по приложению</a></li>
                                </ul>
                            </nav>
                        </div>
                    </header>
                </div>
                <div>
                    <div class="mod">
                        <h1>Окно регистрации</h1>
                        <button id="btn">Регистрация</button>
                        
                    </div>
                    <div class="model" id="model">
                        <div class="model-content">
                            <h3>Добро пожаловать на регистрацию</h3>
                            <form action="register.php" method="post">
                            <label style="display: block;">Введите ваш login</label>
                            <input type="text" style="display: block;" name="login" placeholder="Login">
                            <label style="display: block;">Введите ваш пароль</label>
                            <input type="text" style="display: block;" name="password" placeholder="password">
                            <label style="display: block;">Повтор пароля</label>
                            <input type="text" style="display: block;" name="confimpassword" placeholder="confimpassword">
                            <label style="display: block;">Введите Email</label>
                            <input type="email" style="display: block; margin-bottom: 5px;" name="Email" placeholder="@Email" >
                            <button type="submit" style="display: block;">Зарегистироваться</button>
                            </form>
                            <?php
                                if(count($errors) > 0) {
                                foreach($errors as $e)
                                {
                                    echo $e;
                                }
                    
                                }
                            ?> 
                        </div>

                        
                    </div>
                </div>
                </div>
            </div>
        </body>
        <script src="js/script.js"></script>
        
    </head>
</html>