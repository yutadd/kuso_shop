window.add2Cart = function (id, name, count) {
  fetch("/cart.php", {
    method: "POST",
    credentials: "include",
    body: { action: "add2Cart", productID: id, count: count }, //個数
  }).then((e) => {
    if (e.ok) {
      alert(name + "を" + count + "個カートに追加した");
    } else {
      alert("エラーが発生しました。ログインしていますか？");
    }
  });
};
