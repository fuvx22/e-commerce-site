let emailChecked = false;

$(".input-email").keyup(function () {
  const txtEmail = $(".input-email").val();
  $.post("../AJAX/checkEmail.php", { email: txtEmail }, (data) => {
    if (data == "exists") {
      $(".error-email").text("Email Đã Tồn Tại").show();
      emailChecked = true;
    } else {
      $(".error-email").text("").hide();
      emailChecked = false;
    }
    // Kiểm tra hợp lệ của form sau khi kiểm tra email
  });
});

function passConfirmation() {
  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirmPassword").value;
  const message = document.getElementById("Message");

  // Kiểm tra xem cả hai ô nhập mật khẩu có giá trị hay không
  if (password === "" && confirmPassword === "") {
    message.style.display = "none"; // Ẩn thông báo nếu cả hai ô đều trống
    return true; // Kết thúc hàm nếu cả hai ô đều trống
  }

  // Kiểm tra sự khớp nhau của mật khẩu
  if (password === confirmPassword) {
    message.style.display = "inline-block";
    message.innerHTML = "Password matches";
    return true;
  } else {
    message.style.display = "inline-block";
    message.innerHTML = "Password do not match";
    return false;
  }
}

function checkFormValidity() {
  if (!emailChecked && passConfirmation()) {
    // Form hợp lệ, cho phép gửi đi
    return true;
  } else {
    // Form không hợp lệ, ngăn chặn việc gửi đi
    return false;
  }
}
