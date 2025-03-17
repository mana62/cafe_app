"use strict";

// スライド切り替え処理
document.addEventListener("DOMContentLoaded", function () {
    // SIGN UPボタン
    const signupButton = document.getElementById("signup");
    // LOGINボタン
    const signinButton = document.getElementById("signin");
    // ピンクボックス
    const pinkbox = document.querySelector(".pinkbox");
    // ログインフォーム
    const signinForm = document.querySelector(".signin");
    // サインアップフォーム
    const signupForm = document.querySelector(".signup");

    // ページ読み込み時にエラーがある場合の処理
    if (document.querySelector(".signup p.error")) {
        // 新規登録フォームを表示(80%移動させる)
        pinkbox.style.transform = "translateX(80%)";
        // 新規登録フォームを表示してる時は、ログインフォームを隠す
        signinForm.classList.add("nodisplay");
        // 新規登録フォームのnodisplayをremoveして表示
        signupForm.classList.remove("nodisplay");
    } else if (document.querySelector(".signin p.error")) {
        // ログインフォームを表示
        pinkbox.style.transform = "translateX(0%)";
        signupForm.classList.add("nodisplay");
        signinForm.classList.remove("nodisplay");
    }

    // SIGN UPボタンがクリックされた時
    signupButton.addEventListener("click", function () {
        // 右へスライド
        pinkbox.style.transform = "translateX(80%)";
        signinForm.classList.add("nodisplay");
        signupForm.classList.remove("nodisplay");
    });

    // LOGINボタンがクリックされた時
    signinButton.addEventListener("click", function () {
        // 元の位置に戻す
        pinkbox.style.transform = "translateX(0%)";
        signupForm.classList.add("nodisplay");
        signinForm.classList.remove("nodisplay");
    });

    // パスワード表示/非表示の切り替え
    document.querySelectorAll(".toggle_password").forEach((button) => {
        button.addEventListener("click", () => {
            // 直前のパスワード入力欄
            const passwordInput = button.previousElementSibling;
            // ボタン内の画像
            const img = button.querySelector("img");

            if (passwordInput.type === "password") {
                // パスワードを表示
                passwordInput.type = "text";
                // 目を閉じたアイコンに変更
                img.src = "/img/icon/lock_close.png";
            } else {
                // パスワードを非表示
                passwordInput.type = "password";
                // 目を開けたアイコンに変更
                img.src = "/img/icon/lock_open.png";
            }
        });
    });
});
