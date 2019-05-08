// 'use strict';
let inputUser = document.getElementById('uid');

inputUser.addEventListener('change', function(e){
  var charCode = e.charCode;
  if (charCode != 0) {
    if (charCode < 97 || charCode > 122) {
      e.preventDefault();
      displayWarning(
        "Please use lowercase letters only."
        + "\n" + "charCode: " + charCode + "\n"
      );
    }
  }
});
