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
    <link rel="stylesheet" href="bf.css">
   
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
            <a href="login.html">เข้าสู่ระบบ</a>
             <a >/</a>
            <a href="sign in.html">ลงทะเบียน </a>
            <h2>|</h2>
            <div id="cart-icon" >
                <h1 href="#" onclick="toggleCart()">🛒</h1>
                <span id="cart-count">0</span> 
            </div>
            <div id="cart-dropdown" >
                <div id="cart-items"></div>
                <div id="cart-total" class="cart-total">รวม: 0 บาท</div>
                <button id="checkout-button" onclick="goToCart()">ไปที่ตะกร้า</button>
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

    <div class="container">
        <div class="product-container">
            <div class="product-image">
                <img src="https://i.pinimg.com/736x/6b/b0/6b/6bb06bb45ac1b95157c019d7693cbcea.jpg  ">
            </div>
            
            <div class="product-details">
                <h1 class="product-title">ชีสทาร์ต - Cheese tart</h1>
                <p class="product-description">
                    ขนมอบชนิดหนึ่งที่มีฐานเป็นแป้งทาร์ตกรอบและไส้เป็นครีมชีสที่เนียนนุ่ม รสชาติกลมกล่อม มีความหวานมันและมักจะมีกลิ่นหอมของชีสเด่นชัด
                </p>
                
                <div class="product-price">80 บาท</div>
                
                <div class="quantity-control">
                    <button class="quantity-btn" id="decrease">-</button>
                    <div class="quantity-display" id="quantity">1</div>
                    <button class="quantity-btn" id="increase">+</button>
                    <button class="add-to-cart">เพิ่มสินค้าลงตะกร้า</button>
                </div>
            </div>
        </div>
        
        <div class="reviews-container">
            <h2 style="margin-bottom: 20px;">รีวิวจากลูกค้า</h2>
            <div class="reviews-flex" id="reviewsContainer">
                <div class="review-box">
                    <div class="review-header">
                        <div class="review-title">Little cake</div>
                        <div class="rating">⭐⭐⭐⭐⭐</div>
                    </div>
                    <p class="review-content">เค้กรสชาติหวานอร่อยกำลังดีค่ะ ส่งของไว เค้กไม่แห้งในราคาที่น่าพอใจ</p>
                    <p class="review-date">01 เมษายน 2568</p>
                </div>
                
                
                
            </div>
            
            <!-- New Review Form -->
            <div class="new-review-container">
                <h3>เขียนรีวิวเค้ก</h3>
                <form id="reviewForm">
                    <!-- Removed the "ชื่อ" field -->
                    <div class="form-group">
                        <label>ให้คะแนน</label>
                        <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5" />
                            <label for="star5">★</label>
                            <input type="radio" id="star4" name="rating" value="4" />
                            <label for="star4">★</label>
                            <input type="radio" id="star3" name="rating" value="3" />
                            <label for="star3">★</label>
                            <input type="radio" id="star2" name="rating" value="2" />
                            <label for="star2">★</label>
                            <input type="radio" id="star1" name="rating" value="1" />
                            <label for="star1">★</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="reviewContent">รีวิวของคุณ</label>
                        <textarea id="reviewContent" required placeholder="แชร์ความคิดเห็นของคุณเกี่ยวกับเค้กบลูเบอร์รี่..."></textarea>
                    </div>
                    
                    <button type="submit" class="submit-review">ส่งรีวิว</button>
                </form>
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

        // ฟังก์ชันเพิ่มรีวิวใหม่ในหน้า
        function addReviewToPage(name, rating, content) {
            const reviewsContainer = document.getElementById('reviewsContainer');
            const reviewDate = new Date().toLocaleDateString('th-TH', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            const reviewBox = document.createElement('div');
            reviewBox.classList.add('review-box');
            reviewBox.innerHTML = `
                <div class="review-header">
                    <div class="review-title">${name}</div>
                    <div class="rating">${'⭐'.repeat(rating)}</div>
                </div>
                <p class="review-content">${content}</p>
                <p class="review-date">${reviewDate}</p>
            `;

            reviewsContainer.appendChild(reviewBox);
        }

        // จัดการการส่งฟอร์มรีวิว
        document.getElementById('reviewForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const rating = document.querySelector('input[name="rating"]:checked')?.value || 0;
            const content = document.getElementById('reviewContent').value;

            if (rating && content) {
                addReviewToPage('ผู้ใช้ไม่ระบุชื่อ', rating, content); // Default name for anonymous reviews

                // ล้างฟอร์มหลังจากส่งรีวิว
                document.getElementById('reviewForm').reset();
            } else {
                alert('กรุณากรอกข้อมูลให้ครบถ้วน');
            }
        });

        // ฟังก์ชันเพิ่มจำนวนสินค้า
        document.getElementById('increase').addEventListener('click', function() {
            const quantityDisplay = document.getElementById('quantity');
            let quantity = parseInt(quantityDisplay.textContent);
            quantityDisplay.textContent = quantity + 1;
        });

        // ฟังก์ชันลดจำนวนสินค้า
        document.getElementById('decrease').addEventListener('click', function() {
            const quantityDisplay = document.getElementById('quantity');
            let quantity = parseInt(quantityDisplay.textContent);
            if (quantity > 1) {
                quantityDisplay.textContent = quantity - 1;
            }
        });

        // เพิ่มสินค้าลงตะกร้าพร้อมจำนวน
        document.querySelector('.add-to-cart').addEventListener('click', function() {
            const quantity = parseInt(document.getElementById('quantity').textContent);
            const productName = document.querySelector('.product-title').textContent;
            const productPrice = parseInt(document.querySelector('.product-price').textContent.replace(' บาท', ''));
            const productImage = document.querySelector('.product-image img').src;

            for (let i = 0; i < quantity; i++) {
                addToCart(productName, productPrice, productImage);
            }
        });
    </script> 
        
</body>
</html>