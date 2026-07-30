<?php include '../Layouts/header.php' ?>

<!-- ==========================================================
    HEADER
========================================================== -->
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
    <div>
        <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">
            Website Desa Bungur
        </p>
        <h1 class="mt-2 text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900">
            Manajemen UMKM
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Kelola seluruh UMKM yang akan ditampilkan pada website resmi Desa Bungur.
        </p>
    </div>
</div>

<!-- ==========================================================
    TOOLBAR
========================================================== -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">

    <div
        class="p-4 flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center border-b border-slate-200">
        <div class="flex items-center gap-3">
            <h2 class="text-sm font-semibold text-slate-900">All UMKM</h2>
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
                    <option value="500">500</option>
                    <option value="1000">1000</option>
                </select>
            </div>

            <!-- SEARCH -->
            <div class="relative flex-1 sm:flex-none">
                <iconify-icon icon="solar:magnifer-linear"
                    class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" width="16"></iconify-icon>
                <input id="searchInput" type="text" placeholder="Search..."
                    class="w-full sm:w-48 lg:w-64 h-9 rounded-lg border border-slate-200 bg-white pl-9 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition">
            </div>

            <!-- ADD -->
            <button id="addBtn"
                class="h-9 px-3.5 rounded-lg bg-slate-900 text-white hover:bg-black transition text-sm font-medium flex items-center gap-1.5">
                <iconify-icon icon="solar:add-circle-linear" width="16"></iconify-icon>
                Add
            </button>
        </div>
    </div>

    <!-- ==========================================================
        AG GRID
    ========================================================== -->
    <div id="umkmGrid" class="ag-theme-quartz" style="height:420px; width:100%;"></div>

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

    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .category-kuliner {
        background: #FEF3C7;
        color: #92400E;
    }

    .category-kerajinan {
        background: #EDE9FE;
        color: #5B21B6;
    }

    .category-kesehatan {
        background: #DCFCE7;
        color: #166534;
    }

    .category-pertanian {
        background: #D1FAE5;
        color: #065F46;
    }

    .category-peternakan {
        background: #DBEAFE;
        color: #1E40AF;
    }

    .category-jasa {
        background: #E0E7FF;
        color: #3730A3;
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
        content: "🏪";
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

    .product-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        background: #F8FAFC;
        border-radius: 12px;
        border: 1px solid #F1F5F9;
    }

    .product-item .product-info {
        flex: 1;
    }

    .product-item .product-name {
        font-weight: 600;
        font-size: 14px;
        color: #0F172A;
    }

    .product-item .product-price {
        font-size: 13px;
        color: #16A34A;
        font-weight: 600;
    }

    .product-item .product-remove {
        color: #EF4444;
        cursor: pointer;
        padding: 4px;
        border-radius: 6px;
        transition: background 0.15s;
    }

    .product-item .product-remove:hover {
        background: #FEE2E2;
    }

    .product-item img {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
    }

    .product-input-row {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 8px;
        align-items: center;
    }

    .product-input-row input {
        padding: 6px 10px;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        font-size: 13px;
        outline: none;
        transition: border 0.15s;
    }

    .product-input-row input:focus {
        border-color: #0F172A;
        box-shadow: 0 0 0 2px rgba(15, 23, 42, 0.1);
    }

    .product-input-row .btn-add-product {
        padding: 6px 14px;
        border-radius: 8px;
        background: #0F172A;
        color: white;
        border: none;
        font-size: 13px;
        cursor: pointer;
        transition: background 0.15s;
        white-space: nowrap;
    }

    .product-input-row .btn-add-product:hover {
        background: #000000;
    }

    /* ==========================================================
       MODAL STYLING - PERBAIKAN
    ========================================================== */
    #formModal .bg-white {
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }

    #formContent {
        max-height: 55vh;
        overflow-y: auto;
        padding: 4px 6px;
    }

    #formContent::-webkit-scrollbar {
        width: 5px;
    }

    #formContent::-webkit-scrollbar-track {
        background: #F1F5F9;
        border-radius: 10px;
    }

    #formContent::-webkit-scrollbar-thumb {
        background: #CBD5E1;
        border-radius: 10px;
    }

    #formContent::-webkit-scrollbar-thumb:hover {
        background: #94A3B8;
    }

    #closeModalBtn {
        transition: all 0.2s ease;
    }

    #closeModalBtn:hover {
        background: #F1F5F9;
    }

    #closeModalBtn:hover iconify-icon {
        color: #0F172A;
    }

    #deleteConfirmModal .bg-white {
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }
</style>

<!-- ==========================================================
JAVASCRIPT
========================================================== -->
<script>
    // ==========================================================
    // DATA (Dummy)
    // ==========================================================
    const allData = [
        {
            id: 1,
            name: "Keripik Pisang Bungur",
            owner: "Siti Aminah",
            category: "Kuliner",
            address: "Dusun Bungur RT 02 RW 03, Kecamatan Kanor, Kabupaten Bojonegoro",
            hero_image: "https://picsum.photos/seed/umkm1/1200/500",
            hours: "08.00 - 17.00 WIB",
            wa: "6281234567890",
            embed_map: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.123456!2d112.123456!3d-7.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDcnMjQuNSJTIDExMsKwMDcnMjQuNSJF!5e0!3m2!1sid!2sid!4v1234567890",
            products: [
                { name: "Keripik Original", price: "Rp 10.000", image: "https://picsum.photos/seed/prod1/200/200" },
                { name: "Keripik Coklat", price: "Rp 15.000", image: "https://picsum.photos/seed/prod2/200/200" }
            ]
        },
        {
            id: 2,
            name: "Batik Tulis Bungur",
            owner: "Mulyono",
            category: "Kerajinan",
            address: "Dusun Krajan RT 01 RW 02, Kecamatan Kanor, Kabupaten Bojonegoro",
            hero_image: "https://picsum.photos/seed/umkm2/1200/500",
            hours: "09.00 - 16.00 WIB",
            wa: "6281234567891",
            embed_map: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.123457!2d112.123457!3d-7.123457!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDcnMjQuNSJTIDExMsKwMDcnMjQuNSJF!5e0!3m2!1sid!2sid!4v1234567891",
            products: [
                { name: "Batik Motif Bungur", price: "Rp 150.000", image: "https://picsum.photos/seed/prod4/200/200" },
                { name: "Batik Motif Padi", price: "Rp 200.000", image: "https://picsum.photos/seed/prod5/200/200" }
            ]
        },
        {
            id: 3,
            name: "Tempe Bungur Sehat",
            owner: "Slamet Riyadi",
            category: "Kuliner",
            address: "Dusun Selatan RT 03 RW 01, Kecamatan Kanor, Kabupaten Bojonegoro",
            hero_image: "https://picsum.photos/seed/umkm3/1200/500",
            hours: "06.00 - 18.00 WIB",
            wa: "6281234567892",
            embed_map: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.123458!2d112.123458!3d-7.123458!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDcnMjQuNSJTIDExMsKwMDcnMjQuNSJF!5e0!3m2!1sid!2sid!4v1234567892",
            products: [
                { name: "Tempe Segar", price: "Rp 5.000", image: "https://picsum.photos/seed/prod6/200/200" },
                { name: "Tempe Oven", price: "Rp 7.000", image: "https://picsum.photos/seed/prod7/200/200" }
            ]
        }
    ];

    // ==========================================================
    // STATE
    // ==========================================================
    let gridApi = null;
    let currentPage = 1;
    let itemsPerPage = 10;
    let filteredData = [...allData];
    let tempProducts = [];
    let tempHeroImage = null;
    let tempProductImages = [];

    // ==========================================================
    // RENDERERS
    // ==========================================================

    function NoRenderer(params) {
        const number = (currentPage - 1) * itemsPerPage + params.node.rowIndex + 1;
        return `<span class="text-slate-400 font-medium">${number}</span>`;
    }

    function NameRenderer(params) {
        return `<div class="w-full truncate font-medium text-slate-800" title="${params.value}">${params.value}</div>`;
    }

    function OwnerRenderer(params) {
        return `<span class="text-slate-600">${params.value ?? "-"}</span>`;
    }

    function CategoryRenderer(params) {
        const map = {
            'Kuliner': 'category-kuliner',
            'Kerajinan': 'category-kerajinan',
            'Kesehatan': 'category-kesehatan',
            'Pertanian': 'category-pertanian',
            'Peternakan': 'category-peternakan',
            'Jasa': 'category-jasa'
        };
        const cls = map[params.value] || 'bg-slate-100 text-slate-700';
        return `<span class="category-badge ${cls}">${params.value}</span>`;
    }

    function AddressRenderer(params) {
        return `<span class="text-slate-600 text-sm truncate" title="${params.value}">${params.value ?? "-"}</span>`;
    }

    function ActionRenderer(params) {
        const wrapper = document.createElement("div");
        wrapper.className = "flex items-center gap-2";

        const edit = document.createElement("button");
        edit.className = "p-1.5 rounded-lg hover:bg-slate-100 transition";
        edit.innerHTML = `<iconify-icon icon="solar:pen-2-linear" width="17"></iconify-icon>`;
        edit.title = "Edit UMKM";
        edit.onclick = e => {
            e.stopPropagation();
            openFormModal('edit', params.data);
        };

        const del = document.createElement("button");
        del.className = "p-1.5 rounded-lg hover:bg-red-50 text-red-500 transition";
        del.innerHTML = `<iconify-icon icon="solar:trash-bin-trash-linear" width="17"></iconify-icon>`;
        del.title = "Hapus";
        del.onclick = e => {
            e.stopPropagation();
            openDeleteModal(params.data);
        };

        wrapper.appendChild(edit);
        wrapper.appendChild(del);
        return wrapper;
    }

    // ==========================================================
    // COLUMN DEFINITIONS
    // ==========================================================
    const columnDefs = [
        { headerName: "No", cellRenderer: NoRenderer, width: 70, minWidth: 70, maxWidth: 70, resizable: false, suppressMovable: true },
        { headerName: "Nama UMKM", field: "name", cellRenderer: NameRenderer, flex: 1, minWidth: 200, resizable: true },
        { headerName: "Pemilik", field: "owner", cellRenderer: OwnerRenderer, width: 160, minWidth: 140, resizable: true },
        { headerName: "Kategori", field: "category", cellRenderer: CategoryRenderer, width: 130, minWidth: 110, resizable: true },
        { headerName: "Alamat", field: "address", cellRenderer: AddressRenderer, flex: 1, minWidth: 200, resizable: true },
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
                <span class="text-4xl">🏪</span>
                <span>No UMKM Found</span>
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
            const matchSearch = item.name.toLowerCase().includes(keyword) ||
                item.owner.toLowerCase().includes(keyword) ||
                item.category.toLowerCase().includes(keyword) ||
                item.address.toLowerCase().includes(keyword);
            return matchSearch;
        });

        currentPage = 1;
        refreshGrid();
    }

    // ==========================================================
    // FORM MODAL
    // ==========================================================
    let currentEditId = null;

    function openFormModal(mode, data = null) {
        const modal = document.getElementById("formModal");
        const title = document.getElementById("formModalTitle");

        if (mode === 'add') {
            currentEditId = null;
            title.textContent = 'Tambah UMKM';
            tempProducts = [];
            tempHeroImage = null;
            tempProductImages = [];
        } else {
            currentEditId = data.id;
            title.textContent = 'Edit UMKM';
            tempProducts = data.products ? JSON.parse(JSON.stringify(data.products)) : [];
            tempHeroImage = data.hero_image || null;
        }

        renderForm(data);
        renderProducts();

        modal.classList.remove("hidden");
    }

    function renderForm(data) {
        const container = document.getElementById("formContent");
        const categories = ['Kuliner', 'Kerajinan', 'Kesehatan', 'Pertanian', 'Peternakan', 'Jasa'];
        const categoryOptions = categories.map(cat =>
            `<option value="${cat}" ${data && data.category === cat ? 'selected' : ''}>${cat}</option>`
        ).join('');

        container.innerHTML = `
            <form id="umkmForm" class="p-6" enctype="multipart/form-data">
                <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-2">
                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama UMKM <span class="text-red-500">*</span></label>
                        <input type="text" id="formName" value="${data ? data.name : ''}" 
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                            placeholder="Masukkan nama UMKM..." required>
                    </div>

                    <!-- Pemilik -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Pemilik <span class="text-red-500">*</span></label>
                        <input type="text" id="formOwner" value="${data ? data.owner : ''}" 
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                            placeholder="Masukkan nama pemilik..." required>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select id="formCategory" 
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10">
                            ${categoryOptions}
                        </select>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                        <input type="text" id="formAddress" value="${data ? data.address : ''}" 
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                            placeholder="Masukkan alamat lengkap...">
                    </div>

                    <!-- Foto Utama - Upload -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Foto Utama</label>
                        ${data && data.hero_image ? `
                            <div class="mb-2">
                                <img src="${data.hero_image}" class="w-32 h-32 object-cover rounded-xl border border-slate-200" alt="Hero Image">
                                <p class="text-xs text-slate-400 mt-1">Gambar saat ini</p>
                            </div>
                        ` : ''}
                        <input type="file" id="formHeroImage" accept="image/*"
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                        <p class="text-xs text-slate-400 mt-1">Upload foto utama UMKM (JPG, PNG, WEBP)</p>
                    </div>

                    <hr class="border-slate-200">

                    <!-- INFO USAHA -->
                    <div class="bg-slate-50 rounded-xl p-4">
                        <h4 class="font-semibold text-slate-700 mb-3">Info Usaha</h4>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Jam Operasional</label>
                                <input type="text" id="formHours" value="${data ? data.hours : ''}" 
                                    class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                                    placeholder="08.00 - 17.00 WIB">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Kontak WA</label>
                                <input type="text" id="formWa" value="${data ? data.wa : ''}" 
                                    class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                                    placeholder="6281234567890">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Embed Google Maps</label>
                                <input type="text" id="formEmbedMap" value="${data ? data.embed_map : ''}" 
                                    class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                                    placeholder="https://www.google.com/maps/embed?pb=...">
                                <p class="text-xs text-slate-400 mt-1">Copy link embed dari Google Maps</p>
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-200">

                    <!-- MENU / PRODUK -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-semibold text-slate-700">Menu / Produk</h4>
                        </div>

                        <!-- Input tambah produk -->
                        <div class="product-input-row mb-3">
                            <input type="text" id="productNameInput" placeholder="Nama produk..." class="w-full">
                            <input type="text" id="productPriceInput" placeholder="Harga..." class="w-full">
                            <button type="button" id="addProductBtn" class="btn-add-product">+ Tambah</button>
                        </div>

                        <!-- Upload foto produk -->
                        <div class="mb-3">
                            <label class="block text-xs font-medium text-slate-500 mb-1">Upload Foto Produk</label>
                            <input type="file" id="productImageInput" accept="image/*"
                                class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                            <p class="text-xs text-slate-400 mt-1">Upload foto untuk produk berikutnya</p>
                        </div>

                        <div id="productsContainer" class="space-y-2"></div>
                    </div>
                </div>

                <div class="flex gap-3 mt-6 pt-6 border-t">
                    <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-black transition">
                        Simpan
                    </button>
                    <button type="button" id="formCancelBtn" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 transition">
                        Batal
                    </button>
                </div>
            </form>
        `;

        document.getElementById("formCancelBtn").onclick = closeFormModal;
        document.getElementById("addProductBtn").onclick = addProductFromInput;
        document.getElementById("umkmForm").onsubmit = saveUMKM;

        // Enter key untuk tambah produk
        document.getElementById("productNameInput").addEventListener("keydown", function (e) {
            if (e.key === "Enter") { e.preventDefault(); addProductFromInput(); }
        });
        document.getElementById("productPriceInput").addEventListener("keydown", function (e) {
            if (e.key === "Enter") { e.preventDefault(); addProductFromInput(); }
        });
    }

    function addProductFromInput() {
        const nameInput = document.getElementById("productNameInput");
        const priceInput = document.getElementById("productPriceInput");
        const imageInput = document.getElementById("productImageInput");

        const name = nameInput.value.trim();
        const price = priceInput.value.trim();

        if (!name || !price) {
            showToast('⚠️ Nama dan harga produk wajib diisi!', 'warning');
            return;
        }

        // Simpan image jika ada
        let imageUrl = null;
        if (imageInput.files && imageInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imageUrl = e.target.result;
                tempProducts.push({ name, price, image: imageUrl });
                nameInput.value = '';
                priceInput.value = '';
                imageInput.value = '';
                nameInput.focus();
                renderProducts();
            };
            reader.readAsDataURL(imageInput.files[0]);
        } else {
            // Tanpa gambar
            tempProducts.push({ name, price, image: `https://picsum.photos/seed/${Date.now()}/200/200` });
            nameInput.value = '';
            priceInput.value = '';
            imageInput.value = '';
            nameInput.focus();
            renderProducts();
        }
    }

    function renderProducts() {
        const container = document.getElementById("productsContainer");
        if (!container) return;

        if (tempProducts.length === 0) {
            container.innerHTML = `
                <div class="text-center text-slate-400 text-sm py-4 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                    <iconify-icon icon="solar:bag-2-linear" width="28" class="mx-auto mb-1 opacity-50"></iconify-icon>
                    Belum ada produk
                </div>
            `;
            return;
        }

        container.innerHTML = tempProducts.map((product, index) => `
            <div class="product-item">
                <img src="${product.image || 'https://picsum.photos/seed/prod' + index + '/200/200'}" alt="${product.name}">
                <div class="product-info">
                    <div class="product-name">${product.name}</div>
                    <div class="product-price">${product.price}</div>
                </div>
                <button type="button" class="product-remove" onclick="removeProduct(${index})">
                    <iconify-icon icon="solar:trash-bin-trash-linear" width="16"></iconify-icon>
                </button>
            </div>
        `).join('');
    }

    function removeProduct(index) {
        tempProducts.splice(index, 1);
        renderProducts();
    }

    function closeFormModal() {
        document.getElementById("formModal").classList.add("hidden");
        currentEditId = null;
        tempProducts = [];
        tempHeroImage = null;
    }

    function saveUMKM(e) {
        e.preventDefault();

        const name = document.getElementById("formName").value.trim();
        const owner = document.getElementById("formOwner").value.trim();
        const category = document.getElementById("formCategory").value;
        const address = document.getElementById("formAddress").value.trim();
        const hours = document.getElementById("formHours").value.trim();
        const wa = document.getElementById("formWa").value.trim();
        const embed_map = document.getElementById("formEmbedMap").value.trim();
        const heroImageInput = document.getElementById("formHeroImage");

        if (!name || !owner || !address) {
            showToast('⚠️ Nama, Pemilik, dan Alamat wajib diisi!', 'warning');
            return;
        }

        // Handle hero image upload
        let hero_image = null;
        if (heroImageInput.files && heroImageInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                hero_image = e.target.result;
                saveData(hero_image);
            };
            reader.readAsDataURL(heroImageInput.files[0]);
        } else {
            // Jika tidak upload baru, pakai yang lama atau default
            const existing = allData.find(i => i.id === currentEditId);
            hero_image = existing ? existing.hero_image : `https://picsum.photos/seed/${Date.now()}/1200/500`;
            saveData(hero_image);
        }

        function saveData(hero_image) {
            const umkmData = {
                name,
                owner,
                category,
                address,
                hero_image: hero_image || `https://picsum.photos/seed/${Date.now()}/1200/500`,
                hours: hours || '08.00 - 17.00 WIB',
                phone: '0812-3456-7890',
                wa: wa || '6281234567890',
                embed_map: embed_map || '',
                products: tempProducts.length > 0 ? tempProducts : [
                    { name: 'Produk 1', price: 'Rp 10.000', image: 'https://picsum.photos/seed/prod1/200/200' }
                ]
            };

            if (currentEditId) {
                const index = allData.findIndex(i => i.id === currentEditId);
                if (index !== -1) {
                    allData[index] = { ...allData[index], ...umkmData };
                    applyFilters();
                    showToast(`✅ UMKM "${name}" berhasil diupdate`, 'success');
                    closeFormModal();
                }
            } else {
                const newId = Math.max(...allData.map(i => i.id), 0) + 1;
                allData.push({ id: newId, ...umkmData });
                applyFilters();
                showToast(`✅ UMKM "${name}" berhasil ditambahkan`, 'success');
                closeFormModal();
            }
        }
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
        const index = allData.findIndex(i => i.id === deleteTarget.id);
        if (index !== -1) {
            const name = allData[index].name;
            allData.splice(index, 1);
            applyFilters();
            showToast(`🗑️ UMKM "${name}" berhasil dihapus`, 'warning');
            closeDeleteModal();
        }
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
        const gridDiv = document.querySelector("#umkmGrid");
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

        document.getElementById("addBtn").addEventListener("click", () => {
            openFormModal('add');
        });

        // ✅ FORM MODAL EVENTS - SEMUA TERPASANG
        document.getElementById("closeModalBtn").addEventListener("click", closeFormModal);
        document.getElementById("formCancelBtn").addEventListener("click", closeFormModal);
        document.getElementById("formBackdrop").addEventListener("click", closeFormModal);

        // ✅ DELETE MODAL EVENTS
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
                closeFormModal();
            }
        });

        document.querySelector('#formModal .bg-white')?.addEventListener('click', e => e.stopPropagation());
        document.querySelector('#deleteConfirmModal .bg-white')?.addEventListener('click', e => e.stopPropagation());
    });
</script>

<!-- ==========================================================
FORM MODAL
========================================================== -->
<div id="formModal" class="fixed inset-0 z-[9999] hidden">
    <div id="formBackdrop" class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
    <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
        <div
            class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden animate-[fadeIn_.2s_ease]">

            <!-- HEADER -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 flex-shrink-0">
                <h2 id="formModalTitle" class="text-xl font-bold text-slate-900">Tambah UMKM</h2>
                <button id="closeModalBtn"
                    class="w-10 h-10 rounded-xl hover:bg-slate-100 transition flex items-center justify-center">
                    <iconify-icon icon="solar:close-circle-linear" width="24"></iconify-icon>
                </button>
            </div>

            <!-- CONTENT -->
            <div id="formContent" class="overflow-y-auto max-h-[55vh] p-1"></div>

        </div>
    </div>
</div>

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
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Hapus UMKM?</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Apakah Anda yakin ingin menghapus UMKM
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

<?php include '../Layouts/footer.php' ?>