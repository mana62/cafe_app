"use strict";

// スライドさせるコード
document.addEventListener("DOMContentLoaded", function () {
  // ボタンと要素を取得
  const signupButton = document.getElementById("signup"); // SIGN UPボタン
  const signinButton = document.getElementById("signin"); // LOGINボタン
  const pinkbox = document.querySelector(".pinkbox"); // ピンクボックス
  const signinForm = document.querySelector(".signin"); // ログインフォーム
  const signupForm = document.querySelector(".signup"); // サインアップフォーム

  // SIGN UPボタンがクリックされた時
  signupButton.addEventListener("click", function () {
      pinkbox.style.transform = "translateX(80%)"; // 右へスライド
      signinForm.classList.add("nodisplay"); // ログインフォームを非表示
      signupForm.classList.remove("nodisplay"); // サインアップフォームを表示
  });

  // LOGINボタンがクリックされた時
  signinButton.addEventListener("click", function () {
      pinkbox.style.transform = "translateX(0%)"; // 元の位置に戻す
      signupForm.classList.add("nodisplay"); // サインアップフォームを非表示
      signinForm.classList.remove("nodisplay"); // ログインフォームを表示
  });

  // パスワード表示非表示
  document.querySelectorAll(".toggle_password").forEach(button => {
    button.addEventListener("click", () => {
      const passwordInput = button.previousElementSibling; // 直前のパスワード入力欄を取得
            const img = button.querySelector("img"); // ボタン内の画像を取得
            
            if (passwordInput.type === "password") {
                passwordInput.type = "text"; // パスワードを表示
                img.src = "/img/icon/lock_close.png"; // 目を閉じたアイコンに変更
            } else {
                passwordInput.type = "password"; // パスワードを非表示
                img.src = "/img/icon/lock_open.png"; // 目を開けたアイコンに変更
            }
    });
  });
});
