@extends('app')

@section('title', 'Register')

@section('content')
   <div class="flex justify-center items-center py-10">
      <div class="card bg-base-100 w-full max-w-md shadow-xl border border-base-300">
         <div class="card-body p-8">
            {{-- Header --}}
            <div class="text-center mb-8">
               <h2 class="text-3xl font-black tracking-tight">Create Account</h2>
               <p class="text-base-content/60 mt-2">Join Evently to start managing your events.</p>
            </div>

            <form action="/register" method="POST" class="space-y-4">
               @csrf

               {{-- Name --}}
               <div class="form-control w-full">
                  <label class="label">
                     <span class="label-text font-bold">Full Name</span>
                  </label>
                  <input name="name" type="text" placeholder="John Doe"
                     class="input input-bordered w-full @error('name') input-error @enderror" value="{{ old('name') }}"
                     required autofocus>
                  @error('name') <label class="label"><span
                  class="label-text-alt text-error font-semibold">{{ $message }}</span></label> @enderror
               </div>

               {{-- Email --}}
               <div class="form-control w-full">
                  <label class="label">
                     <span class="label-text font-bold">Email Address</span>
                  </label>
                  <input name="email" type="email" placeholder="email@example.com"
                     class="input input-bordered w-full @error('email') input-error @enderror" value="{{ old('email') }}"
                     required>
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

               {{-- Submit --}}
               <div class="form-control mt-8">
                  <button class="btn btn-primary btn-block shadow-lg text-white">
                     Create Account
                  </button>
               </div>

               {{-- Toggle Link --}}
               <div class="text-center mt-4">
                  <p class="text-sm opacity-60">
                     Already have an account?
                     <a href="/login" class="link link-primary font-bold no-underline hover:underline">Login here</a>
                  </p>
               </div>
            </form>
         </div>
      </div>
   </div>
@endsection