document.addEventListener('DOMContentLoaded', () => {
    btn_switching();
});


export const able = (voteButton) => {
    voteButton.disabled = false;
    voteButton.classList.remove('bg-green-200', 'hover:bg-green-200');
    voteButton.classList.add('bg-green-500', 'hover:bg-green-600');
}

export const disabled = (voteButton) => {
    voteButton.disabled = true;
    voteButton.classList.remove('bg-green-500', 'hover:bg-green-600');
    voteButton.classList.add('bg-green-200', 'hover:bg-green-200');
}

export const savePreviousOptionId = (chkBtns) => {
    let previousOptionId = null;
    chkBtns.forEach(chkBtn => {
        // 現在投票している選択肢を保存
        if (chkBtn.checked) {
            previousOptionId = chkBtn.getAttribute('data-option-id').trim();
            // console.log(previousOptionId);
        }
    });
    return previousOptionId;
}

export const btn_switching = () => {
    const chkBtns = document.querySelectorAll('.switch_btn');
    let voteButton = document.querySelector('.vote-button');
    let hasVoted = voteButton.getAttribute('data-has-voted') === 'true';
    let previousOptionId = null;

    // 再投票の場合
    if (hasVoted) {
        previousOptionId = savePreviousOptionId(chkBtns);
        chkBtns.forEach(chkBtn => {
            chkBtn.addEventListener('change', () => {
                // 今から投票しようとしている選択肢を保存
                if (chkBtn.checked) {
                    let currentOptionId = chkBtn.getAttribute('data-option-id').trim();
                    if (currentOptionId === previousOptionId) {
                        disabled(voteButton);
                    } else {
                        able(voteButton);
                    }
                    console.log(currentOptionId);
                }
            });
        });
        
    // 未投票の場合
    } else {
        disabled(voteButton);
        chkBtns.forEach(chkBtn => {
            chkBtn.addEventListener('change', () => {
                if (chkBtn.checked) {
                    able(voteButton);
                } else {
                    disabled(voteButton);
                }
            });
            });
    }
}