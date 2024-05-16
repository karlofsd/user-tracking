@extends('layout.app')
@section('title', 'User tracking')
@section('content')
    <div class="col-xl-5 col-md-8">
        <form class="bg-white rounded shadow-5-strong p-4" action="" method="POST">
            @csrf
            <div class="form-outline mb-4">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" value="{{ old('name') }}" class="form-control" name="name" id="inputName"
                    placeholder="Type name" />
                @error('name')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="text" value="{{ old('email') }}" class="form-control" name="email" id="inputEmail"
                    placeholder="Type email" />
                @error('email')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputPassword" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="inputPassword"
                    placeholder="Type password" />
                @error('password')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputConfirmPassword" class="form-label">Confirm password</label>
                <input type="password" class="form-control" name="confirm_password" id="inputConfirmPassword"
                    placeholder="Confirm password" />
                @error('confirm_password')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="row mx-auto mb-4">
                <button type="submit" class="btn btn-primary">
                    Create
                </button>
            </div>
            <div class="mb-3 row">
                <a name="" id="" class="btn" href="{{ route('login') }}" role="button">Sign in</a>
            </div>
        </form>
    </div>
@endsection
