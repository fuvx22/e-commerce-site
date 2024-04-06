$(".input-email").keyup(function () {
  const txtEmail = $(".input-email").val();
  $.post("../AJAX/checkEmail.php", { email: txtEmail }, (data) => {
    if (data == "exists") {
      $(".error-email").text("Email Đã Tồn Tại").show();
    } else {
      $(".error-email").text("").hide();
    }
  });
});
