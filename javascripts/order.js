window.onload = function () {
  let cart = JSON.parse(localStorage.getItem("cart"));
  let productList = document.getElementById("product-list");
  let total = 0;
  for (let product of cart) {
    let productCard = document.querySelector(".card.mb-3").cloneNode(true);
    let img = productCard.querySelector("img");
    img.src = product.image;
    img.alt = product.name;
    let title = productCard.querySelector(".card-title");
    title.textContent = product.name;
    let quantity = productCard.querySelector(".quantity-order");
    quantity.textContent = `Số lượng: ${product.quantity}`;
    let price = productCard.querySelector(".product-price");
    price.textContent = `Giá: ${parseFloat(product.price).toLocaleString()}₫`;
    productList.appendChild(productCard);
    total += product.price * product.quantity;
  }
  let totalElement = document.getElementById("total");
  totalElement.textContent = `${parseFloat(total).toLocaleString()}₫`;
  document.querySelector(".card.mb-3").remove();
};
function handleOrdering(event) {
  event.preventDefault();
  const button = event.target;
  const userId = button.getAttribute("data-user-id");
  const addressCustomer = document.getElementById("address").value;
  const phoneCustomer = document.getElementById("phone").value;
  const noteCustomer = document.getElementById("note").value;
  const paymentMethod = document.getElementById("payment-method").value;
  const errorInput = document.querySelector(".error-message");
  const errorPayment = document.querySelector(".error-message-payment");
  if (addressCustomer === "" || phoneCustomer === "") {
    errorInput.textContent = "Vui lòng điền đầy đủ thông tin";
    return;
  }
  const phoneRegex = /^[0-9]{10}$/;
  if (!phoneRegex.test(phoneCustomer)) {
    errorInput.textContent = "Số điện thoại không hợp lệ";
    return;
  }
  const addressRegex = /^[a-zA-Z0-9\s.,-\/\p{L}]{10,}$/u;
  if (!addressRegex.test(addressCustomer)) {
    errorInput.textContent = "Địa chỉ không hợp lệ";
    return;
  }
  if (paymentMethod === "") {
    errorPayment.textContent = "Vui lòng chọn phương thức thanh toán";
    return;
  }
  const cart = JSON.parse(localStorage.getItem("cart"));
  const order = {
    userId: userId,
    address: addressCustomer,
    phone: phoneCustomer,
    note: noteCustomer,
    payment: paymentMethod,
    cart: cart,
  };
  fetch("../controller/orderController.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(order),
  })
    .then((response) => response.text())
    .then((data) => {
      if (data) {
        const successModal = new bootstrap.Modal(
          document.getElementById("successModal")
        );
        successModal.show();
        document
          .getElementById("successModal")
          .addEventListener("hide.bs.modal", function () {
            window.location.href = "/e-commerce-site/index.php";
          });
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
