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
    <link rel="stylesheet" href="member.css">
   
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

    <div class="container">
        <section class="info-section" style="flex: 2;">
            <h2 class="section-header">Personal Info</h2>
            <div class="section-content">
                <div class="form-group">
                    <label>User Name :</label>
                    <input type="text" id="username">
                    <span class="edit-icon">✏️</span>
                </div>
                <div class="form-group">
                    <label>First Name :</label>
                    <input type="text" id="firstname">
                    <span class="edit-icon">✏️</span>
                </div>
                <div class="form-group">
                    <label>Last Name :</label>
                    <input type="text" id="lastname">
                    <span class="edit-icon">✏️</span>
                </div>
            </div>
        </section>
        
        <div class="points-card">
            <div class="points-title">Member Point</div>
            <div class="points-value" id="member-points">0</div>
        </div>
        
        <section class="info-section">
            <h2 class="section-header">Contact</h2>
            <div class="section-content">
                <div class="form-group">
                    <label>E-Mail :</label>
                    <input type="email" id="email">
                    <span class="edit-icon">✏️</span>
                </div>
                <div class="form-group">
                    <label>เบอร์โทรศัพท์มือถือ :</label>
                    <input type="tel" id="phone">
                    <span class="edit-icon">✏️</span>
                </div>
            </div>
        </section>
        
        <section class="info-section">
            <h2 class="section-header">Address</h2>
            <div class="section-content">
                <div class="form-group">
                    <label>ที่อยู่ :</label>
                    <input type="text" id="address">
                    <span class="edit-icon">✏️</span>
                </div>
                <button class="save-btn" id="saveButton">บันทึกข้อมูล</button>
            </div>
        </section>
    </div>
    <script>
       document.addEventListener('DOMContentLoaded', function() {
    const fields = ['username', 'firstname', 'lastname', 'email', 'phone', 'address'];

    // Save button functionality
    document.getElementById('saveButton').addEventListener('click', function() {
        const data = {};
        fields.forEach(field => {
            data[field] = document.getElementById(field).value;
        });

        // ส่งข้อมูลไปยัง PHP script
        fetch('member1.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('ข้อมูลถูกบันทึกเรียบร้อยแล้ว');
            } else {
                alert('เกิดข้อผิดพลาด: ' + result.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์');
        });
    });
});
    </script>

    

    

<script>
// ใช้ localStorage เพื่อเก็บตะกร้าสินค้า
let cart = JSON.parse(localStorage.getItem('littleBakeryCart')) || [];
let memberPoints = parseInt(localStorage.getItem('memberPoints')) || 0;
document.getElementById('member-points').textContent = memberPoints;

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

    // Update member points
    const newPoints = Math.floor(totalPrice / 100);
    if (newPoints > memberPoints) {
        memberPoints = newPoints;
        localStorage.setItem('memberPoints', memberPoints);
        document.getElementById('member-points').textContent = memberPoints;
    }
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