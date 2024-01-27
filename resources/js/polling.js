document.addEventListener('DOMContentLoaded', function () {
    const voteButton = document.querySelector('.vote-button');
    const radioBtns = document.querySelectorAll('input[type="radio"]');

        voteButton.addEventListener('click', function() {
            radioBtns.forEach(radioBtn => {
                if (radioBtn.checked) {
                    const questionnaireId = voteButton.getAttribute('data-questionnaire-id').trim();
                    const optionId = radioBtn.getAttribute('data-option-id').trim();
                    
                    fetch('/questionnaires/' + questionnaireId + '/' + optionId,{
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ questionnaireId: questionnaireId, optionId: optionId })
                    })
                    .then(response => {
                        if (response.status === 401) { // 認証エラー
                            window.location.href = '/login';
                            return;
                        } else if (response.status === 409) { // 重複エラー
                            return response.json()
                            .then(data => {
                                alert('同じ選択肢に投票できません！');
                                return; 
                            });
                        } else {
                            return response.json();
                        }
                    })
                    .then(data => {
                        if (data) {
                            document.getElementById('vote-count-' + optionId).textContent = data.newVoteCount;
                        }
                    })
                    .catch(error => {
                        console.error('エラーが発生しました:', error);
                    });
                }
            });
        });
});