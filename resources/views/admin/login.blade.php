<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f1f2f6;
        }

        .login-container {
            width: 350px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }

        .login-container h3 {
            font-weight: 600;
            color: #343a40;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group label {
            font-weight: 500;
            color: #495057;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 10px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .text-danger {
            font-size: 0.875rem;
        }
    </style>
</head>

<body>


    <div class="login-container">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <h3>Admin Login</h3>
        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required value="{{ old('email') }}">
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                @error('password')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block mt-3">Login</button>
            <p class="text-center mt-3">
                Don't have an account? <a href="{{ route('admin.register') }}">Register here</a>
            </p>
        </form>
    </div>

    <!-- Link Bootstrap JS và jQuery (nếu cần) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>