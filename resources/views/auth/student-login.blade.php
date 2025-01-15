<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNIARCHIVE - Student Login</title>
    <link rel="stylesheet" href="{{ asset('css/Student.WelcomePage.css') }}">
</head>
<body>

    <!-- Top Left Image -->
    <img src="{{ asset('assets/UNIARCHIVE.png') }}" alt="UNIARCHIVE Logo" class="top-left-image">

    <!-- Main Container for Welcome and Login Sections -->
    <div class="main-container">

        <!-- Login Container -->
        <div class="login-container">
            <!-- Login Section -->
            <div class="login-section">
                <form class="login-form" method="POST" action="{{ route('student.login.post') }}">
                    @csrf
                    <label for="username">Username or E-mail:</label>
                    <input
                        type="text"
                        id="username"
                        name="email"
                        placeholder="Enter your username or email"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                    <label for="password">Password:</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                    <!-- Forgot Password Link -->
                    <p class="forgot-password">
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </p>

                    <button type="submit" class="login-btn">Log In</button>
                    <p>or</p>
                    <button
                        type="button"
                        class="signup-btn"
                        onclick="window.location.href='{{ route('student.register') }}'"
                    >
                        Sign Up!
                    </button>
                </form>
            </div>
        </div>

        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1>Welcome to</h1>
            <h1>UNIARCHIVE!</h1>
            <p class="subheading">Access. Reserve. Discover.</p>
            <p class="description">
                You can explore our collection of research books,
                reserve them conveniently online, and stay updated with availability.
                Enhance your research experience with just a few clicks!
            </p>
        </div>

    </div>

</body>
</html>
