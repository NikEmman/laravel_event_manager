@extends('app') @section('title', 'Log In') @section('content') 
<h2>Login</h2>
    <form action="/login" method="POST">
        @csrf
        <input name="name" type="text" placeholder="Username">
        <input name="password" type="password" placeholder="Password">
        <button>Log In</button>
    </form>
@endsection