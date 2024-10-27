<?php
include 'dbconnect.php'; // Include your database connection file

// Set default values for pagination
$defaultLimit = 5; // Default listings per page if not specified
$limit = isset($_GET['ads_per_page']) ? (int)$_GET['ads_per_page'] : $defaultLimit;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Apply filters
$whereClauses = [];
if (!empty($_GET['city'])) $whereClauses[] = "address_city = '" . mysqli_real_escape_string($connect, $_GET['city']) . "'";
if (!empty($_GET['type'])) $whereClauses[] = "type = '" . mysqli_real_escape_string($connect, $_GET['type']) . "'";
if (!empty($_GET['min_price'])) $whereClauses[] = "price >= " . (int)$_GET['min_price'];
if (!empty($_GET['max_price'])) $whereClauses[] = "price <= " . (int)$_GET['max_price'];

// Handle search query
if (!empty($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($connect, $_GET['search']);
    $whereClauses[] = "(title LIKE '%$searchTerm%' OR description LIKE '%$searchTerm%' OR address_city LIKE '%$searchTerm%' OR type LIKE '%$searchTerm%')";
}

$whereSQL = $whereClauses ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

// Apply sorting by price if selected
$sortOrder = '';
if (!empty($_GET['sort_price'])) {
    $sortOrder = $_GET['sort_price'] == 'asc' ? 'ASC' : 'DESC';
}

// Main SQL query with sorting and pagination
$sql = "SELECT * FROM listings $whereSQL";
if ($sortOrder) {
    $sql .= " ORDER BY price $sortOrder";
}
$sql .= " LIMIT $limit OFFSET $offset";

$result = mysqli_query($connect, $sql);

if ($result === false) {
    echo "Error: " . mysqli_error($connect);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay Finder - House Rentals</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
</head>
<body>
    <?php include "header-1.php"; ?>

    <div class="filters">
        <form method="GET" action="index.php">
            <div class="filter">
                <div class="filter-section">
                    <label>Location:</label>
                    <select name="city">
                        <option value="">Select</option>
                        <option value="Colombo">Colombo</option>
                        <option value="Kandy">Kandy</option>
                        <!-- Add more cities as needed -->
                    </select>
                </div>
                <div class="filter-section">
                    <label>Type:</label>
                    <select name="type">
                        <option value="">Select</option>
                        <option value="Room">Room</option>
                        <option value="Apartment">Apartment</option>
                        <option value="House">House</option>
                    </select>
                </div>
                <div class="filter-section">
                <label>Price:</label>
                    <input type="number" name="min_price" placeholder="Min">
                    <input type="number" name="max_price" placeholder="Max">
                </div>
                <div class="filter-section">
                    <button type="submit">Apply Filters</button>
                </div>    
            </div>
            
            <div class="filter">
                <div class="filter-section">
                    <label>Ads per page:</label>
                    <select name="ads_per_page" onchange="this.form.submit()">
                        <option value="5" <?php echo ($limit == 5) ? 'selected' : ''; ?>>5</option>
                        <option value="10" <?php echo ($limit == 10) ? 'selected' : ''; ?>>10</option>
                        <option value="15" <?php echo ($limit == 15) ? 'selected' : ''; ?>>15</option>
                        <option value="20" <?php echo ($limit == 20) ? 'selected' : ''; ?>>20</option>
                    </select>
                </div>  
                <div class="filter-section">
                <label>Sort by Price:</label>
                    <select name="sort_price" onchange="this.form.submit()">
                        <option value="">Select</option>
                        <option value="asc" <?php echo (isset($_GET['sort_price']) && $_GET['sort_price'] == 'asc') ? 'selected' : ''; ?>>Low to High</option>
                        <option value="desc" <?php echo (isset($_GET['sort_price']) && $_GET['sort_price'] == 'desc') ? 'selected' : ''; ?>>High to Low</option>
                    </select>
                </div>               
            </div>
        </form>
    </div>

    <div class="listings">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="listing">
                    <img src="images/<?php echo $row['house_ID']; ?>.jpg" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p>Features: <?php echo htmlspecialchars($row['description']); ?></p>
                    <p>Location: <?php echo htmlspecialchars($row['address_city']); ?></p>
                    <p>Price: Rs <?php echo number_format($row['price']); ?> / Monthly</p>
                    <p>Rating: <?php echo str_repeat("⭐", $row['rating']); ?></p>
                    <button onclick="window.location.href='moredetails.php?house_ID=<?php echo $row['house_ID']; ?>'">More Info</button>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No listings found.</p>
        <?php endif; ?>
    </div>

    <div class="pagination">
        <?php
        $sqlTotal = "SELECT COUNT(*) AS total FROM listings $whereSQL";
        $totalResult = mysqli_query($connect, $sqlTotal);
        if ($totalResult) {
            $totalListings = mysqli_fetch_assoc($totalResult)['total'];
            $totalPages = ceil($totalListings / $limit);
            if ($page > 1) {
                echo "<a href='index.php?page=" . ($page - 1) . "&ads_per_page=$limit&city=" . urlencode($_GET['city'] ?? '') .
                     "&type=" . urlencode($_GET['type'] ?? '') . 
                     "&min_price=" . urlencode($_GET['min_price'] ?? '') . 
                     "&max_price=" . urlencode($_GET['max_price'] ?? '') .
                     "&sort_price=" . urlencode($_GET['sort_price'] ?? '') . "' class='pagination-btn'>Previous</a>";
            }
            for ($i = 1; $i <= $totalPages; $i++) {
                $activeClass = ($i == $page) ? 'active' : '';
                echo "<a href='index.php?page=$i&ads_per_page=$limit&city=" . urlencode($_GET['city'] ?? '') .
                     "&type=" . urlencode($_GET['type'] ?? '') . 
                     "&min_price=" . urlencode($_GET['min_price'] ?? '') . 
                     "&max_price=" . urlencode($_GET['max_price'] ?? '') .
                     "&sort_price=" . urlencode($_GET['sort_price'] ?? '') . "' class='pagination-number $activeClass'>" . $i . "</a> ";
            }
            if ($page < $totalPages) {
                echo "<a href='index.php?page=" . ($page + 1) . "&ads_per_page=$limit&city=" . urlencode($_GET['city'] ?? '') .
                     "&type=" . urlencode($_GET['type'] ?? '') . 
                     "&min_price=" . urlencode($_GET['min_price'] ?? '') . 
                     "&max_price=" . urlencode($_GET['max_price'] ?? '') .
                     "&sort_price=" . urlencode($_GET['sort_price'] ?? '') . "' class='pagination-btn'>Next</a>";
            }
        } else {
            echo "<p>Error calculating total pages: " . mysqli_error($connect) . "</p>";
        }
        mysqli_close($connect);
        ?>
    </div>
    <?php

        include "footer.php";

    ?>

</body>
</html>
