<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discover Us | Shinigami Vault</title>

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

    <div class="discover-container">

        <!-- manifesto -->
        <div class="manifesto">
            <p class="manifesto-label">shinigami vault</p>
            <h1 class="manifesto-title">we don't print<br>fan art. we <span>open a vault</span>.</h1>
            <p class="manifesto-sub">Sri Lanka&nbsp;&middot;&nbsp;anime streetwear&nbsp;&middot;&nbsp;est. drops every friday</p>
        </div>

        <!-- origin note -->
        <div class="origin-row">
            <div class="origin-note">
                <span class="note-pin"></span>
                <p class="note-line">Every anime fan knows the feeling &mdash; a scene hits so hard you want
                    to wear it. Most merch treats that feeling like a poster. We treat it like a wardrobe.</p>
                <p class="note-line">Shinigami Vault started as a small stash of oversized tees printed for
                    friends who couldn't find anything that looked as good as the shows they loved. It's grown
                    into a running archive of collections, but the brief hasn't changed: streetwear first,
                    fan service second.</p>
                <p class="note-sign">&mdash; the vault keepers</p>
            </div>
            <div class="origin-figure">
                <img src="assets/hero.png" alt="Shinigami Vault apparel">
            </div>
        </div>

        <!-- vault rules -->
        <div class="rules-section">
            <p class="section-label">how we work</p>
            <div class="rules-grid">

                <div class="rule-card">
                    <span class="rule-mark">01</span>
                    <h3 class="rule-title">Built oversized</h3>
                    <p class="rule-text">Every silhouette is cut for streetwear first &mdash; drop-shoulder
                        tees and heavyweight hoodies, not shrink-wrapped anime tees.</p>
                </div>

                <div class="rule-card">
                    <span class="rule-mark">02</span>
                    <h3 class="rule-title">One print, once</h3>
                    <p class="rule-text">Collections retire when they sell out. No reprints, no restocks &mdash;
                        what you cop is what existed.</p>
                </div>

                <div class="rule-card">
                    <span class="rule-mark">03</span>
                    <h3 class="rule-title">Shipped island-wide</h3>
                    <p class="rule-text">Packed and posted from Sri Lanka, with cash on delivery for anyone
                        who'd rather pay at the door.</p>
                </div>

                <div class="rule-card">
                    <span class="rule-mark">04</span>
                    <h3 class="rule-title">Community-picked</h3>
                    <p class="rule-text">New arcs, characters, and colorways come from what our customers
                        keep asking for &mdash; not a mood board.</p>
                </div>

            </div>
        </div>

        <!-- ledger stats -->
        <div class="ledger-strip">
            <div class="ledger-stat">
                <span class="stat-num">12</span>
                <span class="stat-label">collections logged</span>
            </div>
            <div class="ledger-stat">
                <span class="stat-num">38+</span>
                <span class="stat-label">tees in the vault</span>
            </div>
            <div class="ledger-stat">
                <span class="stat-num">14</span>
                <span class="stat-label">hoodies & counting</span>
            </div>
            <div class="ledger-stat">
                <span class="stat-num">fri</span>
                <span class="stat-label">new drops, weekly</span>
            </div>
        </div>

        <!-- cta -->
        <div class="discover-cta">
            <h2>the vault's open.</h2>
            <a class="cta-link" href="collection.php">
                <span class="cta-bracket">[</span> explore the collections <span class="cta-bracket">]</span>
            </a>
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

    .discover-container {
        background: var(--white);
    }

    /* manifesto */

    .manifesto {
        max-width: 900px;
        margin: 0 auto;
        padding: 90px 40px 70px;
        text-align: center;
    }

    .manifesto-label {
        font-size: 11px;
        letter-spacing: 0.3em;
        text-transform: uppercase;
        color: #aaa;
        margin-bottom: 18px;
    }

    .manifesto-title {
        font-family: 'header';
        font-size: 50px;
        color: var(--black);
        line-height: 1.15;
        letter-spacing: 0.01em;
        margin-bottom: 18px;
        text-transform: lowercase;
    }

    .manifesto-title span {
        color: var(--red);
    }

    .manifesto-sub {
        font-size: 13px;
        color: #b0aaa0;
        letter-spacing: 0.08em;
    }

    /* origin note */

    .origin-row {
        max-width: 1080px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 0.8fr;
        gap: 70px;
        align-items: center;
        padding: 20px 40px 100px;
    }

    .origin-note {
        position: relative;
        background: var(--light-bg);
        padding: 44px 40px;
        border-left: 3px solid var(--red);
    }

    .note-pin {
        position: absolute;
        top: -8px;
        left: 34px;
        width: 18px;
        height: 10px;
        background: var(--red);
    }

    .note-line {
        font-size: 15px;
        line-height: 1.75;
        color: var(--dark-grey);
        margin-bottom: 18px;
    }

    .note-sign {
        font-size: 12px;
        letter-spacing: 0.1em;
        color: #a8a29a;
        margin-bottom: 0;
    }

    .origin-figure {
        display: flex;
        justify-content: center;
    }

    .origin-figure img {
        width: 100%;
        max-width: 320px;
        height: auto;
    }

    /* vault rules */

    .rules-section {
        background: var(--hero-bg);
        padding: 80px 40px;
    }

    .section-label {
        text-align: center;
        font-size: 11px;
        letter-spacing: 0.3em;
        text-transform: uppercase;
        color: #b3ada2;
        margin-bottom: 40px;
    }

    .rules-grid {
        max-width: 1080px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1px;
        background: #ddd7cb;
    }

    .rule-card {
        background: var(--hero-bg);
        padding: 30px 26px;
    }

    .rule-mark {
        display: block;
        font-family: 'Courier New', monospace;
        font-size: 13px;
        color: var(--red);
        margin-bottom: 16px;
    }

    .rule-title {
        font-family: 'header';
        font-size: 19px;
        color: var(--black);
        text-transform: lowercase;
        margin-bottom: 10px;
        line-height: 1.2;
    }

    .rule-text {
        font-size: 13px;
        line-height: 1.6;
        color: #6b665d;
        margin: 0;
    }

    /* ledger strip */

    .ledger-strip {
        max-width: 1080px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        padding: 60px 40px;
    }

    .ledger-stat {
        text-align: center;
        border-left: 1px solid #e6e2d9;
        padding: 0 10px;
    }

    .ledger-stat:first-child {
        border-left: none;
    }

    .stat-num {
        display: block;
        font-family: 'header';
        font-size: 40px;
        color: var(--black);
        line-height: 1;
        margin-bottom: 10px;
    }

    .stat-label {
        font-size: 11px;
        letter-spacing: 0.08em;
        color: #a8a29a;
    }

    /* cta */

    .discover-cta {
        text-align: center;
        padding: 40px 40px 110px;
    }

    .discover-cta h2 {
        font-family: 'header';
        font-size: 30px;
        color: var(--black);
        margin-bottom: 26px;
        text-transform: lowercase;
    }

    .cta-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        letter-spacing: 0.05em;
        color: var(--black);
        text-decoration: none;
        padding-bottom: 4px;
        border-bottom: 1px solid var(--black);
        transition: color 0.2s, border-color 0.2s;
    }

    .cta-bracket {
        color: var(--red);
        font-family: 'Courier New', monospace;
    }

    .cta-link:hover {
        color: var(--red);
        border-color: var(--red);
    }

    @media (max-width: 860px) {
        .manifesto-title { font-size: 34px; }
        .origin-row { grid-template-columns: 1fr; padding-bottom: 60px; }
        .origin-figure { order: -1; }
        .rules-grid { grid-template-columns: 1fr 1fr; }
        .ledger-strip { grid-template-columns: 1fr 1fr; row-gap: 30px; }
        .ledger-stat:nth-child(3) { border-left: none; }
    }

</style>