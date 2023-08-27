window.add2Cart = function (id, name) {
  fetch("/cart.php", { method: "POST", credentials: "include" }).then((e) => {
    e.text().then((t) => {
      alert(name + "をカートに追加した");
    });
  });
};
