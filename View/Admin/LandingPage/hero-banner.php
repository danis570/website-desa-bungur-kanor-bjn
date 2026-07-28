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
            Manajemen Hero Slider
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Kelola seluruh slide hero yang akan ditampilkan pada halaman utama website Desa Bungur.
        </p>
    </div>
</div>

<!-- ==========================================================
    TOOLBAR
========================================================== -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">

    <div class="p-4 flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center border-b border-slate-200">
        <div class="flex items-center gap-3">
            <h2 class="text-sm font-semibold text-slate-900">All Slides</h2>
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
    <div id="heroGrid" class="ag-theme-quartz" style="height:420px; width:100%;"></div>

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
        --ag-row-height: 72px;
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

    .slide-thumb {
        width: 80px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
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
        content: "🖼️";
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

    /* Preview hero image di modal */
    .hero-preview {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #E2E8F0;
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
            title: "Desa Bungur",
            subtitle: "Kecamatan Kanor - Kabupaten Bojonegoro",
            description: "Selamat datang di website resmi desa bungur",
            image: "assets/hero1.png",
            is_active: true,
            order: 1
        },
        {
            id: 2,
            title: "Potensi Pertanian",
            subtitle: "Desa Bungur",
            description: "Desa Bungur memiliki potensi pertanian yang menjadi penopang utama ekonomi masyarakat.",
            image: "assets/hero2.png",
            is_active: true,
            order: 2
        },
        {
            id: 3,
            title: "Masyarakat Gotong Royong",
            subtitle: "Desa Bungur",
            description: "Menjaga budaya kebersamaan dan membangun desa menuju masa depan yang lebih baik.",
            image: "assets/hero3.png",
            is_active: true,
            order: 3
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

    function ImageRenderer(params) {
        return `<img src="${params.value}" class="slide-thumb" alt="Slide image" loading="lazy">`;
    }

    function TitleRenderer(params) {
        return `<span class="font-medium text-slate-800">${params.value}</span>`;
    }

    function DescriptionRenderer(params) {
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

    function OrderRenderer(params) {
        return `<span class="text-slate-500 font-medium">#${params.value}</span>`;
    }

    function ActionRenderer(params) {
        const wrapper = document.createElement("div");
        wrapper.className = "flex items-center gap-2";

        const edit = document.createElement("button");
        edit.className = "p-1.5 rounded-lg hover:bg-slate-100 transition";
        edit.innerHTML = `<iconify-icon icon="solar:pen-2-linear" width="17"></iconify-icon>`;
        edit.title = "Edit Slide";
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
        { headerName: "Gambar", field: "image", cellRenderer: ImageRenderer, width: 100, minWidth: 100, maxWidth: 100, resizable: false },
        { headerName: "Judul", field: "title", cellRenderer: TitleRenderer, flex: 1, minWidth: 180, resizable: true },
        { headerName: "Deskripsi", field: "description", cellRenderer: DescriptionRenderer, flex: 1, minWidth: 200, resizable: true },
        { headerName: "Status", field: "is_active", cellRenderer: StatusRenderer, width: 110, minWidth: 90, resizable: true },
        { headerName: "Urutan", field: "order", cellRenderer: OrderRenderer, width: 80, minWidth: 80, maxWidth: 80, resizable: false },
        { headerName: "Action", cellRenderer: ActionRenderer, width: 90, minWidth: 90, maxWidth: 90, resizable: false, suppressMovable: true }
    ];

    // ==========================================================
    // GRID OPTIONS
    // ==========================================================
    const gridOptions = {
        columnDefs,
        rowData: [],
        rowHeight: 72,
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
                <span class="text-4xl">🖼️</span>
                <span>No Slides Found</span>
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
            const matchSearch = item.title.toLowerCase().includes(keyword) ||
                               item.description.toLowerCase().includes(keyword) ||
                               item.subtitle.toLowerCase().includes(keyword);
            return matchSearch;
        });

        // Sort by order
        filteredData.sort((a, b) => a.order - b.order);

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
            title.textContent = 'Tambah Slide Hero';
        } else {
            currentEditId = data.id;
            title.textContent = 'Edit Slide Hero';
        }

        renderForm(data);
        modal.classList.remove("hidden");
    }

    function renderForm(data) {
        const container = document.getElementById("formContent");

        container.innerHTML = `
            <form id="heroForm" class="p-6" enctype="multipart/form-data">
                <div class="space-y-4">
                    <!-- Gambar -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Gambar <span class="text-red-500">*</span></label>
                        ${data && data.image ? `
                            <div class="mb-2">
                                <img src="${data.image}" class="hero-preview" alt="Hero Image">
                                <p class="text-xs text-slate-400 mt-1">Gambar saat ini</p>
                            </div>
                        ` : ''}
                        <input type="file" id="formImage" accept="image/*"
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                        <p class="text-xs text-slate-400 mt-1">Upload gambar slide (JPG, PNG, WEBP) - Rekomendasi: 1920x1080</p>
                    </div>

                    <!-- Judul -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Judul <span class="text-red-500">*</span></label>
                        <input type="text" id="formTitle" value="${data ? data.title : ''}" 
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                            placeholder="Contoh: Desa Bungur" required>
                    </div>

                    <!-- Subtitle -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Subtitle</label>
                        <input type="text" id="formSubtitle" value="${data ? data.subtitle : ''}" 
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                            placeholder="Contoh: Kecamatan Kanor - Kabupaten Bojonegoro">
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea id="formDescription" rows="3"
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                            placeholder="Tulis deskripsi slide..." required>${data ? data.description : ''}</textarea>
                    </div>

                    <!-- Urutan -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Urutan</label>
                        <input type="number" id="formOrder" value="${data ? data.order : 1}" 
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                            placeholder="1" min="1">
                        <p class="text-xs text-slate-400 mt-1">Urutan tampilan slide (semakin kecil semakin awal)</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <select id="formStatus" 
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10">
                            <option value="true" ${data && data.is_active ? 'selected' : ''}>Aktif</option>
                            <option value="false" ${data && !data.is_active ? 'selected' : ''}>Nonaktif</option>
                        </select>
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
        document.getElementById("heroForm").onsubmit = saveData;
    }

    function closeFormModal() {
        document.getElementById("formModal").classList.add("hidden");
        currentEditId = null;
    }

    function saveData(e) {
        e.preventDefault();

        const title = document.getElementById("formTitle").value.trim();
        const subtitle = document.getElementById("formSubtitle").value.trim();
        const description = document.getElementById("formDescription").value.trim();
        const order = parseInt(document.getElementById("formOrder").value) || 1;
        const is_active = document.getElementById("formStatus").value === 'true';
        const imageInput = document.getElementById("formImage");

        if (!title || !description) {
            showToast('⚠️ Judul dan Deskripsi wajib diisi!', 'warning');
            return;
        }

        // Handle image upload
        let image = null;
        if (imageInput.files && imageInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image = e.target.result;
                saveDataWithImage(image);
            };
            reader.readAsDataURL(imageInput.files[0]);
        } else {
            // Jika tidak upload baru, pakai yang lama
            const existing = allData.find(i => i.id === currentEditId);
            image = existing ? existing.image : 'https://picsum.photos/seed/hero' + Date.now() + '/1920/1080';
            saveDataWithImage(image);
        }

        function saveDataWithImage(image) {
            const data = { title, subtitle, description, image, is_active, order };

            if (currentEditId) {
                const index = allData.findIndex(i => i.id === currentEditId);
                if (index !== -1) {
                    allData[index] = { ...allData[index], ...data };
                    applyFilters();
                    showToast(`✅ Slide "${title}" berhasil diupdate`, 'success');
                    closeFormModal();
                }
            } else {
                const newId = Math.max(...allData.map(i => i.id), 0) + 1;
                allData.push({ id: newId, ...data });
                applyFilters();
                showToast(`✅ Slide "${title}" berhasil ditambahkan`, 'success');
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
        document.getElementById("deleteTitle").textContent = `"${item.title}"`;
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
            const title = allData[index].title;
            allData.splice(index, 1);
            applyFilters();
            showToast(`🗑️ Slide "${title}" berhasil dihapus`, 'warning');
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
        const gridDiv = document.querySelector("#heroGrid");
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
                <h2 id="formModalTitle" class="text-xl font-bold text-slate-900">Tambah Slide Hero</h2>
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
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Hapus Slide?</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Apakah Anda yakin ingin menghapus slide
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