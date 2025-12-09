// footer-loader.js 

const FooterLoader = {
    /**
     * Determines the correct path to footer.html based on current page location
     * @returns {string} The path to footer.html
     */
    getFooterPath() {
        const path = window.location.pathname;
        // If we're in the root directory (index.html or /)
        if (path.endsWith('/') || path.endsWith('/index.html') || path.match(/\/krusty%20krab\/?$/i) || path.match(/\/krusty krab\/?$/i)) {
            return 'pages/footer.html';
        }
        // If we're in the pages folder
        if (path.includes('/pages/')) {
            return 'footer.html';
        }
        // If we're in the php folder
        if (path.includes('/php/')) {
            return '../pages/footer.html';
        }
        // Default fallback - try relative to root
        return 'pages/footer.html';
    },

    /**
     * Loads and initializes the footer component
     * @param {string} containerId 
     * @returns {Promise<boolean>} 
     */
    async load(containerId = 'footer-placeholder') {
        try {
            const footerPath = this.getFooterPath();
            const response = await fetch(footerPath);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const html = await response.text();
            
            const container = document.getElementById(containerId);
            if (!container) {
                console.error(`Container #${containerId} not found`);
                return false;
            }
            
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            const styles = doc.querySelectorAll('style');
            styles.forEach(style => {
                if (!document.getElementById(style.id || 'footer-styles')) {
                    const newStyle = document.createElement('style');
                    if (style.id) newStyle.id = style.id;
                    newStyle.textContent = style.textContent;
                    document.head.appendChild(newStyle);
                }
            });
            
            container.innerHTML = doc.body.innerHTML;
            
            this.initializeBubbles();
            
            console.log('✓ Footer loaded successfully');
            return true;
            
        } catch (error) {
            console.error('Error loading footer:', error);
            return false;
        }
    },
    
    initializeBubbles() {
        const footerBubblesContainer = document.getElementById('footer-bubbles');
        
        if (!footerBubblesContainer) {
            console.warn('Footer bubbles container not found');
            return;
        }
        
        footerBubblesContainer.innerHTML = '';
        
        for (let i = 0; i < 25; i++) {
            const bubble = document.createElement('div');
            bubble.classList.add('footer-bubble');
            
            const left = Math.random() * 100;
            const size = Math.random() * 30 + 20;
            
            const speedCategory = Math.random();
            let duration;
            if (speedCategory < 0.3) {
                duration = Math.random() * 4 + 8;  // Fast bubbles
            } else if (speedCategory < 0.7) {
                duration = Math.random() * 6 + 12; // Medium bubbles
            } else {
                duration = Math.random() * 5 + 20; // Slow bubbles
            }
            
            const delay = (Math.random() * 15) - 8;
            const driftX = (Math.random() - 0.5) * 80;
            const driftXEnd = (Math.random() - 0.5) * 80;
            
            bubble.style.cssText = `
                left: ${left}%;
                width: ${size}px;
                height: ${size}px;
                animation-duration: ${duration}s;
                animation-delay: ${delay}s;
            `;
            
            bubble.style.setProperty('--drift-x', `${driftX}px`);
            bubble.style.setProperty('--drift-x-end', `${driftXEnd}px`);
            
            footerBubblesContainer.appendChild(bubble);
        }
        
        console.log('✓ Created 25 footer bubbles');
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        FooterLoader.load();
    });
} else {
    FooterLoader.load();
}

if (typeof window !== 'undefined') {
    window.FooterLoader = FooterLoader;
}