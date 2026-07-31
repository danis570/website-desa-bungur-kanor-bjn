<!-- ==========================================================
    HEADER
========================================================== -->
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
    <div>
        <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">
            Website Desa Bungur
        </p>
        <h1 class="mt-2 text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900">
            Manajemen Pengguna
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Kelola seluruh pengguna yang memiliki akses ke sistem administrasi Desa Bungur.
        </p>
    </div>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            showToast(
                <?= json_encode($_SESSION['success']) ?>,
                "success"
            );
        });
    </script>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            showToast(
                <?= json_encode($_SESSION['error']) ?>,
                "error"
            );
        });
    </script>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['success_add'])): ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            showToast(
                <?= json_encode($_SESSION['success_add']) ?>,
                "success"
            );
        });
    </script>
    <?php unset($_SESSION['success_add']); ?>
<?php endif; ?>
<!-- ==========================================================
    TOOLBAR
========================================================== -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">

    <div
        class="p-4 flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center border-b border-slate-200">
        <div class="flex items-center gap-3">
            <h2 class="text-sm font-semibold text-slate-900">All Users</h2>
            <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full"
                id="totalBadge">0</span>
        </div>

        <div class="flex items-center gap-3 w-full sm:w-auto">
            <div class="flex items-center gap-2">
                <select id="perPageSelect"
                    class="h-8 px-2 rounded-lg border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <!-- SEARCH -->
            <div class="relative flex-1 sm:flex-none">
                <iconify-icon icon="solar:magnifer-linear"
                    class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" width="16"></iconify-icon>
                <input id="searchInput" type="text" placeholder="Search..."
                    class="w-full sm:w-48 lg:w-64 h-9 rounded-lg border border-slate-200 bg-white pl-9 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition">
            </div>

            <!-- FILTER ROLE -->
            <select id="roleFilter"
                class="h-9 rounded-lg border border-slate-200 bg-white px-3 pr-8 text-sm appearance-none bg-[url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2212%22 height=%2212%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23475569%22 stroke-width=%222%22%3E%3Cpolyline points=%226 9%2012 15%2018 9%22%3E%3C/polyline%3E%3C/svg%3E')] bg-[position:right_8px_center] bg-no-repeat focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition">
                <option value="">All Roles</option>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
            </select>

            <!-- ADD -->
            <a href="/admin/users/add"
                class="h-9 px-3.5 rounded-lg bg-slate-900 text-white hover:bg-black transition text-sm font-medium flex items-center gap-1.5">
                <iconify-icon icon="solar:add-circle-linear" width="16"></iconify-icon>
                Add
            </a>
        </div>
    </div>

    <!-- ==========================================================
        AG GRID
    ========================================================== -->
    <div id="usersGrid" class="ag-theme-quartz" style="height:420px; width:100%;"></div>

    <!-- ==========================================================
        PAGINATION
    ========================================================== -->
    <div
        class="border-t border-slate-200 px-4 py-3 flex flex-col sm:flex-row items-center justify-between gap-3 bg-slate-50/30">
        <div class="text-sm text-slate-500">
            Showing <span id="startRow"></span> to <span id="endRow"></span> of <span id="totalRows"></span>
        </div>

        <div class="flex items-center gap-2">
            <button id="prevPage"
                class="h-8 px-3 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition text-sm font-medium text-slate-700 disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-1">
                <iconify-icon icon="solar:arrow-left-linear" width="14"></iconify-icon>
                Prev
            </button>

            <div id="pageNumbers" class="flex items-center gap-1"></div>

            <button id="nextPage"
                class="h-8 px-3 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition text-sm font-medium text-slate-700 disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-1">
                Next
                <iconify-icon icon="solar:arrow-right-linear" width="14"></iconify-icon>
            </button>
        </div>
    </div>

</div>

<!-- ==========================================================
STYLE
========================================================== -->
<style>
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #F1F5F9;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #CBD5E1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94A3B8;
    }

    .ag-theme-quartz {
        --ag-header-background-color: #F8FAFC;
        --ag-background-color: #FFFFFF;
        --ag-border-color: #F1F5F9;
        --ag-row-border-color: #F1F5F9;
        --ag-header-height: 44px;
        --ag-row-height: 52px;
        --ag-font-family: 'Inter', system-ui, sans-serif;
        --ag-font-size: 14px;
        --ag-row-hover-color: #F8FAFC;
        --ag-selected-row-background-color: #F1F5F9;
        --ag-checkbox-checked-color: #0F172A;
        --ag-checkbox-unchecked-color: #94A3B8;
        --ag-checkbox-background-color: #FFFFFF;
        --ag-checkbox-border-radius: 6px;
        --ag-header-foreground-color: #475569;
        --ag-header-column-separator-display: none;
        --ag-pagination-button-color: #475569;
        --ag-pagination-button-hover-color: #0F172A;
        --ag-pagination-background-color: #FFFFFF;
        --ag-pagination-border-color: #F1F5F9;
        --ag-font-weight: 500;
    }

    .ag-theme-quartz .ag-root-wrapper {
        border: none !important;
        border-radius: 0 !important;
    }

    .ag-theme-quartz .ag-header {
        border-bottom: 1px solid #F1F5F9 !important;
    }

    .ag-theme-quartz .ag-header-cell {
        padding: 0 12px;
        font-size: 11px !important;
        font-weight: 600 !important;
        color: #475569 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.03em !important;
    }

    .ag-theme-quartz .ag-cell {
        padding: 0 12px;
        display: flex;
        align-items: center;
        font-size: 14px;
        color: #0F172A;
    }

    .ag-theme-quartz .ag-row {
        border-bottom: 1px solid #F1F5F9;
    }

    .ag-theme-quartz .ag-row:last-child {
        border-bottom: none;
    }

    .ag-theme-quartz .ag-row-hover {
        background-color: #F8FAFC !important;
    }

    /* Highlight row untuk user yang sedang login */
    .ag-theme-quartz .ag-row.current-user {
        background-color: #F0FDF4 !important;
        border-left: 3px solid #15803D !important;
    }

    .ag-theme-quartz .ag-row.current-user .ag-cell {
        background-color: transparent !important;
    }

    .photo-thumb {
        width: 36px;
        height: 36px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #E2E8F0;
    }

    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .role-admin {
        background: #7C3AED;
        color: #FFFFFF;
    }

    .role-user {
        background: #64748B;
        color: #FFFFFF;
    }

    .position-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        background: #F1F5F9;
        color: #475569;
    }

    .position-badge-ketua {
        background: #FEF3C7;
        color: #92400E;
    }

    .position-badge-wakil {
        background: #DBEAFE;
        color: #1E40AF;
    }

    .position-badge-sekretaris {
        background: #E0E7FF;
        color: #3730A3;
    }

    .position-badge-bendahara {
        background: #D1FAE5;
        color: #065F46;
    }

    .position-badge-koordinator {
        background: #FCE4EC;
        color: #9C27B0;
    }

    .position-badge-anggota {
        background: #F1F5F9;
        color: #475569;
    }

    .current-user-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        background: #15803D;
        color: #FFFFFF;
        margin-left: 6px;
    }

    .page-btn {
        min-width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        color: #475569;
        transition: all 0.15s ease;
        cursor: pointer;
        border: 1px solid transparent;
    }

    .page-btn:hover {
        background: #F1F5F9;
    }

    .page-btn.active {
        background: #0F172A;
        color: #FFFFFF;
        border-color: #0F172A;
    }

    .page-btn.disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    .ag-theme-quartz .ag-header-cell::after {
        content: '';
        position: absolute;
        right: 0;
        top: 25%;
        height: 50%;
        width: 1px;
        background: #E2E8F0;
    }

    .ag-theme-quartz .ag-header-cell:last-child::after {
        display: none;
    }

    .ag-theme-quartz .ag-header-cell[col-id="action"]::after {
        display: none;
    }

    .ag-theme-quartz .ag-header-cell[col-id="ag-Grid-AutoColumn"]::after {
        display: none;
    }

    .ag-theme-quartz .ag-header-cell-resize {
        width: 8px !important;
        cursor: col-resize !important;
        opacity: 1 !important;
        background: transparent !important;
    }

    .ag-theme-quartz .ag-header-cell-resize:hover {
        background: #0F172A !important;
        opacity: 0.3 !important;
    }

    .ag-theme-quartz .ag-header-cell-resize:active {
        background: #0F172A !important;
        opacity: 0.5 !important;
    }

    .ag-theme-quartz .ag-header-cell-resize::after {
        content: '';
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        width: 2px;
        background: transparent;
        transition: background 0.15s ease;
    }

    .ag-theme-quartz .ag-header-cell-resize:hover::after {
        background: #0F172A;
    }

    .ag-theme-quartz .ag-paging-panel {
        display: none !important;
    }

    .ag-theme-quartz .ag-overlay-no-rows-center {
        font-size: 14px;
        color: #94A3B8;
        font-weight: 500;
    }

    .ag-theme-quartz .ag-overlay-no-rows-center::before {
        content: "👤";
        display: block;
        font-size: 40px;
        margin-bottom: 8px;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(.96);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* ==========================================================
       DELETE MODAL STYLING
    ========================================================== */
    #deleteConfirmModal .bg-white {
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }

    .preview-thumb {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #E2E8F0;
    }
</style>

<!-- ==========================================================
JAVASCRIPT
========================================================== -->
<script>
    // ==========================================================
    // DATA (Dummy) - Current User: Admin 1
    // ==========================================================
    const CURRENT_USER_ID = <?= $model['user']->id ?>; // ID Admin yang sedang login

    const allData = <?= json_encode(
        array_map(function ($user) {

                return [
                    "id" => $user->id,
                    "name" => $user->name,
                    "photo" => $user->avatar
                        ? "/uploads/avatar/" . $user->avatar
                        : "https://ui-avatars.com/api/?name=" . urlencode($user->name),
                    "role" => $user->role,
                    "email" => $user->email,
                    "position" => $user->position
                ];

            }, $model['users'])
    ); ?>;

    // ==========================================================
    // STATE
    // ==========================================================
    let gridApi = null;
    let currentPage = 1;
    let itemsPerPage = 10;
    let filteredData = [...allData];

    // ==========================================================
    // RENDERERS
    // ==========================================================

    function NoRenderer(params) {
        const number = (currentPage - 1) * itemsPerPage + params.node.rowIndex + 1;
        return `<span class="text-slate-400 font-medium">${number}</span>`;
    }

    function PhotoRenderer(params) {
        return `<img src="${params.value}" class="photo-thumb" alt="User Photo" loading="lazy">`;
    }

    function NameRenderer(params) {
        const isCurrentUser = params.data.id === CURRENT_USER_ID;
        return `
            <span class="font-medium text-slate-800">${params.value}</span>
            ${isCurrentUser ? '<span class="current-user-badge">Anda</span>' : ''}
        `;
    }

    function RoleRenderer(params) {
        const cls = params.value === 'Admin' ? 'role-admin' : 'role-user';
        return `<span class="role-badge ${cls}">${params.value}</span>`;
    }

    function EmailRenderer(params) {
        return `<span class="text-slate-600">${params.value}</span>`;
    }

    function PositionRenderer(params) {
        const position = params.value || 'Anggota';
        let cls = 'position-badge';

        if (position.toLowerCase().includes('ketua')) {
            cls += ' position-badge-ketua';
        } else if (position.toLowerCase().includes('wakil')) {
            cls += ' position-badge-wakil';
        } else if (position.toLowerCase().includes('sekretaris')) {
            cls += ' position-badge-sekretaris';
        } else if (position.toLowerCase().includes('bendahara')) {
            cls += ' position-badge-bendahara';
        } else if (position.toLowerCase().includes('koordinator')) {
            cls += ' position-badge-koordinator';
        } else {
            cls += ' position-badge-anggota';
        }

        return `<span class="${cls}">${position}</span>`;
    }

    function ActionRenderer(params) {
        const wrapper = document.createElement("div");
        wrapper.className = "flex items-center gap-2";

        // Current user tidak bisa diedit oleh dirinya sendiri
        const isCurrentUser = params.data.id === CURRENT_USER_ID;

        // EDIT - redirect ke halaman edit
        const edit = document.createElement("a");
        edit.href = `/admin/users/edit/${params.data.id}`;
        edit.className = `p-1.5 rounded-lg transition ${isCurrentUser ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'hover:bg-slate-100'}`;
        edit.innerHTML = `<iconify-icon icon="solar:pen-2-linear" width="17"></iconify-icon>`;
        edit.title = isCurrentUser ? "Tidak bisa edit diri sendiri" : "Edit User";

        // DELETE
        const del = document.createElement("button");
        del.className = `p-1.5 rounded-lg transition ${isCurrentUser ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-50 text-red-500'}`;
        del.innerHTML = `<iconify-icon icon="solar:trash-bin-trash-linear" width="17"></iconify-icon>`;
        del.title = isCurrentUser ? "Tidak bisa hapus diri sendiri" : "Hapus";
        if (!isCurrentUser) {
            del.onclick = e => {
                e.stopPropagation();
                openDeleteModal(params.data);
            };
        }

        wrapper.appendChild(edit);
        wrapper.appendChild(del);
        return wrapper;
    }

    // ==========================================================
    // COLUMN DEFINITIONS
    // ==========================================================
    const columnDefs = [
        { headerName: "No", cellRenderer: NoRenderer, width: 70, minWidth: 70, maxWidth: 70, resizable: false, suppressMovable: true },
        { headerName: "Foto", field: "photo", cellRenderer: PhotoRenderer, width: 60, minWidth: 60, maxWidth: 60, resizable: false },
        { headerName: "Nama", field: "name", cellRenderer: NameRenderer, flex: 1, minWidth: 200, resizable: true },
        { headerName: "Role", field: "role", cellRenderer: RoleRenderer, width: 110, minWidth: 90, resizable: true },
        { headerName: "Email", field: "email", cellRenderer: EmailRenderer, width: 200, minWidth: 180, resizable: true },
        { headerName: "Posisi", field: "position", cellRenderer: PositionRenderer, width: 200, minWidth: 150, resizable: true },
        { headerName: "Action", cellRenderer: ActionRenderer, width: 90, minWidth: 90, maxWidth: 90, resizable: false, suppressMovable: true }
    ];

    // ==========================================================
    // GRID OPTIONS
    // ==========================================================
    const gridOptions = {
        columnDefs,
        rowData: [],
        rowHeight: 52,
        headerHeight: 44,
        animateRows: true,
        pagination: false,
        suppressCellFocus: true,
        defaultColDef: {
            sortable: true,
            filter: false,
            resizable: true,
            suppressMenu: true
        },
        overlayNoRowsTemplate: `
            <div class="ag-overlay-no-rows-center flex flex-col items-center gap-2 text-slate-400">
                <span>No Users Found</span>
            </div>
        `,
        getRowStyle: function (params) {
            if (params.data && params.data.id === CURRENT_USER_ID) {
                return {
                    background: '#F0FDF4 !important',
                    borderLeft: '3px solid #15803D !important'
                };
            }
            return null;
        }
    };

    // ==========================================================
    // PAGINATION
    // ==========================================================
    function getTotalPages() {
        return Math.max(1, Math.ceil(filteredData.length / itemsPerPage));
    }

    function getPageData() {
        const start = (currentPage - 1) * itemsPerPage;
        return filteredData.slice(start, start + itemsPerPage);
    }

    function updatePagination() {
        const total = filteredData.length;
        const totalPages = getTotalPages();
        const start = total === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
        const end = total === 0 ? 0 : Math.min(currentPage * itemsPerPage, total);

        document.getElementById("startRow").textContent = start;
        document.getElementById("endRow").textContent = end;
        document.getElementById("totalRows").textContent = total;
        document.getElementById("totalBadge").textContent = total;

        document.getElementById("prevPage").disabled = currentPage <= 1;
        document.getElementById("nextPage").disabled = currentPage >= totalPages || total === 0;

        renderPageNumbers(totalPages);
    }

    function renderPageNumbers(totalPages) {
        const container = document.getElementById("pageNumbers");
        container.innerHTML = "";

        if (filteredData.length === 0) {
            container.innerHTML = `<span class="page-btn disabled">1</span>`;
            return;
        }

        let startPage = Math.max(currentPage - 2, 1);
        let endPage = Math.min(startPage + 4, totalPages);
        startPage = Math.max(1, endPage - 4);

        for (let i = startPage; i <= endPage; i++) {
            const btn = document.createElement("button");
            btn.className = "page-btn" + (i === currentPage ? " active" : "");
            btn.textContent = i;
            btn.onclick = () => { currentPage = i; refreshGrid(); };
            container.appendChild(btn);
        }
    }

    function refreshGrid() {
        if (!gridApi) return;
        gridApi.setGridOption("rowData", getPageData());
        gridApi.refreshCells({ force: true });
        updatePagination();
    }

    function applyFilters() {
        const keyword = document.getElementById("searchInput").value.toLowerCase().trim();
        const role = document.getElementById("roleFilter").value;

        filteredData = allData.filter(item => {
            const matchSearch = item.name.toLowerCase().includes(keyword) ||
                item.email.toLowerCase().includes(keyword) ||
                (item.position && item.position.toLowerCase().includes(keyword));

            // Filter role - case insensitive
            const matchRole = role === "" || item.role.toLowerCase() === role.toLowerCase();

            return matchSearch && matchRole;
        });

        currentPage = 1;
        refreshGrid();
    }

    // ==========================================================
    // DELETE MODAL
    // ==========================================================
    let deleteTarget = null;

    function openDeleteModal(item) {
        deleteTarget = item;
        document.getElementById("deleteTitle").textContent = `"${item.name}"`;
        document.getElementById("deleteId").value = item.id;
        document.getElementById("deleteConfirmModal").classList.remove("hidden");
    }

    function closeDeleteModal() {
        document.getElementById("deleteConfirmModal").classList.add("hidden");
        deleteTarget = null;
    }

    function confirmDelete() {

        if (!deleteTarget) return;


        const form = document.createElement('form');

        form.method = "POST";
        form.action = "/admin/users/delete";


        const input = document.createElement('input');

        input.type = "hidden";
        input.name = "id";
        input.value = deleteTarget.id;


        form.appendChild(input);


        document.body.appendChild(form);


        form.submit();

    }

    // ==========================================================
    // TOAST
    // ==========================================================
    function showToast(message, type = 'info') {
        const oldToast = document.querySelector('.custom-toast');
        if (oldToast) oldToast.remove();

        const toast = document.createElement('div');
        toast.className = 'custom-toast fixed bottom-6 right-6 z-[99999] px-6 py-4 rounded-2xl shadow-2xl text-white text-sm font-medium max-w-md transition-all duration-300';

        const colors = {
            success: 'bg-green-600',
            error: 'bg-red-600',
            info: 'bg-blue-600',
            warning: 'bg-amber-600'
        };

        toast.className += ` ${colors[type] || colors.info}`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // ==========================================================
    // INITIALIZE
    // ==========================================================
    document.addEventListener("DOMContentLoaded", () => {
        const gridDiv = document.querySelector("#usersGrid");
        gridApi = agGrid.createGrid(gridDiv, gridOptions);
        refreshGrid();

        document.getElementById("searchInput").addEventListener("input", applyFilters);
        document.getElementById("roleFilter").addEventListener("change", applyFilters);

        document.getElementById("perPageSelect").addEventListener("change", function () {
            itemsPerPage = Number(this.value);
            currentPage = 1;
            refreshGrid();
        });

        document.getElementById("prevPage").addEventListener("click", () => {
            if (currentPage > 1) { currentPage--; refreshGrid(); }
        });
        document.getElementById("nextPage").addEventListener("click", () => {
            if (currentPage < getTotalPages()) { currentPage++; refreshGrid(); }
        });

        // DELETE MODAL EVENTS
        document.getElementById("deleteCancelBtn").addEventListener("click", closeDeleteModal);
        document.getElementById("deleteConfirmBtn").addEventListener("click", confirmDelete);
        document.getElementById("deleteBackdrop").addEventListener("click", closeDeleteModal);

        document.addEventListener("keydown", e => {
            if ((e.ctrlKey || e.metaKey) && e.key === "k") {
                e.preventDefault();
                document.getElementById("searchInput").focus();
            }
            if (e.key === "Escape") {
                closeDeleteModal();
            }
        });

        document.querySelector('#deleteConfirmModal .bg-white')?.addEventListener('click', e => e.stopPropagation());
    });
</script>

<!-- ==========================================================
DELETE MODAL
========================================================== -->
<div id="deleteConfirmModal" class="fixed inset-0 z-[99999] hidden">
    <div id="deleteBackdrop" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="relative z-10 flex items-center justify-center min-h-screen p-6">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden animate-[fadeIn_.2s_ease]">
            <div class="flex justify-center pt-8">
                <div class="w-20 h-20 rounded-full bg-red-100 flex items-center justify-center">
                    <iconify-icon icon="solar:trash-bin-trash-linear" width="40" class="text-red-500"></iconify-icon>
                </div>
            </div>
            <div class="p-8 text-center">
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Hapus Pengguna?</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Apakah Anda yakin ingin menghapus pengguna
                    <strong class="text-slate-900" id="deleteTitle"></strong>?
                    <br>
                    <span class="text-red-500">Tindakan ini tidak dapat dibatalkan!</span>
                </p>
                <input type="hidden" id="deleteId" value="">
            </div>
            <div class="flex gap-3 p-6 pt-0">
                <button id="deleteCancelBtn"
                    class="flex-1 px-4 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 transition text-sm font-medium">Batal</button>
                <button id="deleteConfirmBtn"
                    class="flex-1 px-4 py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white transition text-sm font-medium flex items-center justify-center gap-2">
                    <iconify-icon icon="solar:trash-bin-trash-linear" width="18"></iconify-icon>
                    Hapus
                </button>

            </div>
        </div>
    </div>
</div>