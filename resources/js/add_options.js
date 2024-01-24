document.querySelector('#add_opt_btn').addEventListener('click', () => {
    const newInput = document.createElement('input');
    newInput.type = 'text';
    newInput.name = 'option_name[]';

    const newLabel = document.createElement('label');
    newLabel.textContent = '選択肢 : ';
    newLabel.appendChild(newInput);

    // 新しいrelative divを作成し、labelを追加
    const newRelativeDiv = document.createElement('div');
    newRelativeDiv.className = 'relative';
    newRelativeDiv.appendChild(newLabel);

    // 新しいp-4 w-full divを作成し、relative divを追加
    const newDiv = document.createElement('div');
    newDiv.className = 'p-4 w-full';
    newDiv.appendChild(newRelativeDiv);

    const parentDiv = document.querySelector('#parentDiv');
    parentDiv.appendChild(newDiv);
});





