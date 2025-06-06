<?php
session_start();
include("connect.php");

?>


<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Bakery - ตะกร้าสินค้า</title>
    <link rel="stylesheet" href="cart.css">
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
         <h3  class = "lororo">ChokY&nbsp; </h3>

         <h3 class = "lororo">&nbsp;|&nbsp;</h3>
        <div class="cart-icon">
            <h1>🛒</h1>
            <span class="cart-count" id="header-cart-count">0</span>
        </div>
    </div>

    <nav class="nav-menu">
        <button><h4><a href="littlebakery.php">Little</a></h4></button>
        <button><h4><a href="promotion.php">Promotion</a></h4></button>
        <button><h4><a href="pound.php">Pound Cake</a></h4></button>
        <button><h4><a href="ice.php">Ice Cream Cake</a></h4></button>
        <button><h4><a href="pricecake.php">Piece of cake</a></h4></button>
        <button><h4><a href="bakery.php">Bakery</a></h4></button>
        <button><h4><a href="member.php">Member</a></h4></button>
    </nav> 

    <div class="container">
        <h1 class="cart-title">ตะกร้าสินค้า <span id="cart-item-count">0</span> รายการ</h1>

        <div id="cart-items">
           
        </div>

        <button class="more-items-btn" onclick="window.location.href='littlebakery.php'">เลือกซื้อรายการอื่นเพิ่มเติม</button>

        <div class="cart-summary">
            <h2 class="summary-title">สรุปยอด</h2>
            <div class="summary-row">
                <span>จำนวนสินค้าทั้งหมด</span>
                <span id="total-items">0 ชิ้น</span>
            </div>
            <div class="summary-row">
                <span>ค่าจัดส่ง</span>
                <span>100 บาท</span>
            </div>
            <div class="summary-row">
                <span>ส่วนลดราคาสินค้า</span>
                <span> 0 บาท</span>
            </div>
            <div class="total-row">
                <span>ยอดรวมสุทธิ</span>
                <span id="total-price"></span>
            </div>
            <button class="checkout-btn" onclick="redirectToPayment()"><a href="pay.php">ชำระเงิน</a></button>
        </div>
    </div>

    <script>
        
        // ค่าจัดส่งและส่วนลด
        const shippingFee = 100;
        const discount = 0;
        
        // โหลดข้อมูลจาก localStorage
        let cartItems = [];

        // ฟังก์ชันเปลี่ยนจำนวนสินค้า
        function changeQuantity(index, change) {
            cartItems[index].quantity += change;
            
            // ป้องกันจำนวนสินค้าน้อยกว่า 1
            if (cartItems[index].quantity < 1) {
                if (confirm('คุณต้องการลบสินค้านี้ออกจากตะกร้าหรือไม่?')) {
                    cartItems.splice(index, 1);
                } else {
                    cartItems[index].quantity = 1;
                }
            }
            
            saveCart();
            updateCart();
            renderCartItems();
        }

        // ฟังก์ชันลบสินค้า
        function removeItem(index) {
            if (confirm('คุณต้องการลบสินค้านี้ออกจากตะกร้าหรือไม่?')) {
                cartItems.splice(index, 1);
                saveCart();
                updateCart();
                renderCartItems();
            }
        }

        // ฟังก์ชันแก้ไขสินค้า
        function editItem(index) {
            const note = prompt('กรุณาใส่คำขอพิเศษสำหรับสินค้านี้:', cartItems[index].note);
            if (note !== null) {
                cartItems[index].note = note;
                saveCart();
                updateCart();
                renderCartItems();
            }
        }

        // ฟังก์ชันคำนวณยอดรวมสินค้า
        function calculateTotal() {
            let totalItems = 0;
            let subtotal = 0;
            
            cartItems.forEach(item => {
                totalItems += item.quantity;
                subtotal += item.price * item.quantity;
            });
            
            const total = subtotal + shippingFee - discount;
            
            return {
                totalItems,
                subtotal,
                total
            };
        }

        // ฟังก์ชันบันทึกตะกร้าลง localStorage
        function saveCart() {
            localStorage.setItem('littleBakeryCart', JSON.stringify(cartItems));
        }

        // ฟังก์ชันอัพเดทตะกร้า
        function updateCart() {
            const totals = calculateTotal();
            
            // อัพเดทจำนวนสินค้าทั้งหมด
            document.getElementById('total-items').textContent = `${totals.totalItems} ชิ้น`;
            
            // อัพเดทยอดรวมสุทธิ
            document.getElementById('total-price').textContent = `${totals.total.toLocaleString()} บาท`;
            
            // อัพเดทจำนวนสินค้าที่ header
            document.getElementById('header-cart-count').textContent = totals.totalItems;
            
            // อัพเดทชื่อหัวข้อตะกร้า
            document.getElementById('cart-item-count').textContent = cartItems.length;
        }

        // ฟังก์ชันแสดงรายการสินค้าในตะกร้า
        function renderCartItems() {
            const cartContainer = document.getElementById('cart-items');
            cartContainer.innerHTML = '';
            
            cartItems.forEach((item, index) => {
                const itemElement = document.createElement('div');
                itemElement.className = 'cart-item';
                itemElement.innerHTML = `
                    <img src="${item.image}" alt="${item.name}">
                    <div class="item-details">
                        <div class="item-name">${item.name}</div>
                        <div class="item-note">คำขอพิเศษ: ${item.note || ''}</div>
                    </div>
                    <div class="quantity-controls">
                        <button class="decrease-btn" onclick="changeQuantity(${index}, -1)">-</button>
                        <span class="quantity">${item.quantity}</span>
                        <button class="increase-btn" onclick="changeQuantity(${index}, 1)">+</button>
                    </div>
                    <div class="item-price">${item.price} บ.</div>
                    <div class="item-actions">
                        <button onclick="editItem(${index})">✏️</button>
                        <button onclick="removeItem(${index})">🗑️</button>
                    </div>
                `;
                cartContainer.appendChild(itemElement);
            });
        }

        // ฟังก์ชันชำระเงิน
        async function redirectToPayment() {
            const totals = calculateTotal();
            if (cartItems.length > 0) {
                const response = await fetch('http://localhost:3000/api/orders', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        items: cartItems.map(item => ({
                            product_id: item.product_id,
                            quantity: item.quantity,
                            price: item.price
                        })),
                        totalPrice: totals.total
                    })
                });

                if (response.ok) {
                    alert('คำสั่งซื้อถูกบันทึกแล้ว');
                    // Pass the total amount as a query parameter to pay.html
                    window.location.href = `pay.html?total=${totals.total}`;
                } else {
                    alert('เกิดข้อผิดพลาดในการบันทึกคำสั่งซื้อ');
                }
            } else {
                alert('กรุณาเพิ่มสินค้าในตะกร้าก่อนชำระเงิน');
            }
        }

        // เริ่มต้นแสดงตะกร้า
        window.onload = function() {
            // โหลดข้อมูลจาก localStorage
            const savedCart = localStorage.getItem('littleBakeryCart');
            if (savedCart) {
                cartItems = JSON.parse(savedCart);
            }
            
            updateCart();
            renderCartItems();
        };
    </script>
</body>
</html>