document.addEventListener('DOMContentLoaded', function () {
    // let hasVoted = document.body.getAttribute('data-has-voted') === 'true';
    
    const radioBtns = document.querySelectorAll('.switch_btn');
    let voteButton = document.querySelector('.vote-button');
    let hasVoted = voteButton.getAttribute('data-has-voted') === 'true';
    console.log(hasVoted);
    let previousOptionId = null;

    if (hasVoted) {
        console.log('再投票');
        voteButton.textContent = '再投票';
        voteButton.disabled = true;
        radioBtns.forEach(radioBtn => {
            if (radioBtn.checked) {
                previousOptionId = radioBtn.getAttribute('data-option-id').trim();
                console.log(previousOptionId);
            }
         });
        radioBtns.forEach(radioBtn => {
            radioBtn.addEventListener('change', function() {
                if (radioBtn.checked) {
                    let currentOptionId = radioBtn.getAttribute('data-option-id').trim();
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
        console.log('初めての投票');
        voteButton.textContent = '投票';
        voteButton.disabled = true;
        voteButton.classList.remove('bg-green-500', 'hover:bg-green-600');
        voteButton.classList.add('bg-green-200', 'hover:bg-green-200');
        radioBtns.forEach(radioBtn => {
            radioBtn.addEventListener('change', function() {
                if (radioBtn.checked) {
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