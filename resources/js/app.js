import './bootstrap';
import * as bootstrap from 'bootstrap';
import TomSelect from 'tom-select';

window.bootstrap = bootstrap;
window.TomSelect = TomSelect;

document.addEventListener('DOMContentLoaded', function () {
    const selectElements = document.querySelectorAll('.tom-select');
    if (selectElements.length > 0) {
        selectElements.forEach(element => {
            new TomSelect(element, {
                plugins: ['remove_button'],
                placeholder: 'Lütfen Seçiniz'
            });
        });
    }
});
