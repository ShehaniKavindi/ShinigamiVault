<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shinigami Vault 
        <?php if(isset($_SESSION['customer_id'])) { ?>
             | <?php echo $_SESSION['customer_name']; ?>
        <?php }?>
    </title>

    <!-- stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="icon" href="assets/logo.png" />
</head>

<body>

    <!-- Header -->
    <?php 
    include "header.php"; 
    include "connection.php" 
    ?>


    <!-- carousel -->
    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active d-flex justify-content-around align-items-center"
                data-bs-interval="12000">
                <div class="d-flex justify-content-around align-items-center">
                    <div class="col-7" style="padding: 0 20px;">
                        <h1>New Ryomen Sukuna oversized tees out now !!</h1>
                        <h4>Grab your Tee before it's late</h4>
                        <div class="mt-lg-5 d-flex justify-content-center">
                            <div class="col-4">
                                <button class="red-btn">View Collection</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="carousel-item-image">
                            <img src="assets/carousel-1.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="12000">
                <div class="d-flex justify-content-around align-items-center mt-5">
                    <div class="col-4">
                        <div class="carousel-item-image">
                            <img src="assets/carousel-2.png" alt="">
                        </div>
                    </div>
                    <div class="col-7" style="padding: 0 20px;">
                        <h1>JUJUTSU KAISEN <br>
                            x <br>
                            streetware oversized tees</h1>
                        <h4>Fashion Beyond the Ordinary</h4>
                        <div class="mt-lg-5 d-flex justify-content-center">
                            <div class="col-4">
                                <button class="red-btn">View Collection</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- perk cards -->
    <div class="perks-row">

        <div class="perk-card">
            <div class="perk-icon"><i class="bi bi-truck"></i></div>
            <div>
                <p class="perk-title">Free Delivery</p>
                <p class="perk-sub">On orders over lkr 5,000</p>
            </div>
        </div>

        <div class="perk-card">
            <div class="perk-icon"><i class="bi bi-cash-coin"></i></div>
            <div>
                <p class="perk-title">Cash on Delivery</p>
                <p class="perk-sub">Pay when it arrives</p>
            </div>
        </div>

        <div class="perk-card">
            <div class="perk-icon"><i class="bi bi-arrow-counterclockwise"></i></div>
            <div>
                <p class="perk-title">Easy returns</p>
                <p class="perk-sub">Hassle-free within 7 days</p>
            </div>
        </div>

        <div class="perk-card">
            <div class="perk-icon"><i class="bi bi-globe"></i></div>
            <div>
                <p class="perk-title">Island-wide Shipping</p>
                <p class="perk-sub">Delivered across Sri Lanka</p>
            </div>
        </div>

        <div class="perk-card">
            <div class="perk-icon"><i class="bi bi-shield-check"></i></div>
            <div>
                <p class="perk-title">Secure Checkout</p>
                <p class="perk-sub">Safe & encrypted payments</p>
            </div>
        </div>

    </div>

    <!-- newly arrivals -->
    <div class="new-arrivals-section">
        <h2>⮜----⪻ &nbsp; Newly Arrivals &nbsp; ⪼----⮞</h2>
        <!-- product container -->
        <div class="products-container">
            <div class="row row-cols-3 d-flex justify-content-center" style="margin-left: 1rem; margin-right: 1rem;">
                <?php 
                    $newly_arrivals_rs = Database::search("
                        SELECT p.id, p.title, MIN(pi.path) as path, MIN(i.unit_price) as unit_price, col.name as collection_name
                        FROM product p
                        JOIN product_images pi ON pi.product_id = p.id
                        JOIN inventory i ON i.product_id = p.id
                        JOIN collection col ON col.id = p.collection_id
                        GROUP BY p.id, p.title, col.name
                        ORDER BY p.id DESC
                        LIMIT 3
                    ");

                    while($newly_arrivals_data = $newly_arrivals_rs->fetch_assoc()) { ?>
                        <div class="product-card col">
                            <div class="product-image">
                                <img src="<?php echo $newly_arrivals_data ['path']; ?>" alt="">
                            </div>
                            <div class="product-details">
                                <h6><a href="singleProductView.php?id=<?php echo $newly_arrivals_data ['id']; ?>">
                                    <?php echo $newly_arrivals_data ['collection_name'] . '&nbsp; | &nbsp;' . $newly_arrivals_data ['title']; ?>
                                </a></h6>
                                <h5>LKR. <?php echo number_format($newly_arrivals_data ['unit_price'], 2); ?></h5>
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
    </div>



    <!-- hero section -->
    <div class="hero-section">
        <p>Anime-inspired streetwear, dropped fresh from Sri Lanka.</p>
        <h1>Built For The Anime Fandom</h1>
        <div class="hero-section-stripe">
            <ul>
                <h6>what's in shinigami vault</h6>
                <li>12 collections</li>
                <li>38+ Tees in store</li>
                <li>14 Hoodies & counting</li>
                <li>New collections dropping every Friday</li>
            </ul>
            <div class="hero-image">
                <img src="assets/hero.png" alt="">
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
    /* carousel */
    .carousel {
        width: 100%;
        height: fit-content;
    }

    .carousel-item {
        height: 90vh;
        width: 100%;
        overflow-y: hidden;
        background-color: var(--hero-bg);
    }

    .carousel-item h1 {
        font-family: 'header';
        font-size: 3.4rem;
        text-align: center;
        color: var(--black);
    }

    .carousel-item h4 {
        margin-top: 1.7rem;
        text-align: center;

    }

    .carousel-item-image {
        width: 100%;
        max-height: 35rem;
    }

    .carousel-item-image img {
        width: 100%;
        height: auto;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        height: 30px;
        width: 30px;
        padding: 10px;
        border-radius: 50%;
    }

    .carousel-control-prev-icon:hover,
    .carousel-control-next-icon:hover {
        background-color: var(--red);
    }

    .perks-row {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 280px));
        justify-content: center;
        gap: 12px;
        padding: 1rem 0;
    }

    .perk-card {
        background: var(--white);
        border: 0.5px solid rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 14px 12px;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 12px;
        position: relative;
        overflow: hidden;
        transition: border-color 0.2s;
    }

    .perk-card:hover {
        border-color: var(--red);
    }

    .perk-card::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--red);
        transform: scaleX(0);
        transition: transform 0.25s ease;
    }

    .perk-card:hover::before {
        transform: scaleX(1);
    }

    .perk-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #fff0f2;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 17px;
        color: var(--red);
    }

    .perk-title {
        font-size: 15px;
        color: #575757;
        letter-spacing: 0.05em;
        line-height: 1.1;
        margin: 0 0 2px;
        font-weight: 600;
    }

    .perk-sub {
        font-size: 11px;
        color: #888888;
        margin: 0;
        line-height: 1.4;
    }

    /* newly arrivals */
    .new-arrivals-section {
        width: 100%;
        min-height: 60vh;
    }

    .new-arrivals-section h2 {
        margin-top: 2rem;
        text-align: center;
        font-family: 'header';
    }

    /* hero section */
    .hero-section {
        width: 100%;
        min-height: 70vh;
        background-color: var(--white);
        padding: 35px 0;
    }

    .hero-section p {
        color: rgb(191, 193, 193);
        letter-spacing: 2px;
        text-align: center;
    }

    .hero-section h1 {
        font-family: 'header';
        color: #3c3535;
        text-align: center;
        font-size: 5rem;
    }

    .hero-section-stripe {
        width: 100%;
        height: 40vh;
        background-color: var(--hero-bg);
        padding: 20px 30px;
        margin-top: 5rem;
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin-bottom: 3rem;
    }

    .hero-section-stripe h6 {
        color: #fa8484;
        letter-spacing: 2px;
        margin-bottom: 1rem;
    }

    .hero-section-stripe li {
        font-family: 'header';
        line-height: 2.6rem;
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .hero-image {
        max-width: 550px;
        height: auto;
    }

    .hero-image img {
        width: 100%;
        height: auto;
    }
</style>