<?php
include "connection.php";

$product_id = isset($_GET['id']) ? $_GET['id'] : 0;

$product_rs = Database::search("
    SELECT p.id, p.title, p.description, p.collection_id, MIN(pi.path) as path, MIN(i.unit_price) as unit_price, 
           col.name as collection_name, t.name as type_name, cat.name as category_name
    FROM product p
    JOIN product_images pi ON pi.product_id = p.id
    JOIN inventory i ON i.product_id = p.id
    JOIN collection col ON col.id = p.collection_id
    JOIN type t ON t.id = p.type_id
    JOIN category cat ON cat.id = t.category_id
    WHERE p.id = $product_id
    GROUP BY p.id, p.title, p.description, p.collection_id, col.name, t.name, cat.name
");

$product = $product_rs->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shinigami Vault | <?php echo $product['title']; ?></title>

    <!-- stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="icon" href="assets/logo.png" />
</head>

<body>

    <!-- Header -->
    <?php include "header.php"; ?>


    <!-- Single Product View -->
    <div class="single-product-section">

        <!-- toast -->
        <div class="toast-msg" id="toast-msg">
            <i id="toast-icon" class="bi bi-x-circle-fill"></i>
            <span id="toast-text" class="toast-text"></span>
        </div>

        
        <div class="single-product-container">
            

            <!-- LEFT SIDE -->
            <div class="product-gallery">
                <?php $images_rs = Database::search("
                    SELECT pi.path, pi.color_id, c.name as color_name, c.code as color_code
                    FROM product_images pi
                    JOIN color c ON c.id = pi.color_id
                    WHERE pi.product_id = $product_id
                ");

                $images = $images_rs->fetch_all(MYSQLI_ASSOC);
                ?>

                <!-- main image -->
                <div class="main-image-box">
                    <img id="mainProductImage" src="<?php echo $images[0]['path']; ?>" alt="" class="main-product-image">
                </div>

                <!-- thumbnails -->
                <div class="thumbnail-row">
                    <?php for($i = 0; $i < count($images); $i++) { ?>
                        <div class="thumb <?php echo $i == 0 ? 'active' : ''; ?>" 
                            onclick="changeImage('<?php echo $images[$i]['path']; ?>', this)">
                            <img src="<?php echo $images[$i]['path']; ?>" alt="">
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="product-info">
                <p class="breadcrumb">
                    <?php echo $product['category_name']; ?> / <?php echo $product['type_name']; ?>
                </p>

                <h2 class="product-title">
                    <?php echo $product['collection_name'] . ' | ' . $product['title']; ?>
                </h2>

                <div class="rating-row">
                    <div class="stars">★★★★★</div>
                    <span>5 star reviews</span>
                </div>

                <h3 class="price">LKR. <?php echo number_format($product['unit_price'], 2); ?></h3>

                <?php
                    $variants_rs = Database::search("
                        SELECT i.id as inventory_id, i.size_id, i.color_id, i.qty, s.value as size_value, c.name as color_name, c.code as color_code
                        FROM inventory i
                        JOIN size s ON s.id = i.size_id
                        JOIN color c ON c.id = i.color_id
                        WHERE i.product_id = $product_id
                    ");

                    $variants = $variants_rs->fetch_all(MYSQLI_ASSOC);

                    // separate sizes and colors
                    $sizes = [];
                    $colors = [];
                    foreach($variants as $v) {
                        $sizes[$v['size_id']] = ['value' => $v['size_value'], 'qty' => $v['qty']];
                        $colors[$v['color_id']] = ['name' => $v['color_name'], 'code' => $v['color_code']];
                    }
                ?>

                <div class="info-line">
                    <span class="label">color :</span>
                    <div class="color-options">
                        <?php foreach($colors as $color) { ?>
                            <div class="color-option-wrap">
                                <button class="color-btn" 
                                    style="background-color: <?php echo $color['code']; ?>;"
                                    title="<?php echo $color['name']; ?>">
                                </button>
                                <span class="color-name"><?php echo $color['name']; ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="size-row">
                    <span class="label">size :</span>
                    <div class="size-options">
                        <?php foreach($sizes as $size) { ?>
                            <button class="size-btn <?php echo $size['qty'] == 0 ? 'disabled' : ''; ?>"
                                <?php echo $size['qty'] == 0 ? 'disabled' : ''; ?>>
                                <?php echo $size['value']; ?>
                            </button>
                        <?php } ?>
                    </div>
                </div>

                <?php
                    $single_variant = count($sizes) == 1 && count($colors) == 1;
                    $default_stock = $single_variant ? $variants[0]['qty'] : 'select size & color';
                ?>

                <div class="info-line stock-line">
                    <span class="label">In stock :</span>
                    <span class="value strong" id="stockValue"><?php echo $default_stock; ?></span>
                </div>

                <div class="quantity-sizechart-row">
                    <div class="quantity-wrap">
                        <span class="label">quantity :</span>
                        <div class="quantity-box">
                            <button type="button" onclick="decreaseQty()">-</button>
                            <span id="qtyValue">1</span>
                            <button type="button" onclick="increaseQty()">+</button>
                        </div>
                    </div>

                    <a href="#" class="size-chart-link">Size chart</a>
                </div>

                <div class="action-row">
                    <button class="add-to-bag-btn" type="button" onclick="AddToBag();">
                        Add to bag
                    </button>
                    <button class="wishlist-btn" type="button">
                        <i class="bi bi-suit-heart"></i>
                    </button>
                </div>

                <button class="buynow-btn" type="button">Buy now</button>
            </div>
        </div>

        <!-- product description -->
        <div class="product-description-section">
            <h3>Products Description</h3>
            <p><?php echo nl2br(str_replace('.', '.<br>', $product['description'])); ?></p>
        </div>

        <!-- REVIEWS -->
        <div class="reviews-section">
            <h3>Reveiws for Gojo Satoru Oversized Tee</h3>

            <div class="reviews-grid">

                <!-- Card 1: Stars + Message + Product Photo -->
                <div class="review-card">
                    <div class="rv-star-row">
                        <div class="stars">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                        <span class="rv-reviewer">Monkey D. Luffy</span>
                    </div>
                    <hr class="rv-divider">
                    <p class="rv-msg"><strong>Monkey D. Luffy</strong> says — "Absolutely loved it. The print quality is insane,
                        sharp and no fading after 3 washes. Feels so premium for the price."</p>
                    <img src="assets/products/sample.png" alt="Product" class="rv-product-img">
                </div>

                <!-- Card 2: Stars + Message -->
                <div class="review-card">
                    <div class="rv-star-row">
                        <div class="stars">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star star-empty">★</span>
                        </div>
                        <span class="rv-reviewer">Shehani G</span>
                    </div>
                    <hr class="rv-divider">
                    <p class="rv-msg"><strong>Shehani G</strong> says — "Great tee, fabric is thick and soft. Delivery was
                        fast too. Would definitely order again from Shinigami Vault."</p>
                </div>

                <!-- Card 3: Stars Only -->
                <div class="review-card">
                    <div class="rv-stars-only">
                        <div class="rv-rating-num">5.0</div>
                        <div class="stars">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                        <p class="rv-rating-name">— Anjana Ferdo</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- YOU MAY ALSO LIKE -->
        <div class="related-section">
            <h3>You may also like</h3>
            <?php
            $related_rs = Database::search("
                SELECT p.id, p.title, MIN(pi.path) as path, MIN(i.unit_price) as unit_price, col.name as collection_name
                FROM product p
                JOIN product_images pi ON pi.product_id = p.id
                JOIN inventory i ON i.product_id = p.id
                JOIN collection col ON col.id = p.collection_id
                WHERE p.collection_id = {$product['collection_id']} AND p.id != $product_id
                GROUP BY p.id, p.title, col.name
                ORDER BY p.id DESC
                LIMIT 3
            ");
            $related_num = $related_rs->num_rows;
            ?>
            <!-- product container -->
            <div class="products-container">
                <div class="row row-cols-3 d-flex justify-content-center"
                    style="margin-left: 1rem; margin-right: 1rem; margin-top: -2rem;">
                    <?php 
                        for ($r=0; $r < $related_num; $r++) { 
                            $related_data = $related_rs->fetch_assoc();
                            ?>
                            
                            <div class="product-card col">
                                <div class="product-image">
                                    <img src="<?php echo $related_data['path']; ?>" alt="">
                                </div>
                                <div class="product-details">
                                    <h6><a href="singleProductView.php?id=<?php echo $related_data['id']; ?>">
                                        <?php echo $related_data['collection_name'] . ' | ' . $related_data['title']; ?>
                                    </a></h6>
                                    <h5>LKR. <?php echo number_format($related_data['unit_price'], 2); ?></h5>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="col-10 mt-2">
                                        <button class="primary-btn">Add to Bag</button>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                    
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
    <script>
        const variants = <?php echo json_encode($variants); ?>;

        function updateStock() {
            const activeSize = document.querySelector(".size-btn.active");
            const activeColor = document.querySelector(".color-btn.active");

            if(!activeSize || !activeColor) {
                document.getElementById("stockValue").textContent = "select size & color";
                return;
            }

            const selectedSize = activeSize.textContent.trim();
            const selectedColor = activeColor.textContent.trim();

            const match = variants.find(v => 
                v.size_value.trim() === selectedSize && 
                v.color_name.trim() === selectedColor
            );

            document.getElementById("stockValue").textContent = match ? match.qty : "0";
        }

        window.addEventListener("load", function() {
            const firstSize = document.querySelector(".size-btn:not(:disabled)");
            const firstColor = document.querySelector(".color-btn");

            if(firstSize) firstSize.classList.add("active");
            if(firstColor) firstColor.classList.add("active");

            updateStock();
        });

        document.querySelectorAll(".size-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                document.querySelectorAll(".size-btn").forEach(b => b.classList.remove("active"));
                this.classList.add("active");
                updateStock();
            });
        });

        document.querySelectorAll(".color-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                document.querySelectorAll(".color-btn").forEach(b => b.classList.remove("active"));
                this.classList.add("active");
                updateStock();
            });
        });


        function AddToBag() {
            const activeSize = document.querySelector(".size-btn.active");
            const activeColor = document.querySelector(".color-btn.active");

            if(!activeSize || !activeColor) {
                showToast("⚠ Please select a size and color!");
                return;
            }

            const selectedSize = activeSize.textContent.trim();
            const selectedColor = activeColor.textContent.trim();

            const match = variants.find(v => 
                v.size_value.trim() === selectedSize && 
                v.color_name.trim() === selectedColor
            );

            if(!match) {
                showToast("⚠ Selected variant not found!");
                return;
            }

            if(match.qty == 0) {
                showToast("⚠ This item is out of stock!");
                return;
            }

            const qty = document.getElementById("qtyValue").textContent;

            var form = new FormData();
            form.append("inventory_id", match.inventory_id);
            form.append("qty", qty);

            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    var response = request.responseText;
                    if(response == "success") {
                        showToast("Added to bag! ✓", "success");
                    } else if(response == "login") {
                        showToast("⚠ Please login first!");
                        setTimeout(() => window.location.href = "index.php", 1500);
                    } else {
                        showToast("⚠ Something went wrong!");
                    }
                }
            }
            request.open("POST", "processes/addToCartProcess.php", true);
            request.send(form);
        }
    </script>

    
</body>

</html>

<style>
    .single-product-section {
        width: 100%;
        min-height: 90vh;
        padding: 35px 30px;
    }

    .single-product-container {
        display: grid;
        grid-template-columns: 1fr 0.88fr;
        gap: 18px;
        align-items: start;
        min-height: auto;
    }

    /* LEFT SIDE */
    .product-gallery {
        width: 100%;
    }

    .main-image-box {
        width: 100%;
        min-height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
    }

    .main-product-image {
        width: 100%;
        max-width: 430px;
        max-height: 520px;
        object-fit: contain;
        display: block;
    }

    .thumbnail-row {
        display: flex;
        gap: 18px;
        margin-top: 20px;
        padding-left: 40px;
        justify-content: center;
    }

    .thumb {
        width: 92px;
        height: 92px;
        border: 2px solid transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.3s ease;
        background: transparent;
    }

    .thumb.active {
        border-color: var(--dark-grey);
    }

    .thumb img {
        max-width: 78px;
        max-height: 78px;
        object-fit: contain;
    }

    /* RIGHT SIDE */
    .product-info {
        width: 100%;
        max-width: 640px;
        padding-top: 4px;
        transform: scale(0.88);
        transform-origin: top left;
        margin-left: -20px;
    }

    .breadcrumb {
        font-size: 0.9rem;
        color: #7a7a7a;
        margin-bottom: 20px;
        margin-top: 2rem;
    }

    .product-title {
        font-family: 'header';
        font-size: 2.2rem;
        color: var(--black);
        margin-bottom: 16px;
        line-height: 1.2;
    }

    .rating-row {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 16px;
        flex-wrap: wrap;
        margin-left: 0.5rem;
    }

    .stars {
        color: var(--red);
        font-size: 1.35rem;
        letter-spacing: 1px;
    }

    .rating-row span {
        color: var(--red);
        font-size: 0.9rem;
    }

    .price {
        font-family: 'header';
        font-size: 1.95rem;
        color: var(--black);
        margin-bottom: 2rem;
    }

    .info-line,
    .size-row,
    .quantity-sizechart-row {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .label {
        font-size: 0.98rem;
        color: #4a4a4a;
    }

    .value {
        font-size: 0.98rem;
    }

    .strong {
        font-weight: 700;
        color: var(--dark-grey);
    }

    .color-options {
        display: flex;
        gap: 10px;
    }

    .color-option-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }

    .color-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 2px solid transparent;
        cursor: pointer;
        transition: 0.3s ease;
        padding: 0;
    }

    .color-name {
        font-size: 0.65rem;
        color: var(--dark-grey);
        text-align: center;
        letter-spacing: 0.05em;
    }

    .color-btn:hover, .color-btn.active {
        border-color: var(--dark-grey);
    } 

    .size-btn:disabled {
        opacity: 0.35;
        cursor: not-allowed;
        text-decoration: line-through;
    }

    .size-options {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .size-btn {
        min-width: 56px;
        height: 42px;
        border-radius: 18px;
        border: 2px solid var(--dark-grey);
        background: transparent;
        color: var(--dark-grey);
        font-size: 0.95rem;
        cursor: pointer;
        transition: 0.3s ease;
    }

    .size-btn.active,
    .size-btn:hover {
        background: var(--dark-grey);
        color: var(--white);
    }

    .stock-line {
        margin-top: 0;
    }

    .quantity-sizechart-row {
        justify-content: space-between;
        align-items: center;
    }

    .quantity-wrap {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .quantity-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 128px;
        height: 48px;
        border: 2px solid var(--dark-grey);
        border-radius: 6px;
        padding: 0 14px;
    }

    .quantity-box button {
        border: none;
        background: transparent;
        font-size: 1.55rem;
        cursor: pointer;
        color: var(--dark-grey);
    }

    .quantity-box span {
        font-size: 1.1rem;
        font-family: 'header';
        color: var(--dark-grey);
    }

    .size-chart-link {
        color: #4d4d4d;
        font-size: 1.05rem;
        text-decoration: underline;
    }

    .size-chart-link:hover {
        color: var(--black)
    }

    .action-row {
        display: grid;
        grid-template-columns: 1fr 62px;
        gap: 10px;
        margin-top: 2.5rem;
        margin-bottom: 10px;
    }

    .add-to-bag-btn {
        width: 100%;
        height: 3.5rem;
        border-radius: 5px;
        border: 2px solid var(--black);
        background-color: var(--white);
        color: var(--black);
        letter-spacing: 1px;
        font-size: 1rem;
        font-weight: 800;
    }

    .add-to-bag-btn:hover {
        border: none;
        background-color: var(--black);
        color: var(--white);
        letter-spacing: 1px;
    }

    .add-to-bag-btn:active {
        transform: translateY(1px);
    }

    .wishlist-btn {
        width: 100%;
        height: 3.5rem;
        border-radius: 5px;
        border: none;
        background-color: var(--black);
    }

    .wishlist-btn i {
        color: var(--white);
        font-size: 1rem;
        font-weight: 800;
    }

    .wishlist-btn:active {
        transform: translateY(1px);
    }

    .buynow-btn {
        width: 100%;
        height: 3.5rem;
        border-radius: 5px;
        border: none;
        background-color: var(--red);
        color: var(--white);
        letter-spacing: 1px;
        font-size: 1rem;
        font-weight: 800;
    }

    .buynow-btn:active {
        transform: translateY(1px);
    }


    /* details */
    .product-description-section,
    .reviews-section,
    .related-section {
        margin-top: 36px;
    }

    .product-description-section h3,
    .reviews-section h3,
    .related-section h3 {
        font-family: 'header';
        font-size: 1.4rem;
        margin-bottom: 25px;
        color: var(--dark-grey);
    }

    .product-description-section p {
        padding-left: 28px;
        font-size: 0.9rem;
        margin-bottom: 10px;
        line-height: 1.2;
        color: #636363;
    }


    /* reviews */
    .reviews-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
      gap: 16px;
      padding: 1.5rem 0;
    }
 
    .review-card {
      background: var(--hero-bg);
      border: 0.5px solid rgba(0, 0, 0, 0.12);
      border-radius: 12px;
      padding: 1.25rem;
      position: relative;
      overflow: hidden;
    }
 
    .review-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: var(--red);
    }
 
    .rv-star-row {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 12px;
    }
 
    .stars {
      display: flex;
      gap: 2px;
    }
 
    .star {
      font-size: 14px;
      color: var(--red);
      line-height: 1;
    }
 
    .star-empty {
      color: #cccccc;
    }
 
    .rv-reviewer {
      font-size: 13px;
      font-weight: 500;
      color: var(--black);
      font-family: 'header';
    }
 
    .rv-divider {
      border: none;
      border-top: 0.5px solid rgba(0, 0, 0, 0.12);
      margin: 10px 0;
    }
 
    .rv-msg {
      font-size: 12px;
      color: #555555;
      line-height: 1.65;
      margin: 0;
    }
 
    .rv-msg strong {
      color: var(--black);
      font-weight: 500;
    }
 
    .rv-product-img {
      width: auto;
      height: 60px;
      object-fit: cover;
      margin-top: 12px;
      display: block;
    }
 
    .rv-stars-only {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 90px;
      gap: 12px;
    }
 
    .rv-stars-only .star {
      font-size: 20px;
    }
 
    .rv-rating-num {
      font-family: 'header';
      font-size: 35px;
      color: #111111;
      line-height: 1;
    }
 
    .rv-rating-name {
      font-size: 13px;
      font-weight: 500;
      color: #888888;
      font-family: 'header';
      margin-top: 4px;
    }
</style>

<script>
    function changeImage(imageSrc, clickedThumb) {
        document.getElementById("mainProductImage").src = imageSrc;

        document.querySelectorAll(".thumb").forEach((thumb) => {
            thumb.classList.remove("active");
        });

        clickedThumb.classList.add("active");
    }

    let qty = 1;

    function increaseQty() {
        qty++;
        document.getElementById("qtyValue").textContent = qty;
    }

    function decreaseQty() {
        if (qty > 1) {
            qty--;
            document.getElementById("qtyValue").textContent = qty;
        }
    }

    document.querySelectorAll(".size-btn").forEach((button) => {
        button.addEventListener("click", function () {
            document.querySelectorAll(".size-btn").forEach((btn) => btn.classList.remove("active"));
            this.classList.add("active");
        });
    });
</script>