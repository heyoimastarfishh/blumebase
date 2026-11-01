<?php 
require_once 'includes/db.php'; 
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// This tells the navbar to use the solid white background on this page
$use_solid_nav = true; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop All | Blume</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="page-with-nav">

    <?php include 'includes/navbar.php'; ?>

    <main class="blume-container">
        <h1 class="serif-font blume-shop-title">Products</h1>
        
        <div class="blume-shop-toolbar">
            <span><?php echo count($products); ?> PRODUCTS</span>
            <select>
                <option>SORT BY: FEATURED</option>
                <option>PRICE: LOW TO HIGH</option>
                <option>PRICE: HIGH TO LOW</option>
            </select>
        </div>

        <div class="blume-shop-grid">
            <?php if(count($products) > 0): ?>
                <?php foreach($products as $product): ?>
                    <a href="product.php?id=<?php echo $product['id']; ?>" class="blume-product-link">
                        <div class="blume-image-box">
                            <?php $has_secondary = !empty($product['image_url_2']); ?>
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                                 class="blume-img-primary <?php echo $has_secondary ? 'has-hover-img' : 'no-hover-img'; ?>">
                            
                            <?php if($has_secondary): ?>
                                <img src="<?php echo htmlspecialchars($product['image_url_2']); ?>" class="blume-img-secondary">
                            <?php endif; ?>
                        </div>
                        
                        <div class="blume-product-info">
                            <span class="title"><?php echo htmlspecialchars($product['name']); ?></span>
                            <span class="price">$<?php echo htmlspecialchars($product['price']); ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <?php for($i=1; $i<=8; $i++): ?>
                <div class="blume-product-link">
                    <div class="blume-image-box">
                        <img src="https://via.placeholder.com/400x600?text=Apparel+<?php echo $i; ?>" class="blume-img-primary no-hover-img">
                    </div>
                    <div class="blume-product-info">
                        <span class="title">Signature Pastel Blouse</span>
                        <span class="price">$59.00</span>
                    </div>
                </div>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>