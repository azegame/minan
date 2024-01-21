document.querySelectorAll('.vote-button').forEach(button => {
    button.addEventListener('click', function() {
    const optionId = this.getAttribute('data-option-id').trim();
    fetch('/questionnaires/' + optionId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ optionId: optionId })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('vote-count-' + optionId).textContent = '投票数: ' + data.newVoteCount;
    });
});
});