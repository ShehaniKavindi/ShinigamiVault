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

        <div class="vault-ledger">

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
                $entry_no = str_pad($c + 1, 2, "0", STR_PAD_LEFT);
                ?>
                <div class="entry">
                    <div class="entry-collage">
                        <span class="entry-watermark"><?php echo $entry_no; ?></span>
                        <div class="pinboard">
                            <?php 
                                $images_rs = Database::search("SELECT 
                                    p.id AS product_id,
                                    p.title,
                                    pi.path AS image
                                FROM product p

                                JOIN product_images pi ON p.id = pi.product_id

                                WHERE p.collection_id = $c_id;");

                                $images_num = $images_rs->num_rows;

                                if ($images_num === 0) {
                                    ?>
                                    <div class="pin-empty">
                                        <span>drop pending</span>
                                    </div>
                                    <?php
                                } else {
                                    for ($i=0; $i < $images_num; $i++) { 
                                        $images_data = $images_rs->fetch_assoc();
                                        ?>
                                        <div class="pin-photo">
                                            <img src="<?php echo $images_data['image']; ?>" alt="<?php echo htmlspecialchars($images_data['title']); ?>">
                                        </div>
                                        <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <div class="entry-record">
                        <span class="entry-tag">case file</span>
                        <h2 class="entry-name"><?php echo $collection_data["name"]; ?></h2>
                        <div class="entry-meta">
                            <span class="entry-stamp"><?php echo $entry_no; ?> / <?php echo str_pad($collection_num, 2, "0", STR_PAD_LEFT); ?></span>
                            <span class="entry-count"><?php echo $collection_data["product_count"]; ?> piece<?php echo $collection_data["product_count"] == 1 ? '' : 's'; ?> logged</span>
                        </div>
                        <a class="entry-link" href="search.php?search=<?php echo $collection_data['name']; ?>">
                            <span class="entry-link-bracket">[</span> view collection <span class="entry-link-bracket">]</span>
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
        background: var(--bg);
        min-height: 100vh;
    }

    .hero {
        background: var(--surface);
        padding: 60px 40px 40px;
        text-align: center;
        border-bottom: 1px solid var(--border);
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
        color: var(--heading);
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

    /* ---- vault ledger ---- */

    .vault-ledger {
        max-width: 1180px;
        margin: 0 auto;
        padding: 10px 40px 100px;
    }

    .entry {
        display: grid;
        grid-template-columns: 1.1fr 1fr;
        gap: 60px;
        align-items: center;
        padding: 64px 0;
        border-bottom: 1px solid var(--border);
    }

    .entry:first-child {
        padding-top: 48px;
    }

    .entry:nth-child(even) {
        grid-template-columns: 1fr 1.1fr;
    }

    .entry:nth-child(even) .entry-collage {
        order: 2;
    }

    /* collage side */

    .entry-collage {
        position: relative;
        min-height: 320px;
        display: flex;
        align-items: center;
    }

    .entry-watermark {
        position: absolute;
        top: -30px;
        left: -10px;
        font-family: 'Courier New', monospace;
        font-size: 130px;
        font-weight: 700;
        color: var(--heading);
        opacity: 0.05;
        line-height: 1;
        pointer-events: none;
        z-index: 0;
    }

    .pinboard {
        position: relative;
        z-index: 1;
        display: flex;
        flex-wrap: wrap;
        gap: 0;
        padding-left: 30px;
    }

    .pin-photo {
        position: relative;
        width: 150px;
        height: 190px;
        background: #eceae5;
        border: 6px solid #fff;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.14);
        margin: 0 -20px 14px 0;
        overflow: hidden;
    }

    .pin-photo:nth-of-type(odd) { transform: rotate(-4deg); }
    .pin-photo:nth-of-type(even) { transform: rotate(3deg); margin-top: 26px; }
    .pin-photo:nth-of-type(3n) { transform: rotate(-2deg); margin-top: 12px; }

    .pin-photo::before {
        content: "";
        position: absolute;
        top: 6px;
        left: 50%;
        transform: translateX(-50%);
        width: 16px;
        height: 8px;
        background: var(--red, #e23d3d);
        z-index: 2;
    }

    .pin-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .pin-empty {
        width: 220px;
        height: 190px;
        margin-left: 10px;
        border: 1px dashed #c9c4ba;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #b3ada0;
        font-family: 'Courier New', monospace;
        font-size: 12px;
        letter-spacing: 0.08em;
    }

    /* record side */

    .entry-record {
        position: relative;
    }

    .entry-tag {
        display: inline-block;
        font-family: 'Courier New', monospace;
        font-size: 11px;
        letter-spacing: 0.18em;
        color: var(--red, #e23d3d);
        border: 1px solid var(--red, #e23d3d);
        padding: 3px 10px;
        margin-bottom: 18px;
    }

    .entry-name {
        font-family: 'header', sans-serif;
        font-size: 42px;
        color: var(--heading);
        letter-spacing: 0.02em;
        line-height: 1.05;
        margin-bottom: 18px;
        text-transform: lowercase;
    }

    .entry-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        font-family: 'Courier New', monospace;
        font-size: 12px;
        color: #928d81;
        letter-spacing: 0.04em;
        padding-bottom: 22px;
        margin-bottom: 22px;
        border-bottom: 1px solid var(--border);
    }

    .entry-stamp {
        color: var(--heading);
        font-weight: 700;
    }

    .entry-link {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 13px;
        letter-spacing: 0.05em;
        color: var(--heading);
        text-decoration: none;
        padding-bottom: 3px;
        border-bottom: 1px solid var(--heading);
        transition: color 0.2s, border-color 0.2s;
    }

    .entry-link-bracket {
        color: var(--red, #e23d3d);
        font-family: 'Courier New', monospace;
    }

    .entry-link:hover {
        color: var(--red, #e23d3d);
        border-color: var(--red, #e23d3d);
    }

    @media (max-width: 860px) {
        .vault-ledger { padding: 10px 20px 70px; }
        .entry, .entry:nth-child(even) {
            grid-template-columns: 1fr;
            gap: 28px;
            padding: 44px 0;
        }
        .entry:nth-child(even) .entry-collage { order: 0; }
        .entry-watermark { font-size: 90px; top: -18px; }
        .entry-name { font-size: 32px; }
    }

</style>