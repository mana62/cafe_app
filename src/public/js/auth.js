"use strict";

// 📌 スライド切り替え処理
document.addEventListener("DOMContentLoaded", function () {
    const signupButton = document.getElementById("signup"); // SIGN UPボタン
    const signinButton = document.getElementById("signin"); // LOGINボタン
    const pinkbox = document.querySelector(".pinkbox"); // ピンクボックス
    const signinForm = document.querySelector(".signin"); // ログインフォーム
    const signupForm = document.querySelector(".signup"); // サインアップフォーム

    // 🔹 ページ読み込み時にエラーがある場合の処理
    if (document.querySelector('.signup p.error')) {
        pinkbox.style.transform = "translateX(80%)"; // 新規登録フォームを表示
        signinForm.classList.add("nodisplay");
        signupForm.classList.remove("nodisplay");
    } else if (document.querySelector('.signin p.error')) {
        pinkbox.style.transform = "translateX(0%)"; // ログインフォームを表示
        signupForm.classList.add("nodisplay");
        signinForm.classList.remove("nodisplay");
    }

    // 🔹 SIGN UPボタンがクリックされた時
    signupButton.addEventListener("click", function () {
        pinkbox.style.transform = "translateX(80%)"; // 右へスライド
        signinForm.classList.add("nodisplay");
        signupForm.classList.remove("nodisplay");
    });

    // 🔹 LOGINボタンがクリックされた時
    signinButton.addEventListener("click", function () {
        pinkbox.style.transform = "translateX(0%)"; // 元の位置に戻す
        signupForm.classList.add("nodisplay");
        signinForm.classList.remove("nodisplay");
    });

    // 📌 パスワード表示/非表示の切り替え
    document.querySelectorAll(".toggle_password").forEach(button => {
        button.addEventListener("click", () => {
            const passwordInput = button.previousElementSibling; // 直前のパスワード入力欄
            const img = button.querySelector("img"); // ボタン内の画像

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
