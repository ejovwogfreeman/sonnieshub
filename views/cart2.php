<?php
session_start();
include('./partials/header.php');
include('./config/db.php');

$userId = $_SESSION['user_id']; // Assuming user ID is stored in session after login

if (!$userId) {
    header('Location: login.php'); // Redirect to login page if user is not logged in
    exit();
}
?>

<section id="page-header" class="about-header">
    <h2>#cart</h2>
    <p>Add your coupon code & SAVE up to 70%!</p>
</section>

<section id="cart" class="section-p1">
    <table width="100%">
        <thead>
            <tr>
                <td>Remove</td>
                <td>Image</td>
                <td>Product</td>
                <td>Price</td>
                <td>Quantity</td>
                <td>Subtotal</td>
            </tr>
        </thead>
        <tbody id="cart-items">
            <!-- Cart items will be dynamically inserted here by JavaScript -->
        </tbody>
    </table>
</section>

<section id="cart-add" class="section-p1">
    <div class="coupon">
        <h3>Apply Coupon</h3>
        <div>
            <input type="text" placeholder="Enter Your Coupon">
            <button class="normal">Apply</button>
        </div>
    </div>
    <div class="subtotal">
        <h3>Cart Totals</h3>
        <table>
            <tr>
                <td>Cart Subtotal</td>
                <td id="cart-subtotal">$0.00</td>
            </tr>
            <tr>
                <td>Shipping</td>
                <td>Free</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong id="cart-total">$0.00</strong></td>
            </tr>
        </table>
        <button class="normal">Proceed to checkout</button>
    </div>
</section>

<?php
include('./partials/footer.php');
?>

<script>
    const userId = <?php echo $userId; ?>;

    function updateCartDisplay(cart) {
        const cartItems = document.getElementById('cart-items');
        const cartSubtotal = document.getElementById('cart-subtotal');
        const cartTotal = document.getElementById('cart-total');

        cartItems.innerHTML = '';
        let subtotal = 0;

        if (Object.keys(cart).length === 0) {
            cartItems.innerHTML = '<tr><td colspan="6">The cart is empty.</td></tr>';
        } else {
            for (const [productId, item] of Object.entries(cart)) {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td><a href="#" onclick="removeFromCart(${productId})"><i class="fas fa-times-circle" style="color:black"></i></a></td>
                <td><img src="${item.image}" alt=""></td>
                <td>${item.name}</td>
                <td>$${item.price.toFixed(2)}</td>
                <td><input type="number" value="${item.quantity}" onchange="changeQuantity(${productId}, this.value)"></td>
                <td>$${(item.price * item.quantity).toFixed(2)}</td>
            `;
                cartItems.appendChild(row);
                subtotal += item.price * item.quantity;
            }
        }

        cartSubtotal.textContent = `$${subtotal.toFixed(2)}`;
        cartTotal.textContent = `$${subtotal.toFixed(2)}`;
    }

    async function fetchCart(action, productId = null, quantity = 1) {
        const formData = new FormData();
        formData.append('action', action);
        if (productId !== null) {
            formData.append('productId', productId);
            formData.append('quantity', quantity);
        }

        const response = await fetch('cart-endpoint.php', {
            method: 'POST',
            body: formData,
        });

        if (response.ok) {
            const cart = await response.json();
            updateCartDisplay(cart);
        } else {
            const error = await response.json();
            console.error('Error:', error);
        }
    }

    function removeFromCart(productId) {
        fetchCart('remove', productId);
    }

    function changeQuantity(productId, quantity) {
        if (quantity > 0) {
            fetchCart('update', productId, quantity);
        } else {
            fetchCart('remove', productId);
        }
    }

    // Initial cart display
    fetchCart(''); // Fetch cart without any action to display the initial cart state
</script>