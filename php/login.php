<?php
/**
 * Admin Login Page
 * Krusty Krab Contact Form System
 * 
 * Secret login page accessible by clicking the logo
 */

session_start();

// Check if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin.php");
    exit();
}

// Handle login form submission
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    
    // Check credentials
    if ($username === 'mrkrabs' && $password === 'mrkrabs') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="https://static.wikia.nocookie.net/logopedia/images/8/8a/KK_main_logo.png">
    <title>Admin Login - The Krusty Krab</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        html, body {
            overflow: hidden;
            height: 100%;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            position: relative;
            z-index: 10;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 3rem;
            max-width: 420px;
            width: 100%;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .login-logo {
            width: 120px;
            height: auto;
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        }
        
        .login-title {
            font-family: 'KrabbyPatty', cursive;
            font-size: 2.5rem;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            margin-bottom: 0.5rem;
        }
        
        .login-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            margin-bottom: 2rem;
        }
        
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }
        
        .form-group {
            text-align: left;
        }
        
        .form-group label {
            display: block;
            color: white;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        
        .form-group input {
            width: 100%;
            padding: 0.9rem 1.2rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #FF6F61;
            background: rgba(255, 255, 255, 0.15);
        }
        
        .login-btn {
            background: linear-gradient(135deg, #FF6F61, #ff8a7a);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 111, 97, 0.4);
            margin-top: 0.5rem;
        }
        
        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 111, 97, 0.5);
        }
        
        .error-message {
            background: rgba(255, 107, 107, 0.2);
            border: 1px solid rgba(255, 107, 107, 0.5);
            color: #FFB6C6;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 1.5rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .back-link:hover {
            color: white;
        }
        
        .secret-hint {
            color: rgba(0, 0, 0);
            font-size: 0.75rem;
            margin-top: 1.5rem;
            font-style: bold;
        }
        
        /* Sea stars behind */
        .sea-stars {
            z-index: 1 !important;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="ocean-background">
        <img src="../images/ray.png" alt="Ray" class="ray-image">
        <div class="bubbles-container"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
        
            <h1 class="login-title">Admin Login</h1>
            
            <?php if ($error): ?>
            <div class="error-message">
                🦀 <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            
            <form class="login-form" method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>
                <button type="submit" class="login-btn">Login</button>
            </form>
            
            <a href="../index.html" class="back-link">← Back to Home</a>
            
            <p class="secret-hint">Hint: Ask Mr. Krabs for access</p>
        </div>
    </div>

    <div class="sea-stars">
        <img src="../images/yellow.png" alt="Yellow Star" class="sea-star" style="--random-left: 8%; --random-top: 15%; --random-delay: 0s;">
        <img src="../images/violet.png" alt="Violet Star" class="sea-star" style="--random-left: 75%; --random-top: 25%; --random-delay: 0.3s;">
        <img src="../images/orange.png" alt="Orange Star" class="sea-star" style="--random-left: 12%; --random-top: 65%; --random-delay: 0.6s;">
        <img src="../images/yellow.png" alt="Yellow Star" class="sea-star" style="--random-left: 85%; --random-top: 55%; --random-delay: 0.9s;">
    </div>
</body>
</html>
