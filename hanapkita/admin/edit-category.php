<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['jpaid']==0)) {
  header('location:logout.php');
  } else{
    
if(isset($_POST['submit']))
{
$category=$_POST['category'];
$description=$_POST['description'];
$editid=$_GET['editid'];

$sql="update tblcategory set CategoryName=:category,Description=:description where id=:editid";
$query=$dbh->prepare($sql);
$query->bindParam(':category',$category,PDO::PARAM_STR);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->bindParam(':editid',$editid,PDO::PARAM_STR);
$query->execute();
echo '<script>alert("Category Updated successfully .")</script>';
echo "<script>window.location.href ='manage-category.php'</script>";
}

?>
<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Hanap-Kita - Edit Category</title>
    <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #FEF7F0;
            font-family: 'Inter', sans-serif !important;
        }

        .content {
            padding: 2rem !important;
            max-width: 700px;
            margin: 0 auto;
        }

        /* Page Title */
        .page-title {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #FF6B00;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .page-title h1 {
            color: #2D3748;
            font-size: 1.75rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .page-title p {
            color: #718096;
            margin: 0.5rem 0 0 0;
            font-size: 0.9rem;
        }

        /* Back Button */
        .back-button {
            background: rgba(113, 128, 150, 0.1);
            color: #4A5568;
            border: 1px solid rgba(113, 128, 150, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.2s ease;
        }

        .back-button:hover {
            background: rgba(113, 128, 150, 0.2);
            color: #2D3748;
            text-decoration: none;
            transform: translateX(-2px);
        }

        /* Form Container */
        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }

        .form-title {
            color: #2D3748;
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0 0 1.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Form Groups */
        .form-group.row {
            margin-bottom: 1.5rem !important;
        }

        .form-group.row label {
            font-weight: 500 !important;
            color: #2D3748 !important;
            margin-bottom: 0.5rem !important;
            font-size: 0.9rem !important;
        }

        /* Form Controls */
        .form-control {
            padding: 0.75rem 1rem !important;
            border: 2px solid #E2E8F0 !important;
            border-radius: 8px !important;
            font-size: 0.9rem !important;
            transition: all 0.2s ease !important;
            background: white !important;
        }

        .form-control:focus {
            outline: none !important;
            border-color: #FF6B00 !important;
            box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1) !important;
        }

        /* Textarea specific */
        textarea.form-control {
            min-height: 120px !important;
            resize: vertical !important;
        }

        /* Submit Button */
        .btn-alt-success {
            background: #FF6B00 !important;
            border-color: #FF6B00 !important;
            color: white !important;
            padding: 0.75rem 2rem !important;
            border-radius: 8px !important;
            font-weight: 500 !important;
            transition: all 0.2s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
        }

        .btn-alt-success:hover {
            background: #E55B00 !important;
            border-color: #E55B00 !important;
            color: white !important;
            transform: translateY(-1px) !important;
        }

        /* Category Info */
        .category-info {
            background: #F0F8FF;
            border: 1px solid #BEE3F8;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .info-title {
            color: #2B6CB0;
            font-weight: 600;
            margin: 0 0 0.5rem 0;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-text {
            color: #2C5282;
            font-size: 0.8rem;
            margin: 0;
            line-height: 1.4;
        }

        /* Character Counter */
        .char-counter {
            font-size: 0.75rem;
            color: #718096;
            text-align: right;
            margin-top: 0.25rem;
        }

        .char-counter.warning {
            color: #ED8936;
        }

        .char-counter.danger {
            color: #F56565;
        }

        /* Submit Section */
        .submit-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #E2E8F0;
        }

        .cancel-btn {
            background: rgba(113, 128, 150, 0.1);
            color: #4A5568;
            border: 1px solid rgba(113, 128, 150, 0.2);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .cancel-btn:hover {
            background: rgba(113, 128, 150, 0.2);
            color: #2D3748;
            text-decoration: none;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .content {
                padding: 1rem !important;
            }
            
            .page-title,
            .form-container {
                padding: 1.5rem;
            }
            
            .page-title h1 {
                font-size: 1.5rem;
            }

            .submit-section {
                flex-direction: column;
                gap: 1rem;
            }

            .submit-section .btn-alt-success {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div id="page-container" class="sidebar-o sidebar-inverse side-scroll page-header-fixed main-content-narrow">
        <?php include_once('includes/sidebar.php');?>
        <?php include_once('includes/header.php');?>

        <main id="main-container">
            <div class="content">
                <!-- Back Button -->
                <a href="manage-category.php" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                    Back to Manage Categories
                </a>

                <!-- Page Title -->
                <div class="page-title">
                    <h1>
                        <i class="fas fa-edit" style="color: #FF6B00;"></i>
                        Edit Category
                    </h1>
                    <p>Update job category information and settings</p>
                </div>

                <!-- Category Info -->
                <div class="category-info">
                    <div class="info-title">
                        <i class="fas fa-info-circle"></i>
                        Category Editing Guidelines
                    </div>
                    <p class="info-text">
                        Make sure the category name is clear and descriptive. The description should explain what types of jobs fall under this category to help both employers and job seekers.
                    </p>
                </div>

                <!-- Form Container -->
                <div class="form-container">
                    <h2 class="form-title">
                        <i class="fas fa-folder-open" style="color: #FF6B00;"></i>
                        Category Details
                    </h2>

                    <form method="post">
                        <?php
                        $editid=$_GET['editid'];
                        $sql="SELECT * from tblcategory where id=:editid";
                        $query = $dbh -> prepare($sql);
                        $query->bindParam(':editid',$editid,PDO::PARAM_STR);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                            foreach($results as $row)
                            {               
                        ?>

                        <!-- Category Name -->
                        <div class="form-group row">
                            <label class="col-12" for="category">Category Name:</label>
                            <div class="col-12">
                                <input type="text" 
                                       class="form-control" 
                                       value="<?php echo htmlentities($row->CategoryName);?>" 
                                       name="category" 
                                       id="category"
                                       required="true"
                                       maxlength="100"
                                       placeholder="Enter category name (e.g., Construction, Healthcare)">
                                <div class="char-counter" id="category-counter">
                                    <span id="category-count">0</span>/100 characters
                                </div>
                            </div>
                        </div>

                        <!-- Category Description -->
                        <div class="form-group row">
                            <label class="col-12" for="description">Category Description:</label>
                            <div class="col-12">
                                <textarea class="form-control" 
                                          rows="5" 
                                          name="description" 
                                          id="description"
                                          required="true"
                                          maxlength="500"
                                          placeholder="Provide a detailed description of this job category, including what types of jobs and skills are included..."><?php echo htmlentities($row->Description);?></textarea>
                                <div class="char-counter" id="description-counter">
                                    <span id="description-count">0</span>/500 characters
                                </div>
                            </div>
                        </div>

                        <?php $cnt=$cnt+1;}} ?> 

                        <!-- Submit Section -->
                        <div class="submit-section">
                            <a href="manage-category.php" class="cancel-btn">
                                <i class="fas fa-times"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-alt-success" name="submit">
                                <i class="fa fa-save"></i> Update Category
                            </button>
                        </div>
                    </form>
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
        // Character counter functionality
        function updateCharCounter(inputId, counterId, maxLength) {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(counterId);
            const countSpan = document.getElementById(inputId + '-count');
            
            function updateCount() {
                const currentLength = input.value.length;
                countSpan.textContent = currentLength;
                
                // Update counter styling based on character count
                counter.className = 'char-counter';
                if (currentLength > maxLength * 0.8) {
                    counter.className += ' warning';
                }
                if (currentLength > maxLength * 0.95) {
                    counter.className += ' danger';
                }
            }
            
            // Update on input
            input.addEventListener('input', updateCount);
            
            // Initial update
            updateCount();
        }

        // Initialize character counters and other features
        document.addEventListener('DOMContentLoaded', function() {
            // Focus on first input
            document.getElementById('category').focus();
            
            // Initialize character counters
            updateCharCounter('category', 'category-counter', 100);
            updateCharCounter('description', 'description-counter', 500);
            
            // Auto-resize textarea
            const textarea = document.getElementById('description');
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
            
            // Initial resize
            textarea.style.height = textarea.scrollHeight + 'px';
            
            // Form validation enhancement
            document.querySelector('form').addEventListener('submit', function(e) {
                const category = document.getElementById('category').value.trim();
                const description = document.getElementById('description').value.trim();
                
                if (!category) {
                    e.preventDefault();
                    alert('Please enter a category name.');
                    document.getElementById('category').focus();
                    return false;
                }
                
                if (!description) {
                    e.preventDefault();
                    alert('Please enter a category description.');
                    document.getElementById('description').focus();
                    return false;
                }
                
                if (category.length < 3) {
                    e.preventDefault();
                    alert('Category name must be at least 3 characters long.');
                    document.getElementById('category').focus();
                    return false;
                }
                
                if (description.length < 10) {
                    e.preventDefault();
                    alert('Category description must be at least 10 characters long.');
                    document.getElementById('description').focus();
                    return false;
                }
                
                return true;
            });
        });
    </script>
</body>
</html>
<?php }  ?>
<!--Draft 13 -->