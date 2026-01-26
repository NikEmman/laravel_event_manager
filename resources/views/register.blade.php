@extends('app') @section('title', 'Register')

@section('content')
          <h2>Register</h2>
             
             <form action="/register" method="POST">
              @csrf
              <input name="name" type="text" placeholder="name" required>
              <input name="email" type="email" placeholder="email@example.com" required>
              <input name="password" type="password" placeholder="password" required>
              <button >Register</button></form>
@endsection