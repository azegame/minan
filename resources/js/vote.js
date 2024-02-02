import { btn_switching, able, disabled, savePreviousOptionId} from './btn_switching.js';

document.addEventListener('DOMContentLoaded', function () {
    const voteButton = document.querySelector('.vote-button');
    const chkBtns = document.querySelectorAll('.switch_btn');
    let hasVoted = voteButton.getAttribute('data-has-voted') === 'true';
    let previousOptionId = null;

    if (hasVoted) {
        previousOptionId = savePreviousOptionId(chkBtns);
    }

        voteButton.addEventListener('click', function() {
            chkBtns.forEach(chkBtn => {
                if (chkBtn.checked) {
                    const questionnaireId = voteButton.getAttribute('data-questionnaire-id').trim();
                    const currentOptionId = chkBtn.getAttribute('data-option-id').trim();

                    const bodyData = { 
                        questionnaireId: questionnaireId, 
                        currentOptionId: currentOptionId,
                        previousOptionId: previousOptionId // ここで以前の選択肢IDを送信
                    };

                    fetch('/questionnaires/' + questionnaireId,{
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(bodyData)
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
                            
                            document.getElementById('vote-count-' + currentOptionId).textContent = data.newVoteCount;
                            if (previousOptionId) {
                                document.getElementById('vote-count-' + previousOptionId).textContent = data.previousVoteCount;
                            }
                            
                            btn_switching();
                            previousOptionId = currentOptionId;
                        }
                    })
                    .catch(error => {
                        console.error('エラーが発生しました:', error);
                    });
                }
            });
        });
});