<?php

?>



<html>
<head>

</head>
<body>

    @if(isset(Auth::user()->email))
        <a>Login başarılı Merhaba {{Auth::user()->username}}</a>
        <a href="{{url('/login/logout')}}">çıkış yap</a>
    @else
        <script>window.location = "/login";</script>
    @endif
</body>


</html>
