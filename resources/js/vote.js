import { btn_switching, able, disabled, savePreviousOptionId } from './btn_switching.js';

document.addEventListener('DOMContentLoaded', function () {
    const voteButton = document.querySelector('.vote_button');
    let hasVoted = document.getElementById('hasVoted').value;
    let previousOptionId = null;

    if (hasVoted) {
        previousOptionId = getCheckedOptionId();
        // console.log(previousOptionId);
    }

    voteButton.addEventListener('click', function () {
        let optionId = getCheckedOptionId();
        console.log(optionId);
        // チェック済みの時
        if (optionId > 0) {
            const option = getCheckedOptionById(optionId);
            const bodyData = makeBodyData(voteButton, option, previousOptionId);
            fetch('/questionnaires/' + bodyData.questionnaireId, {
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
                        const userConfirmed = window.confirm('ログインする必要があります。ログインしますか？');
                        if (userConfirmed) {
                            window.location.href = '/login';
                        }
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
            let currentOptionId = null;
            console.log(previousOptionId);
            const questionnaireId = voteButton.value;
            const bodyData = {
                questionnaireId: questionnaireId,
                currentOptionId: currentOptionId,
                previousOptionId: previousOptionId
            };
            fetch('/questionnaires/' + bodyData.questionnaireId, {
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
                        const userConfirmed = window.confirm('ログインする必要があります。ログインしますか？');
                        if (userConfirmed) {
                            window.location.href = '/login';
                        }
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
                    changeBtnAndVoteCount(data, voteButton, previousOptionId, bodyData.currentOptionId);
                    btn_switching();
                    previousOptionId = bodyData.currentOptionId;
                })
                .catch(error => {
                    console.error('エラーが発生しました:', error);
                });
        }
    });
});



const makeBodyData = (voteButton, option, previousOptionId) => {
    const questionnaireId = voteButton.value;
    const currentOptionId = option.value;

    const bodyData = {
        questionnaireId: questionnaireId,
        currentOptionId: currentOptionId,
        previousOptionId: previousOptionId
    };
    console.log(bodyData);
    return bodyData;
}

const changeBtnAndVoteCount = (data, voteButton, previousOptionId, currentOptionId) => {
    if (data) {
        // voteButton.setAttribute('data-has-voted', 'true');
        voteButton.textContent = '再投票'
        voteButton.disabled = true;
        voteButton.classList.remove('bg-green-500', 'hover:bg-green-600');
        voteButton.classList.add('bg-green-200', 'hover:bg-green-200');

        if (currentOptionId != null) {
            document.getElementById('vote-count-' + currentOptionId).textContent = data.newVoteCount;
        }

        if (previousOptionId != null) {
            document.getElementById('vote-count-' + previousOptionId).textContent = data.previousVoteCount;
        }
    }
}

const getCheckedOptionId = () => {
    // const options = document.querySelectorAll('.switch_btn');
    const options = document.getElementsByClassName('switch_btn');
    for (let option of options) {
        if (option.checked) {
            return option.value;
        }
    }
    // for (let i = 0; i < options.length; i++) {
    //     if (options[i].checked) {
    //         return options[i].value;
    //     }
    // };
    return -1;
}




const getCheckedOptionById = (id) => {
    const options = document.querySelectorAll('.switch_btn');
    for (let i = 0; i < options.length; i++) {
        if (options[i].value == id) {
            return options[i];
        }
    };
    return null;
}


const getCheckedOptionById2 = (id) => {
    return document.getElementById(`option-${id}`);
    // const options = document.querySelectorAll('.switch_btn');
    // options.forEach(option => {
    //     if (option.value == id) {
    //         return option;
    //     }
    // });
    // return null;
}


const getCheckedOption = () => {
    return getCheckedOptionById(getCheckedOptionId());
    // const options = document.querySelectorAll('.switch_btn');
    // options.forEach(option => {
    //     if (option.checked) {
    //         return option;
    //     }
    // });
    // return null;
}


