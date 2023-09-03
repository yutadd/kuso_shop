window.add2Cart = function (id, name, count) {
  fetch("/cart.php", {
    method: "POST",
    credentials: "include",
    body: { action: "add2Cart", productID: id, count: count },
  }).then((e) => {
    if (e.ok) {
      alert(name + "を" + count + "個カートに追加した");
    } else {
      alert("エラーが発生しました。ログインしていますか？");
    }
  });
};
window.updateCart = function (id, name, count) {
  fetch("/cart.php", {
    method: "POST",
    credentials: "include",
    body: { action: "add2Cart", productID: id, count: count },//TODO
  }).then((e) => {
    if (e.ok) {
      alert(name + "を" + count + "個にへんこうしました");
    } else {
      alert("エラーが発生しました。");
    }
  });
};
window.deleteFromCart = function (id, name) {
  fetch("/cart.php", {
    method: "POST",
    credentials: "include",
    body: { action: "add2Cart", productID: id },//TODO
  }).then((e) => {
    if (e.ok) {
      alert(name + "を削除しました");
    } else {
      alert("エラーが発生しました。");
    }
  });
};
