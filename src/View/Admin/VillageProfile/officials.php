<!-- ==========================================================
HEADER
========================================================== -->
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
    <div>
        <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">
            Website Desa Bungur
        </p>
        <h1 class="mt-2 text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900">
            Manajemen Aparatur Desa
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Kelola seluruh data perangkat desa yang akan ditampilkan pada website resmi Desa Bungur.
        </p>
    </div>
</div>

<!-- ==========================================================
FLASH MESSAGES
========================================================== -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="mb-6 px-6 py-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg flex items-center justify-between">
        <div class="flex items-center gap-3">
            <iconify-icon icon="solar:check-circle-linear" class="text-2xl text-green-500"></iconify-icon>
            <span><?= htmlspecialchars($_SESSION['success']) ?></span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
            <iconify-icon icon="solar:close-circle-linear" class="text-xl"></iconify-icon>
        </button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="mb-6 px-6 py-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg flex items-center justify-between">
        <div class="flex items-center gap-3">
            <iconify-icon icon="solar:danger-circle-linear" class="text-2xl text-red-500"></iconify-icon>
            <span><?= htmlspecialchars($_SESSION['error']) ?></span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
            <iconify-icon icon="solar:close-circle-linear" class="text-xl"></iconify-icon>
        </button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- ==========================================================
TOOLBAR
========================================================== -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">

    <div class="p-4 flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center border-b border-slate-200">
        <div class="flex items-center gap-3">
            <h2 class="text-sm font-semibold text-slate-900">All Aparatur</h2>
            <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full" id="totalBadge">
                <?= count($model['officials'] ?? []) ?>
            </span>
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
                <input id="searchInput" type="text" placeholder="Cari aparatur..."
                    class="w-full sm:w-48 lg:w-64 h-9 rounded-lg border border-slate-200 bg-white pl-9 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition">
            </div>

            <!-- ADD -->
            <a href="/admin/profile/officials/add"
                class="h-9 px-3.5 rounded-lg bg-slate-900 text-white hover:bg-black transition text-sm font-medium flex items-center gap-1.5">
                <iconify-icon icon="solar:add-circle-linear" width="16"></iconify-icon>
                Tambah
            </a>
        </div>
    </div>

    <!-- ==========================================================
    AG GRID
    ========================================================== -->
    <div id="aparaturGrid" class="ag-theme-quartz" style="height:420px; width:100%;"></div>

    <!-- ==========================================================
    PAGINATION
    ========================================================== -->
    <div class="border-t border-slate-200 px-4 py-3 flex flex-col sm:flex-row items-center justify-between gap-3 bg-slate-50/30">
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

    .position-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0 12px;
        height: 30px;
        box-sizing: border-box;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .position-kades { background: #15803D; color: #FFFFFF; }
    .position-sekdes { background: #2563EB; color: #FFFFFF; }
    .position-kaur { background: #7C3AED; color: #FFFFFF; }
    .position-kasi { background: #DC2626; color: #FFFFFF; }
    .position-staf { background: #6B7280; color: #FFFFFF; }
    .position-other { background: #8B5CF6; color: #FFFFFF; }

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
    .page-btn:hover { background: #F1F5F9; }
    .page-btn.active { background: #0F172A; color: #FFFFFF; border-color: #0F172A; }
    .page-btn.disabled { opacity: 0.3; cursor: not-allowed; }

    .ag-theme-quartz .ag-header-cell::after {
        content: '';
        position: absolute;
        right: 0;
        top: 25%;
        height: 50%;
        width: 1px;
        background: #E2E8F0;
    }
    .ag-theme-quartz .ag-header-cell:last-child::after { display: none; }
    .ag-theme-quartz .ag-header-cell[col-id="action"]::after { display: none; }
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
</style>

<script src="https://cdn.jsdelivr.net/npm/ag-grid-community@31.3.2/dist/ag-grid-community.min.js">
</script>

<script>
    // ==========================================================
    // DATA FROM PHP
    // ==========================================================
    const allData = <?= json_encode($model['officials'] ?? []) ?>;

    // ==========================================================
    // STATE
    // ==========================================================
    let gridApi = null;
    let currentPage = 1;
    let itemsPerPage = 10;
    let filteredData = [...allData];

    // ==========================================================
    // POSITION CLASS MAP
    // ==========================================================
    const positionClasses = {
        'Kepala Desa': 'position-kades',
        'Sekretaris Desa': 'position-sekdes',
        'Kaur Keuangan': 'position-kaur',
        'Kaur Umum': 'position-kaur',
        'Kaur Perencanaan': 'position-kaur',
        'Kasi Pemerintahan': 'position-kasi',
        'Kasi Kesejahteraan': 'position-kasi',
        'Kasi Pelayanan': 'position-kasi',
        'Staf Desa': 'position-staf'
    };

    // ==========================================================
    // RENDERERS
    // ==========================================================

    function NoRenderer(params) {
        const number = (currentPage - 1) * itemsPerPage + params.node.rowIndex + 1;
        return `<span class="text-slate-400 font-medium">${number}</span>`;
    }

    function PhotoRenderer(params) {
        const name = params.data.name || 'Aparatur';
        const photo = params.value;
        
        if (photo) {
            return `<img src="/uploads/official/${encodeURIComponent(photo)}" 
                         class="w-10 h-10 rounded-full object-cover border-2 border-slate-200" 
                         alt="${encodeURIComponent(name)}"
                         onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&size=80&background=15803d&color=fff'">`;
        }
        return `<img src="https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&size=80&background=15803d&color=fff" 
                     class="w-10 h-10 rounded-full object-cover border-2 border-slate-200" 
                     alt="${encodeURIComponent(name)}">`;
    }

    function NameRenderer(params) {
        return `<span class="font-medium text-slate-800">${params.value || '-'}</span>`;
    }

    function PositionRenderer(params) {
        const cls = positionClasses[params.value] || 'position-other';
        return `<span class="position-badge ${cls}">${params.value || '-'}</span>`;
    }

    function StatusRenderer(params) {
        if (params.value) {
            return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                Aktif
            </span>`;
        }
        return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
            <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
            Nonaktif
        </span>`;
    }

    function ActionRenderer(params) {
        const id = params.data.id || 0;
        const name = params.data.name || '';
        
        return `
            <div class="flex items-center gap-2">
                <a href="/admin/profile/officials/edit/${id}" 
                   class="p-1.5 rounded-lg hover:bg-slate-100 transition inline-flex" title="Edit">
                    <iconify-icon icon="solar:pen-2-linear" width="17"></iconify-icon>
                </a>
                <button onclick="openDeleteModal(${id}, '${name.replace(/'/g, "\\'")}')" 
                        class="p-1.5 rounded-lg hover:bg-red-50 text-red-500 transition" title="Hapus">
                    <iconify-icon icon="solar:trash-bin-trash-linear" width="17"></iconify-icon>
                </button>
            </div>
        `;
    }

    // ==========================================================
    // COLUMN DEFINITIONS
    // ==========================================================
    const columnDefs = [
        { headerName: "No", cellRenderer: NoRenderer, width: 70, minWidth: 70, maxWidth: 70, resizable: false },
        { headerName: "Nama", field: "name", cellRenderer: NameRenderer, flex: 1, minWidth: 180, resizable: true },
        { headerName: "Jabatan", field: "position", cellRenderer: PositionRenderer, width: 180, minWidth: 160, resizable: true },
        { headerName: "Periode", field: "period", width: 130, minWidth: 110, resizable: true },
        { headerName: "Status", field: "isActive", cellRenderer: StatusRenderer, width: 110, minWidth: 90, resizable: true },
        { headerName: "Aksi", cellRenderer: ActionRenderer, width: 90, minWidth: 90, maxWidth: 90, resizable: false }
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
                <span class="text-4xl">👤</span>
                <span>Belum ada data aparatur</span>
                <a href="/admin/profile/officials/add" class="text-primary hover:underline text-sm">Tambah aparatur</a>
            </div>
        `
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

        filteredData = allData.filter(item => {
            const matchSearch = (item.name || '').toLowerCase().includes(keyword) ||
                (item.position || '').toLowerCase().includes(keyword) ||
                (item.email || '').toLowerCase().includes(keyword) ||
                (item.period || '').toLowerCase().includes(keyword);
            return matchSearch;
        });

        currentPage = 1;
        refreshGrid();
    }

    // ==========================================================
    // DELETE MODAL
    // ==========================================================
    function openDeleteModal(id, name) {
        document.getElementById('deleteId').value = id;
        document.getElementById('deleteTitle').textContent = name;
        document.getElementById('deleteConfirmModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteConfirmModal').classList.add('hidden');
    }

    // ==========================================================
    // INITIALIZE
    // ==========================================================
    document.addEventListener("DOMContentLoaded", () => {
        const gridDiv = document.querySelector("#aparaturGrid");
        gridApi = agGrid.createGrid(gridDiv, gridOptions);
        refreshGrid();

        document.getElementById("searchInput").addEventListener("input", applyFilters);

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

        document.getElementById("deleteCancelBtn").addEventListener("click", closeDeleteModal);
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
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Hapus Aparatur?</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Apakah Anda yakin ingin menghapus data aparatur
                    <strong class="text-slate-900" id="deleteTitle"></strong>?
                    <br>
                    <span class="text-red-500">Tindakan ini tidak dapat dibatalkan!</span>
                </p>
            </div>
            <form action="/admin/profile/officials/delete" method="POST" class="flex gap-3 p-6 pt-0">
                <input type="hidden" id="deleteId" name="id" value="">
                <button type="button" id="deleteCancelBtn"
                    class="flex-1 px-4 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 transition text-sm font-medium">Batal</button>
                <button type="submit"
                    class="flex-1 px-4 py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white transition text-sm font-medium flex items-center justify-center gap-2">
                    <iconify-icon icon="solar:trash-bin-trash-linear" width="18"></iconify-icon>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>