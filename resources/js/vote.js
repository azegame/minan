document.querySelectorAll('.vote-button').forEach(button => {
    button.addEventListener('click', function() {
    const optionId = this.getAttribute('data-option-id').trim();
    fetch('/questionnaires/' + optionId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            // これ大事
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ optionId: optionId })
    })
    // サーバーからのレスポンスをJSON形式に変換
    .then(response => {
        if (response.status === 401) { // 認証エラーの確認
            window.location.href = '/login';
        }

        if (response.status === 409) { // 409 Conflict
            alert('同じ選択肢に投票できません！');
        }
        return response.json();
    })
    // dataはアロー関数の引数で、変換されたJSONデータを 'data' として受け取る
    .then(data => {
        document.getElementById('vote-count-' + optionId).textContent = data.newVoteCount;
    })
    .catch(error => {
        console.error('エラーが発生しました:', error);
    });
});
});