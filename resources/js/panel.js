import './bootstrap';
import * as bootstrap from 'bootstrap';
import TomSelect from 'tom-select';

window.bootstrap = bootstrap;
window.TomSelect = TomSelect;

const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

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
