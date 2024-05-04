function loadCartFromLocal() {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  const cartList = document.querySelector(".list-group");
  const totalAmountElement = document.querySelector(".total-amount");
  const orderBtn = document.querySelector(".order-btn");
  const cartNullHideP = document.querySelector(".cart-hide-p");
  const cartNullHideA = document.querySelector(".cart-hide-a");
  cartList.innerHTML = "";
  let totalAmount = 0;
  if (cart.length === 0) {
    cartNullHideP.textContent = "Hiện chưa có sản phẩm!";
    cartNullHideA.textContent = "Mua sắm ngay";
    orderBtn.removeAttribute("href");
  } else {
    cartNullHideA.style.display = "none";
    orderBtn.setAttribute("href", "/e-commerce-site/pages/order.php");
  }
  cart.forEach((product) => {
    // Tạo một mục danh sách mới cho sản phẩm
    const listItem = document.createElement("div");
    listItem.className =
      "list-group-item d-flex justify-content-between align-items-center";
    // Thêm nội dung cho mục danh sách
    listItem.innerHTML = `
            <div class="d-flex align-items-center">
                <img src="${
                  product.image
                }" class="img-thumbnail me-3" style="width: 60px; height: 60px;">
                <div>
                    <a class="mb-1 text-decoration-none text-dark" href="/e-commerce-site/pages/product_details.php?id=${
                      product.id
                    }"><h5 >${product.name}</h5></a>
                    <p class="mb-1 ">Số lượng: 
                        <button class="btn btn-sm btn-outline-secondary decrease-quantity">-</button>
                        <span class="product-quantity">${
                          product.quantity
                        }</span>
                        <button class="btn btn-sm btn-outline-secondary increase-quantity">+</button>
                    </p>
                </div>
            </div>
           <div class="d-flex justify-content-between align-items-center">
        <span class="text-muted fw-bolder product-price" style="margin-right: 10px;">${parseFloat(
          product.price
        ).toLocaleString()}₫</span>
        <button class="btn btn-sm btn-outline-dark remove-item" data-index="${
          product.id
        }">&times;</button>
    </div>     
        `;
    listItem.querySelector(".remove-item").addEventListener("click", () => {
      removeItemFromCart(product.id);
    });
    cartList.appendChild(listItem);

    // Cập nhật tổng giá
    totalAmount += product.price * product.quantity;
    listItem
      .querySelector(".increase-quantity")
      .addEventListener("click", () => {
        product.quantity += 1;
        updateCart(cart);
        const cartUpdatedEvent = new CustomEvent("cartUpdated");
        document.dispatchEvent(cartUpdatedEvent);
      });

    // Xử lý sự kiện khi nhấn nút giảm số lượng
    listItem
      .querySelector(".decrease-quantity")
      .addEventListener("click", () => {
        if (product.quantity > 1) {
          product.quantity -= 1;
          updateCart(cart);
          const cartUpdatedEvent = new CustomEvent("cartUpdated");
          document.dispatchEvent(cartUpdatedEvent);
        }
      });
  });
  function removeItemFromCart(productId) {
    // Lấy dữ liệu giỏ hàng từ localStorage
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Tìm chỉ số của sản phẩm cần xóa
    const index = cart.findIndex((product) => product.id === productId);

    // Nếu tìm thấy sản phẩm, xóa sản phẩm đó khỏi giỏ hàng
    if (index > -1) {
      cart.splice(index, 1);
    }
    // Cập nhật giỏ hàng trong localStorage
    localStorage.setItem("cart", JSON.stringify(cart));
    const cartUpdatedEvent = new CustomEvent("cartUpdated");
    document.dispatchEvent(cartUpdatedEvent);
    // Tải lại giỏ hàng
    loadCartFromLocal();
  }
  // Cập nhật tổng giá trong giao diện
  totalAmountElement.textContent = `${totalAmount.toLocaleString()}₫`;
  function updateCart(cart) {
    // Lưu giỏ hàng vào localStorage
    localStorage.setItem("cart", JSON.stringify(cart));
    // Tải lại giao diện
    loadCartFromLocal();
  }
}

// Gọi hàm này khi trang web được tải
document.addEventListener("DOMContentLoaded", loadCartFromLocal);
