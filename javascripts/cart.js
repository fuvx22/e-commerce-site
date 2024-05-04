if (!localStorage.getItem("cart")) {
  localStorage.setItem("cart", JSON.stringify([]));
}
function AddToCart() {
  const button = event.target;

  const productId = button.getAttribute("data-product-id");
  const productName = button.getAttribute("data-product-name");
  const productPrice = button.getAttribute("data-product-price");
  const productImg = button.getAttribute("data-product-img");
  const quantity = number;
  const product = {
    id: productId,
    name: productName,
    price: productPrice,
    image: productImg,
    quantity: quantity,
  };
  let cart = JSON.parse(localStorage.getItem("cart"));
  //   Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
  const existingProduct = cart.find((item) => item.id === product.id);
  if (existingProduct) {
    existingProduct.quantity += quantity;
  } else {
    cart.push(product);
  }
  // Lưu giỏ hàng vào localStorage
  localStorage.setItem("cart", JSON.stringify(cart));

  // console.log(cart);
  const successModal = new bootstrap.Modal(
    document.getElementById("successModal")
  );
  successModal.show();
  loadCartFromLocalStorage();
}
function normalizeAndGetFullImagePath(imagePath) {
  // Tách đường dẫn thành các phần bằng dấu '/'
  const pathSegments = imagePath.split("/");
  const normalizedSegments = [];

  // Duyệt qua từng phần của đường dẫn
  for (const segment of pathSegments) {
    if (segment === "" || segment === ".") {
      continue;
    } else if (segment === "..") {
      // Nếu gặp '..', loại bỏ phần tử cuối cùng của normalizedSegments
      if (normalizedSegments.length > 0) {
        normalizedSegments.pop();
      }
    } else {
      // Thêm phần hiện tại vào normalizedSegments
      normalizedSegments.push(segment);
    }
  }

  // Kết hợp lại các phần để tạo đường dẫn chuẩn hóa
  const normalizedPath = normalizedSegments.join("/");

  // Kiểm tra xem đường dẫn đã bắt đầu bằng '/e-commerce-site/' chưa
  if (!normalizedPath.startsWith("e-commerce-site/")) {
    // Nếu chưa, thêm '/e-commerce-site/' vào trước đường dẫn
    return `/e-commerce-site/${normalizedPath}`;
  }
  // Nếu đã, trả về đường dẫn đã chuẩn hóa
  return `/e-commerce-site/${normalizedPath}`;
}
// Hàm để đọc giỏ hàng từ localStorage và cập nhật giao diện
function loadCartFromLocalStorage() {
  const cartData = JSON.parse(localStorage.getItem("cart")) || [];
  const cartElement = document.querySelector("#giohang ul");
  const cartNull = document.querySelector(".cart-null");
  cartElement.innerHTML = ""; // Xóa nội dung cũ
  let totalPrice = 0;
  if (cartData.length === 0) {
    cartNull.textContent = "Hiện Chưa Có Sản Phẩm!";
  } else {
    cartNull.textContent = "";
  }

  // Duyệt qua từng sản phẩm trong giỏ hàng
  cartData.forEach((product, index) => {
    // Tạo phần tử div cho mỗi sản phẩm
    const productDiv = document.createElement("div");
    productDiv.classList.add("cart-item");
    const fullImagePath = normalizeAndGetFullImagePath(product.image);
    // Thêm nội dung cho sản phẩm
    productDiv.innerHTML = `
          <img src="${fullImagePath}" height="80px" width="15%">
          <div class="cart-item-info">
              <a class="product-name" href="/e-commerce-site/pages/product_details.php?id=${
                product.id
              }">${product.name}</a>
              <p class="product-quantity">Số lượng: ${product.quantity}</p>
              <p class="product-price">Giá: ${parseFloat(
                product.price
              ).toLocaleString()}₫</p>
          </div>
          <button class="remove-item" data-index="${index}"><i class="far fa-times"></i></button>
      `;
    cartElement.appendChild(productDiv);
    totalPrice += product.price * product.quantity;
  });

  // Cập nhật tổng tiền trong giao diện
  const totalPriceElement = document.querySelector(".cart_footer span");
  totalPriceElement.textContent = `${totalPrice.toLocaleString()}₫`;
  const removeButtons = document.querySelectorAll(".remove-item");
  removeButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const index = parseInt(button.getAttribute("data-index"));
      removeItemFromCart(index);
    });
  });
}
function removeItemFromCart(index) {
  // Lấy giỏ hàng từ localStorage
  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  // Xóa sản phẩm khỏi giỏ hàng
  cart.splice(index, 1);

  // Lưu lại giỏ hàng đã cập nhật vào localStorage
  localStorage.setItem("cart", JSON.stringify(cart));

  // Cập nhật lại giao diện giỏ hàng
  loadCartFromLocalStorage();
}
document.addEventListener("cartUpdated", function () {
  // Cập nhật phần cart với dữ liệu mới nhất
  loadCartFromLocalStorage();
});

document.addEventListener("DOMContentLoaded", loadCartFromLocalStorage);
