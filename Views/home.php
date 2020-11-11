<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title><?= APPNAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet">
</head>
<style>
    @font-face {
    font-family: 'Protest';
    src: url(@asset(fonts/protest.ttf));
    }
    *{
        font-family: 'Protest';
    }
    html, body {
        background-color: #ffffff;
        color: #000000;
        height: 70vh;
        margin: 0;
    }
    .menu{
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .menu > a{
        padding: 0 25px;
        text-decoration: none;
        color: #000;
    }
    .docs{
        background-color: #5555ff;
        color: #fff !important;
        line-height: 50px;
        justify-content: center;
    }
    .icon{
        width: 16pt;
        height: 20pt;
    }
    .icon-red{
        filter: invert(22%) sepia(65%) saturate(6888%) hue-rotate(354deg) brightness(92%) contrast(121%);
    }
    .icon-green{
        filter: invert(19%) sepia(97%) saturate(3496%) hue-rotate(98deg) brightness(93%) contrast(105%);
    }
</style>
<html>
<h1 align="center"><img src='@asset(img/aybe.png)' style="height: 70vh"></h1>
<div class="menu">
    <a target="_blank" class="docs" href="docs">Documentation</a>
    <a target="_blank" href="https://github.com/AymaneBenzattat/aybeCraft/">GitHub</a>
    <a target="_blank" href="https://aybe.com">Company</a>
    <a href="404">404</a>
</div>
@section(database)
</html>