document.addEventListener('DOMContentLoaded', function () {
    const button = document.querySelector('.vote-button');
    const optionId = button.getAttribute('data-option-id').trim();
    // ここでサーバーサイドから渡されたユーザーの投票状況を確認
    // 例: const hasVoted = (ここにサーバーからのデータを使用する);
    if (hasVoted) {
        button.textContent = '再投票';
    }
});