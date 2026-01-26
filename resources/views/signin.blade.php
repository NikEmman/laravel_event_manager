<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log in</title>
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

@if ($errors->any())
    <div style="background: #fff3cd; color: #856404; padding: 10px; margin-bottom: 10px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
          <h2>Login</h2>
             
             <form action="/login" method="POST">
              @csrf
              <input name="loginname" type="text" placeholder="name" required>
              <input name="loginpassword" type="password" placeholder="password" required>
              <button >Log In</button>
              </form>
      </div>
</body>
</html>