<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Penjualan Perlengkapan Sekolah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --navy: #102b57;
            --wine: #a50044;
            --ink: #18243a;
            --muted: #718096;
            --line: #e7ebf1;
            --canvas: #f4f6fa;
        }

        body {
            background: var(--canvas);
            color: var(--ink);
            font-family: 'Poppins', sans-serif;
            font-size: .92rem;
        }

        .dashboard { max-width: 1240px; }
        .hero {
            background: linear-gradient(120deg, var(--navy), var(--wine));
            border-radius: 20px;
            box-shadow: 0 16px 38px rgba(16, 43, 87, .18);
        }
        .hero .eyebrow { color: rgba(255,255,255,.72); letter-spacing: .12em; }
        .card {
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 8px 26px rgba(28, 44, 75, .05);
        }
        .card-header {
            background: #fff;
            border-bottom: 1px solid var(--line);
            border-radius: 16px 16px 0 0 !important;
            padding: 1rem 1.25rem;
        }
        .stat-card { position: relative; overflow: hidden; }
        .stat-card::after {
            background: var(--tint);
            border-radius: 50%;
            content: '';
            height: 110px;
            position: absolute;
            right: -32px;
            top: -38px;
            width: 110px;
        }
        .stat-label { color: var(--muted); font-size: .82rem; }
        .stat-value { color: var(--accent); font-size: clamp(1.25rem, 3vw, 1.8rem); font-weight: 700; }
        .stat-icon {
            align-items: center;
            background: var(--tint);
            border-radius: 12px;
            color: var(--accent);
            display: flex;
            font-size: 1.15rem;
            height: 42px;
            justify-content: center;
            width: 42px;
        }
        .form-label { color: #475569; font-size: .82rem; font-weight: 500; }
        .form-control { border-color: #dce2eb; border-radius: 9px; padding: .65rem .8rem; }
        .form-control:focus { border-color: #a50044; box-shadow: 0 0 0 .2rem rgba(165,0,68,.1); }
        .btn { border-radius: 9px; font-size: .84rem; font-weight: 500; padding: .62rem 1rem; }
        .btn-primary { background: var(--wine); border-color: var(--wine); }
        .btn-primary:hover { background: #870039; border-color: #870039; }
        .btn-outline-primary { border-color: var(--wine); color: var(--wine); }
        .btn-outline-primary:hover { background: var(--wine); border-color: var(--wine); }
        .table { --bs-table-bg: transparent; }
        .table thead th {
            background: #f8f9fc;
            border-bottom: 1px solid var(--line);
            color: #5e6b80;
            font-size: .76rem;
            font-weight: 600;
            letter-spacing: .04em;
            padding: .85rem .75rem;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .table tbody td { border-color: var(--line); padding: .8rem .75rem; }
        .product-name { color: var(--ink); font-weight: 500; }
        .chart-wrap { height: 360px; position: relative; }
        .source-note, footer { color: var(--muted); font-size: .78rem; }
        .modal-content { border: 0; border-radius: 16px; }
        @media (max-width: 576px) {
            .hero { border-radius: 14px; }
            .chart-wrap { height: 300px; }
        }
    </style>
</head>
<body>
<main class="container dashboard py-4 py-lg-5">
    <header class="hero mb-4 p-4 p-lg-5 text-white">
        <p class="eyebrow mb-2 small text-uppercase">Dashboard inventaris & penjualan</p>
        <h1 class="h3 fw-bold mb-2">Perlengkapan Sekolah</h1>
        <p class="mb-0 text-white-50">Pantau stok penjualan dan keuntungan produk dalam satu tampilan.</p>
    </header>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="row g-3 mb-4" aria-label="Ringkasan penjualan">
        <div class="col-md-4">
            <article class="card stat-card h-100 p-3 p-lg-4" style="--accent:#102b57;--tint:rgba(16,43,87,.09)">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label mb-2">Total Produk</div>
                        <div class="stat-value">{{ number_format($totalProduk, 0, ',', '.') }}</div>
                    </div>
                    <span class="stat-icon" aria-hidden="true">▦</span>
                </div>
            </article>
        </div>
        <div class="col-md-4">
            <article class="card stat-card h-100 p-3 p-lg-4" style="--accent:#a50044;--tint:rgba(165,0,68,.09)">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label mb-2">Total Unit Terjual</div>
                        <div class="stat-value">{{ number_format($totalTerjual, 0, ',', '.') }}</div>
                    </div>
                    <span class="stat-icon" aria-hidden="true">↗</span>
                </div>
            </article>
        </div>
        <div class="col-md-4">
            <article class="card stat-card h-100 p-3 p-lg-4" style="--accent:#167d68;--tint:rgba(22,125,104,.09)">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label mb-2">Total Keuntungan</div>
                        <div class="stat-value">Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</div>
                    </div>
                    <span class="stat-icon" aria-hidden="true">Rp</span>
                </div>
            </article>
        </div>
    </section>

    <section class="card mb-4">
        <div class="card-header"><h2 class="h6 fw-semibold mb-0">Tambah Produk</h2></div>
        <div class="card-body p-3 p-lg-4">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label" for="produk">Nama Produk</label>
                        <input class="form-control" id="produk" name="produk" maxlength="80" value="{{ old('produk') }}" required>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label" for="harga">Harga (Rp)</label>
                        <input class="form-control" id="harga" name="harga" type="number" min="0" step="1" value="{{ old('harga') }}" required>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label" for="keuntungan">Keuntungan (Rp)</label>
                        <input class="form-control" id="keuntungan" name="keuntungan" type="number" min="0" step="1" value="{{ old('keuntungan') }}" required>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label" for="terjual">Unit Terjual</label>
                        <input class="form-control" id="terjual" name="terjual" type="number" min="0" step="1" value="{{ old('terjual') }}" required>
                    </div>
                    <div class="col-lg-2">
                        <button class="btn btn-primary w-100" type="submit">Tambah Produk</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="card mb-4">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h2 class="h6 fw-semibold mb-1">Grafik Penjualan Produk</h2>
                <p class="source-note mb-0">Sumbu X: harga · sumbu Y: unit terjual · ukuran bubble: keuntungan</p>
            </div>
        </div>
        <div class="card-body p-3 p-lg-4">
            <div class="chart-wrap"><canvas id="bubbleChartPenjualanProduk" aria-label="Grafik bubble penjualan produk"></canvas></div>
        </div>
    </section>

    <section class="card mb-3">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h2 class="h6 fw-semibold mb-1">Daftar Produk</h2>
                <p class="source-note mb-0">Menampilkan {{ $products->count() }} produk dari database MySQL.</p>
            </div>
            <form action="{{ route('products.reset') }}" method="POST" onsubmit="return confirm('Kembalikan data ke 30 produk awal?')">
                @csrf
                <button class="btn btn-outline-primary" type="submit">Reset Data Awal</button>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                    <tr>
                        <th class="ps-4">No.</th>
                        <th>Nama Produk</th>
                        <th class="text-end">Harga</th>
                        <th class="text-end">Keuntungan</th>
                        <th class="text-end">Terjual</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="ps-4 text-secondary">{{ $loop->iteration }}</td>
                            <td class="product-name">{{ $product->produk }}</td>
                            <td class="text-end">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($product->keuntungan, 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($product->terjual, 0, ',', '.') }}</td>
                            <td class="text-center pe-4">
                                <div class="d-inline-flex gap-1">
                                    <button
                                        class="btn btn-sm btn-outline-primary js-edit-product"
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editProductModal"
                                        data-id="{{ $product->id }}"
                                        data-produk="{{ $product->produk }}"
                                        data-harga="{{ $product->harga }}"
                                        data-keuntungan="{{ $product->keuntungan }}"
                                        data-terjual="{{ $product->terjual }}"
                                    >Edit</button>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="py-5 text-center text-secondary" colspan="6">Belum ada data produk.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 px-4 py-3">
            <p class="source-note mb-0">Data tersimpan dan dikelola langsung melalui database MySQL.</p>
        </div>
    </section>

    <footer class="py-3 text-center">Dashboard perlengkapan sekolah · Sumber data: database MySQL</footer>
</main>

<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h2 class="modal-title h6 fw-semibold" id="editProductModalLabel">Edit Produk</h2>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="editProductForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="editProduk">Nama Produk</label>
                        <input class="form-control" id="editProduk" name="produk" maxlength="80" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label" for="editHarga">Harga (Rp)</label>
                            <input class="form-control" id="editHarga" name="harga" type="number" min="0" step="1" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="editKeuntungan">Keuntungan (Rp)</label>
                            <input class="form-control" id="editKeuntungan" name="keuntungan" type="number" min="0" step="1" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="editTerjual">Unit Terjual</label>
                            <input class="form-control" id="editTerjual" name="terjual" type="number" min="0" step="1" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const products = @json($chartProducts);

    const bubbleData = products.map((product) => ({
        x: product.price,
        y: product.sold,
        r: Math.max(6, Math.sqrt(product.profit) / 5),
        product,
    }));

    new Chart(document.getElementById('bubbleChartPenjualanProduk'), {
        type: 'bubble',
        data: {
            datasets: [{
                label: 'Produk',
                data: bubbleData,
                backgroundColor: 'rgba(165, 0, 68, 0.62)',
                borderColor: '#102b57',
                borderWidth: 1.5,
                hoverBackgroundColor: 'rgba(165, 0, 68, 0.85)',
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            const point = context.raw;
                            return [
                                point.product.name,
                                `Harga: Rp ${new Intl.NumberFormat('id-ID').format(point.x)}`,
                                `Terjual: ${new Intl.NumberFormat('id-ID').format(point.y)} unit`,
                                `Keuntungan: Rp ${new Intl.NumberFormat('id-ID').format(point.product.profit)}`,
                            ];
                        },
                    },
                },
            },
            scales: {
                x: {
                    beginAtZero: true,
                    title: { display: true, text: 'Harga Produk (Rp)' },
                    ticks: {
                        callback: (value) => `Rp ${new Intl.NumberFormat('id-ID', { notation: 'compact' }).format(value)}`,
                    },
                },
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Unit Terjual' },
                    ticks: { precision: 0 },
                },
            },
        },
    });

    document.querySelectorAll('.js-edit-product').forEach((button) => {
        button.addEventListener('click', () => {
            document.getElementById('editProductForm').action = `/products/${button.dataset.id}`;
            document.getElementById('editProduk').value = button.dataset.produk;
            document.getElementById('editHarga').value = button.dataset.harga;
            document.getElementById('editKeuntungan').value = button.dataset.keuntungan;
            document.getElementById('editTerjual').value = button.dataset.terjual;
        });
    });
</script>
</body>
</html>
