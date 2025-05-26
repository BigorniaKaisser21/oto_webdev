<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="send.php" method="post">
        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Your Name" autocomplete="off">
        <br>
        <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Your Phone Number" autocomplete="off">
        <br>
        <input type="text" name="email" id="email" class="form-control" placeholder="Enter Your Email" autocomplete="off">
        <br>
        <input type="text" name="password" id="password" class="form-control" placeholder="Enter Your Password" autocomplete="off">
        <br>
        <input type="hidden" name="otp" id="otp" class="form-control">
        <input type="hidden" name="subject" id="subject" class="form-control" value="Received OTP">
        <br>
        <button type="submit" name="send">Signup</button>
    </form>
</body>
</html>
<script>
    function generateRandomNumber(){
        let min = 100000;
        let max = 999999;
        let randomNumber = Math.floor(Math.random() * (max - min + 1)) +min;

        let lastGeneratedNumber = localStorage.getItem ('lastGeneratedNumber');
        while (randomNumber === parseInt(lastGeneratedNumber)) {

        randomNumber = Math.floor(Math.random() * ma(max - min +1)) + min;
        }
        localStorage.setItem('lastGeneratedNumber',randomNumber);
        return randomNumber;
    }
        document.getElementById('otp') .value = generateRandomNumber();
</script>