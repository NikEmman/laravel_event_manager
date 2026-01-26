@extends('app')


@section('content', )
    @auth
    <p>Congrats, you are logged in</p>
    <form action="/logout" method="POST">
        @csrf
    <button>Logout</button></form>
    @else
    <p>New comers feel free to register</p>
      <a href="/register">Register</a>
      <br>
      <p>Already have an account?</p>
        <a href="/login">Login</a>
      
    @endauth
@endsection