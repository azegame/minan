import { btn_switching, able, disabled, savePreviousOptionId} from './btn_switching.js';
aaaaaaa
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
                const bodyData = makeBodyData(voteButton, chkBtn, previousOptionId);
                fetch('/questionnaires/' + bodyData.questionnaireId,{
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
                    changeBtnAndVoteCount(data, voteButton, previousOptionId, bodyData.currentOptionId)
                    btn_switching();
                    previousOptionId = bodyData.currentOptionId;
                })
                .catch(error => {
                    console.error('エラーが発生しました:', error);
                });
            } else {
                const questionnaireId = voteButton.getAttribute('data-questionnaire-id').trim();
                const currentOptionId = null;
                const bodyData = {
                    questionnaireId: questionnaireId,
                    currentOptionId: currentOptionId,
                    previousOptionId: previousOptionId
                };
                // console.log(previousOptionId);
                fetch('/questionnaires/' + bodyData.questionnaireId,{
                    method: 'DELETE',
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
                    console.log(bodyData.currentOptionId);
                    changeBtnAndVoteCount(data, voteButton, previousOptionId, bodyData.currentOptionId);
                    btn_switching();
                    previousOptionId = bodyData.currentOptionId;
                    console.log(previousOptionId);
                })
                .catch(error => {
                    console.error('エラーが発生しました:', error);
                });
            }
        });
    });
});


const makeBodyData = (voteButton, chkBtn, previousOptionId) => {
    const questionnaireId = voteButton.getAttribute('data-questionnaire-id').trim();
    const currentOptionId = chkBtn.getAttribute('data-option-id').trim();

    const bodyData = {
        questionnaireId: questionnaireId,
        currentOptionId: currentOptionId,
        previousOptionId: previousOptionId
    };
    return bodyData;
}

const changeBtnAndVoteCount = (data, voteButton, previousOptionId, currentOptionId) => {
    if (data) {
        voteButton.setAttribute('data-has-voted', 'true');
        voteButton.textContent = '再投票'
        voteButton.disabled = true;
        voteButton.classList.remove('bg-green-500', 'hover:bg-green-600');
        voteButton.classList.add('bg-green-200', 'hover:bg-green-200');
        
        if (currentOptionId != null){
            document.getElementById('vote-count-' + currentOptionId).textContent = data.newVoteCount;
        }
        
        if (previousOptionId != null) {
            document.getElementById('vote-count-' + previousOptionId).textContent = data.previousVoteCount;
        }
    }
}