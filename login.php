<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transparent login form</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style type="text/css">
body {
    margin: 0;
    padding: 0;
    background-image: url('https://images8.alphacoders.com/134/1346020.png');
    background-size: cover;
    background-attachment: fixed;
    height: 100vh;
    font-family: sans-serif;
}
.contact-form {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 400px;
    height: 500px;
    padding: 80px 40px;
    box-sizing: border-box;
    background-color: rgba(41, 39, 39, 0.3);
    box-shadow: 0 5px 30px black;
}
.avatar {
    position: absolute;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    top: calc(-80px/2);
    left: calc(50% - 50px);
    border: 10px solid #fff;
}
.contact-form h2 {
    margin: 0;
    padding: 0 0 20px;
    color: #fff;
    text-align: center;
    text-transform: uppercase;
}
.contact-form p {
    margin: 0;
    padding: 0;
    font-weight: bold;
    color: #fff;
}
.contact-form input {   
    border: none;
    border-bottom-color: currentcolor;
    border-bottom-style: none;
    border-bottom-width: medium;
    width: 90%;
    border-bottom: 2px solid white;
    padding: 10px;
    margin-bottom: 20px;
    font-size: 14px;
    font-weight: bold;
    background-color: transparent;
    color: white;
}
.contact-form input[type="text"], 
.contact-form input[type="password"] {
    border: none;
    border-bottom: 1px solid #fff;
    background: transparent;
    outline: none;
    height: 40px;
    color: #fff;
    font-size: 16px;
}
.btn2 {
    padding: 10px;
    width: 150px;
    border-radius: 20px;
    background-color: rgb(10, 136, 43);
    border-style: none;
    color: white;
    font-weight: 600;
    margin: 10% 0;
}
.btn-area {
    display: flex;
    justify-content: center;
}
.contact-form a {
    color: #fff;
    font-size: 14px;
    font-weight: bold;
    text-decoration: none;
}
.rem {
    text-align: center;
    color: rgb(199, 197, 197) !important;
    font-size: 16px;
}
input[type="checkbox"] {
    width: 5%;
}

    </style>
</head>
<body>
    <div class="contact-form">
        <img src="" class="avatar">
        <h2>login Form</h2>
        <form>
            <input type="text" name="" placeholder="Enter Your Email">
            <input type="password" name="" placeholder="Enter Your Password">
            <div class="btn-area">
                <button type="button" class="btn2">LOGIN</button>
            </div>
            <p class="rem"><input type="checkbox"> Keep me signed in on this device</p>
        </form>
    </div>
</body>
</html>
