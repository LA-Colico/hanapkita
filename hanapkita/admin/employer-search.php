<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['jpaid']==0)) {
  header('location:logout.php');
  } else{

  ?>
<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Hanap-Kita - Employer Search</title>
    <link rel="stylesheet" href="assets/js/plugins/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #FEF7F0;
            font-family: 'Inter', sans-serif !important;
        }

        .content {
            padding: 1.5rem !important;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Simple Header */
        .page-title {
            margin-top: 1.5rem;
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
        }

        .page-title p {
            color: #718096;
            margin: 0.5rem 0 0 0;
            font-size: 0.9rem;
        }

        /* Simple Search Box */
        .search-container {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .search-label {
            font-weight: 500;
            color: #2D3748;
            margin-bottom: 0.75rem;
            display: block;
        }

        .search-wrapper {
            position: relative;
            display: flex;
            gap: 0.75rem;
        }

        .search-input {
            flex: 1;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 2px solid #E2E8F0;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }

        .search-input:focus {
            outline: none;
            border-color: #FF6B00;
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #A0AEC0;
        }

        .search-btn {
            background: #FF6B00;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .search-btn:hover {
            background: #E55B00;
        }

        .search-btn:disabled {
            background: #CBD5E0;
            cursor: not-allowed;
        }

        /* Loading indicator */
        .loading {
            text-align: center;
            padding: 1rem;
            color: #718096;
            font-style: italic;
        }

        /* Results */
        .results-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .results-header {
            background: #F7FAFC;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #E2E8F0;
        }

        .results-title {
            color: #2D3748;
            font-weight: 600;
            margin: 0;
            font-size: 1.1rem;
        }

        .keyword-highlight {
            background: #FFF3E0;
            padding: 0.5rem 1rem;
            margin: 1rem 1.5rem;
            border-radius: 6px;
            border-left: 3px solid #FF6B00;
            font-size: 0.9rem;
        }

        /* Simple Table */
        .simple-table {
            width: 100%;
            border-collapse: collapse;
        }

        .simple-table th {
            background: #F7FAFC;
            padding: 0.75rem;
            text-align: left;
            font-weight: 600;
            color: #2D3748;
            font-size: 0.85rem;
            border-bottom: 1px solid #E2E8F0;
        }

        .simple-table td {
            padding: 0.75rem;
            border-bottom: 1px solid #F1F5F9;
            font-size: 0.85rem;
        }

        .simple-table tr:hover {
            background: #FEFEFE;
        }

        /* Status badges */
        .status-active {
            background: #F0FFF4;
            color: #38A169;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-inactive {
            background: #F7FAFC;
            color: #718096;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Simple button */
        .view-btn {
            background: #FF6B00;
            color: white;
            padding: 0.375rem 0.75rem;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .view-btn:hover {
            background: #E55B00;
            color: white;
            text-decoration: none;
        }

        /* Company logo */
        .company-logo {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid #E2E8F0;
        }

        .company-initials {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: #FF6B00;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #718096;
        }

        .empty-state i {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #CBD5E0;
        }

        /* Search suggestions */
        .search-suggestions {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 6px;
            padding: 0.75rem;
            margin-top: 0.5rem;
            font-size: 0.8rem;
            color: #4A5568;
        }

        .search-suggestions strong {
            color: #2D3748;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .content {
                padding: 1rem !important;
            }
            
            .search-wrapper {
                flex-direction: column;
            }
            
            .simple-table {
                font-size: 0.8rem;
            }
            
            .simple-table th,
            .simple-table td {
                padding: 0.5rem 0.25rem;
            }
            
            .company-logo,
            .company-initials {
                width: 24px;
                height: 24px;
                font-size: 0.6rem;
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
                <!-- Page Title -->
                <div class="page-title">
                    <h1><i class="fas fa-search" style="color: #FF6B00; margin-right: 0.5rem;"></i>Employer Search</h1>
                    <p>Search employers by company name, email, or contact person</p>
                </div>

                <!-- Search Form -->
                <div class="search-container">
                    <form id="basic-form" method="post">
                        <label class="search-label">Search Employers</label>
                        <div class="search-wrapper">
                            <div style="position: relative; flex: 1;">
                                <i class="fas fa-search search-icon"></i>
                                <input id="searchdata" 
                                       type="text" 
                                       name="searchdata" 
                                       class="search-input" 
                                       placeholder="Type company name, email, or contact person..."
                                       autocomplete="off"
                                       <?php if(isset($_POST['searchdata'])) echo 'value="'.htmlentities($_POST['searchdata']).'"'; ?>>
                            </div>
                            <button type="submit" class="search-btn" name="search" id="submit">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </form>
                    
                    <div class="search-suggestions">
                        <strong>Search tips:</strong> You can search by company name (e.g., "ABC Company"), 
                        email address (e.g., "contact@company.com"), or contact person name (e.g., "John Doe").
                    </div>
                    
                    <!-- Auto-search indicator -->
                    <div id="loading" class="loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Searching...
                    </div>
                </div>

                <!-- Search Results -->
                <div id="results-section">
                    <?php
                    if(isset($_POST['search']) || isset($_GET['auto_search']))
                    { 
                        $sdata = isset($_POST['searchdata']) ? $_POST['searchdata'] : $_GET['search_term'];
                        if(!empty($sdata)) {
                    ?>
                    
                    <div class="results-container">
                        <div class="results-header">
                            <h3 class="results-title">Search Results</h3>
                        </div>
                        
                        <div class="keyword-highlight">
                            Results for: <strong>"<?php echo htmlentities($sdata); ?>"</strong>
                        </div>

                        <div style="overflow-x: auto;">
                            <table class="simple-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Logo</th>
                                        <th>Company Name</th>
                                        <th>Contact Person</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Registration Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql="SELECT * from tblemployers where CompnayName like '$sdata%' OR EmpEmail like '$sdata%' OR ConcernPerson like '$sdata%'";
                                    $query = $dbh -> prepare($sql);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);

                                    $cnt=1;
                                    if($query->rowCount() > 0)
                                    {
                                        foreach($results as $row)
                                        {               
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt);?></td>
                                        <td>
                                            <?php if (!empty($row->CompnayLogo)): ?>
                                                <img src="../employers/employerslogo/<?php echo $row->CompnayLogo; ?>" 
                                                     class="company-logo" 
                                                     alt="Logo"
                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                                                <div class="company-initials" style="display: none;">
                                                    <?php echo strtoupper(substr($row->CompnayName, 0, 2)); ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="company-initials">
                                                    <?php echo strtoupper(substr($row->CompnayName, 0, 2)); ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td style="font-weight: 500; color: #2D3748;"><?php echo htmlentities($row->CompnayName);?></td>
                                        <td style="color: #4A5568;"><?php echo htmlentities($row->ConcernPerson);?></td>
                                        <td style="color: #3182CE;"><?php echo htmlentities($row->EmpEmail);?></td>
                                        <td>
                                            <?php if($row->Is_Active=='1'){ ?>
                                                <span class="status-active">Active</span>
                                            <?php } else { ?>
                                                <span class="status-inactive">Inactive</span>
                                            <?php } ?>
                                        </td>
                                        <td style="color: #718096; font-size: 0.8rem;">
                                            <?php echo date('M j, Y', strtotime($row->RegDtae));?>
                                        </td>
                                        <td>
                                            <a href="view-employer-details.php?viewid=<?php echo htmlentities($row->id);?>" 
                                               class="view-btn" 
                                               target="_blank">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    <?php 
                                        $cnt=$cnt+1;
                                        } 
                                    } else { 
                                    ?>
                                    <tr>
                                        <td colspan="8">
                                            <div class="empty-state">
                                                <i class="fas fa-building"></i>
                                                <h4 style="color: #2D3748; margin: 0.5rem 0;">No Results Found</h4>
                                                <p style="margin: 0;">No employers found matching "<strong><?php echo htmlentities($sdata); ?></strong>"</p>
                                                <p style="margin: 0.5rem 0 0 0; font-size: 0.8rem;">Try searching with different keywords or check the spelling.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php 
                        }
                    } 
                    ?>
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
        let searchTimeout;
        const searchInput = document.getElementById('searchdata');
        const loadingDiv = document.getElementById('loading');
        const submitBtn = document.getElementById('submit');

        // Auto-search functionality
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim();
            
            // Clear previous timeout
            clearTimeout(searchTimeout);
            
            // Hide loading if empty
            if (searchTerm.length === 0) {
                loadingDiv.style.display = 'none';
                return;
            }
            
            // Show loading after user stops typing for 1 second
            searchTimeout = setTimeout(function() {
                if (searchTerm.length >= 2) { // Minimum 2 characters for employer search
                    performAutoSearch(searchTerm);
                }
            }, 1000);
        });

        function performAutoSearch(searchTerm) {
            loadingDiv.style.display = 'block';
            
            // Create a form data object
            const formData = new FormData();
            formData.append('searchdata', searchTerm);
            formData.append('search', '1');
            
            // Send AJAX request
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Extract results section from response
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, 'text/html');
                const newResults = doc.querySelector('#results-section');
                
                if (newResults) {
                    document.getElementById('results-section').innerHTML = newResults.innerHTML;
                }
                
                loadingDiv.style.display = 'none';
            })
            .catch(error => {
                console.error('Search error:', error);
                loadingDiv.style.display = 'none';
            });
        }

        // Manual search form submission
        document.getElementById('basic-form').addEventListener('submit', function(e) {
            const searchData = searchInput.value.trim();
            
            if (!searchData) {
                e.preventDefault();
                alert('Please enter a search term.');
                return false;
            }
            
            if (searchData.length < 2) {
                e.preventDefault();
                alert('Please enter at least 2 characters to search.');
                return false;
            }
            
            // Show loading
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
            submitBtn.disabled = true;
        });

        // Focus on search input when page loads
        document.addEventListener('DOMContentLoaded', function() {
            searchInput.focus();
        });

        // Add some helpful keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + K to focus search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
            }
        });
    </script>
</body>
</html>
<?php }  ?>

<!-- Done 17 -->