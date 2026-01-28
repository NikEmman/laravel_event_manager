<div class="navbar bg-base-100 shadow-md px-4 md:px-12 rounded-b-xl">
    <div class="flex-1">
        <a href="/" class="btn btn-ghost text-xl font-black tracking-tight flex items-center gap-2">
            <span class="bg-primary text-primary-content px-2 py-1 rounded-lg">E</span>
            EVENTLY
        </a>
    </div>

    <div class="flex-none">
        <ul class="menu menu-horizontal px-1 gap-2">
            <li><a href="/" class="font-medium">Home</a></li>

            @auth
                <li>
                    <form action="/logout" method="POST" class="p-0">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm text-error hover:bg-error/10">
                            Logout
                        </button>
                    </form>
                </li>
            @else
                <li><a href="/login" class="btn btn-ghost btn-sm">Login</a></li>
                <li><a href="/register" class="btn btn-primary btn-sm text-white">Register</a></li>
            @endauth
        </ul>
    </div>
</div>