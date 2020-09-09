<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title><?= APPNAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
</head>
<style>
    *{
        font-family: 'Lato', sans-serif;
    }
    html, body {
        background-color: #ffffff;
        color: #000000;
        height: 70vh;
        margin: 0;
    }
    h1{
        font-size: 30vh;
    }
    .menu{
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .menu > a{
        padding: 0 25px;
    }
    .setup{
        background-color: #5555ff;
        color: #ffffff;
        line-height: 50px;
        justify-content: center;
    }
</style>
<html>
<h1 align="center">aybe.<span style="font-weight: 200; color: #5555ff">Craft</span></h1>
<div class="menu">
    <?php
        if (!SETUP) {
            echo "<a class='setup'>Setup your app</a>";
        }else {
            echo "<a class='setup'>Dev tools</a>";
        }
    ?>
    <a>Documentation</a>
    <a>GitHub</a>
    <a>Community</a>
</div>
@section("database")
</html>