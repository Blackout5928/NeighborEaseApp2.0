<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <style>
        .result {
            background-color: green;
            color: #fff;
            padding: 20px;
        }
        .row {
            display: flex;
        }
    </style>
    <script src="ht.js"></script>
</head>
<body>
    <div class="row">
        <div class="col">
            <div style="width: 500px;" id="reader"></div>
        </div>
        <audio id="myAudio1">
            <source src="success.mp3" type="audio/ogg">
        </audio>
        <audio id="myAudio2">
            <source src="failes.mp3" type="audio/ogg">
        </audio>
        <div class="col" style="padding: 30px;">
            <h4>SCAN RESULT</h4>
            <div>Home Owner House Number</div>
            <form action="">
                <input type="text" name="start" class="input" id="result" onkeyup="showHint(this.value)" placeholder="result here" readonly="" />
            </form>
            <p>Status: <span id="txtHint"></span></p>
        </div>
    </div>
    <script>
        var x = document.getElementById("myAudio1");
        var x2 = document.getElementById("myAudio2");      

        function showHint(str) {
            console.log("showHint called with:", str);
            if (str.length == 0) {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "gethint.php?q=" + str, true);
                xmlhttp.send();
            }
        }

        function playAudio() { 
            x.play(); 
        }

        function onScanSuccess(qrCodeMessage) {
            console.log("QR Code scanned:", qrCodeMessage);
            var trimmedMessage = qrCodeMessage.substr(14, 3);
            document.getElementById("result").value = trimmedMessage;
            showHint(trimmedMessage);
            playAudio();
        }

        function onScanError(errorMessage) {
            console.error("Scan error:", errorMessage);
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    </script>
</body>
</html>
