<?php

$servername = "na01-sql.pebblehost.com";
$username = "customer_444048_beebot";
$password = "ExtremeSafJDatabase117@";
$dbname = "customer_444048_beebot";

global $conn;
$conn = new mysqli($servername, $username, $password, $dbname);

global $beebot;
$beebot = '938487470339801169';

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

function getUserSounds($user_id) {
  global $conn;
  $sql = "SELECT id, name FROM sound WHERE user_id = $user_id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "id: " . $row["id"]. " - Name: " . $row["name"]. "<br>";
    }
  } else {
    echo "0 results";
  }
}

function getGuildSettings($guild_id) {
  global $conn;
  global $beebot;
  $sql = "SELECT prefix, name_tts, language_tts, exp_enabled FROM guild_settings WHERE guild_id = $guild_id AND bot_id = $beebot";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "prefix: " . $row["prefix"]. " - name_tts: " . $row["name_tts"]. " - language_tts: " . $row["language_tts"]. " - exp_enabled: " . $row["exp_enabled"]."<br>";
    }
  } else {
    echo "0 results";
  }
}

function getWelcomeMessage($guild_id) {
  global $conn;
  global $beebot;

  $arr = [];
  $sql = "SELECT message_text, channel_id FROM welcome_message WHERE guild_id = $guild_id AND bot_id = $beebot";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $arr = ['message'=>$row["message_text"], 'channel'=>$row["channel_id"]];
    }
  }

  $sql = "SELECT role_id FROM welcome_roles WHERE guild_id = $guild_id AND bot_id = $beebot";
  $result = $conn->query($sql);

  $roles = [];
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $roles[$row['role_id']] = ['role_id'=>$row['role_id']];
    }
  }
  return $arr + ['roles'=>$roles];
}


//$conn->close();
?>