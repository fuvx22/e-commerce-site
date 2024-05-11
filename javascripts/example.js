var topmenu = document.querySelector(".topmenu");
var img = document.querySelectorAll(".topmenu img");

var i = 0;
setInterval(() => {
  if (i == img.length - 1) {
    i = 0;
    var width = img[0].offsetWidth;
    topmenu.style.transform = `translatex(0px)`;
  } else {
    i++;
    var width = img[0].offsetWidth;
    topmenu.style.transform = `translatex(${width * -1 * i}px)`;
  }
}, 4000);

var text = document.querySelector(".text");
var icon = document.getElementsByTagName("p");
var j = 0;
setInterval(() => {
  if (j == length.icon) {
    j = 0;
    var height = icon[0].offsetHeight;
    text.style.transform = `translateY(0px)`;
  } else {
    j++;
    var height = icon[0].offsetHeight;
    text.style.transform = `translateY(${height * j * -2}px)`;
  }
}, 2000);
function thaydoi1(index) {
  var doiicon = document.getElementById("thaydoiicon" + index);
  doiicon.setAttribute("class", "fa-solid fa-chevron-up");
}
function thaydoi2(index) {
  var doiicon = document.getElementById("thaydoiicon" + index);
  doiicon.setAttribute("class", "fa-solid fa-chevron-down");
}
document.getElementById("cart").addEventListener("click", function () {
  document.querySelector(".cart").style = "display:block";
  // document.querySelector(".product").style='display:block';
});
document.getElementById("icon_arrow").addEventListener("click", function () {
  document.querySelector(".cart").style = "display:none";
  //document.querySelector(".product").style='display:none';
});
// Hàm để đọc giỏ hàng từ localStorage và cập nhật giao diện
