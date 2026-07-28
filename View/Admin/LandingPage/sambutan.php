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
            Manajemen Sambutan Kepala Desa
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Kelola sambutan dan profil Kepala Desa yang akan ditampilkan pada website resmi Desa Bungur.
        </p>
    </div>
</div>

<!-- ==========================================================
    TOOLBAR
========================================================== -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">

    <div class="p-4 flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center border-b border-slate-200">
        <div class="flex items-center gap-3">
            <h2 class="text-sm font-semibold text-slate-900">All Sambutan</h2>
            <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full" id="totalBadge">0</span>
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
    <div id="sambutanGrid" class="ag-theme-quartz" style="height:420px; width:100%;"></div>

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

    .photo-thumb {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #E2E8F0;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .status-active {
        background: #DCFCE7;
        color: #166534;
    }
    .status-inactive {
        background: #FEE2E2;
        color: #991B1B;
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
        content: "👨‍💼";
        display: block;
        font-size: 40px;
        margin-bottom: 8px;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(.96); }
        to { opacity: 1; transform: scale(1); }
    }

    /* ==========================================================
       MODAL STYLING
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

    /* Preview image di modal */
    .preview-thumb {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #E2E8F0;
    }

    .preview-ttd {
        width: 120px;
        height: 50px;
        object-fit: contain;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 4px;
    }

    .content-preview {
        background: #F8FAFC;
        padding: 12px 16px;
        border-radius: 12px;
        border: 1px solid #F1F5F9;
        max-height: 120px;
        overflow-y: auto;
        font-size: 14px;
        color: #475569;
        line-height: 1.7;
    }
    .content-preview::-webkit-scrollbar {
        width: 4px;
    }
    .content-preview::-webkit-scrollbar-thumb {
        background: #CBD5E1;
        border-radius: 10px;
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
            name: "Nama Kepala Desa",
            title: "Kepala Desa Bungur",
            photo: "assets/foto-kades.png",
            signature: "assets/ttd-kades.png",
            greeting: "Assalamu'alaikum Warahmatullahi Wabarakatuh.",
            closing: "Wassalamu'alaikum Warahmatullahi Wabarakatuh.",
            content: "Puji syukur kehadirat Allah SWT atas limpahan rahmat dan karunia-Nya sehingga Website Resmi Desa Bungur hadir sebagai media informasi dan pelayanan publik digital. Website ini menjadi sarana keterbukaan informasi mengenai pemerintahan desa, pembangunan, pelayanan masyarakat, serta potensi Desa Bungur. Mari bersama-sama menjaga semangat gotong royong untuk mewujudkan desa yang maju, mandiri, dan sejahtera.",
            is_active: true
        }
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

    function NoRenderer(params) {
        const number = (currentPage - 1) * itemsPerPage + params.node.rowIndex + 1;
        return `<span class="text-slate-400 font-medium">${number}</span>`;
    }

    function PhotoRenderer(params) {
        return `<img src="${params.value}" class="photo-thumb" alt="Kades Photo" loading="lazy">`;
    }

    function NameRenderer(params) {
        return `<span class="font-medium text-slate-800">${params.value}</span>`;
    }

    function TitleRenderer(params) {
        return `<span class="text-slate-600">${params.value}</span>`;
    }

    function ContentRenderer(params) {
        const maxLength = 60;
        const text = params.value || '';
        const truncated = text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
        return `<span class="text-slate-600 text-sm" title="${text}">${truncated}</span>`;
    }

    function StatusRenderer(params) {
        if (params.value) {
            return `<span class="status-badge status-active"><span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Aktif</span>`;
        }
        return `<span class="status-badge status-inactive"><span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Nonaktif</span>`;
    }

    function ActionRenderer(params) {
        const wrapper = document.createElement("div");
        wrapper.className = "flex items-center gap-2";

        const edit = document.createElement("button");
        edit.className = "p-1.5 rounded-lg hover:bg-slate-100 transition";
        edit.innerHTML = `<iconify-icon icon="solar:pen-2-linear" width="17"></iconify-icon>`;
        edit.title = "Edit Sambutan";
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
        { headerName: "Foto", field: "photo", cellRenderer: PhotoRenderer, width: 70, minWidth: 70, maxWidth: 70, resizable: false },
        { headerName: "Nama", field: "name", cellRenderer: NameRenderer, flex: 1, minWidth: 180, resizable: true },
        { headerName: "Jabatan", field: "title", cellRenderer: TitleRenderer, width: 180, minWidth: 160, resizable: true },
        { headerName: "Sambutan", field: "content", cellRenderer: ContentRenderer, flex: 1, minWidth: 200, resizable: true },
        { headerName: "Status", field: "is_active", cellRenderer: StatusRenderer, width: 110, minWidth: 90, resizable: true },
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
                <span class="text-4xl">👨‍💼</span>
                <span>No Data Found</span>
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
                               item.title.toLowerCase().includes(keyword) ||
                               item.content.toLowerCase().includes(keyword);
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
            title.textContent = 'Tambah Sambutan';
        } else {
            currentEditId = data.id;
            title.textContent = 'Edit Sambutan';
        }

        renderForm(data);
        modal.classList.remove("hidden");
    }

    function renderForm(data) {
        const container = document.getElementById("formContent");

        container.innerHTML = `
            <form id="sambutanForm" class="p-6" enctype="multipart/form-data">
                <div class="space-y-4">
                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="formName" value="${data ? data.name : ''}" 
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                            placeholder="Nama Kepala Desa" required>
                    </div>

                    <!-- Jabatan -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                        <input type="text" id="formTitle" value="${data ? data.title : 'Kepala Desa Bungur'}" 
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                            placeholder="Kepala Desa Bungur" required>
                    </div>

                    <!-- Foto -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Foto</label>
                        ${data && data.photo ? `
                            <div class="mb-2">
                                <img src="${data.photo}" class="preview-thumb" alt="Photo">
                                <p class="text-xs text-slate-400 mt-1">Gambar saat ini</p>
                            </div>
                        ` : ''}
                        <input type="file" id="formPhoto" accept="image/*"
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                        <p class="text-xs text-slate-400 mt-1">Upload foto Kepala Desa (JPG, PNG, WEBP)</p>
                    </div>

                    <!-- Tanda Tangan -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tanda Tangan</label>
                        ${data && data.signature ? `
                            <div class="mb-2">
                                <img src="${data.signature}" class="preview-ttd" alt="Signature">
                                <p class="text-xs text-slate-400 mt-1">Tanda tangan saat ini</p>
                            </div>
                        ` : ''}
                        <input type="file" id="formSignature" accept="image/*"
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                        <p class="text-xs text-slate-400 mt-1">Upload tanda tangan (JPG, PNG, WEBP)</p>
                    </div>

                    <!-- Pembuka -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Salam Pembuka <span class="text-red-500">*</span></label>
                        <input type="text" id="formGreeting" value="${data ? data.greeting : 'Assalamu\'alaikum Warahmatullahi Wabarakatuh.'}" 
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                            placeholder="Salam pembuka..." required>
                    </div>

                    <!-- Isi Sambutan -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Isi Sambutan <span class="text-red-500">*</span></label>
                        <textarea id="formContent" rows="6"
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                            placeholder="Tulis sambutan..." required>${data ? data.content : ''}</textarea>
                    </div>

                    <!-- Penutup -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Salam Penutup <span class="text-red-500">*</span></label>
                        <input type="text" id="formClosing" value="${data ? data.closing : 'Wassalamu\'alaikum Warahmatullahi Wabarakatuh.'}" 
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                            placeholder="Salam penutup..." required>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <select id="formStatus" 
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10">
                            <option value="true" ${data && data.is_active ? 'selected' : ''}>Aktif</option>
                            <option value="false" ${data && !data.is_active ? 'selected' : ''}>Nonaktif</option>
                        </select>
                        <p class="text-xs text-slate-400 mt-1">Hanya 1 data yang bisa aktif ditampilkan di frontend</p>
                    </div>
                </div>

                <div class="flex gap-3 mt-6 pt-6 border-t">
                    <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-black transition">
                        <iconify-icon icon="solar:check-circle-linear" width="18" class="inline mr-1"></iconify-icon>
                        Simpan
                    </button>
                    <button type="button" id="formCancelBtn" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 transition">
                        Batal
                    </button>
                </div>
            </form>
        `;

        document.getElementById("formCancelBtn").onclick = closeFormModal;
        document.getElementById("sambutanForm").onsubmit = saveData;
    }

    function closeFormModal() {
        document.getElementById("formModal").classList.add("hidden");
        currentEditId = null;
    }

    function saveData(e) {
        e.preventDefault();

        const name = document.getElementById("formName").value.trim();
        const title = document.getElementById("formTitle").value.trim();
        const greeting = document.getElementById("formGreeting").value.trim();
        const content = document.getElementById("formContent").value.trim();
        const closing = document.getElementById("formClosing").value.trim();
        const is_active = document.getElementById("formStatus").value === 'true';
        const photoInput = document.getElementById("formPhoto");
        const signatureInput = document.getElementById("formSignature");

        if (!name || !title || !content || !greeting || !closing) {
            showToast('⚠️ Semua field wajib diisi!', 'warning');
            return;
        }

        let photo = null;
        let signature = null;

        // Handle photo upload
        if (photoInput.files && photoInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photo = e.target.result;
                processSignature(photo);
            };
            reader.readAsDataURL(photoInput.files[0]);
        } else {
            processSignature(null);
        }

        function processSignature(photoData) {
            if (signatureInput.files && signatureInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    signature = e.target.result;
                    saveDataFinal(photoData, signature);
                };
                reader.readAsDataURL(signatureInput.files[0]);
            } else {
                saveDataFinal(photoData, null);
            }
        }

        function saveDataFinal(photoData, signatureData) {
            // Jika tidak upload baru, pakai yang lama
            const existing = allData.find(i => i.id === currentEditId);
            const finalPhoto = photoData || (existing ? existing.photo : null);
            const finalSignature = signatureData || (existing ? existing.signature : null);

            const data = { name, title, greeting, content, closing, is_active, photo: finalPhoto, signature: finalSignature };

            if (currentEditId) {
                const index = allData.findIndex(i => i.id === currentEditId);
                if (index !== -1) {
                    // Jika aktif, nonaktifkan yang lain
                    if (is_active) {
                        allData.forEach((item, idx) => {
                            if (idx !== index) allData[idx].is_active = false;
                        });
                    }
                    allData[index] = { ...allData[index], ...data };
                    applyFilters();
                    showToast(`✅ Sambutan "${name}" berhasil diupdate`, 'success');
                    closeFormModal();
                }
            } else {
                // Jika aktif, nonaktifkan yang lain
                if (is_active) {
                    allData.forEach(item => item.is_active = false);
                }
                const newId = Math.max(...allData.map(i => i.id), 0) + 1;
                allData.push({ id: newId, ...data });
                applyFilters();
                showToast(`✅ Sambutan "${name}" berhasil ditambahkan`, 'success');
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
            showToast(`🗑️ Sambutan "${name}" berhasil dihapus`, 'warning');
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
        const gridDiv = document.querySelector("#sambutanGrid");
        gridApi = agGrid.createGrid(gridDiv, gridOptions);
        refreshGrid();

        document.getElementById("searchInput").addEventListener("input", applyFilters);

        document.getElementById("perPageSelect").addEventListener("change", function() {
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

        // FORM MODAL EVENTS
        document.getElementById("closeModalBtn").addEventListener("click", closeFormModal);
        document.getElementById("formCancelBtn").addEventListener("click", closeFormModal);
        document.getElementById("formBackdrop").addEventListener("click", closeFormModal);

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
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-hidden animate-[fadeIn_.2s_ease]">
            
            <!-- HEADER -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 flex-shrink-0">
                <h2 id="formModalTitle" class="text-xl font-bold text-slate-900">Tambah Sambutan</h2>
                <button id="closeModalBtn" class="w-10 h-10 rounded-xl hover:bg-slate-100 transition flex items-center justify-center">
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
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Hapus Sambutan?</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Apakah Anda yakin ingin menghapus sambutan
                    <strong class="text-slate-900" id="deleteTitle"></strong>?
                    <br>
                    <span class="text-red-500">Tindakan ini tidak dapat dibatalkan!</span>
                </p>
                <input type="hidden" id="deleteId" value="">
            </div>
            <div class="flex gap-3 p-6 pt-0">
                <button id="deleteCancelBtn" class="flex-1 px-4 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 transition text-sm font-medium">Batal</button>
                <button id="deleteConfirmBtn" class="flex-1 px-4 py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white transition text-sm font-medium flex items-center justify-center gap-2">
                    <iconify-icon icon="solar:trash-bin-trash-linear" width="18"></iconify-icon>
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<?php include '../Layouts/footer.php' ?>