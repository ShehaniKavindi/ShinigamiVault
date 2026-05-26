<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shinigami Vault</title>

    <!-- stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="icon" href="assets/logo.png" />
</head>

<body>

    <!-- header -->
    <?php 
    include "connection.php"; 
    include "header.php"; 
    
    
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'newest';
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $order = match($filter) {
        'price_asc'  => 'MIN(i.unit_price) ASC',
        'price_desc' => 'MIN(i.unit_price) DESC',
        'oldest'     => 'p.id ASC',
        default      => 'p.id DESC'
    };

    $search_condition = '';
    if($search != '') {
        $search_condition = "AND (p.title LIKE '%$search%' OR col.name LIKE '%$search%')";
    }

    $all_products_rs = Database::search("
        SELECT p.id, p.title, MIN(pi.path) as path, MIN(i.unit_price) as unit_price, col.name as collection_name
        FROM product p
        JOIN product_images pi ON pi.product_id = p.id
        JOIN inventory i ON i.product_id = p.id
        JOIN collection col ON col.id = p.collection_id
        WHERE 1=1 $search_condition
        GROUP BY p.id, p.title, col.name
        ORDER BY $order
    ");

    $all_products_num = $all_products_rs->num_rows;
    ?>


    <!-- search bar n filter -->
    <div class="all-products-top">
        <div class="all-products-header col-2">
            <h4>All Products</h4>
        </div>
        <div class="all-products-search-bar col-6">
            <div class="search-wrapper">
                <input type="text" id="search" name="search" placeholder="search your Tee" 
                    value="<?php echo htmlspecialchars($search); ?>"/>
                <button onclick="doSearch()" type="button">
                    <i class="bi bi-search search-btn"></i>
                </button>
            </div>
        </div>
        <div class="all-products-filter col-2">
            <div class="dropdown-center">
                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Filter
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="?filter=price_asc">Price: Low to high</a></li>
                    <li><a class="dropdown-item" href="?filter=price_desc">Price: High to low</a></li>
                    <li><a class="dropdown-item" href="?filter=newest">Newest to Oldest</a></li>
                    <li><a class="dropdown-item" href="?filter=oldest">Oldest to Newest</a></li>
                </ul>
            </div>
            <h6 class="mt-1">In Stock<span> (<?php echo $all_products_num; ?>)</span></h6>
        </div>
    </div>

    

    <!-- product container -->
    <div class="products-container">
        <div class="row row-cols-3 d-flex justify-content-center" style="margin-left: 1rem; margin-right: 1rem;">
            
        <?php
        
        for($i = 0; $i < $all_products_num; $i++) { 
            $all_products_data = $all_products_rs->fetch_assoc(); ?>
            <div class="product-card col">
                <div class="product-image">
                    <img src="<?php echo $all_products_data['path']; ?>" alt="">
                </div>
                <div class="product-details">
                    <h6><a href="singleProductView.php?id=<?php echo $all_products_data['id']; ?>">
                        <?php echo $all_products_data['collection_name'] . ' | ' . $all_products_data['title']; ?>
                    </a></h6>
                    <h5>LKR. <?php echo number_format($all_products_data['unit_price'], 2); ?></h5>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="col-10 mt-2">
                        <button class="primary-btn">Add to Bag</button>
                    </div>
                </div>
            </div>
        <?php } ?>
        
        </div>
    </div>

    <!-- footer -->
    <?php include "footer.php"; ?>

    <!-- js -->
     <script>
        function doSearch() {
            var search = document.getElementById("search").value;
            var filter = "<?php echo $filter; ?>";
            window.location.href = "?search=" + search + "&filter=" + filter;
        }
        document.getElementById("search").addEventListener("keypress", function(e) {
            if(e.key === "Enter") {
                doSearch();
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>

<style>
    .all-products-top {
        width: 100%;
        height: 10vh;
        display: flex;
        justify-content: space-around;
        align-items: end;
        padding: 0 20px;
    }
    .all-products-header h4 {
        font-family: 'header';
        color: var(--black);
    }
    .all-products-filter {
        display: flex;
        justify-content: space-around;
    }
    .all-products-filter button{
        border: none;
        background: none;
        font-weight: 700;
    }
    .all-products-filter a{
        font-size: 0.75rem;
    }
    .all-products-filter a:hover{
        color: var(--black);
        font-weight: 700;
    }
    .all-products-filter h6 {
        font-weight: 700;

    }
</style>

