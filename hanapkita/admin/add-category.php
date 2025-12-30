<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['jpaid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {

$category=$_POST['category'];
$description=$_POST['description'];

$sql="insert into tblcategory(CategoryName,Description)values(:category,:description)";
$query=$dbh->prepare($sql);
$query->bindParam(':category',$category,PDO::PARAM_STR);
$query->bindParam(':description',$description,PDO::PARAM_STR);

 $query->execute();

   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {
    echo '<script>alert("Category has been created.")</script>';
echo "<script>window.location.href ='manage-category.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}

?>
<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Hanap-Kita - Add Category</title>
    <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-orange: #FF6B00;
            --light-orange: #FFE5D1;
            --bg-peach: #FEF7F0;
            --card-white: #FFFFFF;
            --text-dark: #2D3748;
            --text-gray: #718096;
            --text-light: #A0AEC0;
            --success-green: #48BB78;
            --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-card: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }

        body {
            background: linear-gradient(135deg, var(--bg-peach) 0%, #FAF5F0 100%);
            min-height: 100vh;
        }

        .main-content {
            padding: 2rem;
            margin-left: 0;
            max-width: 900px;
            margin: 0 auto;
        }

        .page-header {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-orange), #FF8F42);
            border-radius: 20px 20px 0 0;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .header-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.3);
        }

        .header-text h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 0.5rem 0;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-text p {
            color: var(--text-gray);
            font-size: 1.1rem;
            margin: 0;
            line-height: 1.5;
        }

        /* Quick Stats */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--card-white);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 107, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-card);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
            flex-shrink: 0;
        }

        .stat-icon.categories { background: linear-gradient(135deg, var(--primary-orange), #FF8F42); }
        .stat-icon.jobs { background: linear-gradient(135deg, #4299E1, #3182CE); }
        .stat-icon.active { background: linear-gradient(135deg, var(--success-green), #38A169); }

        .stat-content h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            line-height: 1.2;
        }

        .stat-content p {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
        }

        /* Main Form Card */
        .form-card {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-orange), #FF8F42);
            border-radius: 20px 20px 0 0;
        }

        .form-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid rgba(255, 107, 0, 0.1);
        }

        .form-header-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 8px rgba(255, 107, 0, 0.3);
        }

        .form-header-text h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .form-header-text p {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
        }

        /* Form Elements */
        .modern-form {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .form-label {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: var(--primary-orange);
            font-size: 0.875rem;
        }

        .form-label .required {
            color: #EF4444;
            font-size: 0.75rem;
        }

        .form-input, .form-textarea {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid rgba(255, 107, 0, 0.1);
            border-radius: 12px;
            background: var(--card-white);
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s ease;
            resize: vertical;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
            transform: translateY(-1px);
        }

        .form-textarea {
            min-height: 120px;
            line-height: 1.6;
        }

        .form-help {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-help i {
            color: var(--primary-orange);
            font-size: 0.75rem;
        }

        .char-counter {
            font-size: 0.75rem;
            color: var(--text-light);
            text-align: right;
            margin-top: 0.25rem;
        }

        /* Action Buttons */
        .form-actions {
            margin-top: 1rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 107, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .btn-modern {
            padding: 0.875rem 2rem;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 140px;
            justify-content: center;
            font-family: inherit;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 107, 0, 0.1);
            color: var(--primary-orange);
            border: 2px solid rgba(255, 107, 0, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(255, 107, 0, 0.2);
            transform: translateY(-1px);
            text-decoration: none;
            color: var(--primary-orange);
        }

        .btn-outline {
            background: transparent;
            color: var(--text-gray);
            border: 2px solid rgba(113, 128, 150, 0.2);
        }

        .btn-outline:hover {
            background: rgba(113, 128, 150, 0.1);
            color: var(--text-dark);
            text-decoration: none;
        }

        /* Tips Section */
        .tips-section {
            background: rgba(255, 107, 0, 0.02);
            border: 1px solid rgba(255, 107, 0, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .tips-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .tips-header i {
            color: var(--primary-orange);
            font-size: 1.25rem;
        }

        .tips-header h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .tips-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .tips-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-gray);
            line-height: 1.5;
        }

        .tips-list li i {
            color: var(--primary-orange);
            font-size: 0.75rem;
            margin-top: 0.25rem;
            flex-shrink: 0;
        }

        /* Preview Section */
        .preview-section {
            background: var(--card-white);
            border: 2px dashed rgba(255, 107, 0, 0.2);
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        .preview-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .preview-header i {
            color: var(--primary-orange);
        }

        .preview-header h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .preview-content {
            padding: 1rem;
            background: rgba(255, 107, 0, 0.02);
            border-radius: 8px;
            border-left: 4px solid var(--primary-orange);
        }

        .preview-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 0.5rem 0;
        }

        .preview-description {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
            line-height: 1.5;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .page-header, .form-card {
                padding: 1.5rem;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-modern {
                width: 100%;
            }

            .stats-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div id="page-container" class="sidebar-o sidebar-inverse side-scroll page-header-fixed main-content-narrow">
        <?php include_once('includes/sidebar.php');?>
        <?php include_once('includes/header.php');?>

        <main id="main-container">
            <div class="content main-content">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="header-text">
                            <h1>Add New Job Category</h1>
                            <p>Create a new job category to help organize and classify job listings on your platform</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-icon categories">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="stat-content">
                            <h3>
                                <?php 
                                $sql_categories = "SELECT COUNT(*) as count FROM tblcategory";
                                $query_categories = $dbh->prepare($sql_categories);
                                $query_categories->execute();
                                echo $query_categories->fetch(PDO::FETCH_OBJ)->count;
                                ?>
                            </h3>
                            <p>Total Categories</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon jobs">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="stat-content">
                            <h3>
                                <?php 
                                $sql_jobs = "SELECT COUNT(*) as count FROM tbljobs";
                                $query_jobs = $dbh->prepare($sql_jobs);
                                $query_jobs->execute();
                                echo $query_jobs->fetch(PDO::FETCH_OBJ)->count;
                                ?>
                            </h3>
                            <p>Total Jobs</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon active">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3>
                                <?php 
                                $sql_active = "SELECT COUNT(*) as count FROM tbljobs WHERE isActive = 1";
                                $query_active = $dbh->prepare($sql_active);
                                $query_active->execute();
                                echo $query_active->fetch(PDO::FETCH_OBJ)->count;
                                ?>
                            </h3>
                            <p>Active Jobs</p>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="form-card">
                    <div class="form-header">
                        <div class="form-header-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="form-header-text">
                            <h2>Category Details</h2>
                            <p>Fill in the information below to create a new job category</p>
                        </div>
                    </div>

                    <form method="post" class="modern-form" id="categoryForm">
                        <!-- Category Name -->
                        <div class="form-group">
                            <label class="form-label" for="category">
                                <i class="fas fa-heading"></i>
                                Category Name
                                <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="category" 
                                id="category"
                                class="form-input" 
                                required="true"
                                placeholder="e.g., Information Technology, Healthcare, Construction"
                                maxlength="100"
                                oninput="updatePreview(); updateCharCount('category', 'categoryCount', 100)"
                            >
                            <p class="form-help">
                                <i class="fas fa-lightbulb"></i>
                                Choose a clear, descriptive name that job seekers will easily understand
                            </p>
                            <div class="char-counter">
                                <span id="categoryCount">0</span>/100 characters
                            </div>
                        </div>

                        <!-- Category Description -->
                        <div class="form-group">
                            <label class="form-label" for="description">
                                <i class="fas fa-align-left"></i>
                                Category Description
                                <span class="required">*</span>
                            </label>
                            <textarea 
                                name="description" 
                                id="description"
                                class="form-textarea" 
                                required="true"
                                placeholder="Provide a detailed description of this job category, including typical roles, responsibilities, and skills required..."
                                maxlength="500"
                                oninput="updatePreview(); updateCharCount('description', 'descriptionCount', 500)"
                            ></textarea>
                            <p class="form-help">
                                <i class="fas fa-info-circle"></i>
                                Describe what types of jobs fall under this category and what skills are typically required
                            </p>
                            <div class="char-counter">
                                <span id="descriptionCount">0</span>/500 characters
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <div class="preview-section">
                            <div class="preview-header">
                                <i class="fas fa-eye"></i>
                                <h4>Category Preview</h4>
                            </div>
                            <div class="preview-content">
                                <div class="preview-title" id="previewTitle">Category Name</div>
                                <div class="preview-description" id="previewDescription">Category description will appear here...</div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <div>
                                <a href="manage-category.php" class="btn-modern btn-outline">
                                    <i class="fas fa-times"></i>
                                    Cancel
                                </a>
                            </div>
                            <div style="display: flex; gap: 1rem;">
                                <button type="button" class="btn-modern btn-secondary" onclick="resetForm()">
                                    <i class="fas fa-undo"></i>
                                    Reset Form
                                </button>
                                <button type="submit" class="btn-modern btn-primary" name="submit">
                                    <i class="fas fa-plus"></i>
                                    Create Category
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Tips Section -->
                    <div class="tips-section">
                        <div class="tips-header">
                            <i class="fas fa-lightbulb"></i>
                            <h3>Tips for Creating Effective Categories</h3>
                        </div>
                        <ul class="tips-list">
                            <li>
                                <i class="fas fa-check"></i>
                                Use broad, industry-standard terms that job seekers will search for
                            </li>
                            <li>
                                <i class="fas fa-check"></i>
                                Avoid overly specific categories that might have very few job listings
                            </li>
                            <li>
                                <i class="fas fa-check"></i>
                                Include relevant keywords in the description to improve searchability
                            </li>
                            <li>
                                <i class="fas fa-check"></i>
                                Consider the local job market and common industries in your area
                            </li>
                            <li>
                                <i class="fas fa-check"></i>
                                Keep category names concise but descriptive (2-3 words maximum)
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>

        <?php include_once('includes/footer.php');?>
    </div>

    <!-- Scripts -->
    <script src="assets/js/core/jquery.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/core/jquery.slimscroll.min.js"></script>
    <script src="assets/js/core/jquery.scrollLock.min.js"></script>
    <script src="assets/js/core/jquery.appear.min.js"></script>
    <script src="assets/js/core/jquery.countTo.min.js"></script>
    <script src="assets/js/core/js.cookie.min.js"></script>
    <script src="assets/js/codebase.js"></script>

    <script>
        // Update character count
        function updateCharCount(inputId, countId, maxLength) {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(countId);
            const currentLength = input.value.length;
            
            counter.textContent = currentLength;
            
            // Change color based on usage
            if (currentLength > maxLength * 0.8) {
                counter.style.color = '#EF4444';
            } else if (currentLength > maxLength * 0.6) {
                counter.style.color = '#F6E05E';
            } else {
                counter.style.color = 'var(--text-light)';
            }
        }

        // Update live preview
        function updatePreview() {
            const categoryName = document.getElementById('category').value || 'Category Name';
            const categoryDesc = document.getElementById('description').value || 'Category description will appear here...';
            
            document.getElementById('previewTitle').textContent = categoryName;
            document.getElementById('previewDescription').textContent = categoryDesc;
        }

        // Reset form
        function resetForm() {
            if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
                document.getElementById('categoryForm').reset();
                updatePreview();
                updateCharCount('category', 'categoryCount', 100);
                updateCharCount('description', 'descriptionCount', 500);
            }
        }

        // Form validation
        document.getElementById('categoryForm').addEventListener('submit', function(e) {
            const category = document.getElementById('category').value.trim();
            const description = document.getElementById('description').value.trim();
            
            if (category.length < 2) {
                e.preventDefault();
                alert('Category name must be at least 2 characters long.');
                document.getElementById('category').focus();
                return false;
            }
            
            if (description.length < 10) {
                e.preventDefault();
                alert('Category description must be at least 10 characters long.');
                document.getElementById('description').focus();
                return false;
            }
            
            // Show loading state
            const submitBtn = document.querySelector('button[name="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';
            submitBtn.disabled = true;
        });

        // Initialize character counters and preview
        document.addEventListener('DOMContentLoaded', function() {
            updateCharCount('category', 'categoryCount', 100);
            updateCharCount('description', 'descriptionCount', 500);
            updatePreview();
        });

        // Auto-save to localStorage (optional)
        function autoSave() {
            const formData = {
                category: document.getElementById('category').value,
                description: document.getElementById('description').value,
                timestamp: Date.now()
            };
            localStorage.setItem('categoryFormDraft', JSON.stringify(formData));
        }

        // Auto-save every 10 seconds
        setInterval(autoSave, 10000);

        // Load draft on page load
        document.addEventListener('DOMContentLoaded', function() {
            const draft = localStorage.getItem('categoryFormDraft');
            if (draft) {
                const data = JSON.parse(draft);
                // Only load if draft is less than 24 hours old
                if (Date.now() - data.timestamp < 24 * 60 * 60 * 1000) {
                    if (confirm('Found a saved draft. Would you like to restore it?')) {
                        document.getElementById('category').value = data.category;
                        document.getElementById('description').value = data.description;
                        updatePreview();
                        updateCharCount('category', 'categoryCount', 100);
                        updateCharCount('description', 'descriptionCount', 500);
                    }
                }
            }
        });

        // Clear draft after successful submission
        window.addEventListener('beforeunload', function() {
            // Clear draft if form was submitted successfully
            if (document.querySelector('.btn-primary').disabled) {
                localStorage.removeItem('categoryFormDraft');
            }
        });
    </script>
</body>
</html>
<?php }  ?>
<!-- Done 4 -->