"use strict";

// DOMContentLoaded イベント → ページが完全に読み込まれた後に処理を実行
document.addEventListener("DOMContentLoaded", () => {
    // .liked-btn クラスのすべてのボタンを取得し、クリックイベントを追加
    document.querySelectorAll(".liked-btn").forEach((button) => {
        button.addEventListener("click", function () {
            // data-product-id から 商品ID を取得し、toggleFavorite 関数を呼び出す
            const productId = this.getAttribute("data-product-id");
            toggleFavorite(this, productId);
        });
    });
});

function toggleFavorite(button, productId) {
    // button.classList.contains("liked") → ボタンが「いいね済み」かどうかを判定
    const isLiked = button.classList.contains("liked");

    // button.classList.toggle("liked") → 見た目を即時変更
    button.classList.toggle("liked");

    // fetch() でサーバーにリクエストを送信（POST）
    fetch(`/favorites/${productId}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            // X-CSRF-TOKEN → CSRF対策のトークンを送信
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content"),
        },
        body: JSON.stringify({ liked: !isLiked }),
    })
        .then((response) => {
            if (!response.ok) {
                // レスポンスが正常 (response.ok) でなければエラーをスロー
                throw new Error("サーバーエラー: " + response.status);
            }
            return response.json();
        })
        // サーバーのレスポンスを受けて、ボタンのスタイルを変更
        .then((data) => {
            if (data.liked) {
                button.classList.add("liked");
            } else {
                button.classList.remove("liked");
            }
        })

        // エラーが発生した場合は元の状態に戻す
        .catch((error) => {
            console.error("Error:", error);
            button.classList.toggle("liked");
            alert("お気に入りの更新に失敗しました");
        });
}

// レビューの星評価のイベントリスナー
document.addEventListener("DOMContentLoaded", function () {
    // .review__stars label → 星の要素 を取得
    const stars = document.querySelectorAll(".review__stars label");
    // ratingInput → 選択した評価をフォームにセットするための hidden input
    const ratingInput = document.getElementById("rating-value");

    stars.forEach((star) => {
        star.addEventListener("click", function () {
            // クリックされた星の data-value を取得
            const value = this.getAttribute("data-value");
            // ratingInput.value = value; → 選択した評価を保存
            ratingInput.value = value;

            // クリックした星まで色を変更
            stars.forEach((s) => {
                s.classList.remove("selected");
                if (s.getAttribute("data-value") <= value) {
                    s.classList.add("selected");
                }
            });
        });
    });
});
