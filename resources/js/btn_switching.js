document.addEventListener('DOMContentLoaded', function () {
    //const voteButtonStr = document.querySelector('.vote-button').textContent;
    const radioBtns = document.querySelectorAll('.switch_btn');
    const optionId = null;
    if (radioBtns.defaultChecked) {
        optionId = radioBtn.getAttribute('data-option-id').trim();
    }

    radioBtns.forEach(radioBtn => {
        radioBtn.addEventListener('change', function() {
            updateButtonState(!$hasVoted);
            const optionId = radioBtn.getAttribute('data-option-id').trim();
        });
    });

    function updateButtonState(active) {
        if (active) {
            voteButton.disabled = false;
            voteButton.textContent = '投票';
            voteButton.classList.remove('vote-button-inactive');
            voteButton.classList.add('vote-button-active');
        } else {
            voteButton.disabled = true;
            voteButton.textContent = '再投票';
            voteButton.classList.remove('vote-button-active');
            voteButton.classList.add('vote-button-inactive');
        }
    }

});