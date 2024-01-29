document.addEventListener('DOMContentLoaded', function () {
    // let hasVoted = document.body.getAttribute('data-has-voted') === 'true';
    const radioBtns = document.querySelectorAll('.switch_btn');
    let voteButton = document.querySelector('.vote-button');
    let previousOptionId = null;

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
                console.log(currentOptionId);
                if (currentOptionId === previousOptionId) {
                    voteButton.disabled = true;
                    voteButton.textContent = '再投票';
                    voteButton.classList.remove('bg-green-500', 'hover:bg-green-600');
                    voteButton.classList.add('bg-green-200', 'hover:bg-green-200');
                } else {
                    voteButton.disabled = false;
                    voteButton.textContent = '再投票';
                    voteButton.classList.remove('bg-green-200', 'hover:bg-green-200');
                    voteButton.classList.add('bg-green-500', 'hover:bg-green-600');
                }
            } else {
                voteButton.disabled = true;
            }
        });
    });
});