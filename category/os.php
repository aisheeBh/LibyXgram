<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibyXgram | Operating Systems</title>
    <link rel="stylesheet" type="text/css" href="category_styles.css">
</head>

<body>
    <a class="home-button" href="../index.php">Home</a>

    <div class="container">
        <header class="header">
            <h1><a href="os.php"><br>LibyXgram | Operating Systems</a></h1>
            <div class="search-bar">
                <input type="text" id="search-input" placeholder="Search for books...">
            </div>
        </header>

        <nav class="nav">
            <ul class="category-list">
                <?php
                // Fetch categories from Google Sheets and create category links
                $spreadsheetUrl = 'https://docs.google.com/spreadsheets/d/1OBMN1rwkWJfv2g6XVLa44VjaZIfSIPVegBcUkTM7K-E/edit?usp=sharing';
                $csvUrl = '' . preg_replace('/\/edit\?usp=sharing$/', '/export?format=csv', $spreadsheetUrl);
                $categories = array_map('str_getcsv', file($csvUrl));
                foreach ($categories as $category) {
                    $categoryName = $category[0];
                    $categoryLink = $category[1];
                    echo "<li><a href='$categoryLink'>$categoryName</a></li>";
                }
                ?>
            </ul>
        </nav>

        <div id="search-results" class="category-list"></div>

        <footer class="footer">
            <p>&copy; <?php echo date('Y'); ?> LibyXgram. All rights reserved.</p>
        </footer>
    </div>

    <script>
        const searchInput = document.getElementById('search-input');
        const categoryList = document.querySelector('.category-list');
        const searchResults = document.getElementById('search-results');

        searchInput.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            let resultsHtml = '';

            if (searchTerm.length > 0) {
                const filteredCategories = <?php echo json_encode($categories); ?>.filter(function (category) {
                    return category[0].toLowerCase().includes(searchTerm);
                });

                if (filteredCategories.length > 0) {
                    filteredCategories.forEach(function (category) {
                        const categoryName = category[0];
                        const categoryLink = category[1];
                        resultsHtml += `<li><a href='${categoryLink}'>${categoryName}</a></li>`;
                    });
                } else {
                    resultsHtml = '<p class="no-category">No category found.</p>';
                }
            }

            categoryList.style.display = searchTerm.length === 0 ? 'flex' : 'none';
            searchResults.innerHTML = resultsHtml;
        });
    </script>
</body>

</html>
