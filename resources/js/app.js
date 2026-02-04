import './bootstrap';
import 'bootstrap-icons/font/bootstrap-icons.css';

document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebarToggle');

    toggle?.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');

        localStorage.setItem(
            'sidebar-collapsed',
            sidebar.classList.contains('collapsed') ? '1' : '0'
        );
    });

    if (localStorage.getItem('sidebar-collapsed') === '1') {
        sidebar.classList.add('collapsed');
    }
});

document.addEventListener('DOMContentLoaded', () => {
    let activeDropdown = null;

    document.querySelectorAll('.has-dropdown').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();

            const key = link.dataset.dropdown;
            const menu = document.querySelector(
                `.sidebar-dropdown[data-dropdown-menu="${key}"]`
            );

            if (!menu) return;

            // toggle
            if (activeDropdown === menu) {
                menu.style.display = 'none';
                activeDropdown = null;
                return;
            }

            // close previous
            document.querySelectorAll('.sidebar-dropdown')
                .forEach(d => d.style.display = 'none');

            // position
            const rect = link.getBoundingClientRect();

            menu.style.top = `${rect.top}px`;
            menu.style.left = `${rect.right + 12}px`;
            menu.style.display = 'block';

            activeDropdown = menu;
        });
    });

    // close on outside click
    document.addEventListener('click', e => {
        if (
            activeDropdown &&
            !e.target.closest('.sidebar-dropdown') &&
            !e.target.closest('.has-dropdown')
        ) {
            activeDropdown.style.display = 'none';
            activeDropdown = null;
        }
    });
});