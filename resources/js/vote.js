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
        .then(response => {
            if (response.status === 401) { // 認証エラー
                window.location.href = '/login';
                return;
            } else if (response.status === 409) { // 重複エラー
                return response.json().then(data => {
                    document.getElementById('vote-count-' + optionId).textContent = data.newVoteCount;
                    alert('同じ選択肢に投票できません！');
                    return; // これ以上の処理を防ぐ
                });
            } else {
                return response.json();
            }
        })
         // dataはアロー関数の引数で、変換されたJSONデータを 'data' として受け取る
        .then(data => {
            // 成功処理
            if (data) {
                document.getElementById('vote-count-' + optionId).textContent = data.newVoteCount;
            }
        })
        .catch(error => {
            console.error('エラーが発生しました:', error);
        });
    });
});
