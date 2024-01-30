document.addEventListener('DOMContentLoaded', function () {
    const voteButton = document.querySelector('.vote-button');
    const chkBtns = document.querySelectorAll('.switch_btn');

        voteButton.addEventListener('click', function() {
            chkBtns.forEach(chkBtn => {
                if (chkBtn.checked) {
                    const questionnaireId = voteButton.getAttribute('data-questionnaire-id').trim();
                    const optionId = chkBtn.getAttribute('data-option-id').trim();

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
                            voteButton.setAttribute('data-has-voted', 'true');
                            voteButton.textContent = '再投票'
                            voteButton.disabled = true;
                            voteButton.classList.remove('bg-green-500', 'hover:bg-green-600');
                            voteButton.classList.add('bg-green-200', 'hover:bg-green-200');

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