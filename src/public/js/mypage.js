document.addEventListener("DOMContentLoaded", function () {
  showTab('profile'); // 初期表示は「ユーザー情報」

  document.querySelectorAll(".tab-btn").forEach(button => {
      button.addEventListener("click", function () {
          showTab(this.getAttribute("onclick").replace("showTab('", "").replace("')", ""));
      });
  });
});

function showTab(tabId) {
  // すべてのタブを非表示にする
  document.querySelectorAll(".tab-content").forEach(tab => {
      tab.classList.remove("active");
  });

  // 選択したタブだけ表示
  document.getElementById(tabId).classList.add("active");

  // すべてのタブボタンの「active」を削除
  document.querySelectorAll(".tab-btn").forEach(button => {
      button.classList.remove("active");
  });

  // クリックしたボタンだけ「active」にする
  document.querySelector(`button[onclick="showTab('${tabId}')"]`).classList.add("active");
}

function toggleEdit(section) {
  const displayDiv = document.getElementById(section + '-display');
  const editDiv = document.getElementById(section + '-edit');

  if (displayDiv.style.display === "none") {
      displayDiv.style.display = "block";
      editDiv.style.display = "none";
  } else {
      displayDiv.style.display = "none";
      editDiv.style.display = "block";
  }

  // お気に入りボタンのJSを作成
  document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".liked-btn").forEach(function(btn) {
        btn.addEventListener("click", function() {
            let productId = this.dataset.productId;
            let tokenElement = document.querySelector('meta[name="csrf-token"]');
            if (!tokenElement) {
                console.error("CSRF token not found");
                return;
            }
            let token = tokenElement.getAttribute("content");

            fetch(`/favorites/${productId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({})
            })
            .then(response => response.text())  // ✅ レスポンスをテキストで受け取る
            .then(text => {
                console.log("Response:", text); // ✅ デバッグ用ログ
                return JSON.parse(text);        // ✅ JSONに変換
            })
            .then(data => {
                if (data.liked) {
                    this.classList.add("liked");
                } else {
                    this.classList.remove("liked");
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
});
}