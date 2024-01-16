document.querySelector('#add_opt_btn').addEventListener('click', () => {
    const newForm = document.createElement('input');
    newForm.type = 'text';
  
    const newLabel = document.createElement('label');
    newLabel.textContent = '選択肢';
  
    newLabel.appendChild(newForm);
    document.querySelector('div').appendChild(newLabel);
  });