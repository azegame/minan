document.addEventListener('DOMContentLoaded', () => {
    const chkBtns = document.querySelectorAll('.switch_btn');
    chkBtns.forEach(chkBtn => {
        chkBtn.addEventListener('change', () => {
            if (chkBtn.checked) {
                chkBtns.forEach(otherChkBtn => {
                    if (chkBtn != otherChkBtn) {
                        otherChkBtn.checked = false;
                    }
                }); 
            }
        });
    });
    
});