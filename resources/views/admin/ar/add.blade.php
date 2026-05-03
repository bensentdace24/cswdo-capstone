@extends('layouts.app')

@section('content')
    <div class="content-wrapper" style="background-color:#f0f2f5; min-height:100vh; font-family:'Inter', sans-serif;">

        {{-- HEADER --}}
        <section class="content-header py-4" style="background:#fff; border-bottom:1px solid #e0e0e0;">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 style="font-size:1.8rem; font-weight:700; color:#333; margin:0;">
                    <i class="fas fa-receipt me-2" style="color:#1D4FA1;"></i> Add Acknowledgement Receipt
                </h1>
                <a href="{{ url('admin/ar/viewing-list') }}" class="btn btn-light"
                    style="border:1px solid #dcdcdc; color:#555; border-radius:8px; font-weight:600; padding:8px 18px;">
                    ← Back to List
                </a>
            </div>
        </section>

        <section class="content py-5">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9">

                        @include('_message')

                        <div class="card shadow-sm" style="border-radius:16px; border:none;">
                            <div class="card-body p-5">

                                <form action="{{ url('admin/ar/store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    {{-- ROW 1: RECIPIENT & BARANGAY --}}
                                    <div class="row mb-4">
                                        <div class="col-md-7">
                                            <label class="fw-bold mb-2">Name of Recipient *</label>
                                            <select name="client_verification_id" class="form-control" required>
                                                <option value="">-- Select beneficiary --</option>
                                                @foreach ($clients as $c)
                                                    <option value="{{ $c->id }}">
                                                        {{ $c->client->full_name ?? 'Unknown' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-5">
                                            <label class="fw-bold mb-2">Barangay *</label>
                                            <select name="barangay" class="form-control" required>
                                                <option value="">-- Select Barangay --</option>
                                                @php
                                                    $barangays = [
                                                        'A. O. FLOIRENDO',
                                                        'DATU ABDUL DADIA',
                                                        'BUENAVISTA',
                                                        'CACAO',
                                                        'CAGANGOHAN',
                                                        'CONSOLACION',
                                                        'DAPCO',
                                                        'GREDU',
                                                        'J.P. LAUREL',
                                                        'KASILAK',
                                                        'KATIPUNAN',
                                                        'KATUALAN',
                                                        'KAUSWAGAN',
                                                        'KIOTOY',
                                                        'LITTLE PANAY',
                                                        'LOWER PANAGA',
                                                        'MABUNAO',
                                                        'MADUAO',
                                                        'MALATIVAS',
                                                        'MANAY',
                                                        'NANYO',
                                                        'NEW MALAGA',
                                                        'NEW MALITBOG',
                                                        'NEW PANDAN',
                                                        'NEW VISAYAS',
                                                        'QUEZON',
                                                        'SALVACION',
                                                        'SAN FRANCISCO',
                                                        'SAN NICOLAS',
                                                        'SAN PEDRO',
                                                        'SAN ROQUE',
                                                        'SAN VICENTE',
                                                        'SANTA CRUZ',
                                                        'SANTO NIÑO',
                                                        'SINDATON',
                                                        'SOUTHERN DAVAO',
                                                        'TAGPORE',
                                                        'TIBUNGOL',
                                                        'UPPER LICANAN',
                                                        'WATERFALL',
                                                    ];
                                                @endphp
                                                @foreach ($barangays as $b)
                                                    <option value="{{ $b }}">{{ $b }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- ROW 2: AMOUNT, WORDS, & TYPE --}}
                                    <div class="row mb-4 pt-3 border-top">
                                        <div class="col-md-3">
                                            <label class="fw-bold mb-2">Amount (₱) *</label>
                                            <input type="number" name="amount" id="amountInput" class="form-control"
                                                required placeholder="0.00">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fw-bold mb-2">Amount in Words *</label>
                                            <input type="text" name="amount_words" id="amountWordsInput"
                                                class="form-control" required placeholder="Pesos Only">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="fw-bold mb-2">Type *</label>
                                            <select name="type" class="form-control" required>
                                                <option value="">-- Select Type --</option>
                                                <option value="Medical">Medical</option>
                                                <option value="Pharmacy">Pharmacy</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- ROW 3: DATE FIELDS --}}
                                    <div class="row mb-4 pt-3 border-top">
                                        <div class="col-md-4">
                                            <label class="fw-bold mb-2">Day *</label>
                                            <input type="text" name="day_received" class="form-control" required
                                                placeholder="e.g. 27th">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="fw-bold mb-2">Month *</label>
                                            <input type="text" name="month_received" class="form-control" required
                                                placeholder="e.g. December">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="fw-bold mb-2">Year *</label>
                                            <input type="text" name="year_received" class="form-control" required
                                                placeholder="e.g. 2024">
                                        </div>
                                    </div>

                                    {{-- ROW 4: PHOTO UPLOAD --}}
                                    <div class="mb-4 pt-3 border-top">
                                        <label class="fw-bold mb-3">Evidence / Photo (Optional)</label>
                                        <div id="dropZone"
                                            style="border:2px dashed #d1d5db; border-radius:12px; padding:30px; text-align:center; background:#fafafa;">
                                            <input type="file" name="photo" id="photoInput" accept="image/*"
                                                class="d-none">
                                            {{-- ROW X: FINANCE OFFICER NAME --}}
                                            <div class="row mb-4 pt-3 border-top">
                                                <div class="col-md-12">
                                                    <label class="fw-bold mb-2">Finance Officer Name *</label>
                                                    <input type="text" name="finance_officer_name" class="form-control"
                                                        required placeholder="e.g. KAREN A. MALAKINGBATO">
                                                </div>
                                            </div>

                                            <div id="uploadPrompt">
                                                <p class="text-muted mb-3">Upload a file or capture a photo</p>
                                                <button type="button" class="btn btn-outline-secondary me-2"
                                                    id="chooseFileBtn">📁 Choose File</button>
                                                <button type="button" class="btn btn-primary" id="openCameraBtn">📷 Capture
                                                    Photo</button>
                                            </div>

                                            <div id="previewContainer" style="display:none;">
                                                <img id="photoPreview" src=""
                                                    style="max-width:300px; border-radius:12px; border: 1px solid #ddd;">
                                                <div class="mt-2">
                                                    <button type="button" id="removePhotoBtn"
                                                        class="btn btn-sm btn-danger">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FORM ACTIONS --}}
                                    <div class="d-flex justify-content-end gap-2 pt-4 border-top">
                                        <a href="{{ url('admin/ar/viewing-list') }}" class="btn btn-light px-4"
                                            style="border:1px solid #ddd;">Cancel</a>
                                        <button type="submit" class="btn btn-primary px-5"
                                            style="background-color:#1D4FA1; border:none; font-weight:600;">
                                            💾 Save Receipt
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- CAMERA MODAL --}}
    <div id="cameraModal"
        style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.85); z-index:9999; backdrop-filter: blur(4px);">
        <div
            style="background:#fff; max-width:500px; margin:10vh auto; border-radius:16px; overflow:hidden; position:relative;">
            <div class="p-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="m-0 fw-bold">Camera Preview</h5>
                <button type="button" id="closeCameraBtn" class="btn-close" aria-label="Close"></button>
            </div>
            <div class="p-3 bg-dark">
                <video id="cameraVideo" autoplay playsinline style="width:100%; border-radius:8px;"></video>
                <canvas id="cameraCanvas" style="display:none;"></canvas>
            </div>
            <div class="p-3 text-center border-top">
                <button type="button" class="btn btn-primary btn-lg rounded-pill px-4" id="takePhotoBtn">📸 Capture
                    Photo</button>
            </div>
        </div>
    </div>

    <script>
        const chooseFileBtn = document.getElementById('chooseFileBtn');
        const openCameraBtn = document.getElementById('openCameraBtn');
        const closeCameraBtn = document.getElementById('closeCameraBtn');
        const takePhotoBtn = document.getElementById('takePhotoBtn');
        const removePhotoBtn = document.getElementById('removePhotoBtn');
        const photoInput = document.getElementById('photoInput');
        const photoPreview = document.getElementById('photoPreview');
        const uploadPrompt = document.getElementById('uploadPrompt');
        const previewContainer = document.getElementById('previewContainer');
        const cameraModal = document.getElementById('cameraModal');
        const video = document.getElementById('cameraVideo');
        const canvas = document.getElementById('cameraCanvas');

        let stream = null;

        function showPreview(url) {
            photoPreview.src = url;
            uploadPrompt.style.display = 'none';
            previewContainer.style.display = 'block';
        }

        function resetUpload() {
            photoInput.value = "";
            uploadPrompt.style.display = 'block';
            previewContainer.style.display = 'none';
        }

        chooseFileBtn.addEventListener('click', () => photoInput.click());

        photoInput.addEventListener('change', () => {
            if (photoInput.files && photoInput.files[0]) {
                const reader = new FileReader();
                reader.onload = e => showPreview(e.target.result);
                reader.readAsDataURL(photoInput.files[0]);
            }
        });

        openCameraBtn.addEventListener('click', async () => {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: "environment"
                    }
                });
                video.srcObject = stream;
                cameraModal.style.display = 'block';
            } catch (err) {
                alert('Cannot access camera. Please check permissions.');
            }
        });
        //mau rani akong gi dunggag para sa save button hehe
        takePhotoBtn.addEventListener('click', () => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);

            canvas.toBlob(blob => {

                const filename = "capture_" + Date.now() + ".jpg";

                // 1️⃣ Save to file input (for Laravel upload)
                const file = new File([blob], filename, {
                    type: "image/jpeg"
                });
                const dt = new DataTransfer();
                dt.items.add(file);
                photoInput.files = dt.files;

                // 2️⃣ Show preview
                showPreview(URL.createObjectURL(blob));

                // 3️⃣ Force download to user's Downloads folder
                const link = document.createElement("a");
                link.href = URL.createObjectURL(blob);
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                stopCamera();

            }, 'image/jpeg', 0.8);
        });

        function stopCamera() {
            if (stream) stream.getTracks().forEach(t => t.stop());
            cameraModal.style.display = 'none';
        }

        closeCameraBtn.addEventListener('click', stopCamera);
        removePhotoBtn.addEventListener('click', resetUpload);
    </script>
    <script>
        function numberToWords(num) {
            const ones = [
                "", "ONE", "TWO", "THREE", "FOUR", "FIVE", "SIX", "SEVEN", "EIGHT", "NINE",
                "TEN", "ELEVEN", "TWELVE", "THIRTEEN", "FOURTEEN", "FIFTEEN",
                "SIXTEEN", "SEVENTEEN", "EIGHTEEN", "NINETEEN"
            ];

            const tens = [
                "", "", "TWENTY", "THIRTY", "FORTY", "FIFTY",
                "SIXTY", "SEVENTY", "EIGHTY", "NINETY"
            ];

            function convert(n) {
                if (n < 20) return ones[n];
                if (n < 100) return tens[Math.floor(n / 10)] + (n % 10 ? " " + ones[n % 10] : "");
                if (n < 1000) return ones[Math.floor(n / 100)] + " HUNDRED" + (n % 100 ? " " + convert(n % 100) : "");
                if (n < 1000000) return convert(Math.floor(n / 1000)) + " THOUSAND" + (n % 1000 ? " " + convert(n % 1000) :
                    "");
                return "";
            }

            return convert(num);
        }

        const amountInput = document.getElementById('amountInput');
        const amountWordsInput = document.getElementById('amountWordsInput');

        amountInput.addEventListener('input', function() {
            const value = parseInt(this.value, 10);

            if (!isNaN(value) && value > 0) {
                amountWordsInput.value = numberToWords(value);
            } else {
                amountWordsInput.value = "";
            }
        });
    </script>
@endsection
