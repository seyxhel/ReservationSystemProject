<!DOCTYPE html>
<html>
<head>
    <title>Library Management System</title>
    <link rel="stylesheet" href="{{ asset('css/Admin.login.css') }}">
</head>
<body>
    <div>
        <img src="{{ asset('assets/UNIARCHIVE LOGO.png') }}" />

        <form onsubmit="navigateToDashboard(event)">
            <p>
                Username:
                <input type="text" name="username" size="35" maxlength="50" />
                <br>
            </p>
            <p>
                Password:
                <input type="password" name="password" size="35" maxlength="16" />
                <br>
            </p>
            <p>
                <input type="submit" name="LogIn" value="Log-In" />
            </p>
        </form>
    </div>

    <script>
        function navigateToDashboard(event) {
            event.preventDefault(); // Prevent the form from submitting normally
            const username = document.querySelector('input[name="username"]').value;
            const password = document.querySelector('input[name="password"]').value;

            // Optionally add validation for username and password here
            if (username && password) {
                // Navigate to the dashboard page
                window.location.href = 'Admin.Dashboard.html';
            } else {
                alert('Please enter both username and password!');
            }
        }
    </script>
</body>
</html>
