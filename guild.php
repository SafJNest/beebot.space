<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="../assets/js/script.js"></script>
        <script src="../assets/js/websocket.js"></script>
        <script src="../assets/js/functions.js"></script>
        <link rel="stylesheet" href="../assets/css/style-dashboard.css">
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Beebot</title>
    </head>

    <body>
        <div class="header">
            <div class="logo">
                    <div class="beebot-icon">
                        <img class="beebot-logo" src="../assets/img/beebot-removebg-preview.png"></img>
                    </div>
                    <div class="beebot-name">
                        Beebot
                    </div>
                </div>
            <?=printUser();?>
        </div>

        <div class="container">
            <div class="prefix">

            </div>
            <div>
                <input type="text" id="newPrefix" name="name" required minlength="4" maxlength="8" size="10" />
            </div>
            <div>
                <button onclick="commit()">Change</button>
            </div>


        </div>

        <script>
            window.onload = () => {
                let guildId = <?=$_SESSION['guild_id'];?>;
                let userId = <?=  $_SESSION['user_data']['id']; ?>;
                loadingBee();
                
                console.log(guildId)
                openSocket("getPrefix-" + guildId);
            
            };

            function commit(){
                let prefix = $('#newPrefix').val();
                openSocket("newPrefix-" + guildId + "-" + prefix);
            }

        </script>

    </body>
</html>

<?php

    require __DIR__ . '/assets/php/database.php';
    $guild_id =  $_GET['id'];
    $_SESSION['guild_id'] = $guild_id;
    echo $_SESSION['guild_id'];
    $data = $_SESSION['user_data'];
    $user_id = $data['id'];
    $token = $data['tokenType'];
    $accessToken = $data['accessToken'];
    echo '<script>load("'. $user_id .'", "'. $token .'", "'. $accessToken .'");</script>';

    function printUser(){
        $icon_url = 'https://cdn.discordapp.com/avatars/'. $_SESSION['user_data']['id'] .'/'. $_SESSION['user_data']['avatar'] .'.png';
        echo '
        <div class="user">
            <div class="user-icon">
                <img src="'. $icon_url .'"></img>
            </div>
            <div class="user-name">
                '. $_SESSION['user_data']['global_name'] .'
            </div>
        </div>
        
        ';
    }
    ?>
