"use strict";

document.addEventListener("DOMContentLoaded", function () {
    // window.stripePublicKey をコンソールに表示（デバッグ用
    console.log("Stripe Public Key:", window.stripePublicKey);

    // 公開鍵が設定されていない場合、エラーを出して処理を中断
    if (!window.stripePublicKey) {
        console.error("Stripe 公開鍵が取得できません");
        return;
    }

    // Stripe(window.stripePublicKey) → Stripeオブジェクトを作成
    const stripe = Stripe(window.stripePublicKey);
    const elements = stripe.elements();
    //.elements().create("card") → カード入力フォームを作成
    const cardElement = elements.create("card");
    //.mount("#card-element") → #card-element にフォームを埋め込む
    cardElement.mount("#card-element");
    console.log("Card element mounted.");

    // フォームが送信された時の処理
    const form = document.getElementById("paymentForm");
    form.addEventListener("submit", async (event) => {
        // event.preventDefault(); で ページのリロードを防ぐ
        event.preventDefault();

        const submitButton = form.querySelector(".payment__button-submit");
        // 送信ボタンを無効化し、「処理中...」に変更
        submitButton.disabled = true;
        submitButton.textContent = "処理中...";

        try {
            // サーバーから渡された client_secret と order_id を取得
            const clientSecret = document.getElementById("client_secret").value;
            const orderId = document.getElementById("order_id").value;

            const selectedItems = [];
            const checkboxes = document.querySelectorAll(
                ".item-checkbox:checked"
            );
            checkboxes.forEach((checkbox) => {
                selectedItems.push(checkbox.value);
            });

            if (selectedItems.length === 0) {
                alert("商品を選択してください");
                submitButton.disabled = false;
                submitButton.textContent = "支払う";
                return;
            }

            // confirmCardPayment(clientSecret, {...}) で 決済を実行
            const result = await stripe.confirmCardPayment(clientSecret, {
                payment_method: { card: cardElement },
            });

            // 決済に失敗した場合はエラーを表示し、ボタンを元に戻す
            if (result.error) {
                alert(result.error.message);
                console.error(result.error);
                submitButton.disabled = false;
                submitButton.textContent = "支払う";
                return;
            }

            // サーバーへ決済結果を送信
            // 決済情報をサーバーへ送信
            const response = await axios.post(
                `/payment/${orderId}`,
                {
                    payment_method: "クレジットカード",
                    payment_intent_id: result.paymentIntent.id,
                    selected_items: selectedItems,
                },
                {
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                }
            );

            // 成功したら完了画面へリダイレクト
            if (response.data.succeeded) {
                window.location.href = "/thanks-buy";
            } else {
                alert(response.data.message || "支払い処理に失敗しました");
                if (response.data.error_details) {
                    console.error(response.data.error_details);
                }
                submitButton.disabled = false;
                submitButton.textContent = "支払う";
            }
        } catch (error) {
            alert("支払い処理に失敗しました");
            console.error(error);
            submitButton.disabled = false;
            submitButton.textContent = "支払う";
        }
    });
});
