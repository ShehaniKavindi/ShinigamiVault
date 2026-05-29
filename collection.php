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
    <?php include "connection.php"; ?>
    <?php include "header.php"; ?>

    <div class="collection-container">
        <div class="hero">
            <p class="hero-label">shinigami vault</p>
            <h1 class="hero-title">collec<span>tions</span></h1>
            <p class="hero-sub">buy yours today</p>
        </div>

        <div class="collections-grid">

            <?php
            $collection_rs = Database::search("SELECT 
                col.id,
                col.name,
                COUNT(p.id) AS product_count

            FROM collection col

            LEFT JOIN product p ON col.id = p.collection_id

            GROUP BY col.id;");

            $collection_num = $collection_rs->num_rows;

            for ($c=0; $c < $collection_num; $c++) { 
                $collection_data = $collection_rs->fetch_assoc();
                $c_id = $collection_data["id"];
                ?>
                <div class="col-card" >
                    <div class="col-bg">
                        <div class="col-placeholder">
                            <?php 
                                $images_rs = Database::search("SELECT 
                                    p.id AS product_id,
                                    p.title,
                                    pi.path AS image
                                FROM product p

                                JOIN product_images pi ON p.id = pi.product_id

                                WHERE p.collection_id = $c_id;");

                                $images_num = $images_rs->num_rows;

                                for ($i=0; $i < $images_num; $i++) { 
                                    $images_data = $images_rs->fetch_assoc();
                                    ?>
                                    <div class="mini-product" style="background:#e8e8e8;">
                                        <img src="<?php echo $images_data['image']; ?>" alt="">
                                    </div>
                                    <?php
                                }
                            ?>
                            
                        </div>
                    </div>
                    <div class="col-overlay">
                        <p class="col-badge">anime collection</p>
                        <h2 class="col-name"><?php echo $collection_data["name"]; ?></h2>
                        <p class="col-count"><?php echo $collection_data["product_count"]; ?> pieces</p>
                        <a href="search.php?search=<?php echo $collection_data['name']; ?>">
                            <button class="col-btn" >explore →</button>
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>

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

    .collection-container {
        background: #f8f8f8;
        min-height: 100vh;
    }

    .hero {
        background: #fff;
        padding: 60px 40px 40px;
        text-align: center;
        border-bottom: 1px solid #e8e8e8;
    }

    .hero-label {
        font-size: 11px;
        letter-spacing: 0.3em;
        color: #aaa;
        margin-bottom: 12px;
    }

    .hero-title {
        font-size: 52px;
        font-weight: 900;
        color: #111;
        letter-spacing: 0.08em;
        line-height: 1;
        margin-bottom: 10px;
    }

    .hero-title span {
        color: #e03535;
    }

    .hero-sub {
        font-size: 12px;
        color: #bbb;
        letter-spacing: 0.15em;
    }

    .collections-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2px;
        padding: 2px;
        background: #e8e8e8;
    }

    .col-card {
        position: relative;
        height: 340px;
        overflow: hidden;
        cursor: pointer;
        background: #f0f0f0;
    }

    .col-card.wide {
        grid-column: span 2;
        height: 260px;
    }

    .col-bg {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .col-placeholder {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 6px;
        padding: 20px;
        width: 100%;
        height: 100%;
    }

    .col-placeholder.wide-grid {
        grid-template-columns: repeat(5, 1fr);
    }

    .mini-product {
        border-radius: 4px;
    }

    .mini-product img{
        width: 100%;
        object-fit: cover;
    }

    .col-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(255, 255, 255, 0.97) 0%, rgba(255, 255, 255, 0.5) 55%, transparent 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 24px;
        transition: background 0.3s;
    }
    .col-overlay a{
        width: 100%;
    }

    .col-card:hover .col-overlay {
        background: linear-gradient(to top, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.75) 60%, rgba(255, 255, 255, 0.1) 100%);
    }

    .col-badge {
        font-size: 10px;
        letter-spacing: 0.2em;
        color: #e03535;
        margin-bottom: 8px;
    }

    .col-name {
        font-size: 26px;
        font-weight: 900;
        color: #111;
        letter-spacing: 0.06em;
        line-height: 1;
        margin-bottom: 6px;
    }

    .col-count {
        font-size: 11px;
        color: #aaa;
        letter-spacing: 0.1em;
        margin-bottom: 16px;
    }

    .col-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 10px;
        letter-spacing: 0.2em;
        color: #111;
        border: 1px solid #ccc;
        padding: 7px 16px;
        opacity: 0;
        transform: translateY(8px);
        transition: all 0.3s;
        background: transparent;
        cursor: pointer;
        width: 100%;
    }

    .col-card:hover .col-btn {
        opacity: 1;
        transform: translateY(0);
        border-color: #e03535;
        color: #e03535;
    }


</style>