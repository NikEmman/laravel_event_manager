<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        @if (session('success'))
    <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px;">
        {{ session('success') }}
    </div>
@endif

@if (session('failure'))
    <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 10px;">
        {{ session('failure') }}
    </div>
@endif
    @auth
    <p>Congrats, you are logged in</p>
    <form action="/logout" method="POST">
        @csrf
    <button>Logout</button></form>
    @else
    <p>New comers feel free to register</p>
      <a href="/signon">Register</a>
      <br>
      <p>Already have an account?</p>
        <a href="/signin">Login</a>
      
    @endauth
  

</body>
</html>