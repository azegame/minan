document.querySelector('#add_opt_btn').addEventListener('click', () => {
    const newInput = document.createElement('input');
    newInput.type = 'text';
    newInput.name = 'option_name';

    const newLabel = document.createElement('label');
    newLabel.textContent = '選択肢 : ';
    newLabel.appendChild(newInput);

    // 新しいdivを作成し、labelを追加
    const newDiv = document.createElement('div');
    newDiv.appendChild(newLabel);

    // IDを使って最初の選択肢のdiv要素を特定
    const firstChoiceDiv = document.querySelector('#first-choice');

    // firstChoiceDivの直後に新しいdivを挿入
    firstChoiceDiv.parentNode.insertBefore(newDiv, firstChoiceDiv.nextSibling);
});