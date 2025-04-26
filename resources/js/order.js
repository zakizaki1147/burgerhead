document.addEventListener('DOMContentLoaded', function () {
    const updateModal = document.querySelector('#modalUpdateOrder');
    const createModal = document.querySelector('#modalAddOrder');

    function initModal(modal) {
        setupAddMenu(modal);
        attachHandlers(modal);
    }

    // Fungsi umum untuk handle Add Menu (bisa dipakai di update & create)
    function setupAddMenu(modal) {
        const menuList = modal.querySelector('.menu-list');
        const menuGroupTemplate = menuList.querySelector('.menu-group');
        const addMenuButton = modal.querySelector('.add-menu-button');

        if (!menuList || !menuGroupTemplate || !addMenuButton) return;

        addMenuButton.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const currentCount = menuList.querySelectorAll('.menu-group').length;
            if (currentCount >= 5) return;

            const newGroup = menuGroupTemplate.cloneNode(true);
            newGroup.querySelector('.menu-select').value = '';
            newGroup.querySelector('.amount-input').value = '1';
            newGroup.querySelector('.remove-menu-button').classList.remove('hidden');
            menuList.appendChild(newGroup);

            attachHandlers(modal);
            updateRemoveButtons(modal);
            updateMenuOptions();

            if (currentCount + 1 >= 5) {
                addMenuButton.classList.add('hidden');
            }
        });

        updateRemoveButtons(modal); // Cek awal jika sudah 5
        updateMenuOptions();
    }

    // Fungsi attach handler (khusus untuk modal tertentu)
    function attachHandlers(modal) {
        const decreaseButtons = modal.querySelectorAll('.decrease-amount-button');
        const increaseButtons = modal.querySelectorAll('.increase-amount-button');
        const removeButtons = modal.querySelectorAll('.remove-menu-button');
        const allSelects = modal.querySelectorAll('.menu-select');

        allSelects.forEach(select => {
            select.onchange = updateMenuOptions;
        });

        decreaseButtons.forEach(button => {
            button.onclick = () => {
                const amountInput = button.closest('.menu-group').querySelector('.amount-input');
                const currentValue = parseInt(amountInput.value);
                if (currentValue > 1) {
                    amountInput.value = currentValue - 1;
                }
            };
        });

        increaseButtons.forEach(button => {
            button.onclick = () => {
                const amountInput = button.closest('.menu-group').querySelector('.amount-input');
                amountInput.value = parseInt(amountInput.value) + 1;
            };
        });

        removeButtons.forEach(button => {
            button.onclick = (e) => {
                e.preventDefault();
                e.stopPropagation();
                const menuList = modal.querySelector('.menu-list');
                const addMenuButton = modal.querySelector('.add-menu-button');
                button.closest('.menu-group').remove();

                updateRemoveButtons(modal);
                updateMenuOptions();
                updateModal();

                // Munculkan lagi tombol Add kalau kurang dari 5
                if (menuList.querySelectorAll('.menu-group').length < 5) {
                    addMenuButton.classList.remove('hidden');
                }
            };
        });
    }

    // Fungsi helper untuk handle tombol remove dan batas menu
    function updateRemoveButtons(modal) {
        const menuGroups = modal.querySelectorAll('.menu-group');
        menuGroups.forEach((group, index) => {
            const removeButton = group.querySelector('.remove-menu-button');
            if (index === 0) {
                removeButton.classList.add('hidden');
            } else {
                removeButton.classList.remove('hidden');
            }
        });

        const addMenuButton = modal.querySelector('.add-menu-button');
        if (menuGroups.length >= 5) {
            addMenuButton.classList.add('hidden');
        } else {
            addMenuButton.classList.remove('hidden');
        }
    }

    function updateMenuOptions() {
        const allSelects = document.querySelectorAll('.menu-select');
        const selectedValues = Array.from(allSelects).map(select => select.value).filter(value => value !== '');

        allSelects.forEach(select => {
            const options = select.querySelectorAll('option');

            options.forEach(option => {
                if (option.value === '') return;
                const isSelectedBefore = selectedValues.includes(option.value) && option.value !== select.value;
                option.hidden = isSelectedBefore;
            });
        });
    }

    // Setup untuk masing-masing modal
    if (updateModal) initModal(updateModal);
    if (createModal) initModal(createModal);

    // Fungsi update dari luar
    window.fillUpdateOrderMenus = function (menus) {
        const menuList = updateModal.querySelector('.menu-list');
        const menuGroupTemplate = menuList.querySelector('.menu-group');

        menuList.innerHTML = '';
        menus.forEach((menu, index) => {
            const newMenuGroup = menuGroupTemplate.cloneNode(true);
            newMenuGroup.querySelector('.menu-select').value = menu.menu_id;
            newMenuGroup.querySelector('.amount-input').value = menu.menu_amount;

            if (index > 0) {
                newMenuGroup.querySelector('.remove-menu-button').classList.remove('hidden');
            }

            menuList.appendChild(newMenuGroup);
        });

        attachHandlers(updateModal);
        updateRemoveButtons(updateModal);
        updateMenuOptions();
    }
});
