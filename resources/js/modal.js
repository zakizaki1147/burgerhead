document.addEventListener('DOMContentLoaded', function () {
    const openModalButtons = document.querySelectorAll('[data-open-modal]');
    const closeModalButtons = document.querySelectorAll('[data-close-modal]');
    const modals = document.querySelectorAll('[data-modal]');

    openModalButtons.forEach(button => {
        const modalId = button.getAttribute('data-open-modal');
        const modal = document.getElementById(modalId);

        button.addEventListener('click', () => {
            if (!modal) return;

            const type = button.getAttribute('data-type') ?? 'detail';

            if (type === 'update' && modalId === 'modalUpdateOrder') {
                const tableSelect = modal.querySelector('#modalTableId');
                const selectedTableId = button.dataset.tableId;

                if (selectedTableId) {
                    let optionExists = Array.from(tableSelect.options).some(option => option.value === selectedTableId);

                    if (!optionExists) {
                        const option = document.createElement('option');
                        option.value = selectedTableId;
                        option.textContent = `Table #${selectedTableId} (Currently Used)`;
                        tableSelect.appendChild(option);
                    }

                    tableSelect.value = selectedTableId;
                }
            }

            for (const attr of button.attributes) {
                if (!attr.name.startsWith('data-')) continue;

                const attrName = attr.name.replace('data-', '');
                const id = 'modal' + attrName.split('-').map(part => part.charAt(0).toUpperCase() + part.slice(1)).join('');
                const el = modal.querySelector(`#${id}`);

                if (attrName === 'menu-list' && type === 'detail') {
                    const menuList = modal.querySelector('#modalMenuList');
                    if (menuList) {
                        menuList.innerHTML = '';
                        const menus = JSON.parse(attr.value);
                        menus.forEach(menu => {
                            const li = document.createElement('li');
                            li.textContent = `${menu.menu_name} - ${menu.menu_amount}pc(s)`;
                            menuList.appendChild(li);
                        });
                    }
                    continue;
                }

                if (attrName === 'menu-list' && type === 'update') {
                    const menus = JSON.parse(attr.value);
                    if (typeof fillUpdateOrderMenus === 'function') {
                        fillUpdateOrderMenus(menus);
                    }
                    continue;
                }

                if (!el) continue;

                if (type === 'detail') {
                    el.textContent = attr.value || '-';
                }

                else if (type === 'update') {
                    if (el.tagName === 'INPUT' || el.tagName === 'SELECT') {
                        el.value = attr.value;
                    } else {
                        el.textContent = attr.value;
                    }
                }
            }

            if (type === 'update') {
                const formId = button.getAttribute('data-target-form');
                const updateUrl = button.getAttribute('data-update-url');
                if (formId && updateUrl) {
                    const form = modal.querySelector(`form#${formId}`);
                    if (form) {
                        form.setAttribute('action', updateUrl);
                    }
                }
            }

            if (type === 'create') {
                const formId = button.getAttribute('data-target-form');
                const createUrl = button.getAttribute('data-create-url');
                if (formId && createUrl) {
                    const form = modal.querySelector(`form#${formId}`);
                    if (form) {
                        form.setAttribute('action', createUrl);
                    }
                }
            }

            if (type === 'delete') {
                const deleteUrl = button.getAttribute('data-delete-url');
                const form = modal.querySelector('form[data-delete-form]');
                if (deleteUrl && form) {
                    form.setAttribute('action', deleteUrl);
                }
            }

            modal.classList.remove('hidden');
            modal.classList.add('opacity-0');

            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
            })
            document.body.style.overflow = 'hidden';
        });
    });

    function resetForm(modal) {
        const form = modal.querySelector('form');
        if (!form) return;

        form.reset();

        const allSelects = form.querySelectorAll('.menu-select');
        allSelects.forEach(select => {
            select.value = '';
            const options = select.querySelectorAll('option');
            options.forEach(option => option.hidden = false);
        });

        const menuList = form.querySelector('.menu-list');
        if (menuList) {
            const menuGroups = menuList.querySelectorAll('.menu-group');
            menuGroups.forEach((group, index) => {
                if (index > 0) group.remove();
            });
        }

        const addOrderTotalPrice = form.querySelector('#addOrderTotalPrice');
        if (addOrderTotalPrice) {
            addOrderTotalPrice.textContent = '0';
        }

        const addMenuButton = form.querySelector('.add-menu-button');
        if (addMenuButton) {
            addMenuButton.classList.remove('hidden');
        }
    }

    closeModalButtons.forEach(button => {
        button.addEventListener('click', () => {
            const modal = button.closest('[data-modal]');
            if (modal) {
                resetForm(modal);
                modal.classList.remove('opacity-100');
                modal.classList.add('opacity-0');

                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 200);

                document.body.style.overflow = '';
            }
        });
    });

    modals.forEach(modal => {
        modal.addEventListener('click', (e) => {
            const content = modal.querySelector('[data-modal-content]');
            if (content && !content.contains(e.target)) {
                resetForm(modal);
                modal.classList.remove('opacity-100');
                modal.classList.add('opacity-0');

                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 200);

                document.body.style.overflow = '';
            }
        });
    });
});