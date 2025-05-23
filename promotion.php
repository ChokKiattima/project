<?php 
 session_start();
 include("connect.php");

?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Bakery</title>
    <link rel="stylesheet" href="promotion.css">
   
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="https://i.postimg.cc/rzD6Dt39/logocake.png" alt="Little Bakery Logo">
            <h1>Little Bakery</h1>
        </div>
        <div class="search-bar">
            
            <input type="text" placeholder="ค้นหา...">
        </div>
        <div class="header-icons">
        <?php if (isset($_SESSION['username'])): ?>
        <!-- ถ้ามี $_SESSION['username'] -->
        <p><?php echo htmlspecialchars($_SESSION['username']); ?></p>
        <a>/</a>
        <a href="logout.php">ออกจากระบบ</a>
        <?php else: ?>
        <!-- ถ้าไม่มี $_SESSION['username'] -->
        <a href="login.php">เข้าสู่ระบบ</a>
        <a>/</a>
        <a href="register.php">ลงทะเบียน</a>
        <?php endif; ?>
        <h2>|</h2>
        <div id="cart-icon">
          <h1 href="#" onclick="toggleCart()">🛒</h1>
          <span id="cart-count">0</span>
        </div>
        <div id="cart-dropdown">
          <div id="cart-items"></div>
          <div id="cart-total" class="cart-total">รวม: 0 บาท</div>
          <button id="checkout-button" onclick="goToCart()">ไปที่ตะกร้า</button>
        </div>
      </div>
    </div>
    </div>
   
    <nav class="nav-menu">
        <button><h3><a href="littlebakery.php">Little</a></h3></button>
        <button><h3 href="#">Promotion</h3></button>
        <button><h3><a href="pound.php">Pound Cake</a></h3></button>
        <button><h3><a href="ice.php">Ice Cream Cake</a></h3></button>
        <button><h3><a href="pricecake.php">Piece of cake</a></h3></button>
        <button><h3><a href="bakery.php">Bakery</a></h3></button>
        <button><h3><a href="member.php">Member</a></h3></button>
    </nav> 

    <section class="promotions">
        <div class="promo-card">
            <div class="promo-text">11 . 11</div>
            <div class="promo-text">ลดแรง!</div>
            <div class="promo-discount">10%</div>
        </div>
        
        <div class="promo-card birthday-promo">
            <div class="promo-title">Happy</div>
            <div class="sale-text">BIRTHDAY</div>
            <div class="promo-title">SALE</div>
            <div class="promo-discount red">15%<span class="cursor">_</span></div>
        </div>
        
        <div class="promo-card">
            <div class="price-tag">1000บาท</div>
            <div class="free-delivery">FREE</div>
            <div class="delivery-text">DELIVERY</div>
            <div class="thai-text">ทั่วประเทศไทย</div>
        </div>
    </section>
    
    
    
    

    <script>
        // Sample product data
        const products = [
            {
                name: "Strawberry Cake",
                price: "450 ฿",
                image: "/api/placeholder/200/150"
            },
            {
                name: "Chocolate Brownie",
                price: "180 ฿",
                image: "/api/placeholder/200/150"
            },
            {
                name: "Red Velvet Cupcake",
                price: "90 ฿",
                image: "/api/placeholder/200/150"
            },
            {
                name: "Cheese Bread",
                price: "120 ฿",
                image: "/api/placeholder/200/150"
            }
        ];
        
        // Function to load products
        function loadProducts() {
            const productContainer = document.getElementById('popularProducts');
            
            products.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'product-card';
                
                productCard.innerHTML = `
                    <div class="product-image">
                        <img src="${product.image}" alt="${product.name}">
                    </div>
                    <div class="product-details">
                        <div class="product-name">${product.name}</div>
                        <div class="product-price">${product.price}</div>
                        <button class="add-to-cart">Add to Cart</button>
                    </div>
                `;
                
                productContainer.appendChild(productCard);
            });
        }
        
        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            loadProducts();
            
            // Add click event to cart buttons
            setTimeout(() => {
                const cartButtons = document.querySelectorAll('.add-to-cart');
                cartButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        alert('Item added to cart!');
                    });
                });
            }, 100);
        });
    </script>

    

    

<script>
// ใช้ localStorage เพื่อเก็บตะกร้าสินค้า
let cart = JSON.parse(localStorage.getItem('littleBakeryCart')) || [];

function addToCart(name, price, image) {
    // ตรวจสอบว่ามีสินค้าในตะกร้าแล้วหรือไม่
    const existingItem = cart.find(item => item.name === name);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({ 
            name, 
            price, 
            quantity: 1, 
            image,
            note: ""
        });
    }
    
    // บันทึกลงใน localStorage
    saveCart();
    updateCart();
}

function saveCart() {
    localStorage.setItem('littleBakeryCart', JSON.stringify(cart));
}

function updateCart() {
    const cartItemsContainer = document.getElementById('cart-items');
    const cartCountElement = document.getElementById('cart-count');
    const cartTotalElement = document.getElementById('cart-total');
    
    // ล้างรายการสินค้าที่มีอยู่
    cartItemsContainer.innerHTML = '';
    
    // คำนวณจำนวนสินค้าและราคารวม
    let totalItems = 0;
    let totalPrice = 0;
    
    cart.forEach((item, index) => {
        totalItems += item.quantity;
        totalPrice += item.price * item.quantity;
        
        const cartItemElement = document.createElement('div');
        cartItemElement.classList.add('cart-item');
        cartItemElement.innerHTML = `
            <span>${item.name}</span>
            <div class="cart-item-quantity">
                <button onclick="changeQuantity(${index}, -1)">-</button>
                <span>${item.quantity}</span>
                <button onclick="changeQuantity(${index}, 1)">+</button>
                <span>${item.price * item.quantity} บ.</span>
            </div>
        `;
        
        cartItemsContainer.appendChild(cartItemElement);
    });
    
    // อัพเดตจำนวนสินค้าและราคารวม
    cartCountElement.textContent = totalItems;
    cartTotalElement.textContent = `รวม: ${totalPrice} บาท`;
}

function changeQuantity(index, change) {
    cart[index].quantity += change;
    
    // ลบสินค้าถ้าจำนวนเป็น 0
    if (cart[index].quantity <= 0) {
        cart.splice(index, 1);
    }
    
    saveCart();
    updateCart();
}

function toggleCart() {
    const cartDropdown = document.getElementById('cart-dropdown');
    cartDropdown.style.display = cartDropdown.style.display === 'block' ? 'none' : 'block';
}

// ปิดตะกร้าเมื่อคลิกนอกพื้นที่
document.addEventListener('click', function(event) {
    const cartDropdown = document.getElementById('cart-dropdown');
    const cartIcon = document.getElementById('cart-icon');
    
    if (!cartDropdown.contains(event.target) && !cartIcon.contains(event.target)) {
        cartDropdown.style.display = 'none';
    }
});

// เปลี่ยนหน้าไปที่ตะกร้าสินค้า
function goToCart() {
    window.location.href = 'cart.php';
}

// โหลดตะกร้าเมื่อเปิดเพจ
window.onload = function() {
    updateCart();
};
</script> 

</body>
</html>