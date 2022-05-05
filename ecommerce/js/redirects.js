function toUpdateQuantityCart(id, q) {
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