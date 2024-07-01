@extends('layouts.frontend')

@section('title', 'LOGIN|REGISTER')


@section('content')


    <div class="breadcrumb_section">
        <div class="container">
            <ul class="breadcrumb_nav ul_li">
                <li><a href="index-2.html">Home</a></li>
                <li>Login/Register</li>
            </ul>
        </div>
    </div>

    <!-- register_section - start -->
    <section class="register_section section_space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <ul class="nav register_tabnav ul_li_center" role="tablist">
                        <li role="presentation">
                            <button class="active" data-bs-toggle="tab" data-bs-target="#signin_tab" type="button"
                                role="tab" aria-controls="signin_tab" aria-selected="true">Sign In</button>
                        </li>
                        <li role="presentation">
                            <button data-bs-toggle="tab" data-bs-target="#signup_tab" type="button" role="tab"
                                aria-controls="signup_tab" aria-selected="false">Register</button>
                        </li>
                    </ul>

                    <div class="register_wrap tab-content">

                        <div class="tab-pane fade show active" id="signin_tab" role="tabpanel">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form_item_wrap">
                                    <h3 class="input_title">Enail*</h3>
                                    <div class="form_item">
                                        <label for="username_input"><i class="fas fa-user"></i></label>
                                        <input id="username_input" type="email" @error('email') is-invalid @enderror
                                            name="email" value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="User Email">
                                    </div>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form_item_wrap">
                                    <h3 class="input_title">Password*</h3>

                                    <div class="form_item">
                                        <label for="password_input"><i class="fas fa-lock"></i></label>
                                        <input id="password_input" type="password" @error('password') is-invalid @enderror
                                            name="password" required autocomplete="current-password" placeholder="Password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="checkbox_item">
                                        <input id="remember_checkbox" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label for="remember_checkbox">Remember Me</label>
                                    </div>

                                    <span>
                                        @if (Route::has('password.request'))
                                            <a class="checkbox_item" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </span>

                                </div>

                                <div class="form_item_wrap">
                                    <button type="submit" class="btn btn_primary">Sign In</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="signup_tab" role="tabpanel">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form_item_wrap">
                                    <h3 class="input_title">User Name*</h3>
                                    <div class="form_item">
                                        <label for="username_input2"><i class="fas fa-user"></i></label>

                                        <input id="username_input2" type="text"@error('name') is-invalid @enderror
                                            name="name" value="{{ old('name') }}" required autocomplete="name"
                                            autofocus placeholder="User Name">
                                    </div>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form_item_wrap">
                                    <h3 class="input_title">Email*</h3>
                                    <div class="form_item">
                                        <label for="email_input"><i class="fas fa-envelope"></i></label>
                                        <input id="email_input" type="email" @error('email') is-invalid @enderror
                                            name="email" value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="Email">
                                    </div>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form_item_wrap">
                                    <h3 class="input_title">Password*</h3>
                                    <div class="form_item">
                                        <label for="password_input2"><i class="fas fa-lock"></i></label>
                                        <input id="password_input2" type="password"
                                            @error('password') is-invalid @enderror name="password" required
                                            autocomplete="new-password">
                                    </div>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="form_item_wrap">
                                    <h3 class="input_title">{{ __('Cn Password*') }}</h3>
                                    <div class="form_item">
                                        <label for="password_input2"><i class="fas fa-lock"></i></label>
                                        <input id="password_input2" type="password" name="password_confirmation">
                                    </div>
                                </div>


                                <div class="form_item_wrap">
                                    <button type="submit" class="btn btn_secondary">Register</button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- register_section - end

@endsection
