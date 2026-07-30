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
            Manajemen Galeri
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Kelola seluruh foto galeri yang akan ditampilkan pada website resmi Desa Bungur.
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
            <h2 class="text-sm font-semibold text-slate-900">All Photos</h2>
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

            <!-- FILTER -->
            <select id="statusFilter"
                class="h-9 rounded-lg border border-slate-200 bg-white px-3 pr-8 text-sm appearance-none bg-[url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2212%22 height=%2212%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23475569%22 stroke-width=%222%22%3E%3Cpolyline points=%226 9%2012 15%2018 9%22%3E%3C/polyline%3E%3C/svg%3E')] bg-[position:right_8px_center] bg-no-repeat focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition">
                <option value="">All Status</option>
                <option value="Pending">Pending</option>
                <option value="Published">Published</option>
                <option value="Rejected">Rejected</option>
            </select>

            <!-- ADD -->
            <a href="/admin/gallery/create"
                class="h-9 px-3.5 rounded-lg bg-slate-900 text-white hover:bg-black transition text-sm font-medium flex items-center gap-1.5">
                <iconify-icon icon="solar:add-circle-linear" width="16"></iconify-icon>
                Add
            </a>
        </div>
    </div>

    <!-- ==========================================================
        AG GRID - TANPA TITLE, PAKAI CAPTION
    ========================================================== -->
    <div id="galleryGrid" class="ag-theme-quartz" style="height:420px; width:100%;"></div>

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

    /* AG Grid Theme */
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

    /* Page Number */
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

    /* Column Resize */
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
        from {
            opacity: 0;
            transform: scale(.96);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>

<!-- ==========================================================
JAVASCRIPT
========================================================== -->
<script>
    // ==========================================================
    // DATA (Dummy) - HANYA CAPTION, TANPA TITLE
    // ==========================================================
    const allData = [
        { id: 1, caption: "Festival Sedekah Bumi", owner: "Ahmad Fauzi", status: "Pending" },
        { id: 2, caption: "Musyawarah Desa", owner: "KKN UNIROW", status: "Published" },
        { id: 3, caption: "Panen Raya", owner: "Danish", status: "Rejected" },
        { id: 4, caption: "Kerja Bakti", owner: "Karang Taruna", status: "Published" },
        { id: 5, caption: "Sawah Desa Bungur", owner: "Admin Website", status: "Pending" },
        { id: 6, caption: "Gotong Royong", owner: "Admin Website", status: "Published" },
        { id: 7, caption: "Persawahan Hijau", owner: "Danish", status: "Rejected" },
        { id: 8, caption: "Rapat Koordinasi", owner: "Sekretariat Desa", status: "Published" },
        { id: 9, caption: "Senja Desa", owner: "Admin Website", status: "Pending" },
        { id: 10, caption: "Pelatihan UMKM", owner: "KKN UNIROW", status: "Pending" },
        { id: 11, caption: "Bazar Makanan Sehat", owner: "Siti Rahayu", status: "Rejected" },
        { id: 12, caption: "Kunjungan Kerja Camat", owner: "Dewi Lestari", status: "Published" }
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

    // NO
    function NoRenderer(params) {
        const number = (currentPage - 1) * itemsPerPage + params.node.rowIndex + 1;
        return `<span class="text-slate-400 font-medium">${number}</span>`;
    }

    // CAPTION (ganti dari Title)
    function CaptionRenderer(params) {
        return `<div class="w-full truncate font-medium text-slate-800" title="${params.value}">${params.value}</div>`;
    }

    // OWNER
    function OwnerRenderer(params) {
        return `<span class="text-slate-600">${params.value ?? "-"}</span>`;
    }

    // STATUS - SAMA PERSIS DENGAN ARTIKEL
    function StatusRenderer(params) {
        const map = {
            Pending: { class: "status-badge-pending", icon: "solar:clock-circle-linear" },
            Published: { class: "status-badge-published", icon: "solar:check-circle-linear" },
            Rejected: { class: "status-badge-rejected", icon: "solar:close-circle-linear" }
        };
        const item = map[params.value];
        return `
            <span class="status-badge ${item.class}">
                <iconify-icon icon="${item.icon}" width="12"></iconify-icon>
                ${params.value}
            </span>
        `;
    }

    // ==========================================================
    // ACTION RENDERER
    // ==========================================================
    function ActionRenderer(params) {
        const wrapper = document.createElement("div");
        wrapper.className = "flex items-center gap-2";

        // PREVIEW
        const preview = document.createElement("button");
        preview.className = "p-1.5 rounded-lg hover:bg-slate-100 transition";
        preview.innerHTML = `<iconify-icon icon="solar:eye-linear" width="17"></iconify-icon>`;
        preview.title = "Preview & Update Status";
        preview.onclick = e => {
            e.stopPropagation();
            openPreviewModal({
                id: params.data.id,
                image: `https://picsum.photos/seed/${params.data.id}/1200/700`,
                caption: params.data.caption,
                owner: params.data.owner,
                status: params.data.status,
                location: "Desa Bungur"
            });
        };

        // DELETE
        const del = document.createElement("button");
        del.className = "p-1.5 rounded-lg hover:bg-red-50 text-red-500 transition";
        del.innerHTML = `<iconify-icon icon="solar:trash-bin-trash-linear" width="17"></iconify-icon>`;
        del.title = "Hapus";
        del.onclick = e => {
            e.stopPropagation();
            openDeleteModal(params.data);
        };

        wrapper.appendChild(preview);
        wrapper.appendChild(del);
        return wrapper;
    }

    // ==========================================================
    // COLUMN DEFINITIONS - HANYA CAPTION
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
            headerName: "Caption",
            field: "caption",
            cellRenderer: CaptionRenderer,
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
            <div class="ag-overlay-no-rows-center flex flex-col items-center gap-2 text-slate-400">
                <span>No Photos Found</span>
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

    // ==========================================================
    // SEARCH + FILTER
    // ==========================================================
    function applyFilters() {
        const keyword = document.getElementById("searchInput").value.toLowerCase().trim();
        const status = document.getElementById("statusFilter").value;

        filteredData = allData.filter(item => {
            const matchSearch = item.caption.toLowerCase().includes(keyword) ||
                item.owner.toLowerCase().includes(keyword);
            const matchStatus = status === "" || item.status === status;
            return matchSearch && matchStatus;
        });

        currentPage = 1;
        refreshGrid();
    }

    // ==========================================================
    // PREVIEW MODAL
    // ==========================================================
    let currentEditingItem = null;

    function openPreviewModal(item) {
        currentEditingItem = item;
        const modal = document.getElementById("previewModal");
        const content = document.getElementById("previewContent");

        const statusOptions = ['Pending', 'Published', 'Rejected'];
        const statusOptionsHTML = statusOptions.map(status =>
            `<option value="${status}" ${status === item.status ? 'selected' : ''}>${status}</option>`
        ).join('');

        content.innerHTML = `
            <img src="${item.image || 'https://picsum.photos/seed/' + item.id + '/1200/700'}" 
                 class="w-full aspect-video object-cover" 
                 alt="${item.caption}">

            <div class="p-8">
                <!-- STATUS UPDATE SECTION -->
                <div class="bg-slate-50 rounded-2xl p-6 mb-8 border border-slate-200">
                    <h3 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
                        <iconify-icon icon="solar:settings-linear" width="18"></iconify-icon>
                        Update Status Foto
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Pilih Status</label>
                            <select id="modalStatusSelect" 
                                class="w-full h-10 rounded-xl border border-slate-200 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 transition bg-white">
                                ${statusOptionsHTML}
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Status Saat Ini</label>
                            <div id="currentStatusBadge" class="h-10 flex items-center">
                                ${getStatusBadgeHTML(item.status)}
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Terakhir Diupdate</label>
                            <div class="h-10 flex items-center text-sm text-slate-600">
                                <span id="lastUpdatedTime">${new Date().toLocaleString('id-ID')}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PHOTO INFO -->
                <div class="flex flex-wrap gap-3 mb-5">
                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">Galeri</span>
                    <span id="previewStatusBadge" class="px-3 py-1 rounded-full text-sm ${getStatusBadgeClass(item.status)}">
                        ${item.status}
                    </span>
                </div>

                <h1 class="text-3xl font-bold">${item.caption}</h1>

                <div class="flex gap-6 text-slate-500 text-sm mt-4">
                    <span> ${item.owner || 'Admin'}</span>
                    ${item.location ? `<span> ${item.location}</span>` : ''}
                    <span> ID: ${item.id}</span>
                </div>

                <hr class="my-7">

                <div class="prose max-w-none">
                    <p class="text-slate-600">Caption: <strong>"${item.caption}"</strong></p>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="flex flex-wrap justify-end gap-3 mt-10 pt-6 border-t">
                    <button id="modalCancelBtn" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 transition text-sm font-medium">Batal</button>
                    <button id="modalSaveBtn" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-black text-white transition text-sm font-medium flex items-center gap-2">
                        <iconify-icon icon="solar:check-circle-linear" width="18"></iconify-icon>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        `;

        modal.classList.remove("hidden");

        // EVENT LISTENERS
        document.getElementById("modalCancelBtn").onclick = function (e) {
            e.stopPropagation();
            closePreviewModal();
        };

        document.getElementById("modalSaveBtn").onclick = function (e) {
            e.stopPropagation();
            const newStatus = document.getElementById("modalStatusSelect").value;
            const oldStatus = currentEditingItem.status;

            if (newStatus === oldStatus) {
                showToast(`ℹ️ Tidak ada perubahan status, masih "${oldStatus}"`, 'info');
                closePreviewModal();
                return;
            }

            const index = allData.findIndex(i => i.id === currentEditingItem.id);
            if (index !== -1) {
                allData[index].status = newStatus;
                applyFilters();
                showToast(`✅ Status berhasil diubah dari "${oldStatus}" menjadi "${newStatus}"`, 'success');
                closePreviewModal();
            }
        };

        document.getElementById("modalStatusSelect").onchange = function (e) {
            e.stopPropagation();
            const newStatus = this.value;
            const previewBadge = document.getElementById("previewStatusBadge");
            previewBadge.textContent = newStatus;
            previewBadge.className = `px-3 py-1 rounded-full text-sm ${getStatusBadgeClass(newStatus)}`;
            document.getElementById("currentStatusBadge").innerHTML = getStatusBadgeHTML(newStatus);
            document.getElementById("lastUpdatedTime").textContent = new Date().toLocaleString('id-ID');
        };
    }

    function closePreviewModal() {
        document.getElementById("previewModal").classList.add("hidden");
        currentEditingItem = null;
    }

    // ==========================================================
    // HELPER FUNCTIONS
    // ==========================================================
    function getStatusBadgeClass(status) {
        const map = {
            'Pending': 'bg-amber-100 text-amber-700',
            'Published': 'bg-green-100 text-green-700',
            'Rejected': 'bg-red-100 text-red-700'
        };
        return map[status] || 'bg-slate-100 text-slate-700';
    }

    function getStatusBadgeHTML(status) {
        const colorClass = getStatusBadgeClass(status);
        return `<span class="px-3 py-1 rounded-full text-sm font-medium ${colorClass}">${status}</span>`;
    }

    // ==========================================================
    // DELETE MODAL
    // ==========================================================
    let deleteTarget = null;

    function openDeleteModal(item) {
        deleteTarget = item;
        document.getElementById("deleteArticleTitle").textContent = `"${item.caption}"`;
        document.getElementById("deleteArticleId").value = item.id;
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
            allData.splice(index, 1);
            applyFilters();
            showToast(`🗑️ Foto "${deleteTarget.caption}" berhasil dihapus`, 'warning');
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
        const gridDiv = document.querySelector("#galleryGrid");
        gridApi = agGrid.createGrid(gridDiv, gridOptions);
        refreshGrid();

        // SEARCH
        document.getElementById("searchInput").addEventListener("input", applyFilters);

        // FILTER
        document.getElementById("statusFilter").addEventListener("change", applyFilters);

        // PER PAGE
        document.getElementById("perPageSelect").addEventListener("change", function () {
            itemsPerPage = Number(this.value);
            currentPage = 1;
            refreshGrid();
        });

        // PREV / NEXT
        document.getElementById("prevPage").addEventListener("click", () => {
            if (currentPage > 1) { currentPage--; refreshGrid(); }
        });
        document.getElementById("nextPage").addEventListener("click", () => {
            if (currentPage < getTotalPages()) { currentPage++; refreshGrid(); }
        });

        // DELETE MODAL EVENTS
        document.getElementById("deleteCancelBtn").onclick = closeDeleteModal;
        document.getElementById("deleteConfirmBtn").onclick = confirmDelete;
        document.getElementById("deleteBackdrop").onclick = closeDeleteModal;

        // PREVIEW MODAL BACKDROP
        document.getElementById("previewBackdrop").onclick = closePreviewModal;
        document.getElementById("closePreviewModal").onclick = closePreviewModal;

        // CTRL + K
        document.addEventListener("keydown", e => {
            if ((e.ctrlKey || e.metaKey) && e.key === "k") {
                e.preventDefault();
                document.getElementById("searchInput").focus();
            }
            if (e.key === "Escape") {
                closeDeleteModal();
                closePreviewModal();
            }
        });

        // Mencegah klik di dalam modal menutup modal
        document.querySelector('#previewModal .bg-white')?.addEventListener('click', e => e.stopPropagation());
        document.querySelector('#deleteConfirmModal .bg-white')?.addEventListener('click', e => e.stopPropagation());
    });
</script>

<!-- ==========================================================
PREVIEW MODAL
========================================================== -->
<div id="previewModal" class="fixed inset-0 z-[9999] hidden">
    <div id="previewBackdrop" class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
    <div class="relative z-10 flex items-center justify-center min-h-screen p-6">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden animate-[fadeIn_.2s_ease]">
            <div class="flex items-center justify-between px-8 py-5 border-b">
                <h2 class="text-xl font-bold">Preview & Update Status</h2>
                <button id="closePreviewModal" class="w-10 h-10 rounded-xl hover:bg-slate-100 transition">
                    <iconify-icon icon="solar:close-circle-linear" width="24"></iconify-icon>
                </button>
            </div>
            <div id="previewContent" class="max-h-[75vh] overflow-y-auto"></div>
        </div>
    </div>
</div>

<!-- ==========================================================
DELETE CONFIRMATION MODAL
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
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Hapus Foto?</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Apakah Anda yakin ingin menghapus foto
                    <strong class="text-slate-900" id="deleteArticleTitle"></strong>?
                    <br>
                    <span class="text-red-500">Tindakan ini tidak dapat dibatalkan!</span>
                </p>
                <input type="hidden" id="deleteArticleId" value="">
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