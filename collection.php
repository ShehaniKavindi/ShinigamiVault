<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collection | Shinigami Vault</title>

    <!-- stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="icon" href="assets/logo.png" />
</head>

<body>

    <!-- header -->
    <?php include "header.php"; ?>

    <!-- collection name n filter -->
    <div class="collection-products-top">
        <div class="collection-products-header col-3">
            <h4>Jujutsu Kaisen Collection</h4>
        </div>
        <div class="collection-products-filter col-2">
            <div class="dropdown-center">
                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Filter
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Price: Low to high</a></li>
                    <li><a class="dropdown-item" href="#">Price: High to low</a></li>
                    <li><a class="dropdown-item" href="#">Newest to Oldest</a></li>
                    <li><a class="dropdown-item" href="#">Oldest to Newest</a></li>
                </ul>
            </div>
            <h6 class="mt-1">In Stock</h6>
        </div>
    </div>

    <!-- product container -->
    <div class="products-container">
        <div class="row row-cols-3 d-flex justify-content-center" style="margin-left: 1rem; margin-right: 1rem;">
            <div class="product-card col">
                <div class="product-image">
                    <img src="assets/products/sample.png" alt="">
                </div>
                <div class="product-details">
                    <h6><a href="#">Jujutsu Kaisen | gojo satoru Oversized Tee</a></h6>
                    <h5>LKR. 2200.00</h5>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="col-10 mt-2">
                        <button class="primary-btn">Add to Bag</button>
                    </div>
                </div>
            </div>
            <div class="product-card col">
                <div class="product-image">
                    <img src="assets/products/sample.png" alt="">
                </div>
                <div class="product-details">
                    <h6><a href="#">Jujutsu Kaisen | gojo satoru Oversized Tee</a></h6>
                    <h5>LKR. 2200.00</h5>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="col-10 mt-2">
                        <button class="primary-btn">Add to Bag</button>
                    </div>
                </div>
            </div>
            <div class="product-card col">
                <div class="product-image">
                    <img src="assets/products/sample.png" alt="">
                </div>
                <div class="product-details">
                    <h6><a href="#">Jujutsu Kaisen | gojo satoru Oversized Tee</a></h6>
                    <h5>LKR. 2200.00</h5>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="col-10 mt-2">
                        <button class="primary-btn">Add to Bag</button>
                    </div>
                </div>
            </div>
            <div class="product-card col">
                <div class="product-image">
                    <img src="assets/products/sample.png" alt="">
                </div>
                <div class="product-details">
                    <h6><a href="#">Jujutsu Kaisen | gojo satoru Oversized Tee</a></h6>
                    <h5>LKR. 2200.00</h5>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="col-10 mt-2">
                        <button class="primary-btn">Add to Bag</button>
                    </div>
                </div>
            </div>
            <div class="product-card col">
                <div class="product-image">
                    <img src="assets/products/sample.png" alt="">
                </div>
                <div class="product-details">
                    <h6><a href="#">Jujutsu Kaisen | gojo satoru Oversized Tee</a></h6>
                    <h5>LKR. 2200.00</h5>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="col-10 mt-2">
                        <button class="primary-btn">Add to Bag</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include "footer.php"; ?>

    <!-- js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>

<style>
    .collection-products-top {
        width: 100%;
        height: 10vh;
        display: flex;
        justify-content: space-between;
        align-items: end;
        padding: 0 50px;
    }
    .collection-products-header h4 {
        font-family: 'header';
        color: var(--black);
    }
    .collection-products-filter {
        display: flex;
        justify-content: space-around;
    }
    .collection-products-filter button{
        border: none;
        background: none;
        font-weight: 700;
    }
    .collection-products-filter a{
        font-size: 0.75rem;
    }
    .collection-products-filter a:hover{
        color: var(--black);
        font-weight: 700;
    }
    .collection-products-filter h6 {
        font-weight: 700;

    }
</style>

