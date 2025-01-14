<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Website</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="script.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <section id="Home">
        <nav>
            <div class="logo">
                <img src="image/logobusiness2.png">
            </div>

            <ul>
                <li><a href="#Home">Home</a></li>
                <li><a href="#About">About</a></li>
                <li><a href="#Menu">Menu</a></li>
                <li><a href="#reviewForm">Review</a></li>
                <li><a href="faq.html">FAQs</a></li>
            </ul>


        <!-- Cart Icon -->
        <a href="view_orders.html" id="cart_icon" class="cart_button">
            <i class="fa fa-shopping-cart"></i>
            <span id="cart-count">0</span>
        </a>



        <!-- Dropdown Menu -->
        <div class="dropdown">
            <button class="dropdown-btn"><i class="fa fa-chevron-down"></i></button>
            <div class="dropdown-content">
                <a href="update_account.php">Update Account</a>
                <a href="delete_account.php">Delete Account</a>
                <button class="logout-btn" onclick="window.location.href='logout.php';">Logout</button>
            </div>
        </div>


        </nav>

        <div class="main">

            <div class="men_text">
                <h1>Get Malay<span>Bites</span><br>in a Easy Way</h1>
            </div>

            <div class="main_image">
                <img src="image/logobusiness2.png">
            </div>

        </div>

        <p>
        Welcome to Bite Malay, where authentic Malaysian flavors come to life! 
        We’re passionate about sharing the warmth and richness of traditional home-cooked meals, 
        freshly prepared and delivered straight to your door. Each dish is crafted with love, 
        combining timeless recipes with the freshest ingredients to give you a true taste of Malaysia. 
        Let us bring the joy of hearty, flavorful meals to your table and make every bite unforgettable.
        </p>

        <div class="main_btn">
            <a href="#Menu">Order Now</a>
            <i class="fa-solid fa-angle-right"></i>
        </div>

    </section>

    <!--About-->

    <div class="about" id="About">
        <div class="about_main">

            <div class="image">
                <img src="image/NZbottlebg.png">
            </div>

            <div class="about_text">
                <h1><span>About</span>Us</h1>
                <h3>Why Choose us?</h3>
                <p>
                At Bite Malay, we believe every meal tells a story. 
                Our dishes bring the warmth and authenticity of Malaysian kitchens straight to your plate. 
                Passionate about preserving tradition, we strive to make every bite a celebration of 
                our heritage. Offering fresh, authentic Malay cuisine crafted with perfectly balanced spices, 
                we ensure a flavorful experience with every meal. 
                Prepared with love using locally sourced ingredients and made fresh daily, 
                our ready-to-eat dishes are both convenient and satisfying. With easy delivery options, 
                Bite Malay brings the heart of Malaysia to your doorstep.
                </p>
            </div>
        </div>


    </div>

    <!-- Menu Section -->
    <div class="menu" id="Menu">
        <h1>Our&nbsp;<span>Menu</span></h1>
        <div class="menu_box">

            <!-- Menu Card 1 (Cheese Powder Combo) -->
            <div class="menu_card">
                <div class="menu_image">
                    <img src="image/CheesePowderCombo.jpg" alt="Cheese Powder Combo">
                </div>
                <div class="small_card">
                </div>
                <div class="menu_info">
                    <h2>Cheese Powder Combo</h2>
                    <h3>RM15.00</h3>
                    <button class="menu_btn" onclick="addToCart('Cheese Powder Combo', 15)">Order Now</button>
                </div>
            </div>

            <!-- Menu Card 2 (Colek Nise) -->
            <div class="menu_card">
                <div class="menu_image">
                    <img src="image/ColekNise.jpg" alt="Colek Nise">
                </div>
                <div class="small_card">
                </div>
                <div class="menu_info">
                    <h2>Colek Nise</h2>
                    <h3>RM10.00</h3>
                    <button class="menu_btn" onclick="addToCart('Colek Nise', 10)">Order Now</button>
                </div>
            </div>

            <!-- Menu Card 3 (Grill Chicken) -->
            <div class="menu_card">
                <div class="menu_image">
                    <img src="image/GrillChicken.jpg" alt="Grill Chicken">
                </div>
                <div class="small_card">
                </div>
                <div class="menu_info">
                    <h2>Grill Chicken</h2>
                    <h3>RM10.00</h3>
                    <button class="menu_btn" onclick="addToCart('Grill Chicken', 10)">Order Now</button>
                </div>
            </div>

            <!-- Menu Card 4 (Grill Lamb) -->
            <div class="menu_card">
                <div class="menu_image">
                    <img src="image/GrillLamb.jpg" alt="Grill Lamb">
                </div>
                <div class="small_card">
                </div>
                <div class="menu_info">
                    <h2>Grill Lamb</h2>
                    <h3>RM10.00</h3>
                    <button class="menu_btn" onclick="addToCart('Grill Lamb', 10)">Order Now</button>
                </div>
            </div>

            <!-- Menu Card 5 (Latok) -->
            <div class="menu_card">
                <div class="menu_image">
                    <img src="image/Latok.jpg" alt="Latok">
                </div>
                <div class="small_card">
                </div>
                <div class="menu_info">
                    <h2>Latok</h2>
                    <h3>RM15.00</h3>
                    <button class="menu_btn" onclick="addToCart('Latok', 15)">Order Now</button>
                </div>
            </div>

            <!-- Menu Card 6 (NZ Pouch) -->
            <div class="menu_card">
                <div class="menu_image">
                    <img src="image/NZpouch.jpg" alt="NZ pouch">
                </div>
                <div class="small_card">
                </div>
                <div class="menu_info">
                    <h2>NZ Pouch</h2>
                    <h3>RM2.00</h3>
                    <button class="menu_btn" onclick="addToCart('NZ Pouch', 2)">Order Now</button>
                </div>
            </div>

            <!-- Menu Card 7 (Pekasam Rusa) -->
            <div class="menu_card">
                <div class="menu_image">
                    <img src="image/PekasamRusa.jpg" alt="Pekasam Rusa">
                </div>
                <div class="small_card">
                </div>
                <div class="menu_info">
                    <h2>Pekasam Rusa</h2>
                    <h3>RM12.00</h3>
                    <button class="menu_btn" onclick="addToCart('Pekasam Rusa', 12)">Order Now</button>
                </div>
            </div>

            <!-- Menu Card 8 (Pekasam Ikan) -->
            <div class="menu_card">
                <div class="menu_image">
                    <img src="image/PekasamIkan.jpg" alt="Pekasam Ikan">
                </div>
                <div class="small_card">
                </div>
                <div class="menu_info">
                    <h2>Pekasam Ikan</h2>
                    <h3>RM15.00</h3>
                    <button class="menu_btn" onclick="addToCart('Pekasam Ikan', 15)">Order Now</button>
                </div>
            </div>

            <!-- Menu Card 9 (Pekasam Telur Sotong) -->
            <div class="menu_card">
                <div class="menu_image">
                    <img src="image/PekasamTelurSotong.jpg" alt="Pekasam Telur Sotong">
                </div>
                <div class="small_card">
                </div>
                <div class="menu_info">
                    <h2>Pekasam Telur Sotong</h2>
                    <h3>RM12.00</h3>
                    <button class="menu_btn" onclick="addToCart('Pekasam Telur Sotong', 12)">Order Now</button>
                </div>
            </div>

            <!-- Menu Card 10 (Sambal Bilis) -->
            <div class="menu_card">
                <div class="menu_image">
                    <img src="image/SambalBilis.jpg" alt="Sambal Bilis">
                </div>
                <div class="small_card">
                </div>
                <div class="menu_info">
                    <h2>Sambal Bilis</h2>
                    <h3>RM10.00</h3>
                    <button class="menu_btn" onclick="addToCart('Sambal Bilis', 10)">Order Now</button>
                </div>
            </div>
            
        </div>

    </div>

    <script>
        // Place your JavaScript code here
        
        let cart = []; // Array to store cart items

        function updateCartCount() {
            // Retrieve the cart from localStorage or initialize an empty array if not found
            const cart = JSON.parse(localStorage.getItem('cart')) || [];

            // Calculate the total quantity of items in the cart
            const cartCount = cart.reduce((count, item) => count + item.quantity, 0);

            // Find the cart count element and update its content
            const cartIcon = document.getElementById('cart-count');
            if (cartIcon) {
                cartIcon.textContent = cartCount; // Update the cart count in the UI
            }
        }

        // Ensure the function runs when the page is fully loaded
        document.addEventListener('DOMContentLoaded', () => {
            updateCartCount();
        });

        function addToCart(itemName, itemPrice) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
            // Check if the item already exists in the cart
            const existingItem = cart.find(item => item.name === itemName);
            if (existingItem) {
                // If the item exists, increase its quantity
                existingItem.quantity += 1;
            } else {
                // If the item doesn't exist, add it with quantity 1
                cart.push({ name: itemName, price: itemPrice, quantity: 1 });
            }
    
            // Save the updated cart to localStorage
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
        }


        // Function to view the cart and place the order
        function viewCart() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                alert('Your cart is empty!');
            } else {
                let orderSummary = 'Your Order:\n';
                let totalPrice = 0;

                // Display the items in the cart with quantity
                cart.forEach(item => {
                    orderSummary += `${item.name} (x${item.quantity}) - $${(item.price * item.quantity).toFixed(2)}\n`;
                    totalPrice += item.price * item.quantity;
                });

                orderSummary += `\nTotal Price: $${totalPrice.toFixed(2)}\n`;

                if (confirm(orderSummary + '\nDo you want to place the order?')) {
                    placeOrder();
                }
            }
        }


        // Function to place the order
        function placeOrder() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                alert('Your cart is empty!');
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'place_order.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
    
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert('Order placed successfully!');
                    localStorage.removeItem('cart'); // Clear the cart
                    updateCartCount();
                }
            };

            // Send the cart data as JSON
            xhr.send(JSON.stringify({ items: cart }));
        }


        
    </script>


<!--Review Form-->
<div class="review" id="reviewForm">
    <h1><span>Write&nbsp;</span>a Review</h1>

    <div class="review_main">
        <form id="reviewFormElement">
            <div class="input_group">
                <label for="customerName">Name</label>
                <input id="customerName" type="text" placeholder="Enter your name" required>
            </div>
            <div class="input_group">
                <label for="customerEmail">Email</label>
                <input id="customerEmail" type="email" placeholder="Enter your email" required>
            </div>
            <div class="input_group">
                <label for="reviewText">Review</label>
                <textarea id="reviewText" placeholder="Write your review here..." rows="4" required></textarea>
            </div>
            <div class="input_group">
                <label for="rating">Rating</label>
                <select id="rating" required>
                    <option value="" disabled selected>Select your rating</option>
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select>
            </div>
            <button type="submit" class="review_btn">Submit Review</button>
        </form>
    </div>
    <div id="reviewBox" class="review_box"></div>
</div>


<script>
    const reviewForm = document.getElementById('reviewFormElement');
    const reviewBox = document.getElementById('reviewBox');

    // Function to render reviews
    function renderReviews() {
        // Get reviews from local storage
        const reviews = JSON.parse(localStorage.getItem('reviews')) || [];

        // Clear the review box
        reviewBox.innerHTML = '';

        // Display each review
        reviews.forEach((review) => {
            const reviewCard = document.createElement('div');
            reviewCard.classList.add('review_card');
            reviewCard.innerHTML = `
                <div class="review_text">
                    <h2 class="name">${review.name}</h2>
                    <div class="review_icon">
                        ${Array.from({ length: Math.floor(review.rating) })
                            .map(() => '<i class="fa-solid fa-star"></i>')
                            .join('')}
                        ${review.rating % 1 !== 0 ? '<i class="fa-solid fa-star-half-stroke"></i>' : ''}
                    </div>
                    <p>${review.text}</p>
                </div>
            `;
            reviewBox.prepend(reviewCard);
        });
    }

    // Handle form submission
    reviewForm.addEventListener('submit', function (event) {
        event.preventDefault();

        // Get form values
        const name = document.getElementById('customerName').value;
        const email = document.getElementById('customerEmail').value;
        const reviewText = document.getElementById('reviewText').value;
        const rating = document.getElementById('rating').value;

        // Create a review object
        const newReview = { name, email, text: reviewText, rating };

        // Get existing reviews from local storage
        const reviews = JSON.parse(localStorage.getItem('reviews')) || [];

        // Add the new review
        reviews.push(newReview);

        // Save back to local storage
        localStorage.setItem('reviews', JSON.stringify(reviews));

        // Re-render the reviews
        renderReviews();

        // Clear the form
        reviewForm.reset();
    });

    // Render reviews on page load
    document.addEventListener('DOMContentLoaded', renderReviews);
</script>



    <!--Team-->

    <div class="team">
        <h1>Our<span>Team</span></h1>

        <div class="team_box">
            <div class="profile">
                <img src="image/Nisa.jpg">

                <div class="info">
                    <h2 class="name">Nisa</h2>
                    <p class="bio">Team Leader</p>

                </div>

            </div>

            <div class="profile">
                <img src="image/Asmira.jpg">

                <div class="info">
                    <h2 class="name">Asmira</h2>
                    <p class="bio">Marketing Collaborator</p>

                </div>

            </div>

            <div class="profile">
                <img src="image/Fatin.jpg">

                <div class="info">
                    <h2 class="name">Fatin</h2>
                    <p class="bio">Trainer and Mentor</p>

                </div>

            </div>

            <div class="profile">
                <img src="image/Humaira.jpg">

                <div class="info">
                    <h2 class="name">Humaira'</h2>
                    <p class="bio">Research and Development (R&D) Chef</p>

                </div>

            </div>

            <div class="profile">
                <img src="image/Liyana.jpg">

                <div class="info">
                    <h2 class="name">Liyana</h2>
                    <p class="bio">Quality Control Specialist</p>

                </div>

            </div>

        </div>

    </div>



    <!--Footer-->

    <footer>
        <div class="footer_main">

            <div class="footer_tag">
                <h2>Location</h2>
                <p>MALAYSIA</p>
                <p>Malay Bites</p>
                <p>123, Jalan Permata,</p>
                <p>08000 Sungai Petani</p>
                <p>Kedah</p>
            </div>

            <div class="footer_tag">
                <h2>Credits</h2>
                <p>'Kaori Resources'</p>
                <p>A Malaysian company specializing in the production and distribution of food products.</p>
            </div>

            <div class="footer_tag">
                <h2>Contact</h2>
                <p>+60123456789</p>
                <p>+601122334455</p>
                <p>MalayBitescorporation@gmail.com</p>
            </div>

            <div class="footer_tag">
                <h2>Our Service</h2>
                <p>Fast Delivery</p>
                <p>Easy Payments</p>
                <p>Pop-Up Food Stalls</p>
            </div>


            <div class="footer_tag">
            <h2>Follows</h2>
            <a href="https://www.facebook.com" target="blank" aria-label="Facebook">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a href="https://www.twitter.com" target="blank" aria-label="Twitter">
                <i class="fa-brands fa-twitter"></i>
            </a>
            <a href="https://www.instagram.com" target="blank" aria-label="Instagram">
                <i class="fa-brands fa-instagram"></i>
            </a>
        </div>

    </div>

        <p class="end"></p>

    </footer>



    
</body>
</html>

