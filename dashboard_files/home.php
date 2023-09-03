<div style="  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 40px;
  width: 100%;
  margin-top: 30px;">

    <div class="section">
        <canvas id="myChart"></canvas>
    </div>
    <div class="section">
        <div>
            Safj
        </div>
        <div>
            Best serve rever
        </div>
        <div>
            <ul>
                <li>Membri:123</li>
                <li>Bot:3</li>
            </ul>
        </div>
    </div>
    <div class="section">
        <canvas id="myChart"></canvas>
    </div>
    <div class="section">
        <div>
            Welcome & Goodbye
        </div>    
        <div>
            Automatically send messages and give roles to your new members and send a message when a members leave
        </div> 
    </div>
    <div class="section">
        <div>
            Levels
        </div>    
        <div>
            Give your members XP and Levels when they send messages and rank them by activity in a leaderboard
        </div> 
    </div>
    <div class="section">
        <div>
            Boost
        </div>    
        <div>
            When a piece of shit dogshit random animal boost the server
        </div> 
    </div>
    <div class="section">
        <div>
            Sounds
        </div>    
        <div>
            Upload, play, and share sound effects!
            ⬤ Currently 3213438432784230483 sounds on your guild!

        </div> 
    </div>
    <div class="section">
        <canvas id="myChart"></canvas>
    </div>

</div>




<?php
    session_start();
    require __DIR__ . '../../assets/php/database.php';
    require __DIR__ . '../../assets/php/utilities.php';

    $guild_id = $_SESSION['guild_id'];
    $user_id = $_SESSION['user_data']['id'];

    $time = strtotime(date("Y-m-01 00:00:00"));

    $y_user;
    $y_total;
    $x;
    list($y_total, $y_user, $x) = generateCommandGraph($guild_id, $user_id, $time);












    function generateCommandGraph($guild_id, $user_id, $time){
        $commands = getCommand($guild_id, $time);
        $commands_user = getCommand($guild_id, $time, $user_id);

        $count = [];
        foreach(array_keys($commands) as $date ){
            $count[$date][] = count($commands[$date]);
        }

        $count_user = [];
        foreach(array_keys($commands_user) as $date ){
            $count_user[$date][] = count($commands_user[$date]);
        }

        $merge = array_merge(array_keys($count), array_keys($count_user));

        foreach($merge as $key => $value){
            if(!isset($count_user[$value])){
                $count_user[$value] = [0];
            }
            if(!isset($count[$value])){
                $count[$value] = [0];
            }
        }

        ksort($count);
        ksort($count_user);

        $date = [];
        foreach(array_keys($count) as $key => $value){
            $date[$value] = date("d/m/y", $value);
        }

        $newArray_user = [];
        foreach (array_values($count_user) as $key => $valueArray) {
            $newArray_user[$key] = $valueArray[0];
        }
        $newArray = [];
        foreach (array_values($count) as $key => $valueArray) {
            $newArray[$key] = $valueArray[0];
        }

        return [$newArray, $newArray_user, $date];
    }
?>


<script>

    let canvas = document.getElementById("myChart");
    let ctx = canvas.getContext("2d");

    let labels = <?=json_encode(array_values($x));?>;
    let data = {
        labels: labels,
        datasets: [
            {
                label: "Commands",
                data: <?=json_encode($y_total);?>,
                fill: false,
                borderColor: "yellow",
                tension: 0.1
            },
            {
                label: "Yours",
                data: <?=json_encode($y_user);?>,
                fill: false,
                borderColor: "#9ce794",
                tension: 0.1
            }
        ]
    };
    let config = {
        type: "line",
        data: data,
        options: {
            scales: {
                y: {
                    grid: {
                        color: "#272934" 
                    }
                },
                x: {
                    grid: {
                        color: "#272934" 
                    }
                }
            }
        }
    };

    let myChart = new Chart(ctx, config);

</script>

<style>
    .container{
        margin:unset;
        width:unset;
    }
</style>