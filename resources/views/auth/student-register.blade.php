<!DOCTYPE html>
<html>
<head>
    <title>UNIARCHIVE</title>
    <link rel="stylesheet" href="{{ asset('css/Student.CreateAccount.css') }}">
</head>
<body>
    <!-- Top Left Image -->
    <img src="{{ asset('assets/UNIARCHIVE.HEADER.png') }}" alt="UNIARCHIVE Logo" class="top-left-image">

    <!-- Main Container for Welcome and Login Sections -->
    <div class="main-container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1>Welcome to</h1>
            <h1>UNIARCHIVE!</h1>
            <p class="subheading">Access. Reserve. Discover.</p>
            <p class="description">
                Allows you to easily reserve research books, manage your reservations,
                and receive personalized updates on book availability and library events.
                Sign up today for a smoother and more tailored library experience!
            </p>
        </div>

        <!-- Registration Container -->
        <div class="createacc-container">
            <div class="create-account-section">
                <h2>Create Account</h2>
                <form id="createAccountForm" method="POST" action="{{ route('student.register') }}">
                    @csrf <!-- Laravel CSRF token for security -->

                    <!-- Email -->
                    <label for="email">E-mail Address:</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <!-- Student ID -->
                    <label for="student-id">Student ID:</label>
                    <input type="text" id="student-id" name="student_id" value="{{ old('student_id') }}" required>
                    @error('student_id')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <!-- Year & Section -->
                    <label for="year-section">Year & Section:</label>
                    <input type="text" id="year-section" name="year_section" value="{{ old('year_section') }}" required>
                    @error('year_section')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <!-- Program -->
                    <label for="program">Program:</label>
                    <input type="text" id="program" name="program" value="{{ old('program') }}" required>
                    @error('program')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <!-- Name -->
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <!-- Gender -->
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        <option value="prefer-not-to-say" {{ old('gender') == 'prefer-not-to-say' ? 'selected' : '' }}>Prefer not to say</option>
                    </select>
                    @error('gender')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <!-- Birthday -->
                    <label for="birthday">Birthday:</label>
                    <input type="date" id="birthday" name="birthday" value="{{ old('birthday') }}" required>
                    @error('birthday')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <!-- Contact Number -->
                    <label for="contact">Contact Number:</label>
                    <input type="tel" id="contact" name="contact" value="{{ old('contact') }}" required>
                    @error('contact')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <!-- Password -->
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    @error('password')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <!-- Confirm Password -->
                    <label for="password_confirmation">Confirm Password:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>

                    <!-- Submit Button -->
                    <button type="submit">Continue</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
