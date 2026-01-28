@extends('app')

@section('title', 'Log In')

@section('content')
    <div class="flex justify-center items-center py-10">
        <div class="card bg-base-100 w-full max-w-md shadow-xl border border-base-300">
            <div class="card-body p-8">
                {{-- Header --}}
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-black tracking-tight">Welcome Back</h2>
                    <p class="text-base-content/60 mt-2">Log in to manage your scheduled events.</p>
                </div>

                <form action="/login" method="POST" class="space-y-5">
                    @csrf

                    {{-- Email/Username --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-bold">Email Address</span>
                        </label>
                        <input name="email" type="email" placeholder="test@example.com"
                            class="input input-bordered w-full @error('email') input-error @enderror"
                            value="{{ old('email') }}" required autofocus>
                        @error('email') <label class="label"><span
                        class="label-text-alt text-error font-semibold">{{ $message }}</span></label> @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-bold">Password</span>
                        </label>
                        <input name="password" type="password" placeholder="••••••••"
                            class="input input-bordered w-full @error('password') input-error @enderror" required>
                        @error('password') <label class="label"><span
                        class="label-text-alt text-error font-semibold">{{ $message }}</span></label> @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="form-control mt-8">
                        <button class="btn btn-primary btn-block shadow-lg text-white">
                            Log In
                        </button>
                    </div>

                    {{-- Register Toggle --}}
                    <div class="text-center mt-4">
                        <p class="text-sm opacity-60">
                            Don't have an account?
                            <a href="/register" class="link link-primary font-bold no-underline hover:underline">Register
                                for free!</a>
                        </p>
                    </div>
                </form>

                {{-- Optional: Test Credentials Reminder --}}
                <div class="mt-8 p-4 bg-base-200 rounded-lg border border-dashed border-base-300">
                    <p class="text-xs font-bold uppercase opacity-50 mb-1">Dev Credentials</p>
                    <code class="text-xs">test@example.com / password</code>
                </div>
            </div>
        </div>
    </div>
@endsection