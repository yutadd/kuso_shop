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
  const formData = new FormData();
  formData.append("action", "updateCart");
  formData.append("productID", id);
  formData.append("count", count);
  const request = new XMLHttpRequest();
  request.open("POST", "cart.php");
  request.send(formData);
  request.onreadystatechange=function(){
    if(request.readyState==4){
      if(request.status==200){
        alert("response: "+request.responseText+"\r\nカートの"+name + "を" + count + "個に書き換えました");
      }else{
        alert(request.responseText)
      }
    }
  }
};
window.deleteFromCart = function (id, name) {
  const formData = new FormData();
  formData.append("action", "removeFromCart");
  formData.append("productID", id);
  const request = new XMLHttpRequest();
  request.open("POST", "cart.php");
  request.send(formData);
  request.onreadystatechange=function(){
    if(request.readyState==4){
      if(request.status==200){
        alert("response: "+request.responseText+"\r\n"+name + "を" + "カートから削除した。");
        window.location="/cart.php"
      }else{
        alert(request.responseText);
      }
    }
  }
};
