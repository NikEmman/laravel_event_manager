<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
    <div>
         @if ($errors->any())
    <div style="color: red; border: 1px solid red; padding: 10px;">
        <strong>Whoops! Something went wrong:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('failure'))
    <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 10px;">
        {{ session('failure') }}
    </div>
@endif
          <h2>Register</h2>
             
             <form action="/register" method="POST">
              @csrf
              <input name="name" type="text" placeholder="name" required>
              <input name="email" type="email" placeholder="email@example.com" required>
              <input name="password" type="password" placeholder="password" required>
              <button >Register</button></form>
      </div>
</body>
</html>