function toUpdateQuantityCart(id, q, max) {
    if (q != 0 && q != (max + 1))
        window.location = "check/updateQuantityCart.php?id=" + id + "&q=" + q;
}

function toRemoveFromCart(id) {
    window.location = "check/removeFromCart.php?id=" + id;
}

function toCleanCart() {
    window.location = "check/cleanCart.php";
}

function toCheckout() {
    window.location = "checkout.php";
}
function toAddToCart(id, q) {
    window.location = "check/addToCart.php?id=" + id + "&q=" + q;
}

function toRemoveFromWishlist(id) {
    window.location = "check/removeFromWishlist.php?id=" + id;
}