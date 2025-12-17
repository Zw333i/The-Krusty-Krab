# 🦀 The Krusty Krab Website

<p align="center">
  <img src="https://static.wikia.nocookie.net/logopedia/images/8/8a/KK_main_logo.png" alt="Krusty Krab Logo" width="200">
</p>

<p align="center">
  <strong>Home of the World Famous Krabby Patty</strong><br>
  A fully immersive, ocean-themed restaurant website inspired by the cartoon SpongeBob SquarePants
</p>

---

## 📖 Overview

The Krusty Krab is a beautifully designed, fully responsive website for the iconic underwater restaurant from SpongeBob SquarePants. This project features an immersive ocean theme with animated bubbles, floating sea stars, swaying seaweed, and a complete contact management system with PHP/MySQL backend.

## Project Overview
This website was developed by BSIT 3rd year students as part of the Web Development course. It serves as a digital storefront for The Krusty Krab, allowing customers in Bikini Bottom to view the menu, check promotions, and "build their own burger."

## Purpose
To modernize The Krusty Krab's operations by providing an online menu, showcasing the restaurant's history, and streamlining customer inquiries through a digital contact form.

## Team Members & Roles
- *Zeint Justine B. Lacra* - Frontend Developer & Designer
- *Jay Lawrence C. Cerniaz* - Backend Developer & Database Manager
- *Mel Frederick R. Sablan* - Project Manager & Content Strategist

## Tools Used
- **Frontend:** HTML5, CSS3, JavaScript (GSAP, OwlCarousel, SwiperJS)
- **Backend:** PHP (Login, Contact Form Logic)
- **Database:** MySQL (XAMPP)
- **Version Control:** Git & GitHub
- **Editor:** Visual Studio Code

## Site Structure
- index.html - Homepage with Hero Animation
- pages/
  - menu.html - Interactive Menu & Burger Builder
  - about.html - Crew profiles and History
  - gallery.html - 3D Embeds and Videos
  - promotions.html - Daily Specials
  - contact.html - Inquiry Form (Static Interface)
- css/ - Custom Styling
- js/ - Animations and Footer Loader

## Design Concept
- **Color Scheme:** Ocean Blue (#00c0fa), Coral Red (#FF6F61), and Sand Beige
- **Typography:** KrabbyPatty (Custom Font) for headers, Poppins for readability
- **Layout:** Responsive mobile-first grid with immersive underwater animations

## Deployment
- **GitHub Repository:** https://github.com/jy-crnz/The-Krusty-Krab
- **Live Site:** https://jy-crnz.github.io/The-Krusty-Krab/index.html

## Lessons Learned
- Mastered CSS animations (Keyframes) for underwater effects
- Learned to integrate 3rd party libraries like GSAP and Sketchfab
- Solved file path issues using a custom JavaScript Footer Loader

## Timeline
| Phase | Task | Date |
| :--- | :--- | :--- |
| *Proposal* | Planning & wireframe | Oct 14 – Oct 20, 2025 |
| *Development* | Coding & testing | Oct 21 – Dec 05, 2025 |
| *Deployment* | GitHub setup & launch | Dec 06 – Dec 10, 2025 |
| *Submission* | Final documentation | Dec 11 – Dec 12, 2025 |

## ✨ Features

### 🎨 Frontend Features
- **Immersive Ocean Theme** - Deep blue gradients, animated bubbles, floating sea stars, and underwater ambiance
- **Custom Typography** - Uses the authentic "Krabby Patty" font for that genuine Bikini Bottom feel
- **Fully Responsive Design** - Looks great on desktop, tablet, and mobile devices
- **Animated Elements**:
  - Rising bubble animations
  - Floating sea star decorations
  - Swaying seaweed on the ocean floor
  - Smooth hover transitions
  - Interactive card flip effects
- **Dynamic Footer** - Loaded via JavaScript with SpongeBob & Squidward's houses on the ocean floor

### 📄 Pages

| Page | Description |
|------|-------------|
| **Home** (`index.html`) | Hero section featuring the iconic Krabby Patty with ocean animations |
| **Menu** (`pages/menu.html`) | Complete "Galley Grub" menu with SVG burger animation and Owl Carousel |
| **Gallery** (`pages/gallery.html`) | Photo carousel of memorable moments + embedded YouTube commercial |
| **Promotions** (`pages/promotions.html`) | Swiper.js slider showcasing deals and the Wendy's collaboration |
| **About Us** (`pages/about.html`) | Meet the crew with interactive Material Design flip cards |
| **Contact** (`php/contact.php`) | Functional contact form with 3D Sketchfab restaurant model |

### 🔧 Backend Features (PHP/MySQL)
- **Contact Form System** - Stores all submissions in MySQL database
- **Subject Categories** - Dropdown with 6 options:
  - Reservations/Bookings
  - Food & Menu
  - Feedback
  - Services
  - Franchise
  - General
- **Admin Panel** (`php/admin.php`) - Secure dashboard to view all submissions
  - Filter by subject category
  - Sort by date or name
  - Search functionality
  - Responsive table design
- **Authentication System** - Session-based login protection
- **Secret Admin Access** - Click the logo to access admin login!

## 🗂️ Project Structure

```
krusty krab/
├── index.html                 # Homepage
├── README.md                  # This file
│
├── css/
│   ├── index.css              # Homepage styles
│   └── style.css              # Shared styles for all pages
│
├── fonts/
│   └── KrabbyPatty.ttf        # Custom Krabby Patty font
│
├── images/
│   ├── ray.png                # Light Ray
│   ├── krabby patty.png       # Hero image
│   ├── yellow.png             # Yellow sea star
│   ├── violet.png             # Violet sea star
│   ├── orange.png             # Orange sea star
│   ├── spongebob_house.png    # Pineapple house (footer)
│   └── squidward_house.png    # Easter Island head (footer)
│
├── js/
│   ├── script.js              # Main JavaScript functionality
│   └── footer-loader.js       # Dynamic footer loading with path detection
│
├── pages/
│   ├── menu.html              # Restaurant menu
│   ├── gallery.html           # Photo gallery
│   ├── promotions.html        # Current promotions
│   ├── about.html             # About us / Meet the crew
│   └── footer.html            # Shared footer component
│
└── php/
    ├── contact.php            # Contact form page
    ├── process_contact.php    # Form submission handler
    ├── admin.php              # Admin dashboard
    ├── login.php              # Admin login page
    └── db_connect.php         # Database connection
```

## 🛠️ Technologies Used

### Frontend
- **HTML5** - Semantic markup
- **CSS3** - Custom properties, Flexbox, Grid, animations, backdrop-filter
- **JavaScript (ES6+)** - DOM manipulation, Fetch API, async/await
- **jQuery 3.6.0** - DOM utilities and plugin support

### Libraries & Frameworks
- **[Owl Carousel 2.3.4](https://owlcarousel2.github.io/OwlCarousel2/)** - Menu and gallery carousels
- **[Swiper 8.4.5](https://swiperjs.com/)** - Promotions slider
- **[GSAP 3.12.2](https://greensock.com/gsap/)** - Advanced animations (menu page)
- **[Font Awesome 6.4.0](https://fontawesome.com/)** - Icons
- **[Google Fonts](https://fonts.google.com/)** - Fredoka One & Poppins fonts

### Backend
- **PHP 8.x** - Server-side processing
- **MySQL** - Database storage
- **XAMPP** - Local development environment

### External Integrations
- **[Sketchfab](https://sketchfab.com/)** - 3D restaurant model embed
- **[YouTube](https://youtube.com/)** - Embedded video content
- **[EmailJS](https://www.emailjs.com/)** - Optional email notifications

## 💾 Database Setup

### 1. Create the Database
```sql
CREATE DATABASE krusty_krab_db;
USE krusty_krab_db;
```

### 2. Create the Contacts Table
```sql
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 3. Configure Database Connection
Edit `php/db_connect.php` with your credentials:
```php
$host = "localhost";
$username = "root";
$password = "";
$database = "krusty_krab_db";
```

## 🚀 Installation & Setup

1. **Clone or download** the project to your XAMPP htdocs folder:
   ```
   C:\xampp\htdocs\krusty krab\
   ```

2. **Start XAMPP** and enable Apache & MySQL

3. **Create the database** using phpMyAdmin or MySQL CLI (see above)

4. **Access the website** at:
   ```
   http://localhost/krusty%20krab/
   ```

## 🔐 Admin Access

The admin panel is accessible through a **secret login**:

1. **Click the Krusty Krab logo** in the navigation bar
2. Enter credentials:
   - **Username:** `mrkrabs`
   - **Password:** `mrkrabs`
3. View, filter, and search all contact submissions

## 📱 Responsive Breakpoints

| Breakpoint | Device |
|------------|--------|
| < 480px | Mobile phones |
| 480px - 768px | Tablets (portrait) |
| 768px - 992px | Tablets (landscape) |
| 992px - 1200px | Small desktops |
| > 1200px | Large desktops |

## 🎯 Key Design Elements

### Color Palette
| Color | Hex | Usage |
|-------|-----|-------|
| Ocean Blue | `#0077B6` | Primary background gradient |
| Deep Sea | `#023E8A` | Dark sections |
| Coral Red | `#FF6F61` | Buttons, accents, CTAs |
| Golden Yellow | `#FFD700` | Highlights, hover states |
| Sandy Brown | `#F4A460` | Warm accents |
| White | `#FFFFFF` | Text, cards |

### Typography
- **Headings:** KrabbyPatty (custom), Fredoka One
- **Body:** Poppins (300, 400, 600, 700 weights)

## 🌟 Special Features

### Dynamic Footer Loader
The footer is loaded dynamically via `footer-loader.js` which automatically detects the current page location and loads the footer with correct relative paths.

### Animated SVG Burger (Menu Page)
An interactive SVG animation built with GSAP that assembles a Krabby Patty layer by layer.

### Material Design Flip Cards (About Page)
Interactive cards that flip to reveal character information with smooth CSS transitions.

### 3D Restaurant Model (Contact Page)
Embedded Sketchfab 3D model of The Krusty Krab that visitors can rotate and explore.

## 📝 License

This project is created for educational purposes. SpongeBob SquarePants and all related characters and elements are trademarks of and © Viacom International Inc.

## 🙏 Credits

- **SpongeBob SquarePants** - Created by Stephen Hillenburg
- **3D Krusty Krab Model** - [Mrlunettes on Sketchfab](https://sketchfab.com/Mrlunettes)
- **Fonts** - Google Fonts, KrabbyPatty font
- **Icons** - Font Awesome

---

<p align="center">
  Made with 🍔 in Bikini Bottom<br>
  <em>"The Krusty Krab pizza is the pizza for you and me!"</em>
</p>
