"use strict";

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".liked-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const productId = this.getAttribute("data-product-id");
            toggleFavorite(this, productId);
        });
    });
});

function toggleFavorite(button, productId) {
    const isLiked = button.classList.contains("liked");

    // クリック時にハートの見た目を即時反映
    button.classList.toggle("liked");

    // ✅ 正しいエンドポイントに修正
    fetch(`/favorites/${productId}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute("content"),
        },
        body: JSON.stringify({ liked: !isLiked }),
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error("サーバーエラー: " + response.status);
        }
        return response.json();
    })
    .then((data) => {
        if (data.liked) {
            button.classList.add("liked");
        } else {
            button.classList.remove("liked");
        }
    })
    .catch((error) => {
        console.error("Error:", error);
        button.classList.toggle("liked"); // エラー時に元の状態に戻す
        alert("お気に入りの更新に失敗しました");
    });
}

// ⭐ レビューの星評価のイベントリスナー
document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll(".review__stars label");
    const ratingInput = document.getElementById("rating-value");

    stars.forEach(star => {
        star.addEventListener("click", function () {
            const value = this.getAttribute("data-value");
            ratingInput.value = value; // ⭐ 評価の値を hidden input にセット

            // ⭐ クリックした星まで色を変更
            stars.forEach(s => {
                s.classList.remove("selected");
                if (s.getAttribute("data-value") <= value) {
                    s.classList.add("selected");
                }
            });
        });
    });
});
