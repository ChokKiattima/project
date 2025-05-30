<?php 
session_start(); // เริ่มต้น session
include("connect.php"); // เชื่อมต่อฐานข้อมูล

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Bakery</title>
    <link rel="stylesheet" href="pound.css">
   
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
   
    <nav class="nav-menu">
        <button><h3><a href="littlebakery.php">Little</a></h3></button>
        <button><h3><a href="promotion.php">Promotion</a></h3></button>
        <button><h3><a href="pound.php">Pound Cake</a></h3></button>
        <button><h3><a href="ice.php">Ice Cream Cake</a></h3></button>
        <button><h3><a href="pricecake.php">Piece of cake</a></h3></button>
        <button><h3><a href="bakery.php">Bakery</a></h3></button>
        <button><h3><a href="member.php">Member</a></h3></button>
    </nav> 

    <div class="cake-section">
        <div class="section-title"> 
            <h2>Bakery</h2>
            
        </div>
        <div class="cake-grid">
            <div class="cake-item" data-name="Pie jaa" data-price="120">
                <img src="https://i.pinimg.com/736x/c3/bc/30/c3bc30e73374c97211f18d7dcc4ff117.jpg" alt="เค้กแบล็คฟอเรสต์">
                <div class="cake-details">
                    <p class="cake-price"> Apple    Pie jaa    120 บ.</p>
                    <button class="order-btn" onclick="addToCart('Pie jaa', 120, 'https://img.wongnai.com/p/400x0/2019/08/10/1b388707e24a42228efcb4a7cd29a94a.jpg')">ใส่ตะกร้า</button>
                </div>
                <button class="detell" onclick="or('#', 0)"><a href="applepie.php">ดูรายละเอียด</a></button>
            </div>
            <div class="cake-item" data-name="BrokkY " data-price="20">
                <img src="https://i.pinimg.com/736x/ea/ab/53/eaab53fa631bfbaffc42e81fcc55e620.jpg" alt="เค้กสตอเบอร์รี">
                <div class="cake-details">
                    <p class="cake-price">BROOKIE   20 บ.</p>
                    <button class="order-btn" onclick="addToCart('BrokkY ', 20, 'https://image.makewebcdn.com/makeweb/m_1200x600/jKZC6GmS7/other/31.png')">ใส่ตะกร้า</button>
                </div>
                <button class="detell" onclick="or('#', 0)"><a href="brookky.php">ดูรายละเอียด</a></button>
            </div>
            <div class="cake-item" data-name="Cheese Tart" data-price="80">
                <img src="https://i.pinimg.com/736x/6b/b0/6b/6bb06bb45ac1b95157c019d7693cbcea.jpg   " alt="เค้กเรดเวลเวต">
                <div class="cake-details">
                    <p class="cake-price">Cheese Tart    80 บ.</p>
                    <button class="order-btn" onclick="addToCart('Cheese Tart', 80, 'https://image.makewebcdn.com/makeweb/m_1920x0/jKZC6GmS7/other/34.png?v=202405291424')">ใส่ตะกร้า</button>
                </div>
                <button class="detell" onclick="or('#', 0)"><a href="cheesetart.php">ดูรายละเอียด</a></button>
            </div>
            <div class="cake-item" data-name="Raspberry tart" data-price="60">
                <img src="https://i.pinimg.com/736x/e3/33/0f/e3330f4c813af17ec6936ae2f57d726e.jpg" alt="เค้กวินลา">
                <div class="cake-details">
                    <p class="cake-price">Raspberry tart   60บ.</p>
                    <button class="order-btn" onclick="addToCart('Raspberry tart', 60, 'https://image.makewebcdn.com/makeweb/m_1920x0/jKZC6GmS7/other/32.png?v=202405291424')">ใส่ตะกร้า</button>
                </div>
                <button class="detell" onclick="or('#', 0)"><a href="rasberry.php">ดูรายละเอียด</a></button>
            </div>
            <div class="cake-item" data-name="strawberry tart" data-price="70">
                <img src="https://i.pinimg.com/736x/fe/59/97/fe5997b7bfefa7d769d3efbc6e121505.jpg" alt="เค้กวินลา">
                <div class="cake-details">
                    <p class="cake-price">strawberry tart     70 บ.</p>
                    <button class="order-btn" onclick="addToCart('strawberry tart', 70, 'https://i.ibb.co/VcGchcN0/465722978-9403070069711300-5589682847167151453-n-Photoroom.png')">ใส่ตะกร้า</button>
                </div>
                <button class="detell" onclick="or('#', 0)"><a href="strtart.php">ดูรายละเอียด</a></button>
            </div>
            <div class="cake-item" data-name="Eggs tart " data-price="20">
                <img src="https://i.pinimg.com/736x/a1/7b/1c/a17b1c88d73adc3abf04cc55e54aa6c1.jpg" alt="เค้กวินลา">
                <div class="cake-details">
                    <p class="cake-price">Eggs tart    20 บ.</p>
                    <button class="order-btn" onclick="addToCart('Eggs tart ', 20, 'https://image.makewebcdn.com/makeweb/m_1920x0/jKZC6GmS7/other/33.png?v=202405291424')">ใส่ตะกร้า</button>
                </div>
                <button class="detell" onclick="or('#', 0)"><a href="eggs tart.php">ดูรายละเอียด</a></button>
            </div>
        </div>

    </div>

    

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