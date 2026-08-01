<?php
/**
 * @var array $model
 * 
 * Data yang tersedia dalam $model:
 * - title: string
 * - current: string
 * - user: object
 * - article: object
 * - categories: array
 * - breadcrumbs: array
 * - errors: array|null (ditambahkan saat validasi error)
 * - old: array|null (ditambahkan saat validasi error)
 */
?>

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

<form action="/user/news/edit/<?= $model['article']->id ?>" method="POST" enctype="multipart/form-data">

    <!-- ==========================================================
    PAGE HEADER
    ========================================================== -->

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10">

        <div>

            <a href="/user/news" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary transition">

                <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>

                <span>Kembali ke berita</span>

            </a>

            <h1 class="text-4xl font-bold mt-3">

                <?= htmlspecialchars($model['title'] ?? 'Edit Berita') ?>

            </h1>

            <p class="text-gray-500 mt-2">

                Edit dan perbarui informasi terbaru untuk masyarakat Desa Bungur.

            </p>

        </div>

        <div class="flex flex-wrap gap-3">
            <button type="submit" id="uploadButton"
                class="h-12 px-7 rounded-2xl bg-primary text-white font-medium hover:opacity-90 transition">
                <iconify-icon icon="solar:upload-linear" class="text-xl"></iconify-icon>
                Update Berita
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

                    Judul Berita <span class="text-red-500">*</span>

                </label>

                <input id="title" name="title" type="text" placeholder="Masukkan judul berita..."
                    value="<?= htmlspecialchars($model['old']['title'] ?? $model['article']->title ?? '') ?>"
                    class="mt-3 w-full h-14 rounded-2xl border border-gray-200 px-5 focus:outline-none focus:border-primary <?= isset($model['errors']['title']) ? 'border-red-500' : '' ?>">

                <?php if (isset($model['errors']['title'])): ?>
                    <p class="text-red-500 text-sm mt-2"><?= htmlspecialchars($model['errors']['title']) ?></p>
                <?php endif; ?>

            </div>

            <!-- Slug -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

                <label class="block text-sm font-semibold text-gray-700">

                    Slug

                </label>

                <input id="slug" name="slug" readonly placeholder="slug-berita"
                    value="<?= htmlspecialchars($model['old']['slug'] ?? $model['article']->slug ?? '') ?>"
                    class="mt-3 w-full h-14 rounded-2xl bg-gray-50 border border-gray-200 px-5">

            </div>

            <!-- Ringkasan -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

                <label class="block text-sm font-semibold text-gray-700">

                    Ringkasan Berita

                </label>

                <textarea id="summary" name="excerpt" rows="5"
                    placeholder="Tulis ringkasan singkat berita... (kosongkan untuk generate otomatis)"
                    class="mt-3 w-full rounded-2xl border border-gray-200 p-5 resize-none focus:outline-none focus:border-primary <?= isset($model['errors']['excerpt']) ? 'border-red-500' : '' ?>"><?= htmlspecialchars($model['old']['excerpt'] ?? $model['article']->excerpt ?? '') ?></textarea>

                <p class="text-gray-400 text-sm mt-2">Kosongkan untuk generate otomatis dari konten (maksimal 200
                    karakter)</p>

            </div>

            <!-- Editor -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

                <div class="flex items-center justify-between mb-5">

                    <div>

                        <h3 class="font-semibold">

                            Isi Berita <span class="text-red-500">*</span>

                        </h3>

                        <p class="text-sm text-gray-500 mt-1">

                            Tulis isi berita di editor.

                        </p>

                    </div>

                </div>

                <textarea id="editor"
                    name="content"><?= htmlspecialchars($model['old']['content'] ?? $model['article']->content ?? '') ?></textarea>

                <?php if (isset($model['errors']['content'])): ?>
                    <p class="text-red-500 text-sm mt-2"><?= htmlspecialchars($model['errors']['content']) ?></p>
                <?php endif; ?>

                <div class="counter-box">

                    <span id="wordCount">

                        0 Kata

                    </span>

                    <span id="readingTime">

                        0 Menit Membaca

                    </span>

                </div>
            </div>

        </div>

        <!-- ==========================================================
        SIDEBAR
        ========================================================== -->

        <aside class="space-y-6 lg:sticky lg:top-28">

            <!-- Thumbnail -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">

                <h3 class="font-semibold mb-5">

                    Thumbnail

                </h3>

                <label
                    class="cursor-pointer border-2 border-dashed border-gray-300 rounded-2xl h-56 flex justify-center items-center overflow-hidden">

                    <img id="previewImage"
                        src="<?= !empty($model['article']->image) && $model['article']->image !== 'default-news.jpg' ? '/uploads/articles/' . htmlspecialchars($model['article']->image) : '' ?>"
                        class="<?= !empty($model['article']->image) && $model['article']->image !== 'default-news.jpg' ? 'w-full h-full object-cover' : 'hidden' ?>">

                    <div id="uploadPlaceholder"
                        class="<?= !empty($model['article']->image) && $model['article']->image !== 'default-news.jpg' ? 'hidden' : 'text-center' ?>">

                        <iconify-icon icon="solar:gallery-add-linear" class="text-5xl text-primary"></iconify-icon>

                        <p class="mt-3">

                            Upload Thumbnail

                        </p>

                        <p class="text-gray-400 text-sm mt-1">JPG, PNG, WEBP, GIF (Max 2MB)</p>

                    </div>

                    <input id="thumbnail" type="file" name="image" hidden accept="image/*">

                </label>

                <?php if (!empty($model['article']->image) && $model['article']->image !== 'default-news.jpg'): ?>
                    <p class="text-sm text-gray-500 mt-3">
                        <iconify-icon icon="solar:check-circle-linear" class="text-green-500"></iconify-icon>
                        Thumbnail saat ini
                    </p>
                    <p class="text-sm text-gray-400 mt-1">Upload gambar baru untuk mengganti thumbnail</p>
                <?php endif; ?>

            </div>

            <!-- Publikasi -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">

                <h3 class="font-semibold mb-5">

                    Publikasi

                </h3>

                <div class="space-y-5">

                    <div>

                        <label class="text-sm font-medium">

                            Kategori <span class="text-red-500">*</span>

                        </label>

                        <select id="category" name="category_id"
                            class="mt-2 w-full h-12 rounded-xl border border-gray-200 px-4 focus:outline-none focus:border-primary <?= isset($model['errors']['category_id']) ? 'border-red-500' : '' ?>">

                            <?php foreach ($model['categories'] as $category): ?>
                                <option value="<?= $category->id ?>" <?= (isset($model['old']['category_id']) && $model['old']['category_id'] == $category->id) ||
                                      (!isset($model['old']['category_id']) && $model['article']->categoryId == $category->id)
                                      ? 'selected'
                                      : '' ?>>
                          <?= htmlspecialchars($category->name) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>

                        <?php if (isset($model['errors']['category_id'])): ?>
                            <p class="text-red-500 text-sm mt-2"><?= htmlspecialchars($model['errors']['category_id']) ?>
                            </p>
                        <?php endif; ?>

                    </div>

                    <div>

                        <label class="text-sm font-medium">

                            Status

                        </label>

                        <select id="status" name="status"
                            class="mt-2 w-full h-12 rounded-xl border border-gray-200 px-4 focus:outline-none focus:border-primary <?= isset($model['errors']['status']) ? 'border-red-500' : '' ?>">

                            <option value="draft" <?= (isset($model['old']['status']) && $model['old']['status'] === 'draft') ||
                                (!isset($model['old']['status']) && $model['article']->status === 'draft') ? 'selected' : '' ?>>Draft</option>
                            <option value="published" <?= (isset($model['old']['status']) && $model['old']['status'] === 'published') ||
                                (!isset($model['old']['status']) && $model['article']->status === 'published') ? 'selected' : '' ?>>Published</option>

                        </select>

                        <?php if (isset($model['errors']['status'])): ?>
                            <p class="text-red-500 text-sm mt-2"><?= htmlspecialchars($model['errors']['status']) ?></p>
                        <?php endif; ?>

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
        // 1. DOM REFERENCES
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

            // UI elements
            previewImage: document.getElementById('previewImage'),
            uploadPlaceholder: document.getElementById('uploadPlaceholder'),
            wordCount: document.getElementById('wordCount'),
            readingTime: document.getElementById('readingTime'),

            // Buttons
            uploadButton: document.getElementById('uploadButton')
        };

        // Validasi elemen penting
        const requiredElements = ['form', 'title', 'slug', 'summary', 'editor', 'thumbnail', 'category', 'status'];
        for (const key of requiredElements) {
            if (!DOM[key]) {
                console.error(`Elemen #${key} tidak ditemukan di DOM`);
                return;
            }
        }

        // ============================================================
        // 2. STATE MANAGEMENT
        // ============================================================

        const state = {
            editor: null,
            isEditorReady: false,
            isChanged: false,
            autosaveInterval: null,
            draftKey: 'edit_article_<?= $model['article']->id ?>'
        };

        // ============================================================
        // 3. UTILITY FUNCTIONS
        // ============================================================

        const Utils = {
            generateSlug: function (text) {
                return text
                    .toLowerCase()
                    .trim()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            },

            countWords: function (html) {
                if (!html) return 0;
                const text = html
                    .replace(/<[^>]*>/g, ' ')
                    .replace(/&nbsp;/g, ' ')
                    .trim();
                return text === '' ? 0 : text.split(/\s+/).length;
            },

            calculateReadingTime: function (words) {
                return Math.max(1, Math.ceil(words / 200));
            },

            formatWithUnit: function (number, unit) {
                return `${number} ${unit}`;
            },

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

            debounce: function (fn, delay = 500) {
                let timeout = null;
                return function (...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        fn.apply(this, args);
                    }, delay);
                };
            },

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
        // 4. CKEDITOR INITIALIZATION
        // ============================================================

        function isCKEditorAvailable() {
            return typeof window.CKEDITOR !== 'undefined' &&
                typeof window.CKEDITOR.ClassicEditor !== 'undefined';
        }

        async function initEditor() {
            try {
                if (!isCKEditorAvailable()) {
                    throw new Error('CKEditor tidak ditemukan. Pastikan file ckeditor5.umd.js sudah di-load.');
                }

                const CKEDITOR = window.CKEDITOR;
                const { ClassicEditor } = CKEDITOR;

                const pluginNames = [
                    'Essentials', 'Paragraph', 'Heading', 'Bold', 'Italic',
                    'Underline', 'Strikethrough', 'Link', 'List', 'Indent',
                    'BlockQuote', 'Table', 'TableToolbar', 'Image', 'ImageToolbar',
                    'ImageCaption', 'ImageStyle', 'ImageResize', 'ImageUpload',
                    'Base64UploadAdapter', 'MediaEmbed', 'Undo', 'Redo'
                ];

                const availablePlugins = Utils.getAvailablePlugins(pluginNames);

                if (!DOM.editor) {
                    throw new Error('Editor element tidak ditemukan');
                }

                const toolbarItems = [
                    'undo', 'redo', '|',
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'link', '|',
                    'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'insertTable', 'uploadImage', 'mediaEmbed', 'blockQuote'
                ];

                const config = {
                    licenseKey: 'GPL',
                    plugins: availablePlugins,
                    toolbar: { items: toolbarItems },
                    language: 'id'
                };

                const hasImage = pluginNames.some(name =>
                    name === 'Image' || name === 'ImageToolbar' || name === 'ImageUpload'
                );

                if (hasImage) {
                    config.image = {
                        toolbar: ['imageStyle:inline', 'imageStyle:block', 'imageStyle:side', '|', 'imageTextAlternative']
                    };
                }

                const hasTable = pluginNames.some(name =>
                    name === 'Table' || name === 'TableToolbar'
                );

                if (hasTable) {
                    config.table = {
                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                    };
                }

                const editor = await ClassicEditor.create(DOM.editor, config);

                state.editor = editor;
                state.isEditorReady = true;

                setupEditorEvents(editor);
                updateWordCounter(editor);

                console.log('✅ CKEditor berhasil diinisialisasi');

                return editor;

            } catch (error) {
                console.error('❌ Error inisialisasi CKEditor:', error);

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

        function setupEditorEvents(editor) {
            if (!editor) return;

            const throttledUpdate = Utils.throttle(function () {
                if (!state.isEditorReady) return;
                updateWordCounter(editor);
                markAsChanged(true);
            }, 200);

            editor.model.document.on('change:data', throttledUpdate);
        }

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
        // 5. FEATURE FUNCTIONS
        // ============================================================

        // SLUG
        function initSlug() {
            if (!DOM.title || !DOM.slug) return;

            const generateSlugFromTitle = Utils.debounce(function () {
                const titleValue = DOM.title.value.trim();
                if (titleValue) {
                    DOM.slug.value = Utils.generateSlug(titleValue);
                    markAsChanged(true);
                }
            }, 300);

            DOM.title.addEventListener('input', generateSlugFromTitle);
        }

        // THUMBNAIL
        function initThumbnail() {
            if (!DOM.thumbnail) return;

            DOM.thumbnail.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;

                if (!file.type.startsWith('image/')) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Format Tidak Didukung',
                            text: 'Mohon upload file gambar',
                            confirmButtonColor: '#3085d6'
                        });
                    } else {
                        alert('Mohon upload file gambar');
                    }
                    this.value = '';
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Ukuran Terlalu Besar',
                            text: 'Ukuran file maksimal 2MB',
                            confirmButtonColor: '#3085d6'
                        });
                    } else {
                        alert('Ukuran file maksimal 2MB');
                    }
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
                    markAsChanged(true);
                };
                reader.onerror = function () {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Membaca File',
                            text: 'Terjadi kesalahan saat membaca file',
                            confirmButtonColor: '#3085d6'
                        });
                    } else {
                        alert('Gagal membaca file');
                    }
                };
                reader.readAsDataURL(file);
            });
        }

        // PROGRESS
        function initProgress() {
            const progressElements = [
                DOM.title,
                DOM.slug,
                DOM.summary,
                DOM.thumbnail,
                DOM.category,
                DOM.status
            ];

            const update = Utils.debounce(updateProgress, 200);

            progressElements.forEach(element => {
                if (element) {
                    element.addEventListener('input', update);
                    element.addEventListener('change', update);
                }
            });

            state.progressInterval = setInterval(() => {
                if (state.isEditorReady) {
                }
            }, 1000);
        }

        // DRAFT
        function saveDraft() {
            try {
                const draft = {
                    title: DOM.title ? DOM.title.value || '' : '',
                    slug: DOM.slug ? DOM.slug.value || '' : '',
                    summary: DOM.summary ? DOM.summary.value || '' : '',
                    content: (state.isEditorReady && state.editor) ? state.editor.getData() || '' : '',
                    category: DOM.category ? DOM.category.value || '' : '',
                    status: DOM.status ? DOM.status.value || '' : '',
                    timestamp: Date.now()
                };

                localStorage.setItem(state.draftKey, JSON.stringify(draft));
            } catch (error) {
                console.warn('Error saving draft:', error);
            }
        }

        function initAutosave() {
            state.autosaveInterval = setInterval(function () {
                if (state.isChanged) {
                    saveDraft();
                }
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

        function initRestoreDraft() {
            const draftData = localStorage.getItem(state.draftKey);
            if (!draftData) return;

            setTimeout(function () {
                if (state.isEditorReady && state.editor) {
                    restoreDraft();
                } else {
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
            }, 500);
        }

        // ============================================================
        // 6. UPLOAD BUTTON
        // ============================================================

        function initUpload() {
            if (!DOM.uploadButton || !DOM.form) return;

            DOM.uploadButton.addEventListener('click', function (e) {
                e.preventDefault();

                // 🔥 VALIDASI KATEGORI (WAJIB UNTUK SEMUA STATUS)
                if (!DOM.category || !DOM.category.value) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Kategori Wajib Diisi',
                            text: 'Silakan pilih kategori untuk berita ini',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6'
                        });
                    } else {
                        alert('Kategori wajib dipilih');
                    }
                    return;
                }

                const selectedStatus = DOM.status ? DOM.status.value : 'draft';
                const isPublish = selectedStatus === 'published';

                // Validasi untuk publish
                if (isPublish) {
                    // Cek konten minimal
                    if (state.isEditorReady && state.editor) {
                        try {
                            const content = state.editor.getData();
                            if (Utils.countWords(content) < 10) {
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Konten Terlalu Pendek',
                                        text: 'Minimal 10 kata untuk publikasi',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#3085d6'
                                    });
                                } else {
                                    alert('Konten minimal 10 kata untuk publikasi');
                                }
                                return;
                            }
                        } catch (error) {
                            console.warn('Error checking content:', error);
                        }
                    }
                }

                // Konfirmasi
                const titleText = isPublish ? 'Update & Publish Berita?' : 'Update Draft Berita?';
                const textMessage = isPublish
                    ? 'Berita akan diperbarui dan dipublikasikan.'
                    : 'Berita akan diperbarui sebagai draft.';

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: titleText,
                        text: textMessage,
                        icon: isPublish ? 'question' : 'info',
                        showCancelButton: true,
                        confirmButtonColor: isPublish ? '#3085d6' : '#6B7280',
                        cancelButtonColor: '#d33',
                        confirmButtonText: isPublish ? 'Ya, Update & Publish!' : 'Ya, Update Draft',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (isPublish) {
                                localStorage.removeItem(state.draftKey);
                            }
                            DOM.form.submit();
                        }
                    });
                } else {
                    if (confirm(`Yakin ingin ${isPublish ? 'mempublikasikan' : 'menyimpan draft'} berita ini?`)) {
                        if (isPublish) {
                            localStorage.removeItem(state.draftKey);
                        }
                        DOM.form.submit();
                    }
                }
            });
        }

        // ============================================================
        // 7. NAVIGATION
        // ============================================================

        function markAsChanged(value = true) {
            state.isChanged = value;
        }

        // ============================================================
        // 8. CLEANUP
        // ============================================================

        function cleanup() {
            if (state.autosaveInterval) {
                clearInterval(state.autosaveInterval);
                state.autosaveInterval = null;
            }

            if (state.progressInterval) {
                clearInterval(state.progressInterval);
                state.progressInterval = null;
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
        // 9. APP INITIALIZATION
        // ============================================================

        async function initApp() {
            try {
                initSlug();
                initThumbnail();
                initUpload();

                await initEditor();
                initAutosave();
                markAsChanged(false);

                console.log('✅ Aplikasi berhasil diinisialisasi');
            } catch (error) {
                console.error('❌ Error inisialisasi aplikasi:', error);
            }
        }

        // ============================================================
        // 10. START APPLICATION
        // ============================================================

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initApp);
        } else {
            initApp();
        }

        window.addEventListener('pagehide', cleanup);

    })();
</script>