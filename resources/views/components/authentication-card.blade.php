<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Signup</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .form-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding-top: 1.5rem;
            background-color: #f7fafc;
        }
        .form-wrapper {
            width: 100%;
            max-width: 28rem; /* Change max-width to adjust the size */
            margin-top: 1.5rem;
            padding: 1.5rem;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border-radius: 0.5rem;
            text-align: center;
        }
        .user-icon {
            font-size: 3rem;
            color: #4a5568;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div>
            {{ $logo }}
        </div>

        <div class="form-wrapper">
            <i class="fas fa-user user-icon"></i>
            {{ $slot }}
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
