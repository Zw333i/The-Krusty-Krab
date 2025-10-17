// script.js

$(document).ready(function() {
    
    // Mobile Navigation Toggle
    $('.mobile-toggle').click(function() {
        $('.nav-links').toggleClass('active');
        $(this).toggleClass('active');
    });

    // Close mobile menu when clicking outside
    $(document).click(function(event) {
        if (!$(event.target).closest('.navbar').length) {
            $('.nav-links').removeClass('active');
            $('.mobile-toggle').removeClass('active');
        }
    });

    if ($('.custom-carousel').length) {
        $('.custom-carousel').each(function() {
            $(this).owlCarousel({
                autoWidth: true,
                loop: true,
                margin: 30,
                nav: true,
                dots: true,
                navText: ['‹', '›'],
                freeDrag: true,  
                responsive: {
                    0: {
                        items: 1,
                        freeDrag: true  
                    },
                    600: {
                        items: 2,
                        freeDrag: true  
                    },
                    1000: {
                        items: 3,
                        freeDrag: false  
                    }
                }
            });
        });

        $(document).on('click', '.custom-carousel .item', function() {
        const carousel = $(this).closest('.custom-carousel');
        carousel.find('.item').removeClass('active');
        $(this).addClass('active');
});

    }

    // Gallery Carousel Functionality
    if ($('#carouselWrapper').length) {
        let currentIndex = 0;
        const items = $('.carousel-item');
        const totalItems = items.length;
        
        // Click on carousel item
        $('.carousel-item').click(function() {
            const clickedIndex = $(this).data('index');
            if (clickedIndex !== currentIndex) {
                setActiveItem(clickedIndex);
            }
        });

        // Previous button
        $('#prevBtn').click(function() {
            currentIndex = (currentIndex - 1 + totalItems) % totalItems;
            setActiveItem(currentIndex);
        });

        // Next button
        $('#nextBtn').click(function() {
            currentIndex = (currentIndex + 1) % totalItems;
            setActiveItem(currentIndex);
        });

        function setActiveItem(index) {
            currentIndex = index;
            
            // Remove active class from all items
            items.removeClass('active');
            
            // Add active class to clicked item
            items.eq(index).addClass('active');
            
            // Calculate the position to center the active item
            const itemWidth = items.eq(index).hasClass('active') ? 500 : 320;
            const containerWidth = $('.carousel-container').width();
            const offset = (containerWidth / 2) - (itemWidth / 2);
            
            // Calculate cumulative width before the active item
            let totalWidth = 0;
            items.each(function(i) {
                if (i < index) {
                    const w = $(this).hasClass('active') ? 500 : 320;
                    totalWidth += w + 30; // 30px for margins
                }
            });
            
            // Apply transform
            const translateX = offset - totalWidth - 15;
            $('#carouselWrapper').css('transform', `translateX(${translateX}px)`);
        }

        // Auto-play carousel (optional)
        let autoplayInterval = setInterval(function() {
            currentIndex = (currentIndex + 1) % totalItems;
            setActiveItem(currentIndex);
        }, 5000);

        // Stop autoplay on hover
        $('.carousel-container').hover(
            function() {
                clearInterval(autoplayInterval);
            },
            function() {
                autoplayInterval = setInterval(function() {
                    currentIndex = (currentIndex + 1) % totalItems;
                    setActiveItem(currentIndex);
                }, 5000);
            }
        );

        // Handle window resize
        $(window).resize(function() {
            setActiveItem(currentIndex);
        });
    }

    // Contact Form Submission
    $('#contactForm').submit(function(e) {
        e.preventDefault();
        
        const formData = {
            name: $('#name').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
            subject: $('#subject').val(),
            message: $('#message').val()
        };

        // Show success message (in a real application, you would send this to a server)
        $('#formResponse')
            .removeClass('error-message')
            .addClass('success-message')
            .css({
                'display': 'block',
                'background-color': '#90EE90',
                'color': '#006400',
                'border': '2px solid #006400'
            })
            .html(`
                <strong>✓ Message Sent Successfully!</strong><br>
                Thank you, ${formData.name}! We've received your message and will get back to you soon at ${formData.email}.
            `);

        // Reset form
        this.reset();

        // Hide success message after 5 seconds
        setTimeout(function() {
            $('#formResponse').fadeOut();
        }, 5000);

        console.log('Form submitted:', formData);
    });
    
    $('a[href^="#"]').on('click', function(e) {
        const target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 80
            }, 800);
        }
    });

    $(document).on('click', '.menu-list-link', function(e) {
        e.preventDefault();
        
        const target = $(this).data('target');
        const element = $('#' + target);
        
        console.log('Menu item clicked:', target);
        
        if (element.length) {
            console.log('Found element:', element);
            
            const carousel = element.closest('.custom-carousel');
            const owlCarousel = carousel.data('owl.carousel');
            
            if (!owlCarousel) {
                console.log('Owl Carousel not initialized');
                return;
            }
            
            const allItems = carousel.find('.owl-item:not(.cloned) .item');
            let targetIndex = -1;
            
            allItems.each(function(index) {
                if ($(this).attr('id') === target) {
                    targetIndex = index;
                    return false; 
                }
            });
            
            console.log('Target index:', targetIndex);
            
            if (targetIndex !== -1) {
                $('html, body').stop().animate({
                    scrollTop: element.closest('.menu-category').offset().top - 100
                }, 800, function() {
                    console.log('Scroll complete');
                    
                    setTimeout(function() {
                        carousel.find('.item').removeClass('active');
                        
                        const screenWidth = $(window).width();
                        
                        if (screenWidth >= 1000) {
                            const desktopIndex = targetIndex > 0 ? targetIndex - 1 : 0;
                            owlCarousel.to(desktopIndex, 400, true);
                        } else {
                            owlCarousel.to(targetIndex, 400, true);
                        }
                        
                        console.log('Navigated to index:', targetIndex);
                        
                        setTimeout(function() {
                            carousel.find('.item').removeClass('active');
                            
                            element.addClass('active');
                            
                            console.log('Card expanded with active class');
                            
                            setTimeout(function() {
                                owlCarousel.trigger('refresh.owl.carousel');
                            }, 50);
                        }, 450);
                    }, 100);
                });
            } else {
                console.log('Target index not found');
            }
        } else {
            console.log('Element not found for target:', target);
        }
    });

    function isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    function handleScrollAnimations() {
        $('.featured-card, .menu-item, .staff-card, .info-card').each(function() {
            if (isElementInViewport(this)) {
                $(this).addClass('fade-in-up');
            }
        });
    }

    // Add CSS for scroll animations
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .fade-in-up {
                animation: fadeInUp 0.6s ease forwards;
            }
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `)
        .appendTo('head');

    // Trigger on scroll
    $(window).on('scroll', handleScrollAnimations);
    handleScrollAnimations(); // Initial check

    // Add hover effect to buttons
    $('.btn, .submit-btn, .carousel-btn').hover(
        function() {
            $(this).css('transform', 'translateY(-3px) scale(1.05)');
        },
        function() {
            $(this).css('transform', 'translateY(0) scale(1)');
        }
    );

    // Prevent form submission animation conflict
    $('.carousel-btn').click(function(e) {
        e.stopPropagation();
    });

    // Add loading state to navigation
    $('.nav-links a').click(function() {
        if ($(this).attr('href').indexOf('#') === -1) {
            $(this).append(' <span style="font-size: 0.8em;">⟳</span>');
        }
    });

    // Console log for debugging
    console.log('🦀 The Krusty Krab website loaded successfully!');
    console.log('📍 Total menu items:', $('.menu-item').length);
    console.log('🎨 Gallery items:', $('.carousel-item').length);
});

// Additional functionality for interactive elements
document.addEventListener('DOMContentLoaded', function() {
    
    // Add ripple effect to buttons
    const buttons = document.querySelectorAll('.btn, .submit-btn');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });
    });

    // Add ripple effect styles
    const style = document.createElement('style');
    style.textContent = `
        .btn, .submit-btn {
            position: relative;
            overflow: hidden;
        }
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple-animation 0.6s ease-out;
            pointer-events: none;
        }
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
});

// Form validation helper
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePhone(phone) {
    const re = /^[\d\s\-\(\)]+$/;
    return re.test(phone) || phone === '';
}

// Add real-time validation to contact form
$(document).ready(function() {
    $('#email').on('blur', function() {
        const email = $(this).val();
        if (email && !validateEmail(email)) {
            $(this).css('border-color', '#FF6F61');
        } else {
            $(this).css('border-color', '#f2f2f2');
        }
    });

    $('#phone').on('blur', function() {
        const phone = $(this).val();
        if (phone && !validatePhone(phone)) {
            $(this).css('border-color', '#FF6F61');
        } else {
            $(this).css('border-color', '#f2f2f2');
        }
    });
});