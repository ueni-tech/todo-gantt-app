"use strict";

// ボタンの制御
function isDisabled() {
  $("form").submit(function() {
    $(":submit", this).prop("disabled", true);
  });
}
