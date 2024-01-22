document.querySelectorAll('.vote-button').forEach(button => {
    button.addEventListener('click', function() {
    const optionId = this.getAttribute('data-option-id').trim();
    fetch('/questionnaires/' + optionId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ optionId: optionId })
    })
    // サーバーからのレスポンスをJSON形式に変換
    .then(response => response.json())
    // dataはアロー関数の引数で、変換されたJSONデータを 'data' として受け取る
    .then(data => {
        document.getElementById('vote-count-' + optionId).textContent = data.newVoteCount;
    });
});
});