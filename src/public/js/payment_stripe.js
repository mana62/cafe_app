"use strict";

document.addEventListener("DOMContentLoaded", function () {
    console.log("Stripe Public Key:", window.stripePublicKey);

    if (!window.stripePublicKey) {
        console.error("Stripe 公開鍵が取得できませんでした。");
        return;
    }

    const stripe = Stripe(window.stripePublicKey);
    const elements = stripe.elements();
    const cardElement = elements.create("card");
    cardElement.mount("#card-element");
    console.log("Card element mounted.");

    const form = document.getElementById("paymentForm");
    form.addEventListener("submit", async (event) => {
        event.preventDefault();

        const submitButton = form.querySelector(".payment__button-submit");
        submitButton.disabled = true;
        submitButton.textContent = "処理中...";

        try {
            const clientSecret = document.getElementById("client_secret").value;
            const orderId = document.getElementById("order_id").value;

            const selectedItems = [];
            const checkboxes = document.querySelectorAll('.item-checkbox:checked');
            checkboxes.forEach(checkbox => {
                selectedItems.push(checkbox.value);
            });

            if (selectedItems.length === 0) {
                alert('アイテムを選択してください');
                submitButton.disabled = false;
                submitButton.textContent = "支払う";
                return;
            }

            const result = await stripe.confirmCardPayment(clientSecret, {
                payment_method: { card: cardElement },
            });

            if (result.error) {
                alert(result.error.message);
                console.error(result.error);
                submitButton.disabled = false;
                submitButton.textContent = "支払う";
                return;
            }

            const response = await axios.post(`/payment/${orderId}`, {
                payment_method: "クレジットカード",
                payment_intent_id: result.paymentIntent.id,
                selected_items: selectedItems,
            }, {
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            });

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