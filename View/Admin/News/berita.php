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
            Manajemen Artikel
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Kelola seluruh artikel yang akan ditampilkan pada website resmi Desa Bungur.
        </p>
    </div>
</div>

<!-- ==========================================================
    TOOLBAR - SUPER SIMPLE
    ========================================================== -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">

    <!-- Toolbar -->
    <div
        class="p-4 flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center border-b border-slate-200">
        <div class="flex items-center gap-3">
            <h2 class="text-sm font-semibold text-slate-900">All articles</h2>
            <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full"
                id="totalBadge">12</span>
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

            <!-- FILTER -->
            <select id="statusFilter"
                class="h-9 rounded-lg border border-slate-200 bg-white px-3 pr-8 text-sm appearance-none bg-[url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2212%22 height=%2212%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23475569%22 stroke-width=%222%22%3E%3Cpolyline points=%226 9%2012 15%2018 9%22%3E%3C/polyline%3E%3C/svg%3E')] bg-[position:right_8px_center] bg-no-repeat focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition">
                <option value="">All Status</option>
                <option value="Pending">Pending</option>
                <option value="Published">Published</option>
                <option value="Rejected">Rejected</option>
            </select>

            <!-- ADD -->
            <button
                class="h-9 px-3.5 rounded-lg bg-slate-900 text-white hover:bg-black transition text-sm font-medium flex items-center gap-1.5">
                <iconify-icon icon="solar:add-circle-linear" width="16"></iconify-icon>
                Add
            </button>
        </div>
    </div>

    <!-- ==========================================================
        AG GRID - SUPER SIMPLE (Hanya 4 Kolom)
        ========================================================== -->
    <div id="articleGrid" class="ag-theme-quartz" style="height:420px; width:100%;"></div>

    <!-- ==========================================================
        PAGINATION - SUPER SIMPLE
        ========================================================== -->
    <div
        class="border-t border-slate-200 px-4 py-3 flex flex-col sm:flex-row items-center justify-between gap-3 bg-slate-50/30">
        <!-- Left: Info -->
        <div class="text-sm text-slate-500">
            Showing <span id="startRow"></span> to <span id="endRow"></span> of <span id="totalRows"></span>
        </div>

        <!-- Right: Pagination Buttons -->
        <div class="flex items-center gap-2">
            <button id="prevPage"
                class="h-8 px-3 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition text-sm font-medium text-slate-700 disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-1">
                <iconify-icon icon="solar:arrow-left-linear" width="14"></iconify-icon>
                Prev
            </button>

            <!-- Page Numbers -->
            <div id="pageNumbers" class="flex items-center gap-1">
                <!-- Dynamically generated -->
            </div>

            <button id="nextPage"
                class="h-8 px-3 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition text-sm font-medium text-slate-700 disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-1">
                Next
                <iconify-icon icon="solar:arrow-right-linear" width="14"></iconify-icon>
            </button>
        </div>
    </div>

</div>


<!-- ==========================================================
STYLE - Minimal untuk AG Grid
========================================================== -->
<style>
    /* Scrollbar */
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

    /* AG Grid Theme - Minimal */
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

    /* Checkbox */
    .ag-theme-quartz .ag-checkbox-input-wrapper {
        border-radius: 6px !important;
        border: 1.5px solid #CBD5E1 !important;
        background: #FFFFFF !important;
        width: 18px !important;
        height: 18px !important;
        transition: all 0.15s ease;
    }

    .ag-theme-quartz .ag-checkbox-input-wrapper.ag-checked {
        background: #0F172A !important;
        border-color: #0F172A !important;
    }

    .ag-theme-quartz .ag-checkbox-input-wrapper.ag-checked::after {
        border-color: #FFFFFF !important;
        border-width: 2px !important;
        top: 40% !important;
        left: 30% !important;
        width: 30% !important;
        height: 20% !important;
    }

    /* Hide AG Grid Pagination */
    .ag-theme-quartz .ag-paging-panel {
        display: none !important;
    }

    /* Empty State */
    .ag-theme-quartz .ag-overlay-no-rows-center {
        font-size: 14px;
        color: #94A3B8;
        font-weight: 500;
    }

    .ag-theme-quartz .ag-overlay-no-rows-center::before {
        content: "📝";
        display: block;
        font-size: 40px;
        margin-bottom: 8px;
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-badge-pending {
        background: #FEF3C7;
        color: #92400E;
    }

    .status-badge-published {
        background: #DCFCE7;
        color: #166534;
    }

    .status-badge-rejected {
        background: #FEE2E2;
        color: #991B1B;
    }

    /* Page Number Active */
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

    /* ==========================================================
   COLUMN RESIZE - GARIS PEMISAH
   ========================================================== */

    /* Tampilkan garis pemisah antar kolom */
    .ag-theme-quartz .ag-header-cell::after {
        content: '';
        position: absolute;
        right: 0;
        top: 25%;
        height: 50%;
        width: 1px;
        background: #E2E8F0;
    }

    /* Sembunyikan garis pemisah di kolom terakhir */
    .ag-theme-quartz .ag-header-cell:last-child::after {
        display: none;
    }

    /* Sembunyikan garis pemisah di kolom action */
    .ag-theme-quartz .ag-header-cell[col-id="action"]::after {
        display: none;
    }

    /* Sembunyikan garis pemisah di kolom checkbox */
    .ag-theme-quartz .ag-header-cell[col-id="ag-Grid-AutoColumn"]::after {
        display: none;
    }

    /* Gaya untuk handle resize (garis yang bisa digeser) */
    .ag-theme-quartz .ag-header-cell-resize {
        width: 8px !important;
        cursor: col-resize !important;
        opacity: 1 !important;
        background: transparent !important;
    }

    /* Hover effect pada handle resize */
    .ag-theme-quartz .ag-header-cell-resize:hover {
        background: #0F172A !important;
        opacity: 0.3 !important;
    }

    /* Saat sedang di-resize */
    .ag-theme-quartz .ag-header-cell-resize:active {
        background: #0F172A !important;
        opacity: 0.5 !important;
    }

    /* Garis panduan saat resize (opsional) */
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
</style>

<!-- ==========================================================
JAVASCRIPT
========================================================== -->
<script>
    // ==========================================================
    // DATA (Dummy)
    // ==========================================================
    const allData = [
        { id: 1, title: "Festival Sedekah Bumi Desa test menggunakan panjang Bungur", owner: "Budi Santoso", status: "Pending" },
        { id: 2, title: "Posyandu Balita Bulan Juli", owner: "Siti Rahayu", status: "Published" },
        { id: 3, title: "Kerja Bakti Membersihkan Jalan", owner: "Ahmad Fauzi", status: "Rejected" },
        { id: 4, title: "Vaksinasi Anak Sekolah Dasar", owner: "Dewi Lestari", status: "Published" },
        { id: 5, title: "Peringatan HUT Kemerdekaan RI", owner: "Budi Santoso", status: "Pending" },
        { id: 6, title: "Perbaikan Jalan Desa Bungur", owner: "Ahmad Fauzi", status: "Published" },
        { id: 7, title: "Pelatihan UMKM Desa Bungur", owner: "Siti Rahayu", status: "Rejected" },
        { id: 8, title: "Rapat Koordinasi BPD Desa", owner: "Dewi Lestari", status: "Published" },
        { id: 9, title: "Penyuluhan Kesehatan Ibu Hamil", owner: "Budi Santoso", status: "Pending" },
        { id: 10, title: "Pemilihan Ketua Karang Taruna", owner: "Ahmad Fauzi", status: "Published" },
        { id: 11, title: "Bazar Makanan Sehat Desa", owner: "Siti Rahayu", status: "Rejected" },
        { id: 12, title: "Kunjungan Kerja Camat Bungur", owner: "Dewi Lestari", status: "Published" }
    ];

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

    // ==========================================================
    // NO
    // ==========================================================
    function NoRenderer(params) {

        const number =
            (currentPage - 1) * itemsPerPage +
            params.node.rowIndex +
            1;

        return `
        <span class="text-slate-400 font-medium">
            ${number}
        </span>
    `;

    }


    // ==========================================================
    // TITLE
    // ==========================================================
    function TitleRenderer(params) {

        return `
        <div class="w-full truncate font-medium text-slate-800"
             title="${params.value}">
            ${params.value}
        </div>
    `;

    }


    // ==========================================================
    // OWNER
    // ==========================================================
    function OwnerRenderer(params) {

        return `
        <span class="text-slate-600">
            ${params.value ?? "-"}
        </span>
    `;

    }


    // ==========================================================
    // STATUS
    // ==========================================================
    function StatusRenderer(params) {

        const map = {

            Pending: {
                class: "status-badge-pending",
                icon: "solar:clock-circle-linear"
            },

            Published: {
                class: "status-badge-published",
                icon: "solar:check-circle-linear"
            },

            Rejected: {
                class: "status-badge-rejected",
                icon: "solar:close-circle-linear"
            }

        };

        const item = map[params.value];

        return `

        <span class="status-badge ${item.class}">

            <iconify-icon
                icon="${item.icon}"
                width="12">
            </iconify-icon>

            ${params.value}

        </span>

    `;

    }


    // ==========================================================
    // ACTION
    // ==========================================================
    function ActionRenderer(params) {

        const wrapper = document.createElement("div");

        wrapper.className =
            "flex items-center gap-2";



        // EDIT
        const edit = document.createElement("button");

        edit.className =
            "p-1.5 rounded-lg hover:bg-slate-100 transition";

        edit.innerHTML = `
        <iconify-icon
            icon="solar:pen-2-linear"
            width="17">
        </iconify-icon>
    `;

        edit.onclick = e => {

            e.stopPropagation();

            alert("Edit : " + params.data.title);

        };



        // DELETE
        const del = document.createElement("button");

        del.className =
            "p-1.5 rounded-lg hover:bg-red-50 text-red-500 transition";

        del.innerHTML = `
        <iconify-icon
            icon="solar:trash-bin-trash-linear"
            width="17">
        </iconify-icon>
    `;

        del.onclick = e => {

            e.stopPropagation();

            if (confirm("Hapus artikel?")) {

                alert(params.data.title);

            }

        };



        wrapper.appendChild(edit);

        wrapper.appendChild(del);

        return wrapper;

    }



    // ==========================================================
    // COLUMN DEFINITIONS
    // ==========================================================
    const columnDefs = [

        {
            headerName: "No",

            cellRenderer: NoRenderer,

            width: 70,

            minWidth: 70,

            maxWidth: 70,

            resizable: false,

            suppressMovable: true

        },



        {
            headerName: "Title",

            field: "title",

            cellRenderer: TitleRenderer,

            flex: 1,

            minWidth: 260,

            resizable: true

        },



        {
            headerName: "Owner",

            field: "owner",

            cellRenderer: OwnerRenderer,

            width: 180,

            minWidth: 160,

            resizable: true

        },



        {
            headerName: "Status",

            field: "status",

            cellRenderer: StatusRenderer,

            width: 150,

            minWidth: 130,

            resizable: true

        },



        {
            headerName: "Action",

            cellRenderer: ActionRenderer,

            width: 90,

            minWidth: 90,

            maxWidth: 90,

            resizable: false,

            suppressMovable: true

        }

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

        <div
            class="ag-overlay-no-rows-center
            flex flex-col
            items-center
            gap-2
            text-slate-400">

            <span class="text-4xl">
                📝
            </span>

            <span>
                No Data Found
            </span>

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

        return filteredData.slice(
            start,
            start + itemsPerPage
        );

    }

    function updatePagination() {

        const total = filteredData.length;

        const totalPages = getTotalPages();

        const start =
            total === 0
                ? 0
                : (currentPage - 1) * itemsPerPage + 1;

        const end =
            total === 0
                ? 0
                : Math.min(currentPage * itemsPerPage, total);

        document.getElementById("startRow").textContent = start;
        document.getElementById("endRow").textContent = end;
        document.getElementById("totalRows").textContent = total;
        document.getElementById("totalBadge").textContent = total;

        document.getElementById("prevPage").disabled =
            currentPage <= 1;

        document.getElementById("nextPage").disabled =
            currentPage >= totalPages || total === 0;

        renderPageNumbers(totalPages);

    }


    // ==========================================================
    // PAGE NUMBER
    // ==========================================================

    function renderPageNumbers(totalPages) {

        const container =
            document.getElementById("pageNumbers");

        container.innerHTML = "";

        if (filteredData.length === 0) {

            container.innerHTML =
                `<span class="page-btn disabled">1</span>`;

            return;

        }

        let startPage =
            Math.max(currentPage - 2, 1);

        let endPage =
            Math.min(startPage + 4, totalPages);

        startPage =
            Math.max(1, endPage - 4);

        for (let i = startPage; i <= endPage; i++) {

            const btn =
                document.createElement("button");

            btn.className =
                "page-btn" +
                (i === currentPage ? " active" : "");

            btn.textContent = i;

            btn.onclick = () => {

                currentPage = i;

                refreshGrid();

            };

            container.appendChild(btn);

        }

    }



    // ==========================================================
    // REFRESH GRID
    // ==========================================================

    function refreshGrid() {

        if (!gridApi) return;

        gridApi.setGridOption(
            "rowData",
            getPageData()
        );

        gridApi.refreshCells({
            force: true
        });

        updatePagination();

    }



    // ==========================================================
    // SEARCH + FILTER
    // ==========================================================

    function applyFilters() {

        const keyword =
            document
                .getElementById("searchInput")
                .value
                .toLowerCase()
                .trim();

        const status =
            document
                .getElementById("statusFilter")
                .value;

        filteredData =
            allData.filter(item => {

                const matchSearch =

                    item.title
                        .toLowerCase()
                        .includes(keyword)

                    ||

                    item.owner
                        .toLowerCase()
                        .includes(keyword);

                const matchStatus =

                    status === ""

                    ||

                    item.status === status;

                return matchSearch && matchStatus;

            });

        currentPage = 1;

        refreshGrid();

    }



    // ==========================================================
    // INITIALIZE
    // ==========================================================

    document.addEventListener("DOMContentLoaded", () => {

        const gridDiv =
            document.querySelector("#articleGrid");

        gridApi =
            agGrid.createGrid(
                gridDiv,
                gridOptions
            );

        refreshGrid();



        // ============================
        // SEARCH
        // ============================

        document
            .getElementById("searchInput")
            .addEventListener(
                "input",
                applyFilters
            );



        // ============================
        // FILTER
        // ============================

        document
            .getElementById("statusFilter")
            .addEventListener(
                "change",
                applyFilters
            );



        // ============================
        // PER PAGE
        // ============================

        document
            .getElementById("perPageSelect")
            .addEventListener(
                "change",
                function () {

                    itemsPerPage =
                        Number(this.value);

                    currentPage = 1;

                    refreshGrid();

                }
            );



        // ============================
        // PREV
        // ============================

        document
            .getElementById("prevPage")
            .addEventListener(
                "click",
                () => {

                    if (currentPage > 1) {

                        currentPage--;

                        refreshGrid();

                    }

                }
            );



        // ============================
        // NEXT
        // ============================

        document
            .getElementById("nextPage")
            .addEventListener(
                "click",
                () => {

                    if (
                        currentPage <
                        getTotalPages()
                    ) {

                        currentPage++;

                        refreshGrid();

                    }

                }
            );



        // ============================
        // CTRL + K
        // ============================

        document.addEventListener(
            "keydown",
            e => {

                if (
                    (e.ctrlKey || e.metaKey)
                    &&
                    e.key === "k"
                ) {

                    e.preventDefault();

                    document
                        .getElementById("searchInput")
                        .focus();

                }

            }
        );

    });
</script>

<?php include '../Layouts/footer.php' ?>