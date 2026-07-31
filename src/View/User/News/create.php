<?php include '../Layouts/header.php' ?>

<style>
    .ck-editor__editable_inline {
        min-height: 600px;
        max-height: 800px;
    }

    .ck.ck-editor {
        margin-top: 1rem;
    }

    .ck.ck-toolbar {
        border-radius: 16px 16px 0 0;
    }

    .ck.ck-editor__main>.ck-editor__editable {
        border-radius: 0 0 16px 16px;
    }

    .counter-box {
        display: flex;
        justify-content: space-between;
        margin-top: 12px;
        font-size: 14px;
        color: #6B7280;
    }
</style>

<form action="" method="POST" enctype="multipart/form-data">

    <!-- ==========================================================
    PAGE HEADER
    ========================================================== -->

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10">

        <div>

            <a href="berita.php" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary transition">

                <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>

                <span>Kembali ke Artikel</span>

            </a>

            <h1 class="text-4xl font-bold mt-3">

                Tulis Artikel Baru

            </h1>

            <p class="text-gray-500 mt-2">

                Tulis dan publikasikan informasi terbaru untuk masyarakat Desa Bungur.

            </p>

        </div>

        <div class="flex flex-wrap gap-3">

            <button type="button" id="draftButton"
                class="h-12 px-6 rounded-2xl border border-gray-200 bg-white hover:bg-gray-50 transition">

                Simpan Draft

            </button>

            <button type="button"
                class="h-12 px-6 rounded-2xl border border-gray-200 bg-white hover:bg-gray-50 transition">

                Preview

            </button>

            <button type="submit" id="publishButton"
                class="h-12 px-7 rounded-2xl bg-primary text-white font-medium hover:opacity-90 transition">

                Publish

            </button>

        </div>

    </div>

    <!-- ==========================================================
    CONTENT
    ========================================================== -->

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        <!-- ==========================================================
        LEFT CONTENT
        ========================================================== -->

        <div class="lg:col-span-2 space-y-6">

            <!-- Judul -->

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

                <label class="block text-sm font-semibold text-gray-700">

                    Judul Artikel

                </label>

                <input id="title" name="title" type="text" placeholder="Masukkan judul artikel..."
                    class="mt-3 w-full h-14 rounded-2xl border border-gray-200 px-5 focus:outline-none focus:border-primary">

            </div>

            <!-- Slug -->

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

                <label class="block text-sm font-semibold text-gray-700">

                    Slug

                </label>

                <input id="slug" name="slug" readonly placeholder="slug-artikel"
                    class="mt-3 w-full h-14 rounded-2xl bg-gray-50 border border-gray-200 px-5">

            </div>

            <!-- Ringkasan -->

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

                <label class="block text-sm font-semibold text-gray-700">

                    Ringkasan Artikel

                </label>

                <textarea id="summary" name="summary" rows="5" placeholder="Tulis ringkasan singkat artikel..."
                    class="mt-3 w-full rounded-2xl border border-gray-200 p-5 resize-none focus:outline-none focus:border-primary"></textarea>

            </div>

            <!-- Editor -->

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

                <div class="flex items-center justify-between mb-5">

                    <div>

                        <h3 class="font-semibold">

                            Isi Artikel

                        </h3>

                        <p class="text-sm text-gray-500 mt-1">

                            Tulis isi artikel di editor.

                        </p>

                    </div>

                </div>

                <!-- CKEditor dipasang pada Part 2 -->

                <textarea id="editor" name="content"></textarea>

                <div class="counter-box">

                    <span id="wordCount">

                        0 Kata

                    </span>

                    <span id="readingTime">

                        0 Menit Membaca

                    </span>

                </div>
            </div>

            <!-- SEO -->

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

                <h3 class="text-xl font-bold mb-6">

                    SEO

                </h3>

                <div class="space-y-5">

                    <div>

                        <label class="block text-sm font-semibold">

                            Meta Title

                        </label>

                        <input id="metaTitle" name="meta_title" type="text"
                            class="mt-2 w-full h-12 rounded-xl border border-gray-200 px-4">

                    </div>

                    <div>

                        <label class="block text-sm font-semibold">

                            Meta Description

                        </label>

                        <textarea id="metaDescription" name="meta_description" rows="4"
                            class="mt-2 w-full rounded-xl border border-gray-200 p-4 resize-none"></textarea>

                    </div>

                </div>

            </div>

        </div>

        <!-- ==========================================================
        SIDEBAR
        ========================================================== -->

        <aside class="space-y-6 lg:sticky lg:top-28">

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">

                <div class="flex justify-between items-center">

                    <h3 class="font-semibold">

                        Kelengkapan Artikel

                    </h3>

                    <span id="progressText" class="font-bold text-primary">

                        0%

                    </span>

                </div>

                <div class="h-3 rounded-full bg-gray-200 mt-4 overflow-hidden">

                    <div id="progressBar" class="h-full bg-primary rounded-full transition-all" style="width:0%">
                    </div>

                </div>

                <p class="text-gray-500 text-sm mt-4">

                    Lengkapi artikel sebelum dipublikasikan.

                </p>

            </div>

            <!-- Thumbnail -->

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">

                <h3 class="font-semibold mb-5">

                    Thumbnail

                </h3>

                <label
                    class="cursor-pointer border-2 border-dashed border-gray-300 rounded-2xl h-56 flex justify-center items-center overflow-hidden">

                    <img id="previewImage" class="hidden w-full h-full object-cover">

                    <div id="uploadPlaceholder" class="text-center">

                        <iconify-icon icon="solar:gallery-add-linear" class="text-5xl text-primary"></iconify-icon>

                        <p class="mt-3">

                            Upload Thumbnail

                        </p>

                    </div>

                    <input id="thumbnail" type="file" name="thumbnail" hidden accept="image/*">

                </label>

            </div>

            <!-- Publish -->

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">

                <h3 class="font-semibold mb-5">

                    Publikasi

                </h3>

                <div class="space-y-5">

                    <div>

                        <label class="text-sm font-medium">

                            Kategori

                        </label>

                        <select id="category" name="category"
                            class="mt-2 w-full h-12 rounded-xl border border-gray-200 px-4">

                            <option>Berita</option>
                            <option>Agenda</option>
                            <option>UMKM</option>
                            <option>Wisata</option>
                            <option>Pemerintahan</option>

                        </select>

                    </div>

                    <div>

                        <label class="text-sm font-medium">

                            Status

                        </label>

                        <select id="status" name="status"
                            class="mt-2 w-full h-12 rounded-xl border border-gray-200 px-4">

                            <option>Draft</option>
                            <option>Pending Review</option>
                            <option>Publish</option>

                        </select>

                    </div>

                    <div>

                        <label class="text-sm font-medium">

                            Tag

                        </label>

                        <input id="tags" type="text" name="tags">
                    </div>

                </div>

            </div>

        </aside>

    </div>

</form>

<script>

    (function () {
        'use strict';

        // ============================================================
        // 1. DOM REFERENCES - Semua referensi elemen diinisialisasi di sini
        // ============================================================

        const DOM = {
            // Form elements
            form: document.querySelector('form'),
            title: document.getElementById('title'),
            slug: document.getElementById('slug'),
            summary: document.getElementById('summary'),
            editor: document.getElementById('editor'),
            thumbnail: document.getElementById('thumbnail'),
            category: document.getElementById('category'),
            status: document.getElementById('status'),
            tags: document.getElementById('tags'),

            // UI elements
            previewImage: document.getElementById('previewImage'),
            uploadPlaceholder: document.getElementById('uploadPlaceholder'),
            wordCount: document.getElementById('wordCount'),
            readingTime: document.getElementById('readingTime'),
            progressBar: document.getElementById('progressBar'),
            progressText: document.getElementById('progressText'),

            // Buttons
            draftButton: document.getElementById('draftButton'),
            publishButton: document.getElementById('publishButton'),

            // SEO
            metaTitle: document.getElementById('metaTitle'),
            metaDescription: document.getElementById('metaDescription')
        };

        // Validasi elemen penting
        const requiredElements = ['form', 'title', 'slug', 'summary', 'editor', 'thumbnail', 'category'];
        for (const key of requiredElements) {
            if (!DOM[key]) {
                console.error(`Elemen #${key} tidak ditemukan di DOM`);
                return;
            }
        }

        // ============================================================
        // 2. STATE MANAGEMENT - State aplikasi terpusat
        // ============================================================

        const state = {
            editor: null,           // CKEditor instance
            tagify: null,           // Tagify instance
            isEditorReady: false,   // Flag untuk mengecek kesiapan editor
            isChanged: false,       // Flag untuk beforeunload
            autosaveInterval: null, // Reference untuk interval
            draftKey: 'draft_article',
            isRestoring: false      // Flag untuk mencegah race condition
        };

        // ============================================================
        // 3. UTILITY FUNCTIONS - Fungsi-fungsi pembantu
        // ============================================================

        const Utils = {
            /**
             * Generate slug dari string
             */
            generateSlug: function (text) {
                return text
                    .toLowerCase()
                    .trim()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            },

            /**
             * Hitung jumlah kata dari HTML content
             */
            countWords: function (html) {
                if (!html) return 0;
                const text = html
                    .replace(/<[^>]*>/g, ' ')
                    .replace(/&nbsp;/g, ' ')
                    .trim();
                return text === '' ? 0 : text.split(/\s+/).length;
            },

            /**
             * Hitung reading time
             */
            calculateReadingTime: function (words) {
                return Math.max(1, Math.ceil(words / 200));
            },

            /**
             * Format angka dengan satuan
             */
            formatWithUnit: function (number, unit) {
                return `${number} ${unit}`;
            },

            /**
             * Throttle function
             */
            throttle: function (fn, delay = 300) {
                let timeout = null;
                return function (...args) {
                    if (timeout) return;
                    timeout = setTimeout(() => {
                        fn.apply(this, args);
                        timeout = null;
                    }, delay);
                };
            },

            /**
             * Debounce function
             */
            debounce: function (fn, delay = 500) {
                let timeout = null;
                return function (...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        fn.apply(this, args);
                    }, delay);
                };
            },

            /**
             * Safe check if plugin exists in CKEditor
             */
            pluginExists: function (pluginName) {
                try {
                    if (!window.CKEDITOR || !window.CKEDITOR.ClassicEditor) {
                        return false;
                    }
                    // Cek apakah plugin tersedia di CKEDITOR
                    return typeof window.CKEDITOR[pluginName] !== 'undefined';
                } catch (e) {
                    return false;
                }
            },

            /**
             * Get available plugins from CKEDITOR
             */
            getAvailablePlugins: function (pluginNames) {
                const available = [];
                for (const name of pluginNames) {
                    try {
                        if (window.CKEDITOR[name] && typeof window.CKEDITOR[name] === 'function') {
                            available.push(window.CKEDITOR[name]);
                        }
                    } catch (e) {
                        // Plugin tidak tersedia
                    }
                }
                return available;
            }
        };

        // ============================================================
        // 4. CKEDITOR INITIALIZATION - Inisialisasi CKEditor 5 Self-Hosted
        // ============================================================

        /**
         * Cek apakah CKEditor sudah tersedia (loaded via UMD)
         */
        function isCKEditorAvailable() {
            return typeof window.CKEDITOR !== 'undefined' &&
                typeof window.CKEDITOR.ClassicEditor !== 'undefined';
        }

        /**
         * Inisialisasi CKEditor 5 dari UMD (self-hosted)
         */
        async function initEditor() {
            try {
                // Cek apakah CKEditor sudah tersedia
                if (!isCKEditorAvailable()) {
                    throw new Error('CKEditor tidak ditemukan. Pastikan file ckeditor5.umd.js sudah di-load.');
                }

                const CKEDITOR = window.CKEDITOR;
                const { ClassicEditor } = CKEDITOR;

                // Daftar plugin yang diinginkan (coba load semua yang tersedia)
                const pluginNames = [
                    'Essentials',
                    'Paragraph',
                    'Heading',
                    'Bold',
                    'Italic',
                    'Underline',
                    'Strikethrough',
                    'Link',
                    'List',
                    'Indent',
                    'BlockQuote',
                    'Table',
                    'TableToolbar',
                    'Image',
                    'ImageToolbar',
                    'ImageCaption',
                    'ImageStyle',
                    'ImageResize',
                    'ImageUpload',
                    'Base64UploadAdapter',
                    'MediaEmbed',
                    'Undo',
                    'Redo'
                ];

                // Ambil plugin yang tersedia
                const availablePlugins = Utils.getAvailablePlugins(pluginNames);

                if (availablePlugins.length === 0) {
                    console.warn('Tidak ada plugin yang ditemukan, menggunakan konfigurasi minimal');
                } else {
                    console.log(`✅ ${availablePlugins.length} plugin ditemukan dan akan digunakan`);
                }

                // Pastikan editor element ada
                if (!DOM.editor) {
                    throw new Error('Editor element tidak ditemukan');
                }

                // Toolbar items yang tersedia (hanya yang didukung)
                const toolbarItems = [
                    'undo', 'redo',
                    '|',
                    'heading',
                    '|',
                    'bold', 'italic', 'underline', 'strikethrough',
                    '|',
                    'link',
                    '|',
                    'bulletedList', 'numberedList',
                    '|',
                    'outdent', 'indent',
                    '|',
                    'insertTable',
                    'uploadImage',
                    'mediaEmbed',
                    'blockQuote'
                ];

                // Filter toolbar items yang tersedia
                const availableToolbarItems = [];
                for (const item of toolbarItems) {
                    if (item === '|') {
                        availableToolbarItems.push(item);
                    } else {
                        // Cek apakah item toolbar tersedia di editor
                        try {
                            // Untuk heading, bold, italic, dll biasanya selalu tersedia
                            availableToolbarItems.push(item);
                        } catch (e) {
                            console.warn(`Toolbar item "${item}" tidak tersedia`);
                        }
                    }
                }

                // Build konfigurasi
                const config = {
                    licenseKey: 'GPL',
                    plugins: availablePlugins,
                    toolbar: {
                        items: availableToolbarItems
                    },
                    language: 'id'
                };

                // Tambahkan konfigurasi image jika plugin Image tersedia
                const hasImage = pluginNames.some(name =>
                    name === 'Image' || name === 'ImageToolbar' || name === 'ImageUpload'
                );

                if (hasImage) {
                    config.image = {
                        toolbar: [
                            'imageStyle:inline',
                            'imageStyle:block',
                            'imageStyle:side',
                            '|',
                            'imageTextAlternative'
                        ]
                    };
                }

                // Tambahkan konfigurasi table jika plugin Table tersedia
                const hasTable = pluginNames.some(name =>
                    name === 'Table' || name === 'TableToolbar'
                );

                if (hasTable) {
                    config.table = {
                        contentToolbar: [
                            'tableColumn',
                            'tableRow',
                            'mergeTableCells'
                        ]
                    };
                }

                // Buat editor
                const editor = await ClassicEditor.create(DOM.editor, config);

                state.editor = editor;
                state.isEditorReady = true;

                // Setup event listener untuk word counter & reading time
                setupEditorEvents(editor);

                // Update progress setelah editor siap
                updateProgress();

                // Update word counter
                updateWordCounter(editor);

                console.log('✅ CKEditor berhasil diinisialisasi');

                return editor;

            } catch (error) {
                console.error('❌ Error inisialisasi CKEditor:', error);

                // Fallback: tampilkan textarea biasa
                if (DOM.editor) {
                    DOM.editor.style.display = 'block';
                    DOM.editor.style.minHeight = '600px';
                    DOM.editor.style.border = '1px solid #ddd';
                    DOM.editor.style.padding = '10px';
                    DOM.editor.style.borderRadius = '8px';
                    DOM.editor.style.fontFamily = 'Arial, sans-serif';
                }

                throw error;
            }
        }

        /**
         * Setup event listener untuk CKEditor
         */
        function setupEditorEvents(editor) {
            if (!editor) return;

            const throttledUpdate = Utils.throttle(function () {
                if (!state.isEditorReady) return;
                updateWordCounter(editor);
                updateProgress();
                markAsChanged(true);
            }, 200);

            editor.model.document.on('change:data', throttledUpdate);
        }

        /**
         * Update word counter dan reading time
         */
        function updateWordCounter(editor) {
            if (!editor || !state.isEditorReady) return;

            try {
                const content = editor.getData();
                const words = Utils.countWords(content);
                const readingTime = Utils.calculateReadingTime(words);

                if (DOM.wordCount) {
                    DOM.wordCount.textContent = Utils.formatWithUnit(words, 'Kata');
                }
                if (DOM.readingTime) {
                    DOM.readingTime.textContent = Utils.formatWithUnit(readingTime, 'Menit Membaca');
                }
            } catch (error) {
                console.warn('Error updating word counter:', error);
            }
        }

        // ============================================================
        // 5. OTHER INIT FUNCTIONS
        // ============================================================

        /**
         * Inisialisasi auto slug dari title
         */
        function initSlug() {
            if (!DOM.title || !DOM.slug) return;

            const generateSlugFromTitle = Utils.debounce(function () {
                const titleValue = DOM.title.value.trim();
                if (titleValue) {
                    DOM.slug.value = Utils.generateSlug(titleValue);
                    updateProgress();
                    markAsChanged(true);
                }
            }, 300);

            DOM.title.addEventListener('input', generateSlugFromTitle);
        }

        /**
         * Inisialisasi thumbnail preview
         */
        function initThumbnail() {
            if (!DOM.thumbnail) return;

            DOM.thumbnail.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;

                if (!file.type.startsWith('image/')) {
                    alert('Mohon upload file gambar');
                    this.value = '';
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar (max 5MB)');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    if (DOM.previewImage) {
                        DOM.previewImage.src = e.target.result;
                        DOM.previewImage.classList.remove('hidden');
                    }
                    if (DOM.uploadPlaceholder) {
                        DOM.uploadPlaceholder.classList.add('hidden');
                    }
                    updateProgress();
                    markAsChanged(true);
                };
                reader.onerror = function () {
                    alert('Gagal membaca file');
                };
                reader.readAsDataURL(file);
            });
        }

        /**
         * Inisialisasi Tagify
         */
        function initTagify() {
            if (typeof Tagify === 'undefined') {
                console.warn('Tagify tidak ditemukan');
                return;
            }

            if (!DOM.tags) {
                console.warn('Tag element tidak ditemukan');
                return;
            }

            try {
                state.tagify = new Tagify(DOM.tags, {
                    dropdown: {
                        enabled: 0
                    },
                    maxTags: 10,
                    editTags: false,
                    placeholder: 'Tambahkan tag...'
                });

                if (state.tagify) {
                    state.tagify.on('change', function () {
                        markAsChanged(true);
                    });
                }
            } catch (error) {
                console.error('Error inisialisasi Tagify:', error);
            }
        }

        /**
         * Inisialisasi progress bar
         */
        function initProgress() {
            const progressElements = [
                DOM.title,
                DOM.slug,
                DOM.summary,
                DOM.thumbnail,
                DOM.category
            ];

            const update = Utils.debounce(updateProgress, 200);

            progressElements.forEach(element => {
                if (element) {
                    element.addEventListener('input', update);
                    element.addEventListener('change', update);
                }
            });

            const progressInterval = setInterval(() => {
                if (state.isEditorReady) {
                    updateProgress();
                }
            }, 1000);

            state.progressInterval = progressInterval;
        }

        /**
         * Update progress artikel
         */
        function updateProgress() {
            try {
                let score = 0;

                if (DOM.title && DOM.title.value.trim()) score += 20;
                if (DOM.slug && DOM.slug.value.trim()) score += 10;
                if (DOM.summary && DOM.summary.value.trim()) score += 20;

                if (state.isEditorReady && state.editor) {
                    try {
                        const content = state.editor.getData();
                        if (Utils.countWords(content) > 0) score += 30;
                    } catch (e) {
                        // Ignore error
                    }
                }

                if (DOM.thumbnail && DOM.thumbnail.files && DOM.thumbnail.files.length > 0) score += 10;
                if (DOM.category && DOM.category.value && DOM.category.value !== '') score += 10;

                score = Math.min(100, score);

                if (DOM.progressBar) {
                    DOM.progressBar.style.width = score + '%';
                }
                if (DOM.progressText) {
                    DOM.progressText.textContent = score + '%';
                }
            } catch (error) {
                console.warn('Error updating progress:', error);
            }
        }

        /**
         * Inisialisasi autosave ke localStorage
         */
        function initAutosave() {
            state.autosaveInterval = setInterval(function () {
                saveDraft();
            }, 30000);

            const saveOnChange = Utils.debounce(function () {
                if (state.isChanged) {
                    saveDraft();
                }
            }, 2000);

            if (DOM.form) {
                DOM.form.addEventListener('input', saveOnChange);
            }
        }

        /**
         * Simpan draft ke localStorage
         */
        function saveDraft() {
            try {
                const draft = {
                    title: DOM.title ? DOM.title.value || '' : '',
                    slug: DOM.slug ? DOM.slug.value || '' : '',
                    summary: DOM.summary ? DOM.summary.value || '' : '',
                    content: (state.isEditorReady && state.editor) ? state.editor.getData() || '' : '',
                    metaTitle: DOM.metaTitle ? DOM.metaTitle.value : '',
                    metaDescription: DOM.metaDescription ? DOM.metaDescription.value : '',
                    category: DOM.category ? DOM.category.value || '' : '',
                    status: DOM.status ? DOM.status.value || '' : '',
                    tags: state.tagify ? state.tagify.value : '',
                    timestamp: Date.now()
                };

                localStorage.setItem(state.draftKey, JSON.stringify(draft));
            } catch (error) {
                console.warn('Error saving draft:', error);
            }
        }

        /**
         * Restore draft dari localStorage
         */
        function initRestoreDraft() {
            const draftData = localStorage.getItem(state.draftKey);
            if (!draftData) return;

            const maxAttempts = 50;
            let attempts = 0;

            const checkEditor = setInterval(function () {
                attempts++;

                if (state.isEditorReady && state.editor) {
                    clearInterval(checkEditor);
                    restoreDraft();
                } else if (attempts >= maxAttempts) {
                    clearInterval(checkEditor);
                    console.warn('Timeout restoring draft - editor not ready');
                    restoreDraftPartial();
                }
            }, 100);
        }

        /**
         * Restore draft lengkap
         */
        function restoreDraft() {
            if (state.isRestoring) return;
            state.isRestoring = true;

            try {
                const draftData = localStorage.getItem(state.draftKey);
                if (!draftData) {
                    state.isRestoring = false;
                    return;
                }

                const draft = JSON.parse(draftData);
                if (!draft || typeof draft !== 'object') {
                    state.isRestoring = false;
                    return;
                }

                if (draft.title && DOM.title) DOM.title.value = draft.title;
                if (draft.slug && DOM.slug) DOM.slug.value = draft.slug;
                if (draft.summary && DOM.summary) DOM.summary.value = draft.summary;
                if (draft.metaTitle && DOM.metaTitle) DOM.metaTitle.value = draft.metaTitle;
                if (draft.metaDescription && DOM.metaDescription) DOM.metaDescription.value = draft.metaDescription;
                if (draft.category && DOM.category) DOM.category.value = draft.category;
                if (draft.status && DOM.status) DOM.status.value = draft.status;

                if (draft.tags && state.tagify) {
                    try {
                        state.tagify.loadOriginalValues(JSON.parse(draft.tags));
                    } catch (e) {
                        // Ignore
                    }
                }

                if (draft.content && state.isEditorReady && state.editor) {
                    try {
                        state.editor.setData(draft.content);
                        setTimeout(() => {
                            updateWordCounter(state.editor);
                            updateProgress();
                        }, 100);
                    } catch (error) {
                        console.warn('Error restoring content:', error);
                    }
                }

                updateProgress();
                markAsChanged(false);

                console.log('✅ Draft berhasil direstore');

            } catch (error) {
                console.warn('Error restoring draft:', error);
            } finally {
                state.isRestoring = false;
            }
        }

        /**
         * Restore draft partial (tanpa content)
         */
        function restoreDraftPartial() {
            try {
                const draftData = localStorage.getItem(state.draftKey);
                if (!draftData) return;

                const draft = JSON.parse(draftData);
                if (!draft || typeof draft !== 'object') return;

                if (draft.title && DOM.title) DOM.title.value = draft.title;
                if (draft.slug && DOM.slug) DOM.slug.value = draft.slug;
                if (draft.summary && DOM.summary) DOM.summary.value = draft.summary;
                if (draft.category && DOM.category) DOM.category.value = draft.category;

                if (draft.content) {
                    const contentWatcher = setInterval(function () {
                        if (state.isEditorReady && state.editor && !state.isRestoring) {
                            clearInterval(contentWatcher);
                            try {
                                state.editor.setData(draft.content);
                                setTimeout(() => {
                                    updateWordCounter(state.editor);
                                    updateProgress();
                                }, 100);
                            } catch (error) {
                                console.warn('Error restoring content:', error);
                            }
                        }
                    }, 200);

                    setTimeout(() => {
                        clearInterval(contentWatcher);
                    }, 5000);
                }

                updateProgress();

            } catch (error) {
                console.warn('Error restoring draft partial:', error);
            }
        }

        /**
         * Inisialisasi publish button dengan SweetAlert2
         */
        function initPublish() {
            if (!DOM.publishButton || !DOM.form) return;

            DOM.publishButton.addEventListener('click', function (e) {
                e.preventDefault();

                if (typeof Swal === 'undefined') {
                    console.warn('SweetAlert2 tidak ditemukan');
                    DOM.form.submit();
                    return;
                }

                if (state.isEditorReady && state.editor) {
                    try {
                        const content = state.editor.getData();
                        if (Utils.countWords(content) < 10) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Konten Terlalu Pendek',
                                text: 'Minimal 10 kata untuk publikasi',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#3085d6'
                            });
                            return;
                        }
                    } catch (error) {
                        console.warn('Error checking content:', error);
                    }
                }

                Swal.fire({
                    title: 'Publish Artikel?',
                    text: 'Artikel akan dipublikasikan dan dapat dilihat oleh publik.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Publish!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        localStorage.removeItem(state.draftKey);
                        DOM.form.submit();
                    }
                });
            });
        }

        /**
         * Inisialisasi draft button dengan SweetAlert2
         */
        function initDraft() {
            if (!DOM.draftButton) return;

            DOM.draftButton.addEventListener('click', function () {
                saveDraft();

                if (typeof Swal === 'undefined') {
                    alert('Draft berhasil disimpan');
                    return;
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Draft Disimpan',
                    text: 'Artikel berhasil disimpan sebagai draft',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        }

        /**
         * Mark as changed untuk beforeunload
         */
        function markAsChanged(value = true) {
            state.isChanged = value;
        }

        /**
         * Inisialisasi beforeunload handler
         */
        function initBeforeUnload() {
            const unloadHandler = function (e) {
                if (!state.isChanged) return;
                saveDraft();
                const message = 'Anda memiliki perubahan yang belum disimpan. Yakin ingin keluar?';
                e.preventDefault();
                e.returnValue = message;
                return message;
            };

            window.addEventListener('beforeunload', unloadHandler);
            window.addEventListener('pagehide', function (e) {
                if (state.isChanged) {
                    saveDraft();
                }
            });
        }

        /**
         * Inisialisasi Chart.js dengan pengecekan null yang ketat
         */
        function initChartJS() {

            if (typeof Chart === 'undefined') {
                console.warn('Chart.js tidak ditemukan');
                return;
            }

            const canvas = document.getElementById('myChart');

            if (!canvas) {
                console.warn('Canvas dengan ID "myChart" tidak ditemukan');
                return;
            }

            try {

                const ctx = canvas.getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                        datasets: [{
                            label: 'Artikel',
                            data: [12, 19, 3, 5, 2, 3],
                            backgroundColor: 'rgba(54,162,235,.2)',
                            borderColor: 'rgba(54,162,235,1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });

                console.log('✅ Chart.js berhasil diinisialisasi');

            } catch (error) {

                console.warn('Error inisialisasi Chart.js:', error);

            }

        }

        /**
         * Cleanup semua resources
         */
        function cleanup() {
            if (state.autosaveInterval) {
                clearInterval(state.autosaveInterval);
                state.autosaveInterval = null;
            }

            if (state.progressInterval) {
                clearInterval(state.progressInterval);
                state.progressInterval = null;
            }

            if (state.tagify) {
                try {
                    state.tagify.destroy();
                } catch (error) {
                    // Ignore
                }
                state.tagify = null;
            }

            if (state.editor) {
                try {
                    state.editor.destroy();
                } catch (error) {
                    // Ignore
                }
                state.editor = null;
                state.isEditorReady = false;
            }
        }

        // ============================================================
        // 6. APPLICATION INITIALIZATION
        // ============================================================

        /**
         * Main initialization function
         */
        async function initApp() {
            try {
                // 1. Inisialisasi komponen yang tidak memerlukan editor
                initSlug();
                initThumbnail();
                initTagify();
                initProgress();
                initBeforeUnload();
                initPublish();
                initDraft();

                // 2. Inisialisasi editor (async)
                await initEditor();

                // 3. Setup autosave dan restore setelah editor siap
                initAutosave();
                initRestoreDraft();

                // 4. Set initial state
                markAsChanged(false);

                console.log('✅ Aplikasi berhasil diinisialisasi');

            } catch (error) {
                console.error('❌ Error inisialisasi aplikasi:', error);
            }
        }

        // ============================================================
        // 7. START APPLICATION
        // ============================================================

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initApp);
        } else {
            initApp();
        }

        window.addEventListener('pagehide', cleanup);

    })();
</script>

<?php include '../Layouts/footer.php' ?>