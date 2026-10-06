let currentOperandText = '0';
let previousOperandText = '';
let operation = null;

const currentOperandElem = document.getElementById('current-operand');
const previousOperandElem = document.getElementById('previous-operand');
const historyListElem = document.getElementById('history-list');
const historyPanelElem = document.getElementById('history-panel');
const historyToggleBtn = document.querySelector('.history-toggle-btn');

// Toggle History Panel Visibility
function toggleHistory() {
    historyPanelElem.classList.toggle('show');
    historyToggleBtn.classList.toggle('active');
}

function updateDisplay() {
    currentOperandElem.innerText = currentOperandText;
    previousOperandElem.innerText = previousOperandText;
}

function appendNumber(number) {
    if (number === '.' && currentOperandText.includes('.')) return;
    if (currentOperandText === '0' && number !== '.') {
        currentOperandText = number;
    } else {
        currentOperandText += number;
    }
    updateDisplay();
}

function appendOperator(op) {
    if (currentOperandText === '') return;
    if (previousOperandText !== '') {
        compute();
    }
    operation = op;
    previousOperandText = `${currentOperandText} ${op}`;
    currentOperandText = '';
    updateDisplay();
}

function compute() {
    let computation;
    const prev = parseFloat(previousOperandText);
    const current = parseFloat(currentOperandText);
    
    if (isNaN(prev) || isNaN(current)) return;

    switch (operation) {
        case '+':
            computation = prev + current;
            break;
        case '-':
            computation = prev - current;
            break;
        case '*':
            computation = prev * current;
            break;
        case '/':
            computation = prev === 0 ? 0 : prev / current;
            break;
        default:
            return;
    }

    const calculationString = `${previousOperandText} ${currentOperandText} = ${computation}`;
    addHistory(calculationString);

    currentOperandText = computation.toString();
    operation = undefined;
    previousOperandText = '';
    updateDisplay();
}

function addHistory(text) {
    const item = document.createElement('div');
    item.classList.add('history-item');
    item.innerText = text;
    historyListElem.prepend(item);
}

function clearAll() {
    currentOperandText = '0';
    previousOperandText = '';
    operation = null;
    updateDisplay();
}

function deleteDigit() {
    if (currentOperandText.length === 1) {
        currentOperandText = '0';
    } else {
        currentOperandText = currentOperandText.slice(0, -1);
    }
    updateDisplay();
}