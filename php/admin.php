<?php
/**
 * Admin Panel - Contact Submissions
 * Krusty Krab Contact Form System
 * 
 * This file displays all contact form submissions in a styled table
 * Matches the ocean/Krusty Krab theme
 */

// Start session and check authentication
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'db_connect.php';

// Get sort parameter
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Get subject filter parameter
$subjectFilter = isset($_GET['subject']) ? $_GET['subject'] : 'all';

// Build ORDER BY clause based on sort parameter
switch ($sort) {
    case 'oldest':
        $orderBy = "ORDER BY created_at ASC";
        break;
    case 'name_asc':
        $orderBy = "ORDER BY name ASC";
        break;
    case 'name_desc':
        $orderBy = "ORDER BY name DESC";
        break;
    default: // newest
        $orderBy = "ORDER BY created_at DESC";
        break;
}

// Build WHERE clause for subject filter
$whereClause = "";
if ($subjectFilter !== 'all') {
    $subjectFilter = mysqli_real_escape_string($conn, $subjectFilter);
    $whereClause = "WHERE subject = '$subjectFilter'";
}

// Fetch all contact submissions with sorting and filtering
$sql = "SELECT * FROM contacts $whereClause $orderBy";
$result = mysqli_query($conn, $sql);

// Count total submissions
$totalSubmissions = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="https://static.wikia.nocookie.net/logopedia/images/8/8a/KK_main_logo.png">
    <title>Admin Panel - The Krusty Krab</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Hide body overflow to prevent double scrollbar */
        html {
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        body {
            overflow: hidden;
        }
        
        .admin-container {
            padding: 120px 2rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
            min-height: 100vh;
            position: relative;
            z-index: 10;
            overflow-y: auto;
        }
        
        .admin-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .admin-title {
            font-family: 'KrabbyPatty', cursive;
            font-size: 3rem;
            color: white;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.3);
            margin-bottom: 0.5rem;
        }
        
        .admin-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
        }
        
        .admin-user {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            margin-top: 0.75rem;
        }
        
        .logout-link {
            color: #FF6F61;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .logout-link:hover {
            color: #ff8a7a;
            text-decoration: underline;
        }
        
        .table-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            overflow-x: auto;
            position: relative;
            z-index: 20;
        }
        
        /* Sort dropdown styles */
        .controls-bar {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .total-messages {
            color: white;
            font-weight: 600;
            font-size: 1rem;
            background: rgba(255, 215, 0, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            border: 1px solid rgba(255, 215, 0, 0.4);
        }
        
        .total-messages span {
            color: #FFD700;
            font-weight: 700;
        }
        
        .sort-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .sort-label {
            color: white;
            font-weight: 600;
        }
        
        .sort-select {
            padding: 0.6rem 1.2rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='white' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
        }
        
        .sort-select:hover,
        .sort-select:focus {
            border-color: #FF6F61;
            background-color: rgba(255, 255, 255, 0.15);
            outline: none;
        }
        
        .sort-select option {
            background: #0077B6;
            color: white;
        }
        
        .contacts-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }
        
        .contacts-table th {
            background: rgba(255, 111, 97, 0.8);
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .contacts-table th:first-child {
            border-radius: 10px 0 0 0;
        }
        
        .contacts-table th:last-child {
            border-radius: 0 10px 0 0;
        }
        
        .contacts-table td {
            padding: 1rem;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            vertical-align: top;
        }
        
        .contacts-table tbody tr {
            transition: all 0.3s ease;
        }
        
        .contacts-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .contacts-table tbody tr:last-child td:first-child {
            border-radius: 0 0 0 10px;
        }
        
        .contacts-table tbody tr:last-child td:last-child {
            border-radius: 0 0 10px 0;
        }
        
        .message-cell {
            max-width: 300px;
            word-wrap: break-word;
        }
        
        .message-preview {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            cursor: pointer;
        }
        
        .message-preview:hover {
            -webkit-line-clamp: unset;
        }
        
        .id-cell {
            font-weight: 600;
            color: #FFD700;
        }
        
        .date-cell {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
            white-space: nowrap;
        }
        
        .email-link {
            color: white;
            text-decoration: none;
            font-weight: 700;
        }
        
        .email-link:hover {
            text-decoration: underline;
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: white;
        }
        
        .empty-state-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
        }
        
        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .empty-state p {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .back-link {
            display: inline-block;
            margin-top: 2rem;
            color: white;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #FF6F61, #ff8a7a);
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .back-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 111, 97, 0.4);
        }
        
        /* Search and Filter */
        .search-bar {
            margin-bottom: 1.5rem;
        }
        
        .search-input {
            width: 100%;
            max-width: 400px;
            padding: 0.75rem 1.5rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        
        .search-input:focus {
            outline: none;
            border-color: #FF6F61;
            background: rgba(255, 255, 255, 0.15);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .admin-title {
                font-size: 2rem;
            }
            
            .table-container {
                padding: 1rem;
            }
            
            .contacts-table th,
            .contacts-table td {
                padding: 0.75rem 0.5rem;
                font-size: 0.85rem;
            }
            
            .controls-bar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-input {
                max-width: 100%;
            }
        }
        
        /* Sea stars behind table */
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

    <div class="admin-container">
        <div class="admin-header">
            <h1 class="admin-title">Admin Panel</h1>
            <p class="admin-subtitle">Contact Form Submissions</p>
            <p class="admin-user">Welcome, <strong><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></strong> | <a href="admin.php?logout=1" class="logout-link">Logout</a></p>
        </div>
        
        <div class="table-container">
            <?php if ($totalSubmissions > 0): ?>
            
            <div class="controls-bar">
                <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search messages...">
                
                <div class="total-messages">
                    Total Messages: <span><?php echo $totalSubmissions; ?></span>
                </div>
                
                <div class="sort-container">
                    <span class="sort-label">Subject:</span>
                    <select class="sort-select" id="subjectFilter" onchange="updateFilters()">
                        <option value="all" <?php echo $subjectFilter === 'all' ? 'selected' : ''; ?>>All Subjects</option>
                        <option value="Reservations/Bookings" <?php echo $subjectFilter === 'Reservations/Bookings' ? 'selected' : ''; ?>>Reservations/Bookings</option>
                        <option value="Food & Menu" <?php echo $subjectFilter === 'Food & Menu' ? 'selected' : ''; ?>>Food & Menu</option>
                        <option value="Feedback" <?php echo $subjectFilter === 'Feedback' ? 'selected' : ''; ?>>Feedback</option>
                        <option value="Services" <?php echo $subjectFilter === 'Services' ? 'selected' : ''; ?>>Services</option>
                        <option value="Franchise" <?php echo $subjectFilter === 'Franchise' ? 'selected' : ''; ?>>Franchise</option>
                        <option value="General" <?php echo $subjectFilter === 'General' ? 'selected' : ''; ?>>General</option>
                    </select>
                </div>
                
                <div class="sort-container">
                    <span class="sort-label">Sort by:</span>
                    <select class="sort-select" id="sortSelect" onchange="updateFilters()">
                        <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Newest First</option>
                        <option value="oldest" <?php echo $sort === 'oldest' ? 'selected' : ''; ?>>Oldest First</option>
                        <option value="name_asc" <?php echo $sort === 'name_asc' ? 'selected' : ''; ?>>Name (A-Z)</option>
                        <option value="name_desc" <?php echo $sort === 'name_desc' ? 'selected' : ''; ?>>Name (Z-A)</option>
                    </select>
                </div>
            </div>
            
            <table class="contacts-table" id="contactsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date/Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td class="id-cell">#<?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td>
                            <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="email-link">
                                <?php echo htmlspecialchars($row['email']); ?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($row['phone'] ?: '-'); ?></td>
                        <td><?php echo htmlspecialchars($row['subject']); ?></td>
                        <td class="message-cell">
                            <div class="message-preview" title="Click to expand">
                                <?php echo nl2br(htmlspecialchars($row['message'])); ?>
                            </div>
                        </td>
                        <td class="date-cell">
                            <?php echo date('M d, Y', strtotime($row['created_at'])); ?><br>
                            <small><?php echo date('h:i A', strtotime($row['created_at'])); ?></small>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            
            <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <h3>No Messages Yet</h3>
                <p>Contact form submissions will appear here.</p>
            </div>
            <?php endif; ?>
        </div>
        
        <center>
            <a href="contact.php" class="back-link">← Back to Contact Page</a>
        </center>
    </div>

    <div class="sea-stars">
        <img src="../images/yellow.png" alt="Yellow Star" class="sea-star" style="--random-left: 8%; --random-top: 15%; --random-delay: 0s;">
        <img src="../images/violet.png" alt="Violet Star" class="sea-star" style="--random-left: 75%; --random-top: 25%; --random-delay: 0.3s;">
        <img src="../images/orange.png" alt="Orange Star" class="sea-star" style="--random-left: 12%; --random-top: 65%; --random-delay: 0.6s;">
        <img src="../images/yellow.png" alt="Yellow Star" class="sea-star" style="--random-left: 85%; --random-top: 55%; --random-delay: 0.9s;">
        <img src="../images/violet.png" alt="Violet Star" class="sea-star" style="--random-left: 25%; --random-top: 40%; --random-delay: 1.2s;">
        <img src="../images/orange.png" alt="Orange Star" class="sea-star" style="--random-left: 70%; --random-top: 70%; --random-delay: 1.5s;">
    </div>

    <!-- Footer -->
    <div id="footer-placeholder"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/footer-loader.js"></script>
    
    <script>
        // Hamburger menu toggle
        const hamburgerToggle = document.querySelector('.hamburger-toggle');
        const mobileMenu = document.querySelector('.mobile-menu');

        hamburgerToggle.addEventListener('click', () => {
            hamburgerToggle.classList.toggle('active');
            mobileMenu.classList.toggle('active');
        });

        // Navbar scroll effect
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Search functionality
        document.getElementById('searchInput')?.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#contactsTable tbody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Update filters function for both subject and sort
        function updateFilters() {
            const sort = document.getElementById('sortSelect').value;
            const subject = document.getElementById('subjectFilter').value;
            window.location.href = 'admin.php?sort=' + sort + '&subject=' + encodeURIComponent(subject);
        }
        
        // Message expand on click
        document.querySelectorAll('.message-preview').forEach(el => {
            el.addEventListener('click', function() {
                this.style.webkitLineClamp = this.style.webkitLineClamp === 'unset' ? '3' : 'unset';
            });
        });
    </script>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
