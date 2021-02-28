<!DOCTYPE html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>@v(APPNAME)</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter&display=swap');

    * {
        font-family: 'Inter', sans-serif;
    }

    @media (prefers-color-scheme: light) {
        body {
            background-color: white;
            color: black;
        }

        a {
            color: black;
        }
    }

    @media (prefers-color-scheme: dark) {
        body {
            background-color: black;
            color: white;
        }

        a {
            color: white;
        }
    }

    * {
        font-family: 'Inter';
    }

    html,
    body {
        margin: 0;
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    menu {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    menu>a {
        padding: 0 25px;
        text-decoration: none;
        /* color: #000; */
    }

    .docs {
        background-color: #5555ff;
        color: #fff !important;
        line-height: 50px;
        justify-content: center;
    }

    .icon {
        width: 16pt;
        height: 20pt;
    }

    .icon-red {
        filter: invert(22%) sepia(65%) saturate(6888%) hue-rotate(354deg) brightness(92%) contrast(121%);
    }

    .icon-green {
        filter: invert(19%) sepia(97%) saturate(3496%) hue-rotate(98deg) brightness(93%) contrast(105%);
    }
</style>
<html>
<img src='@asset(img/craft.png)' style="height: 32vh">
<menu>
    <a target="_blank" class="docs" href="docs">Documentation</a>
    <a target="_blank" href="https://github.com/AymaneBenzattat/aybeCraft/">GitHub</a>
    <a href="404">404</a>
    @if($auth)
    <a href="@url(/Login)">Login</a>
    @end
</menu>

</html>