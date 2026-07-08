@extends('layouts.owner')

@section('title', 'Observasi Kesehatan')
@section('page-title', 'Data Sapi')

@push('styles')
<style>
/* ============================================================
   Observasi Kesehatan Styles — Figma node 97-203
   ============================================================ */

/* Main Data Section — Figma Card layout */
.ks-data-section {
    background: #FFFFFF;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    overflow: hidden;
    margin-bottom: 24px;
    margin-top: 20px;
}

.ks-data-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 24px 32px 18px;
    flex-wrap: wrap;
    gap: 10px;
}

.ks-btn-filter {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 0;
    border: none;
    background: transparent;
    color: #124827;
    font-size: 18px;
    font-weight: 700;
    cursor: pointer;
    font-family: 'Manrope', sans-serif;
    transition: opacity 0.15s;
}

.ks-btn-filter:hover {
    opacity: 0.8;
}

.ks-btn-filter__icon {
    width: 20px;
    height: 20px;
}

/* Filter Tabs */
.ks-tabs {
    display: flex;
    gap: 0;
    padding: 0 32px;
    border-bottom: 1px solid #E5E7EB;
}

.ks-tab {
    padding: 12px 24px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    border: none;
    background: none;
    border-bottom: 3px solid transparent;
    color: #6B7280;
    font-family: 'Manrope', sans-serif;
    transition: color 0.15s, border-color 0.15s, background 0.15s;
    border-radius: 8px 8px 0 0;
    white-space: nowrap;
}

.ks-tab:hover {
    color: #124827;
}

.ks-tab--active {
    background: #124827;
    color: #FFFFFF;
    border-radius: 8px;
    margin-bottom: 4px;
    margin-top: 4px;
    border-bottom: none;
}

.ks-tab--yellow {
    color: #D97706;
}

.ks-tab--red {
    color: #DC2626;
}

/* Data Table */
.ks-table-wrap {
    overflow-x: auto;
}

.ks-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Manrope', sans-serif;
}

.ks-table thead th {
    padding: 12px 24px;
    font-size: 15px;
    font-weight: 900;
    color: #111827;
    text-align: left;
    background: #FAFAFA;
    border-bottom: 1px solid #F3F4F6;
    white-space: nowrap;
}

.ks-table thead th:first-child {
    border-radius: 0;
    padding-left: 32px;
}

.ks-table thead th:last-child {
    padding-right: 32px;
}

.ks-table tbody tr {
    border-bottom: 1px solid #F9FAFB;
    transition: background 0.12s;
}

.ks-table tbody tr:last-child {
    border-bottom: none;
}

.ks-table tbody tr:hover {
    background: #F9FAFB;
}

.ks-table tbody td {
    padding: 12px 24px;
    font-size: 15px;
    color: #111827;
    vertical-align: middle;
}

.ks-table tbody td:first-child {
    padding-left: 32px;
}

.ks-table tbody td:last-child {
    padding-right: 32px;
}

/* Cow cell */
.ks-cow-cell {
    display: flex;
    align-items: center;
    gap: 14px;
}

.ks-cow-thumb-img {
    width: 32px;
    height: 32px;
    object-fit: contain;
    flex-shrink: 0;
}

.ks-cow-name {
    font-size: 16px;
    font-weight: 800;
    color: #111827;
    margin: 0 0 2px;
    line-height: 1.2;
}

.ks-cow-id {
    font-size: 13px;
    font-weight: 600;
    color: #9CA3AF;
    margin: 0;
    line-height: 1.2;
}

/* Indicators */
.ks-text--green {
    color: #124827;
    font-weight: 800;
}

.ks-text--yellow {
    color: #C99C15;
    font-weight: 800;
}

.ks-text--red {
    color: #EF0000;
    font-weight: 800;
}

/* Catatan cell */
.ks-catatan {
    font-size: 15px;
    color: #4B5563;
    max-width: 180px;
}

.ks-catatan__date {
    font-size: 15px;
    font-weight: 700;
    color: #111827;
    display: block;
    margin-bottom: 2px;
}

/* Empty state */
.ks-empty {
    text-align: center;
    padding: 64px 24px;
    color: #9CA3AF;
}

.ks-empty__title {
    font-size: 17px;
    font-weight: 700;
    color: #374151;
    margin: 0 0 6px;
}

.ks-empty__sub {
    font-size: 13px;
    font-weight: 400;
    margin: 0;
}

/* Pagination bar */
.ks-pagination-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 24px 32px 28px;
    border-top: 1px solid #F3F4F6;
    gap: 12px;
    flex-wrap: wrap;
}

.ks-pagination-info {
    font-size: 13px;
    font-weight: 600;
    color: #6B7280;
    white-space: nowrap;
}

.ks-pagination-nav {
    display: flex;
    align-items: center;
    gap: 4px;
}

.ks-page-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 34px;
    height: 34px;
    padding: 0 6px;
    border-radius: 8px;
    border: 1.5px solid #E5E7EB;
    background: #FFFFFF;
    font-size: 13px;
    font-weight: 700;
    color: #374151;
    cursor: pointer;
    font-family: 'Manrope', sans-serif;
    transition: background 0.15s, color 0.15s, border-color 0.15s, transform 0.1s;
    user-select: none;
    line-height: 1;
}

.ks-page-btn:hover:not(:disabled):not(.ks-page-btn--active) {
    background: #F3F4F6;
    border-color: #D1D5DB;
    transform: translateY(-1px);
}

.ks-page-btn--active {
    background: #124827;
    border-color: #124827;
    color: #FFFFFF;
    cursor: default;
}

.ks-page-btn--arrow {
    color: #374151;
    font-size: 15px;
    font-weight: 900;
}

.ks-page-btn--arrow:disabled {
    opacity: 0.3;
    cursor: not-allowed;
    transform: none;
}

.ks-page-btn--ellipsis {
    border-color: transparent;
    background: transparent;
    cursor: default;
    color: #9CA3AF;
    font-size: 14px;
    letter-spacing: 1px;
}

.ks-page-btn--ellipsis:hover {
    background: transparent;
    transform: none;
}

/* Header Welcome block */
.ks-welcome-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px;
}

.ks-welcome-title {
    font-size: 24px;
    font-weight: 800;
    color: #111827;
    margin: 0 0 6px;
}

.ks-welcome-subtitle {
    font-size: 14px;
    font-weight: 500;
    color: #4B5563;
    margin: 0;
}

.ks-date-selector {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 0;
    border: none;
    background: transparent;
    color: #000000;
    font-size: 20px;
    font-weight: 800;
    cursor: pointer;
    font-family: 'Manrope', sans-serif;
    transition: opacity 0.15s;
}

.ks-date-selector:hover {
    opacity: 0.8;
}

.ks-date-selector__arrow {
    font-size: 22px;
    color: #000000;
    font-weight: 900;
}
</style>
@endpush

@section('content')

{{-- Welcome Header --}}
<div class="ks-welcome-header">
    <div>
        <h1 class="ks-welcome-title">Observasi Kesehatan</h1>
        <p class="ks-welcome-subtitle">Catatan data sapi berdasarkan hasil observasi karyawan</p>
    </div>
</div>

{{-- Main Data Section --}}
<div class="ks-data-section">

    {{-- Search and Filter Row --}}
    <div class="ks-table-controls" style="display: flex; justify-content: space-between; align-items: center; padding: 16px 32px; border-bottom: 1px solid #E5E7EB; gap: 16px; flex-wrap: wrap;">
        <!-- Left: Search input -->
        <div style="position: relative; flex: 1; max-width: 320px; min-width: 200px;">
            <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); display: flex; align-items: center; pointer-events: none;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2.5" width="16" height="16">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </span>
            <input type="text" id="sapiSearchInput" placeholder="Cari Sapi (Nama atau ID)..." style="padding: 9px 14px 9px 40px; border: 1.5px solid #D1D5DB; border-radius: 8px; font-size: 13.5px; font-weight: 600; font-family: 'Manrope', sans-serif; color: #111827; background: #FFFFFF; width: 100%; box-sizing: border-box; transition: border-color 0.15s; outline: none;" oninput="onSearchOrFilterChange()">
        </div>
        
        <!-- Right: Status Dropdown -->
        <div style="position: relative; min-width: 180px;">
            <select id="sapiStatusFilter" onchange="onSearchOrFilterChange()" style="padding: 9px 36px 9px 14px; border: 1.5px solid #D1D5DB; border-radius: 8px; font-size: 13.5px; font-weight: 600; font-family: 'Manrope', sans-serif; color: #374151; background: #FFFFFF; width: 100%; box-sizing: border-box; -webkit-appearance: none; -moz-appearance: none; appearance: none; cursor: pointer; transition: border-color 0.15s; outline: none;">
                <option value="semua">Semua Status</option>
                <option value="normal">Normal</option>
                <option value="pemantauan">Perlu Pemantauan</option>
                <option value="tindakan">Perlu Tindakan</option>
            </select>
            <svg viewBox="0 0 24 24" fill="none" stroke="#374151" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" style="right: 12px; width: 16px; height: 16px; pointer-events: none; position: absolute; top: 50%; transform: translateY(-50%);"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="ks-table-wrap">
        <table class="ks-table">
            <thead>
                <tr>
                    <th scope="col">Daftar Sapi</th>
                    <th scope="col">Nafsu Makan</th>
                    <th scope="col">Kondisi Susu</th>
                    <th scope="col">Perilaku</th>
                    <th scope="col">Catatan Terakhir</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody id="ks-tbody">

                @forelse($sapis as $sapi)
                    @php
                        $latest = $sapi->kesehatan->first();
                        $statusClass = 'normal';
                        if ($sapi->status === 'perlu_pemantauan') $statusClass = 'pemantauan';
                        if ($sapi->status === 'perlu_tindakan') $statusClass = 'tindakan';
                    @endphp
                    <tr class="ks-row" data-status="{{ $statusClass }}">
                        <td>
                            <div class="ks-cow-cell">
                                <img src="{{ asset('images/icons/icondatasapi.svg') }}" alt="" class="ks-cow-thumb-img">
                                <div>
                                    <div class="ks-cow-name">{{ $sapi->name }}</div>
                                    <div class="ks-cow-id">({{ $sapi->code }})</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($latest && strtolower($latest->nafsu_makan) === 'baik')
                                <span class="ks-text--green">Baik</span>
                            @elseif($latest && strtolower($latest->nafsu_makan) === 'kurang')
                                <span class="ks-text--yellow">Kurang</span>
                            @else
                                <span style="color: #6B7280;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($latest && strtolower($latest->kondisi_susu) === 'normal')
                                <span class="ks-text--green">Normal</span>
                            @elseif($latest && strtolower($latest->kondisi_susu) === 'bermasalah')
                                <span class="ks-text--red">Bermasalah</span>
                            @else
                                <span style="color: #6B7280;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($latest && strtolower($latest->perilaku) === 'aktif')
                                <span class="ks-text--green">Aktif</span>
                            @elseif($latest && strtolower($latest->perilaku) === 'lesu')
                                <span class="ks-text--red">Lesu</span>
                            @else
                                <span style="color: #6B7280;">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="ks-catatan">
                                @if($latest)
                                    <span class="ks-catatan__date">{{ $latest->created_at->locale('id')->isoFormat('D MMM YYYY') }}</span>
                                    {{ Str::limit($latest->catatan, 35) }}
                                @else
                                    <span class="ks-catatan__date">—</span>
                                    Belum ada catatan
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($sapi->status === 'normal')
                                <span style="color: #124827; font-weight: 800; font-size: 15px;">Normal</span>
                            @elseif($sapi->status === 'perlu_pemantauan')
                                <span style="color: #C99C15; font-weight: 800; font-size: 15px;">Perlu Pemantauan</span>
                            @else
                                <span style="color: #EF0000; font-weight: 800; font-size: 15px;">Perlu Tindakan</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr id="ks-empty-row">
                        <td colspan="6">
                            <div class="ks-empty">
                                <h4 class="ks-empty__title">Tidak ada data sapi</h4>
                                <p class="ks-empty__sub">Data sapi saat ini kosong atau belum dimasukkan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    {{-- ── Pagination bar ── --}}
    <div class="ks-pagination-bar" id="ks-pagination-bar">
        <span class="ks-pagination-info" id="ks-pagination-info">Menampilkan 0 - 0 dari 0 Data</span>
        <nav class="ks-pagination-nav" id="ks-pagination-nav" aria-label="Navigasi halaman"></nav>
    </div>

</div>

@endsection

@push('scripts')
<script>
(function () {
    /* ── Config ───────────────────────────────────────────────── */
    const PER_PAGE = 9;

    /* ── State ────────────────────────────────────────────────── */
    let currentFilter = 'semua';
    let currentPage   = 1;

    /* ── DOM refs ─────────────────────────────────────────────── */
    const allRows   = Array.from(document.querySelectorAll('#ks-tbody tr.ks-row'));
    const tabs      = document.querySelectorAll('.ks-tab');
    const infoEl    = document.getElementById('ks-pagination-info');
    const navEl     = document.getElementById('ks-pagination-nav');

    function getVisible() {
        const searchInput = document.getElementById('sapiSearchInput');
        const statusFilter = document.getElementById('sapiStatusFilter');
        
        const searchQuery = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const selectedStatus = statusFilter ? statusFilter.value : 'semua';

        return allRows.filter(row => {
            // Status filter
            let normalizedRowStatus = row.dataset.status; // 'normal', 'pemantauan', 'tindakan'
            const statusMatch = (selectedStatus === 'semua' || normalizedRowStatus === selectedStatus);

            // Search query filter (checks name and code)
            const nameEl = row.querySelector('.ks-cow-name');
            const codeEl = row.querySelector('.ks-cow-id');
            const name = nameEl ? nameEl.textContent.toLowerCase() : '';
            const code = codeEl ? codeEl.textContent.toLowerCase() : '';
            
            const searchMatch = !searchQuery || name.includes(searchQuery) || code.includes(searchQuery);

            return statusMatch && searchMatch;
        });
    }

    function onSearchOrFilterChange() {
        currentPage = 1;
        render();
    }

    function render() {
        const visible    = getVisible();
        const total      = visible.length;
        const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));

        // Clamp current page
        if (currentPage > totalPages) currentPage = totalPages;

        const start = (currentPage - 1) * PER_PAGE;  // 0-indexed
        const end   = Math.min(start + PER_PAGE, total);

        // Hide ALL rows first
        allRows.forEach(r => (r.style.display = 'none'));

        // Handle empty row
        const emptyRow = document.getElementById('ks-empty-row');
        if (emptyRow) {
            emptyRow.style.display = total === 0 ? '' : 'none';
        }

        // Show only the current page slice of visible rows
        visible.forEach((r, i) => {
            r.style.display = (i >= start && i < end) ? '' : 'none';
        });

        // ── Info text ──────────────────────────────────────────
        infoEl.textContent = total === 0
            ? 'Tidak ada data'
            : `Menampilkan ${start + 1} - ${end} dari ${total} Data`;

        // ── Page buttons ───────────────────────────────────────
        navEl.innerHTML = '';

        function btn(label, page, cls, disabled) {
            const b = document.createElement('button');
            b.className = 'ks-page-btn ' + (cls || '');
            b.textContent = label;
            b.setAttribute('aria-label', label);
            if (disabled) b.disabled = true;
            if (page !== null && !disabled) {
                b.addEventListener('click', function () {
                    currentPage = page;
                    render();
                });
            }
            navEl.appendChild(b);
        }

        // Prev arrow
        btn('\u2039', currentPage - 1, 'ks-page-btn--arrow', currentPage === 1);

        // Page number logic with ellipsis
        const delta = 1; // pages around current
        let pages = [];
        for (let p = 1; p <= totalPages; p++) {
            if (p === 1 || p === totalPages || (p >= currentPage - delta && p <= currentPage + delta)) {
                pages.push(p);
            }
        }

        let prev = null;
        pages.forEach(function (p) {
            if (prev !== null && p - prev > 1) {
                // ellipsis gap
                const e = document.createElement('button');
                e.className = 'ks-page-btn ks-page-btn--ellipsis';
                e.textContent = '...';
                e.disabled = true;
                navEl.appendChild(e);
            }
            btn(p, p, p === currentPage ? 'ks-page-btn--active' : '', false);
            prev = p;
        });

        // Next arrow
        btn('\u203A', currentPage + 1, 'ks-page-btn--arrow', currentPage === totalPages || total === 0);
    }

    // Expose window.onSearchOrFilterChange
    window.onSearchOrFilterChange = onSearchOrFilterChange;

    // ── Initial render ─────────────────────────────────────────
    render();

    /* ── Sync title ───────────────────────────────────────────── */
    document.title = "Observasi Kesehatan | Parman Farm";

})();
</script>
@endpush
