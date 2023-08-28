window.add2Cart = function (id, name) {
  fetch("/cart.php", { method: "POST", credentials: "include" }).then((e) => {
    if(e.ok){
      alert(name + "をカートに追加した");
    }
  });
};
