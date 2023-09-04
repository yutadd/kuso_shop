window.add2Cart = function (id, name, count) {
  const formData = new FormData();
  formData.append("action", "add2Cart");
  formData.append("productID", id);
  formData.append("count", count);
  const request = new XMLHttpRequest();
  request.open("POST", "cart.php");
  request.send(formData);
  request.onreadystatechange=function(){
    if(request.readyState==4){
      if(request.status==200){
        alert("response: "+request.responseText+"\r\n"+name + "を" + count + "個カートに追加した");
      }else{
        alert(request.responseText)
      }
    }
  }
  /*fetch("/cart.php", {
    method: "POST",
    credentials: "include",
    headers: {
      "Content-Type": "application/json",
      // 'Content-Type': 'application/x-www-form-urlencoded',
    },
    body:JSON.stringify({ "action": "add2Cart", "productID": id, "count": count }),
  }).then((e) => {
    if (e.ok) {
      alert(name + "を" + count + "個カートに追加した");
    } else {
      alert("エラーが発生しました。ログインしていますか？");
    }
  });*/
};
window.updateCart = function (id, name, count) {
  fetch("/cart.php", {
    method: "POST",
    credentials: "include",
    body: { "action": "add2Cart", "productID": id, "count": count },//TODO
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
