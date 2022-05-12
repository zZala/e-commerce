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

function toDeleteArticle(id){
    window.location = "check/deleteArticle.php?id=" + id;
}

function toAddArticle(){
    window.location = "check/modalAddArticle.php";
}

function caricaPopup(text, type) {
    $.bootstrapGrowl(text, {
        ele: 'body', // which element to append to
        type: type, // (null, 'info', 'error', 'success')
        offset: { from: 'top', amount: 30 }, // 'top', or 'bottom'
        align: 'center', // ('left', 'right', or 'center')
        width: 'auto', // (integer, or 'auto')
        delay: 2000,
        allow_dismiss: false,
        stackup_spacing: 10 // spacing between consecutively stacked growls.
    });
}