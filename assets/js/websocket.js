let socket;
let id;



function openSocket(id, msg){
    socket = new WebSocket("ws://192.99.45.100:8096/ws");
    id = id;
    
    socket.addEventListener("open", (event) => {
        socket.send(msg+"-"+id);

    });
    socket.addEventListener("close", (event) => {

    });
    
    socket.onmessage = (event) => {
        if(event.data.startsWith("server_list")){
            let json = JSON.parse(customSplitByCharacter(event.data, "-", 2)[1]);
            for(let i = 0; i < json.length; i++){
                let img =  '<img src="' + json[i].icon + '">' +
                '</img>';
                if(json[i].icon == "null"){
                    img =  '<div style=" text-align: center;top: 30PX;POSITION: RELATIVE;">' + String(json[i].name).charAt(0) + '</div>';
                }

                $('.guilds').append('' +
                    '<div class="guild" onclick="loadGuild(\''+String(json[i].id).trim()+'\')">' +
                        '<div>' +
                            '<table>' +
                                '<tbody>' +
                                    '<tr>' +
                                        '<td>' +
                                        '<div class="imgGuild">' +
                                            img +
                                        '</div>' +
                                        '</td>' +
                                        '<td>' +
                                        '<div>' +
                                            json[i].name  +
                                        '</div>' +
                                        '</td>' +
                                    '</tr>' +
                                '</tbody>' +
                            '</table>' +
                        '</div>' +
                    '</div>'
                );
            }
            
           
        }else if(event.data.startsWith("getHomeStats")){
            console.log(event.data)
            let json = JSON.parse(customSplitByCharacter(event.data, "-", 2)[1]);
            $('#servers').html(json['cont_guilds']);
            $('#users').html(json['cont_user']);
            $('#commands').html(json['cont_command']);
        }
        socket.close();
    };

    

}   

    function send(){
        let string = document.getElementById("input").value;
        socket.send(string);
    }


    function customSplitByCharacter(inputString, splitChar, n) {
        if (n <= 1) {
            return [inputString];
        }
        n--;
        const parts = inputString.split(splitChar);
        const resultArray = [];
    
        for (let i = 0; i < Math.min(n, parts.length); i++) {
            resultArray.push(parts[i]);
        }
    
        if (n < parts.length) {
            const remainingPart = parts.slice(n).join(splitChar);
            resultArray.push(remainingPart);
        }
    
        return resultArray;
    }
