"use strict";

// DOMContentLoaded イベントは、HTMLの読み込みが完了した時 に実行される
document.addEventListener("DOMContentLoaded", function () {
    // // 初期表示は「ユーザー情報」
    showTab("profile");

    // .tab-btn クラスを持つすべてのボタンにクリックイベントを設定
    document.querySelectorAll(".tab-btn").forEach((button) => {
        // クリックされた時の処理
        button.addEventListener("click", function () {
            showTab(
                // this.getAttribute("onclick") → ボタンの onclick 属性の値を取得
                this.getAttribute("onclick")
                    // .replace(...) で showTab('...') という文字列から '...' の部分だけを取り出す
                    // クリックすると該当のタブが表示されるようにする
                    .replace("showTab('", "")
                    .replace("')", "")
            );
        });
    });
});

function showTab(tabId) {
    // .tab-content クラスを持つすべての要素から active クラスを削除し、非表示 にする
    document.querySelectorAll(".tab-content").forEach((tab) => {
        tab.classList.remove("active");
    });

    // 選択したタブだけ表示
    // tabId に対応する id を持つ要素を取得し、active クラスを追加して表示
    document.getElementById(tabId).classList.add("active");

    // すべてのタブボタンの「active」を削除
    document.querySelectorAll(".tab-btn").forEach((button) => {
        button.classList.remove("active");
    });

    // クリックしたボタンだけ「active」にする
    document
        .querySelector(`button[onclick="showTab('${tabId}')"]`)
        .classList.add("active");
}

// section に応じた id の要素を取得
// （例： profile の場合、profile-display と profile-edit）
function toggleEdit(section) {
    const displayDiv = document.getElementById(section + "-display");
    const editDiv = document.getElementById(section + "-edit");

    // 現在表示されている要素を非表示にし、もう一方を表示する
    if (displayDiv.style.display === "none") {
        displayDiv.style.display = "block";
        editDiv.style.display = "none";
    } else {
        displayDiv.style.display = "none";
        editDiv.style.display = "block";
    }

    // お気に入りボタンのJSを作成
    document.addEventListener("DOMContentLoaded", function () {
        // .liked-btn を持つすべてのボタンにクリックイベントを設定
        document.querySelectorAll(".liked-btn").forEach(function (btn) {
            btn.addEventListener("click", function () {
                // data-product-id 属性を取得し、対象の product_id を取得
                let productId = this.dataset.productId;
                // CSRF（クロスサイトリクエストフォージェリ）対策のためのトークン を取得
                let tokenElement = document.querySelector(
                    'meta[name="csrf-token"]'
                );
                if (!tokenElement) {
                    console.error("CSRF token not found");
                    return;
                }
                let token = tokenElement.getAttribute("content");

                // fetch() を使って POST リクエストを送信し、お気に入りを追加/削除
                fetch(`/favorites/${productId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                    },
                    body: JSON.stringify({}),
                })
                    // レスポンスの liked 状態に応じて、ボタンのスタイルを変更
                    .then((response) => response.text()) // レスポンスをテキストで受け取る
                    .then((text) => {
                        console.log("Response:", text); // デバッグ用ログ
                        return JSON.parse(text); // JSONに変換
                    })
                    .then((data) => {
                        if (data.liked) {
                            this.classList.add("liked");
                        } else {
                            this.classList.remove("liked");
                        }
                    })
                    .catch((error) => console.error("Error:", error));
            });
        });
    });
}
