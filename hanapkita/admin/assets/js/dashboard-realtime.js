/**
 * Real-time Dashboard JavaScript
 * Handles live updates, charts, and data visualization
 */

class HanapKitaDashboard {
    constructor() {
        this.charts = {};
        this.updateInterval = 30000; // 30 seconds
        this.apiBase = 'api/dashboard-data.php';
        this.isUpdating = false;
        
        this.init();
    }

    init() {
        this.initializeCharts();
        this.setupEventListeners();
        this.startRealTimeUpdates();
        this.loadInitialData();
    }

    /**
     * Initialize all charts
     */
    initializeCharts() {
        Chart.defaults.font.family = 'Inter';
        Chart.defaults.color = '#718096';

        // Applications Chart
        if (document.getElementById('applicationsChart')) {
            this.charts.applications = new Chart(document.getElementById('applicationsChart'), {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Applications',
                        data: [],
                        borderColor: '#FF6B00',
                        backgroundColor: 'rgba(255, 107, 0, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#FF6B00',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 107, 0, 0.1)' }
                        },
                        x: {
                            grid: { color: 'rgba(255, 107, 0, 0.1)' }
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuart'
                    }
                }
            });
        }

        // Categories Chart
        if (document.getElementById('categoriesChart')) {
            this.charts.categories = new Chart(document.getElementById('categoriesChart'), {
                type: 'doughnut',
                data: {
                    labels: [],
                    datasets: [{
                        data: [],
                        backgroundColor: [
                            '#FF6B00', '#FF8F42', '#667eea', '#764ba2',
                            '#f093fb', '#f5576c', '#4facfe', '#00f2fe'
                        ],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeInOutQuart'
                    }
                }
            });
        }

        // Status Chart
        if (document.getElementById('statusChart')) {
            this.charts.status = new Chart(document.getElementById('statusChart'), {
                type: 'bar',
                data: {
                    labels: ['Hired', 'Pending', 'Rejected'],
                    datasets: [{
                        label: 'Applications',
                        data: [],
                        backgroundColor: ['#48BB78', '#FF6B00', '#EF4444'],
                        borderRadius: 8,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 107, 0, 0.1)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    },
                    animation: {
                        duration: 1200,
                        easing: 'easeInOutQuart'
                    }
                }
            });
        }
    }

    /**
     * Load initial data for all components
     */
    async loadInitialData() {
        try {
            await Promise.all([
                this.updateStats(),
                this.updateApplicationsChart(),
                this.updateCategoriesChart(),
                this.updateStatusChart(),
                this.updateRecentActivities()
            ]);
        } catch (error) {
            console.error('Error loading initial data:', error);
            this.showNotification('Error loading dashboard data', 'error');
        }
    }

    /**
     * Update basic statistics
     */
    async updateStats() {
        try {
            const response = await fetch(`${this.apiBase}?action=stats`);
            const data = await response.json();
            
            // Update stat numbers with animation
            this.animateStatNumbers(data);
            
        } catch (error) {
            console.error('Error updating stats:', error);
        }
    }

    /**
     * Animate stat numbers
     */
    animateStatNumbers(data) {
        const stats = {
            categories: data.categories,
            employers: data.employers,
            jobseekers: data.jobseekers,
            jobs: data.jobs
        };

        Object.keys(stats).forEach(key => {
            const element = document.querySelector(`.stat-number[data-stat="${key}"]`);
            if (element) {
                this.countUp(element, parseInt(element.textContent) || 0, stats[key]);
            }
        });
    }

    /**
     * Count up animation for numbers
     */
    countUp(element, start, end, duration = 1000) {
        const startTime = performance.now();
        const range = end - start;

        const animate = (currentTime) => {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            const easeOut = 1 - Math.pow(1 - progress, 3);
            const current = Math.round(start + range * easeOut);
            
            element.textContent = current;
            
            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        };

        requestAnimationFrame(animate);
    }

    /**
     * Update applications chart
     */
    async updateApplicationsChart() {
        try {
            const response = await fetch(`${this.apiBase}?action=applications_chart`);
            const data = await response.json();
            
            if (this.charts.applications) {
                this.charts.applications.data.labels = data.labels;
                this.charts.applications.data.datasets[0].data = data.data;
                this.charts.applications.update('none');
            }
        } catch (error) {
            console.error('Error updating applications chart:', error);
        }
    }

    /**
     * Update categories chart
     */
    async updateCategoriesChart() {
        try {
            const response = await fetch(`${this.apiBase}?action=categories_chart`);
            const data = await response.json();
            
            if (this.charts.categories) {
                this.charts.categories.data.labels = data.labels;
                this.charts.categories.data.datasets[0].data = data.data;
                this.charts.categories.update('none');
            }
        } catch (error) {
            console.error('Error updating categories chart:', error);
        }
    }

    /**
     * Update status chart
     */
    async updateStatusChart() {
        try {
            const response = await fetch(`${this.apiBase}?action=status_chart`);
            const data = await response.json();
            
            if (this.charts.status) {
                this.charts.status.data.datasets[0].data = data.data;
                this.charts.status.update('none');
            }
        } catch (error) {
            console.error('Error updating status chart:', error);
        }
    }

    /**
     * Update recent activities
     */
    async updateRecentActivities() {
        try {
            const response = await fetch(`${this.apiBase}?action=recent_activities&limit=8`);
            const activities = await response.json();
            
            const container = document.querySelector('.activity-list');
            if (container && activities.length > 0) {
                container.innerHTML = activities.map(activity => 
                    this.createActivityHTML(activity)
                ).join('');
            }
        } catch (error) {
            console.error('Error updating recent activities:', error);
        }
    }

    /**
     * Create HTML for activity item
     */
    createActivityHTML(activity) {
        const iconClass = this.getActivityIcon(activity.type);
        const timeAgo = this.getTimeAgo(activity.timestamp);
        
        return `
            <div class="activity-item" style="animation: fadeInLeft 0.5s ease-out;">
                <div class="activity-icon ${activity.type}">
                    <i class="fas ${iconClass}"></i>
                </div>
                <div class="activity-content">
                    <p class="activity-text">
                        <strong>${this.escapeHtml(activity.user_name)}</strong> 
                        ${this.escapeHtml(activity.action)}
                    </p>
                    <p class="activity-time">
                        <i class="fas fa-clock"></i>
                        ${activity.time} (${timeAgo})
                    </p>
                </div>
            </div>
        `;
    }

    /**
     * Get activity icon based on type
     */
    getActivityIcon(type) {
        const icons = {
            'application': 'fa-file-alt',
            'login': 'fa-sign-in-alt',
            'logout': 'fa-sign-out-alt',
            'register': 'fa-user-plus',
            'update': 'fa-edit',
            'delete': 'fa-trash'
        };
        return icons[type] || 'fa-info-circle';
    }

    /**
     * Get time ago string
     */
    getTimeAgo(timestamp) {
        const now = Date.now() / 1000;
        const diff = now - timestamp;
        
        if (diff < 60) return 'just now';
        if (diff < 3600) return Math.floor(diff / 60) + 'm ago';
        if (diff < 86400) return Math.floor(diff / 3600) + 'h ago';
        return Math.floor(diff / 86400) + 'd ago';
    }

    /**
     * Escape HTML to prevent XSS
     */
    escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, (m) => map[m]);
    }

    /**
     * Setup event listeners
     */
    setupEventListeners() {
        // Refresh button
        const refreshBtn = document.getElementById('refreshDashboard');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', () => {
                this.refreshAll();
            });
        }

        // Auto-refresh toggle
        const autoRefreshToggle = document.getElementById('autoRefreshToggle');
        if (autoRefreshToggle) {
            autoRefreshToggle.addEventListener('change', (e) => {
                if (e.target.checked) {
                    this.startRealTimeUpdates();
                } else {
                    this.stopRealTimeUpdates();
                }
            });
        }

        // Visibility change handler (pause updates when tab is not visible)
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.stopRealTimeUpdates();
            } else {
                this.startRealTimeUpdates();
            }
        });

        // Window focus handler
        window.addEventListener('focus', () => {
            this.refreshAll();
        });
    }

    /**
     * Start real-time updates
     */
    startRealTimeUpdates() {
        if (this.updateTimer) {
            clearInterval(this.updateTimer);
        }

        this.updateTimer = setInterval(() => {
            if (!document.hidden) {
                this.loadInitialData();
            }
        }, this.updateInterval);

        this.showNotification('Real-time updates enabled', 'success');
    }

    /**
     * Stop real-time updates
     */
    stopRealTimeUpdates() {
        if (this.updateTimer) {
            clearInterval(this.updateTimer);
            this.updateTimer = null;
        }
    }

    /**
     * Refresh all data manually
     */
    async refreshAll() {
        if (this.isUpdating) return;

        this.isUpdating = true;
        this.showLoadingIndicator(true);

        try {
            await this.loadInitialData();
            this.showNotification('Dashboard updated successfully', 'success');
        } catch (error) {
            this.showNotification('Error updating dashboard', 'error');
        } finally {
            this.isUpdating = false;
            this.showLoadingIndicator(false);
        }
    }

    /**
     * Show loading indicator
     */
    showLoadingIndicator(show) {
        const indicator = document.getElementById('loadingIndicator');
        if (indicator) {
            indicator.style.display = show ? 'block' : 'none';
        }
    }

    /**
     * Show notification
     */
    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 10000;
            animation: slideInRight 0.3s ease-out;
            max-width: 300px;
        `;

        // Set background color based on type
        const colors = {
            'success': '#48BB78',
            'error': '#EF4444',
            'warning': '#F59E0B',
            'info': '#3B82F6'
        };
        notification.style.backgroundColor = colors[type] || colors.info;
        notification.textContent = message;

        document.body.appendChild(notification);

        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease-out';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    /**
     * Destroy dashboard instance
     */
    destroy() {
        this.stopRealTimeUpdates();
        
        // Destroy charts
        Object.values(this.charts).forEach(chart => {
            if (chart && typeof chart.destroy === 'function') {
                chart.destroy();
            }
        });
        
        this.charts = {};
    }
}

// CSS animations
const animationStyles = document.createElement('style');
animationStyles.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    @keyframes fadeInLeft {
        from {
            transform: translateX(-20px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .chart-loading {
        position: relative;
    }
    
    .chart-loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 40px;
        height: 40px;
        margin: -20px 0 0 -20px;
        border: 3px solid rgba(255, 107, 0, 0.3);
        border-top: 3px solid #FF6B00;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(animationStyles);

// Initialize dashboard when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.hanapKitaDashboard = new HanapKitaDashboard();
});

// Cleanup on page unload
window.addEventListener('beforeunload', () => {
    if (window.hanapKitaDashboard) {
        window.hanapKitaDashboard.destroy();
    }
});

// New Created File 3 