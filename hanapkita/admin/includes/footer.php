<style>
    .modern-footer {
        background: linear-gradient(135deg, var(--card-white) 0%, #FEFBF8 100%);
        border-top: 1px solid rgba(255, 107, 0, 0.1);
        padding: 2rem 0 1rem;
        margin-top: auto;
        position: relative;
        overflow: hidden;
    }

    .modern-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, var(--primary-orange), #FF8F42, var(--primary-orange));
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .footer-brand {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .footer-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 1rem;
    }

    .footer-logo-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
    }

    .footer-logo-text {
        color: var(--text-dark);
    }

    .footer-logo-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
        background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .footer-logo-subtitle {
        font-size: 0.875rem;
        color: var(--text-gray);
        margin: 0;
        font-weight: 500;
    }

    .footer-description {
        color: var(--text-gray);
        font-size: 14px;
        line-height: 1.6;
        margin: 0;
        max-width: 300px;
    }

    .footer-social {
        display: flex;
        gap: 12px;
        margin-top: 1rem;
    }

    .social-link {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(255, 107, 0, 0.1);
        color: var(--primary-orange);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 16px;
    }

    .social-link:hover {
        background: var(--primary-orange);
        color: white;
        transform: translateY(-2px);
        text-decoration: none;
    }

    .footer-section {
        display: flex;
        flex-direction: column;
    }

    .footer-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0 0 1rem 0;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(255, 107, 0, 0.1);
        position: relative;
    }

    .footer-title::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 30px;
        height: 2px;
        background: var(--primary-orange);
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .footer-link {
        color: var(--text-gray);
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 4px 0;
    }

    .footer-link:hover {
        color: var(--primary-orange);
        text-decoration: none;
        transform: translateX(4px);
    }

    .footer-link i {
        width: 16px;
        text-align: center;
        font-size: 12px;
        opacity: 0.7;
    }

    .footer-contact-item {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
        font-size: 14px;
        color: var(--text-gray);
    }

    .footer-contact-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(255, 107, 0, 0.1);
        color: var(--primary-orange);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .footer-stats {
        display: flex;
        gap: 2rem;
        margin-top: 1rem;
    }

    .footer-stat {
        text-align: center;
    }

    .footer-stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-orange);
        margin: 0;
        line-height: 1.2;
    }

    .footer-stat-label {
        font-size: 0.75rem;
        color: var(--text-gray);
        margin: 0;
        line-height: 1.2;
    }

    .footer-bottom {
        border-top: 1px solid rgba(255, 107, 0, 0.1);
        padding-top: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .footer-copyright {
        color: var(--text-gray);
        font-size: 14px;
        margin: 0;
    }

    .footer-copyright strong {
        color: var(--primary-orange);
        font-weight: 600;
    }

    .footer-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .footer-meta-item {
        color: var(--text-gray);
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .footer-meta-item i {
        color: var(--success-green);
    }

    .footer-version {
        background: rgba(255, 107, 0, 0.1);
        color: var(--primary-orange);
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
    }

    /* System Status Indicator */
    .system-status {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(72, 187, 120, 0.1);
        color: var(--success-green);
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-indicator {
        width: 8px;
        height: 8px;
        background: var(--success-green);
        border-radius: 50%;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .footer-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .footer-bottom {
            flex-direction: column;
            text-align: center;
        }

        .footer-stats {
            justify-content: center;
        }

        .footer-content {
            padding: 0 1rem;
        }
    }

    @media (max-width: 480px) {
        .footer-stats {
            flex-direction: column;
            gap: 1rem;
        }

        .footer-social {
            justify-content: center;
        }
    }
</style>

<footer id="page-footer" class="modern-footer">
    <div class="footer-content">
        <!-- Main Footer Content -->
        <div class="footer-grid">
            <!-- Brand Section -->
            <div class="footer-brand">
                <div class="footer-logo">
                    <div class="footer-logo-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="footer-logo-text">
                        <h3 class="footer-logo-title">Hanap-Kita</h3>
                        <p class="footer-logo-subtitle">Admin Portal</p>
                    </div>
                </div>
                
                <p class="footer-description">
                    Connecting job seekers and local businesses in Balic-Balic, Sampaloc, Manila. 
                    Empowering communities through meaningful employment opportunities.
                </p>

                <div class="footer-stats">
                    <div class="footer-stat">
                        <p class="footer-stat-number">
                            <?php 
                            $sql_total_jobs = "SELECT jobId from tbljobs";
                            $query_total_jobs = $dbh->prepare($sql_total_jobs);
                            $query_total_jobs->execute();
                            echo $query_total_jobs->rowCount();
                            ?>
                        </p>
                        <p class="footer-stat-label">Total Jobs</p>
                    </div>
                    <div class="footer-stat">
                        <p class="footer-stat-number">
                            <?php 
                            $sql_total_employers = "SELECT id from tblemployers";
                            $query_total_employers = $dbh->prepare($sql_total_employers);
                            $query_total_employers->execute();
                            echo $query_total_employers->rowCount();
                            ?>
                        </p>
                        <p class="footer-stat-label">Employers</p>
                    </div>
                    <div class="footer-stat">
                        <p class="footer-stat-number">
                            <?php 
                            $sql_total_candidates = "SELECT id from tbljobseekers";
                            $query_total_candidates = $dbh->prepare($sql_total_candidates);
                            $query_total_candidates->execute();
                            echo $query_total_candidates->rowCount();
                            ?>
                        </p>
                        <p class="footer-stat-label">Job Seekers</p>
                    </div>
                </div>

                <div class="footer-social">
                    <a href="#" class="social-link" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-link" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-link" title="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="social-link" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-section">
                <h4 class="footer-title">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="dashboard.php" class="footer-link">
                        <i class="fas fa-tachometer-alt"></i>Dashboard
                    </a></li>
                    <li><a href="employer-list.php" class="footer-link">
                        <i class="fas fa-building"></i>Employers
                    </a></li>
                    <li><a href="reg-jobseekers.php" class="footer-link">
                        <i class="fas fa-users"></i>Job Seekers
                    </a></li>
                    <li><a href="all-listed-jobs.php" class="footer-link">
                        <i class="fas fa-briefcase"></i>All Jobs
                    </a></li>
                    <li><a href="manage-category.php" class="footer-link">
                        <i class="fas fa-tags"></i>Categories
                    </a></li>
                </ul>
            </div>

            <!-- Management -->
            <div class="footer-section">
                <h4 class="footer-title">Management</h4>
                <ul class="footer-links">
                    <li><a href="admin-profile.php" class="footer-link">
                        <i class="fas fa-user-circle"></i>Admin Profile
                    </a></li>
                    <li><a href="change-password.php" class="footer-link">
                        <i class="fas fa-key"></i>Change Password
                    </a></li>
                    <li><a href="aboutus.php" class="footer-link">
                        <i class="fas fa-info-circle"></i>About Us
                    </a></li>
                    <li><a href="contactus.php" class="footer-link">
                        <i class="fas fa-envelope"></i>Contact Us
                    </a></li>
                    <li><a href="activity-logs.php" class="footer-link">
                        <i class="fas fa-history"></i>Activity Logs
                    </a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-section">
                <h4 class="footer-title">Contact Info</h4>
                <div class="footer-contact-item">
                    <div class="footer-contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--text-dark);">Location</div>
                        <div>Balic-Balic, Sampaloc, Manila</div>
                    </div>
                </div>
                <div class="footer-contact-item">
                    <div class="footer-contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--text-dark);">Email</div>
                        <div>admin@hanapkita.com</div>
                    </div>
                </div>
                <div class="footer-contact-item">
                    <div class="footer-contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--text-dark);">Phone</div>
                        <div>+63 917 123 4567</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div>
                <p class="footer-copyright">
                    © 2025 <strong>Hanap-Kita</strong>. All rights reserved. 
                    Built with ❤️ for the Filipino community.
                </p>
            </div>

            <div class="footer-meta">
                <div class="system-status">
                    <div class="status-indicator"></div>
                    <span>System Online</span>
                </div>
                
                <div class="footer-meta-item">
                    <i class="fas fa-clock"></i>
                    <span>Last updated: <?php echo date('M j, Y g:i A'); ?></span>
                </div>
                
                <div class="footer-version">
                    v2.1.0
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
// Update footer stats periodically
function updateFooterStats() {
    // This would typically make an AJAX call to get updated stats
    console.log('Footer stats updated');
}

// Update every 5 minutes
setInterval(updateFooterStats, 300000);

// System status monitoring
function checkSystemStatus() {
    const statusIndicator = document.querySelector('.status-indicator');
    const statusText = document.querySelector('.system-status span');
    
    // Simulate system health check
    const isOnline = navigator.onLine;
    
    if (isOnline) {
        statusIndicator.style.background = 'var(--success-green)';
        statusText.textContent = 'System Online';
        statusText.parentElement.style.background = 'rgba(72, 187, 120, 0.1)';
        statusText.parentElement.style.color = 'var(--success-green)';
    } else {
        statusIndicator.style.background = '#EF4444';
        statusText.textContent = 'System Offline';
        statusText.parentElement.style.background = 'rgba(239, 68, 68, 0.1)';
        statusText.parentElement.style.color = '#EF4444';
    }
}

// Check status on load and periodically
checkSystemStatus();
setInterval(checkSystemStatus, 30000);

// Listen for online/offline events
window.addEventListener('online', checkSystemStatus);
window.addEventListener('offline', checkSystemStatus);
</script>

<!--Draft 2 -- >