(function () {
    "use strict";

    const select = (el, all = false) => {
        el = el.trim()
        if (all) {
            return [...document.querySelectorAll(el)]
        } else {
            return document.querySelector(el)
        }
    }

    const on = (type, el, listener, all = false) => {
        if (all) {
            select(el, all).forEach(e => e.addEventListener(type, listener))
        } else {
            select(el, all).addEventListener(type, listener)
        }
    }

    if (select('.toggle-sidebar-btn')) {
        on('click', '.toggle-sidebar-btn', function (e) {
            select('body').classList.toggle('toggle-sidebar')
        })
    }

    $(document).ready(function () {
        $('select').select2();
    });

    const deleteButtons = document.querySelectorAll('[data-bs-toggle="modal"]');

    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var form = document.getElementById('delete-form');
            var action = button.getAttribute('data-bs-action');
            var id = button.getAttribute('data-bs-id');

            if (form) {
                form.action = action.replace(':id', id);
            }
        });
    });

    const forms = document.querySelectorAll("form");
    forms.forEach(form => {
        form.setAttribute("autocomplete", "off");
    });

    const alertBox = document.querySelector('.flash-message');

    if (alertBox) {
        setTimeout(() => {
            alertBox.style.transition = 'opacity 0.5s ease';
            alertBox.style.opacity = '0';

            setTimeout(() => {
                alertBox.remove();
            }, 500);
        }, 5000);
    }
})();
