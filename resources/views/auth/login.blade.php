@extends('layout.app')
@section('title', 'User tracking')
@section('content')

    <div class="col-xl-5 col-md-8">
        <form class="bg-white rounded shadow-5-strong p-4" action="" method="POST">
            @csrf
            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form1Example1">Email address</label>
                <input type="email" id="form1Example1" name='email' value="{{ old('email') }}" class="form-control" />
                @error('email')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form1Example2">Password</label>
                <input type="password" id="form1Example2" name='password' class="form-control" />
                @error('password')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="row mx-auto mb-4">
                <button type="submit" class="btn btn-primary">
                    Login
                </button>
            </div>
            <div class="mb-3 row">
                <a name="" id="" class="btn" href="{{ route('register') }}" role="button">Create a
                    user</a>
            </div>
        </form>
    </div>

@endsection
