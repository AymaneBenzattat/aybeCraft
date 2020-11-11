<div class="menu">
@if($db)
    <h4 align="center" style="color: green; padding: 16pt"><img src='@asset(img/db.svg)' class='icon icon-green'><br>Connected</h4>
@else
    <h4 align="center" style="color: red; padding: 16pt"><img src='@asset(img/db.svg)' class='icon icon-red'><br>Disconnected</h4>
@end
@if($debug)
    <h4 align="center" style="color: green; padding: 16pt"><img src='@asset(img/debug.svg)' class='icon icon-green'><br>Debug</h4>
@else
    <h4 align="center" style="color: red; padding: 16pt"><img src='@asset(img/debug.svg)' class='icon icon-red'><br>Production</h4>
@end
@if($setup)
    <h4 align="center" style="color: green; padding: 16pt"><img src='@asset(img/setup.svg)' class='icon icon-green'><br>Complete</h4>
@else
    <h4 align="center" style="color: red; padding: 16pt"><img src='@asset(img/setup.svg)' class='icon icon-red'><br>Incomplete</h4>
@end
</div>