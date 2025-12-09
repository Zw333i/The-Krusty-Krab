<?php

require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get and sanitize form data
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, trim($_POST['email'])) : '';
    $phone = isset($_POST['phone']) ? mysqli_real_escape_string($conn, trim($_POST['phone'])) : '';
    $subject = isset($_POST['subject']) ? mysqli_real_escape_string($conn, trim($_POST['subject'])) : '';
    $message = isset($_POST['message']) ? mysqli_real_escape_string($conn, trim($_POST['message'])) : '';
    
    // Validate required fields
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($subject)) {
        $errors[] = "Subject is required";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        $sql = "INSERT INTO contacts (name, email, phone, subject, message) 
                VALUES ('$name', '$email', '$phone', '$subject', '$message')";
        
        if (mysqli_query($conn, $sql)) {
            $success = true;
            $successMessage = "Thank you, $name! Your message has been received and saved successfully.";
        } else {
            $success = false;
            $errorMessage = "Database error: " . mysqli_error($conn);
        }
    } else {
        $success = false;
        $errorMessage = implode("<br>", $errors);
    }
    
} else {
    // If accessed directly without POST, redirect to contact page
    header("Location: contact.php");
    exit();
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="https://static.wikia.nocookie.net/logopedia/images/8/8a/KK_main_logo.png">
    <title><?php echo $success ? 'Message Sent!' : 'Error'; ?> - The Krusty Krab</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .result-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            padding-top: 120px;
        }
        
        .result-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 3rem;
            max-width: 600px;
            width: 100%;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .result-icon {
            font-size: 5rem;
            margin-bottom: 1.5rem;
        }
        
        .result-title {
            font-family: 'KrabbyPatty', cursive;
            font-size: 2.5rem;
            color: white;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .result-message {
            color: white;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .success-card {
            border: 2px solid rgba(144, 238, 144, 0.5);
        }
        
        .error-card {
            border: 2px solid rgba(255, 107, 107, 0.5);
        }
        
        .back-btn {
            display: inline-block;
            background: linear-gradient(135deg, #FF6F61, #ff8a7a);
            color: white;
            text-decoration: none;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 111, 97, 0.4);
        }
        
        .back-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 111, 97, 0.5);
        }
        
        .submission-details {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            text-align: left;
        }
        
        .submission-details p {
            color: white;
            margin: 0.5rem 0;
            font-size: 0.95rem;
        }
        
        .submission-details strong {
            color: #FFD700;
        }
    </style>
</head>
<body>
    <div class="ocean-background">
        <img src="../images/ray.png" alt="Ray" class="ray-image">
        <div class="bubbles-container"></div>
    </div>

    <nav class="navbar">
        <div class="nav-container">
            <ul class="nav-left">
                <li><a href="../index.html">Home</a></li>
                <li><a href="../pages/menu.html">Menu</a></li>
                <li><a href="../pages/gallery.html">Gallery</a></li>
            </ul>

            <div class="logo-center">
                <a href="login.php" title="Admin Login">
                    <img src="https://static.wikia.nocookie.net/logopedia/images/8/8a/KK_main_logo.png" alt="Krusty Krab Logo" class="logo-img">
                </a>
                <span class="logo-text">Krusty Krab</span>
            </div>

            <ul class="nav-right">
                <li><a href="../pages/promotions.html">Promotions</a></li>
                <li><a href="../pages/about.html">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>

            <div class="hamburger-menu">
                <button class="hamburger-toggle" aria-label="Toggle menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>

        <div class="mobile-menu">
            <ul>
                <li><a href="../index.html">Home</a></li>
                <li><a href="../pages/menu.html">Menu</a></li>
                <li><a href="../pages/gallery.html">Gallery</a></li>
                <li><a href="../pages/promotions.html">Promotions</a></li>
                <li><a href="../pages/about.html">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </nav>

    <div class="result-container">
        <?php if ($success): ?>
        <div class="result-card success-card">
            <div class="result-icon">🦀</div>
            <h1 class="result-title">Message Sent!</h1>
            <p class="result-message"><?php echo $successMessage; ?></p>
            
            <div class="submission-details">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <?php if (!empty($phone)): ?>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
                <?php endif; ?>
                <p><strong>Subject:</strong> <?php echo htmlspecialchars($subject); ?></p>
            </div>
            
            <a href="contact.php" class="back-btn">← Back to Contact</a>
        </div>
        <?php else: ?>
        <div class="result-card error-card">
            <div class="result-icon">❌</div>
            <h1 class="result-title">Oops! Something Went Wrong</h1>
            <p class="result-message"><?php echo $errorMessage; ?></p>
            <a href="contact.php" class="back-btn">← Try Again</a>
        </div>
        <?php endif; ?>
    </div>

    <div class="sea-stars">
        <img src="../images/yellow.png" alt="Yellow Star" class="sea-star" style="--random-left: 8%; --random-top: 15%; --random-delay: 0s;">
        <img src="../images/violet.png" alt="Violet Star" class="sea-star" style="--random-left: 75%; --random-top: 25%; --random-delay: 0.3s;">
        <img src="../images/orange.png" alt="Orange Star" class="sea-star" style="--random-left: 12%; --random-top: 65%; --random-delay: 0.6s;">
        <img src="../images/yellow.png" alt="Yellow Star" class="sea-star" style="--random-left: 85%; --random-top: 55%; --random-delay: 0.9s;">
    </div>

    <!-- Footer -->
    <div id="footer-placeholder"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/footer-loader.js"></script>
    
    <script>
        const hamburgerToggle = document.querySelector('.hamburger-toggle');
        const mobileMenu = document.querySelector('.mobile-menu');

        hamburgerToggle.addEventListener('click', () => {
            hamburgerToggle.classList.toggle('active');
            mobileMenu.classList.toggle('active');
        });

        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
