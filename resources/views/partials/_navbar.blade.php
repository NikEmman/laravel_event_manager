<nav>
    <a href="/">Home</a>
    @auth
    <form action="/logout" method="POST">
        @csrf
    <button>Logout</button></form>
    @else
    <a href="/login">Login</a>
    <a href="/register">Register</a>
    @endauth
    
</nav>