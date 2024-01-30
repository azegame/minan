document.addEventListener('DOMContentLoaded', () => {
    const chkBtns = document.querySelectorAll('.switch_btn');
    let voteButton = document.querySelector('.vote-button');
    let hasVoted = voteButton.getAttribute('data-has-voted') === 'true';
    console.log(hasVoted);
    let previousOptionId = null;
    // 再投票の場合
    if (hasVoted) {
        voteButton.textContent = '再投票';
        voteButton.disabled = true;
        chkBtns.forEach(chkBtn => {
            // 現在投票している選択肢を保存
            if (chkBtn.checked) {
                previousOptionId = chkBtn.getAttribute('data-option-id').trim();
                console.log(previousOptionId);
            }
         });
         chkBtns.forEach(chkBtn => {
            chkBtn.addEventListener('change', () => {
                // 今から投票しようとしている選択肢を保存
                if (chkBtn.checked) {
                    let currentOptionId = chkBtn.getAttribute('data-option-id').trim();
                    if (currentOptionId === previousOptionId) {
                        voteButton.classList.remove('bg-green-500', 'hover:bg-green-600');
                        voteButton.classList.add('bg-green-200', 'hover:bg-green-200');
                    } else {
                        voteButton.disabled = false;
                        voteButton.classList.remove('bg-green-200', 'hover:bg-green-200');
                        voteButton.classList.add('bg-green-500', 'hover:bg-green-600');
                    }
                }
            });
        });
        // 未投票の場合
    } else {
        voteButton.textContent = '投票';
        voteButton.disabled = true;
        voteButton.classList.remove('bg-green-500', 'hover:bg-green-600');
        voteButton.classList.add('bg-green-200', 'hover:bg-green-200');
        chkBtns.forEach(chkBtn => {
            chkBtn.addEventListener('change', function() {
                if (chkBtn.checked) {
                    voteButton.disabled = false;
                    voteButton.classList.remove('bg-green-200', 'hover:bg-green-200');
                    voteButton.classList.add('bg-green-500', 'hover:bg-green-600');
                } else {
                    voteButton.disabled = true;
                    voteButton.classList.remove('bg-green-500', 'hover:bg-green-600');
                    voteButton.classList.add('bg-green-200', 'hover:bg-green-200');
                }
            });
            });
    }
});