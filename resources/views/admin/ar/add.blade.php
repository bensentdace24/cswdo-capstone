@extends('layouts.app')

@section('content')
<<<<<<< HEAD
    {{-- Page Container --}}
    <div class="content-wrapper" style="background-color: #f0f2f5; min-height: 100vh; font-family: 'Inter', sans-serif;">

        {{-- Top Header Section --}}
        <section class="content-header py-4"
            style="background-color: #ffffff; border-bottom: 1px solid #e0e0e0; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 style="font-size: 1.8rem; font-weight: 700; color: #333; margin: 0;">
                    <i class="fas fa-receipt mr-2" style="color: #1D4FA1;"></i> Add Acknowledgement Receipt
                </h1>
                <a href="{{ url('admin/ar/viewing-list') }}" class="btn btn-light"
                    style="border: 1px solid #dcdcdc; color: #555; border-radius: 8px; font-weight: 600; padding: 8px 18px;">
                    ← Back to List
=======
    {{-- Page Container - Clean background --}}
    <div class="content-wrapper" style="background-color: #f0f2f5; min-height: 100vh;">

        {{-- Top Header Section - Consistent with all modern forms --}}
        <section class="content-header py-4" style="background-color: #ffffff; border-bottom: 1px solid #e0e0e0;">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 style="font-size: 2.2rem; font-weight: 700; color: #333; margin: 0;">
                    <i class="fas fa-receipt mr-2" style="color: #1D4FA1;"></i> Add Acknowledgement Receipt
                </h1>
                {{-- Back Button (Consistent secondary style) --}}
                <a href="{{ url('admin/ar/viewing-list') }}" class="btn btn-secondary"
                    style="background-color: #e0e0e0; border-color: #e0e0e0; color: #555; border-radius: 8px; font-weight: 600; padding: 8px 18px;">
                    ← Back to AR List
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
                </a>
            </div>
        </section>

        <section class="content py-5">
            <div class="container-fluid">
                <div class="row justify-content-center">
<<<<<<< HEAD
=======
                    {{-- Use slightly wider column for finance forms --}}
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
                    <div class="col-md-10 col-lg-8">

                        @include('_message')

<<<<<<< HEAD
                        {{-- Main Card --}}
                        <div class="card shadow-sm" style="border-radius: 16px; border: none; overflow: hidden;">
                            <div class="card-body p-5">
                                <form action="{{ url('admin/ar/store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    {{-- SECTION 1: RECIPIENT --}}
                                    <div class="row mb-4">
                                        <div class="col-md-8 form-group">
                                            <label
                                                style="font-weight: 600; color: #444; margin-bottom: 8px; display: block;">Name
                                                of Recipient <span style="color: #dc3545;">*</span></label>
                                            <select name="client_verification_id" class="form-control custom-select-line"
                                                required
                                                style="border: none; border-bottom: 2px solid #eee; border-radius: 0; padding: 10px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                                <option value="">-- Select beneficiary --</option>
                                                @foreach ($clients as $c)
                                                    <option value="{{ $c->id }}">
                                                        {{ $c->client->full_name ?? 'Unknown' }}</option>
=======
                        {{-- Main Card: Floating and Rounded --}}
                        <div class="card shadow-lg" style="border-radius: 12px; border: none; overflow: hidden;">

                            <div class="card-body p-4" style="padding: 40px;">
                                <form action="{{ url('admin/ar/store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    {{-- SECTION 1: RECIPIENT AND CONTEXT --}}
                                    <div class="row" style="margin-bottom: 30px;">
                                        <div class="col-md-8 form-group">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Name
                                                of Recipient <span style="color: #dc3545;">*</span></label>
                                            <select name="client_verification_id" class="form-control" required
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                                <option value="">-- Select beneficiary --</option>
                                                @foreach ($clients as $c)
                                                    <option value="{{ $c->id }}">
                                                        {{ $c->client->full_name ?? 'Unknown' }}
                                                    </option>
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label
<<<<<<< HEAD
                                                style="font-weight: 600; color: #444; margin-bottom: 8px; display: block;">Barangay
                                                <span style="color: #dc3545;">*</span></label>
                                            <select name="barangay" class="form-control custom-select-line" required
                                                style="border: none; border-bottom: 2px solid #eee; border-radius: 0; padding: 10px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                                <option value="">-- Select Barangay --</option>
                                                @php
                                                    $barangays = [
                                                        'A. O. FLOIRENDO',
                                                        'Datu Abdul Dadia',
                                                        'Buenavista',
                                                        'Cacao',
                                                        'Cagangohan',
                                                        'Consolacion',
                                                        'Dapco',
                                                        'Gredu',
                                                        'J.P. Laurel',
                                                        'Kasilak',
                                                        'Katipunan',
                                                        'Katualan',
                                                        'Kauswagan',
                                                        'Kiotoy',
                                                        'Little Panay',
                                                        'Lower Panaga',
                                                        'Mabunao',
                                                        'Maduao',
                                                        'Malativas',
                                                        'Manay',
                                                        'Nanyo',
                                                        'New Malaga',
                                                        'New Malitbog',
                                                        'New Pandan',
                                                        'New Visayas',
                                                        'Quezon',
                                                        'Salvacion',
                                                        'San Francisco',
                                                        'San Nicolas',
                                                        'San Pedro',
                                                        'San Roque',
                                                        'San Vicente',
                                                        'Santa Cruz',
                                                        'Santo Niño',
                                                        'Sindaton',
                                                        'Southern Davao',
                                                        'Tagpore',
                                                        'Tibongol',
                                                        'Upper Licanan',
                                                        'Waterfall',
                                                    ];
                                                @endphp
                                                @foreach ($barangays as $b)
                                                    <option>{{ $b }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- SECTION 2: AMOUNT --}}
                                    <div class="row mb-4 pt-3" style="border-top: 1px solid #f0f0f0;">
                                        <div class="col-md-4 form-group">
                                            <label
                                                style="font-weight: 600; color: #444; margin-bottom: 8px; display: block;">Amount
                                                (₱) <span style="color: #dc3545;">*</span></label>
                                            <input type="number" name="amount" class="form-control custom-input-line"
                                                required placeholder="0.00"
                                                style="border: none; border-bottom: 2px solid #eee; border-radius: 0; padding: 10px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <label
                                                style="font-weight: 600; color: #444; margin-bottom: 8px; display: block;">Amount
                                                in Words <span style="color: #dc3545;">*</span></label>
                                            <input type="text" name="amount_words" class="form-control custom-input-line"
                                                required placeholder="Pesos Only"
                                                style="border: none; border-bottom: 2px solid #eee; border-radius: 0; padding: 10px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>
                                        <div class="col-md-12 form-group mt-3">
                                            <label
                                                style="font-weight: 600; color: #444; margin-bottom: 8px; display: block;">Assistance
                                                Type <span style="color: #dc3545;">*</span></label>
                                            <input type="text" name="type" class="form-control custom-input-line"
                                                placeholder="e.g. Medical / Financial Assistance" required
                                                style="border: none; border-bottom: 2px solid #eee; border-radius: 0; padding: 10px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>
                                    </div>

                                    {{-- SECTION 3: DATE & PHOTO --}}
                                    <div class="row mb-4 pt-3" style="border-top: 1px solid #f0f0f0;">
                                        <div class="col-md-4 form-group">
                                            <label
                                                style="font-weight: 600; color: #444; margin-bottom: 8px; display: block;">Day
                                                <span style="color: #dc3545;">*</span></label>
                                            <input type="text" name="day_received" class="form-control custom-input-line"
                                                placeholder="e.g. 27th" required
                                                style="border: none; border-bottom: 2px solid #eee; border-radius: 0; padding: 10px 0;">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label
                                                style="font-weight: 600; color: #444; margin-bottom: 8px; display: block;">Month
                                                <span style="color: #dc3545;">*</span></label>
                                            <input type="text" name="month_received"
                                                class="form-control custom-input-line" placeholder="e.g. December" required
                                                style="border: none; border-bottom: 2px solid #eee; border-radius: 0; padding: 10px 0;">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label
                                                style="font-weight: 600; color: #444; margin-bottom: 8px; display: block;">Year
                                                <span style="color: #dc3545;">*</span></label>
                                            <input type="text" name="year_received"
                                                class="form-control custom-input-line" placeholder="e.g. 2024" required
                                                style="border: none; border-bottom: 2px solid #eee; border-radius: 0; padding: 10px 0;">
                                        </div>

                                        {{-- IMPROVED PHOTO UPLOAD ZONE --}}
                                        <div class="col-md-12 form-group mt-4">
                                            <label
                                                style="font-weight: 600; color: #444; margin-bottom: 15px; display: block;">
                                                Evidence / Photo Attachment <span class="text-muted"
                                                    style="font-weight: 400; font-size: 0.85rem;">(Optional)</span>
                                            </label>

                                            <div id="dropZone"
                                                style="border: 2px dashed #d1d5db; border-radius: 12px; padding: 40px; background-color: #f8f9fa; text-align: center; transition: all 0.3s ease;">
                                                <input type="file" name="photo" id="photoInput" accept="image/*"
                                                    class="d-none">

                                                {{-- Empty State --}}
                                                <div id="uploadPrompt">
                                                    <i class="fas fa-cloud-upload-alt mb-3"
                                                        style="font-size: 2.5rem; color: #cbd5e0;"></i>
                                                    <p style="color: #718096; margin-bottom: 20px;">Upload a file or
                                                        capture a photo from your camera</p>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <button type="button" class="btn btn-white shadow-sm mr-2"
                                                            id="chooseFileBtn"
                                                            style="border: 1px solid #ddd; font-weight: 600; padding: 8px 20px;">📁
                                                            Choose File</button>
                                                        <button type="button" class="btn btn-primary shadow-sm"
                                                            id="openCameraBtn"
                                                            style="font-weight: 600; padding: 8px 20px; background-color: #1D4FA1; border: none;">📷
                                                            Capture Photo</button>
                                                    </div>
                                                </div>

                                                {{-- Preview State --}}
                                                <div id="previewContainer"
                                                    style="display: none; position: relative; max-width: 320px; margin: 0 auto;">
                                                    <img id="photoPreview" src="" alt="Preview"
                                                        style="width: 100%; border-radius: 12px; border: 4px solid #fff; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">
                                                    <button type="button" id="removePhotoBtn"
                                                        class="btn btn-danger btn-sm"
                                                        style="position: absolute; top: -12px; right: -12px; border-radius: 50%; width: 32px; height: 32px; font-weight: bold; border: 2px solid #fff;">&times;</button>
                                                    <p class="mt-3 mb-0"
                                                        style="color: #38a169; font-weight: 600; font-size: 0.9rem;"><i
                                                            class="fas fa-check-circle mr-1"></i> Ready to upload</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FORM ACTIONS --}}
                                    <div class="pt-4 d-flex justify-content-end align-items-center"
                                        style="border-top: 1px solid #f0f0f0;">
                                        <a href="{{ url('admin/ar/viewing-list') }}" class="btn btn-link mr-3"
                                            style="color: #718096; text-decoration: none; font-weight: 600;">Cancel</a>
                                        <button type="submit" class="btn btn-primary shadow-sm"
                                            style="background-color: #1D4FA1; border: none; border-radius: 10px; font-weight: 700; padding: 12px 40px; font-size: 1rem;">
                                            <i class="fas fa-save mr-2"></i> Save Receipt
=======
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Barangay
                                                <span style="color: #dc3545;">*</span></label>
                                            <select name="barangay" class="form-control" required
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                                <option value="">-- Select Barangay --</option>

                                                <option>A. O. Floirendo</option>
                                                <option>Datu Abdul Dadia</option>
                                                <option>Buenavista</option>
                                                <option>Cacao</option>
                                                <option>Cagangohan</option>
                                                <option>Consolacion</option>
                                                <option>Dapco</option>
                                                <option>Gredu</option>
                                                <option>J.P. Laurel</option>
                                                <option>Kasilak</option>
                                                <option>Katipunan</option>
                                                <option>Katualan</option>
                                                <option>Kauswagan</option>
                                                <option>Kiotoy</option>
                                                <option>Little Panay</option>
                                                <option>Lower Panaga</option>
                                                <option>Mabunao</option>
                                                <option>Maduao</option>
                                                <option>Malativas</option>
                                                <option>Manay</option>
                                                <option>Nanyo</option>
                                                <option>New Malaga</option>
                                                <option>New Malitbog</option>
                                                <option>New Pandan</option>
                                                <option>New Visayas</option>
                                                <option>Quezon</option>
                                                <option>Salvacion</option>
                                                <option>San Francisco</option>
                                                <option>San Nicolas</option>
                                                <option>San Pedro</option>
                                                <option>San Roque</option>
                                                <option>San Vicente</option>
                                                <option>Santa Cruz</option>
                                                <option>Santo Niño</option>
                                                <option>Sindaton</option>
                                                <option>Southern Davao</option>
                                                <option>Tagpore</option>
                                                <option>Tibongol</option>
                                                <option>Upper Licanan</option>
                                                <option>Waterfall</option>
                                            </select>

                                        </div>

                                    </div>

                                    {{-- SECTION 2: AMOUNT DETAILS --}}
                                    <div class="row"
                                        style="border-top: 1px solid #eee; padding-top: 30px; margin-bottom: 30px;">
                                        <div class="col-md-4 form-group">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Amount
                                                (₱) <span style="color: #dc3545;">*</span></label>
                                            <input type="number" name="amount" class="form-control" required
                                                placeholder="0.00"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>

                                        <div class="col-md-8 form-group">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Amount
                                                in Words <span style="color: #dc3545;">*</span></label>
                                            <input type="text" name="amount_words" class="form-control" required
                                                placeholder="Pesos Only"
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>

                                        <div class="col-md-12 form-group">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Assistance
                                                Type <span style="color: #dc3545;">*</span></label>
                                            <input type="text" name="type" class="form-control"
                                                placeholder="e.g. Medical / Financial Assistance" required
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>
                                    </div>

                                    {{-- SECTION 3: DATE AND PHOTO --}}
                                    <div class="row"
                                        style="border-top: 1px solid #eee; padding-top: 30px; margin-bottom: 30px;">
                                        <div class="col-md-4 form-group">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Day
                                                Received <span style="color: #dc3545;">*</span></label>
                                            <input type="text" name="day_received" class="form-control"
                                                placeholder="e.g. 27th" required
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Month
                                                Received <span style="color: #dc3545;">*</span></label>
                                            <input type="text" name="month_received" class="form-control"
                                                placeholder="e.g. December" required
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Year
                                                Received <span style="color: #dc3545;">*</span></label>
                                            <input type="text" name="year_received" class="form-control"
                                                placeholder="e.g. 2024" required
                                                style="border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 8px 0; background-color: transparent; box-shadow: none; font-size: 1rem;">
                                        </div>

                                        <div class="col-md-12 form-group" style="margin-top: 15px;">
                                            <label
                                                style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">Photo
                                                (Optional)</label>
                                            <input type="file" name="photo" class="form-control-file"
                                                style="border: 1px solid #ccc; border-radius: 6px; padding: 8px;">
                                        </div>
                                    </div>

                                    {{-- Card Footer - Actions (Right aligned) --}}
                                    <div class="card-footer"
                                        style="padding: 25px 0; background-color: white; border-top: 1px solid #e0e0e0; display: flex; justify-content: flex-end;">
                                        {{-- Cancel Button --}}
                                        <a href="{{ url('admin/ar/viewing-list') }}" class="btn btn-secondary"
                                            style="background-color: #e0e0e0; border-color: #e0e0e0; color: #555; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; margin-right: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                                            Cancel
                                        </a>
                                        {{-- Submit Button (Primary) --}}
                                        <button type="submit" class="btn btn-primary"
                                            style="background-color: #007bff; border-color: #007bff; border-radius: 8px; font-weight: 600; padding: 12px 30px; transition: all 0.2s; box-shadow: 0 2px 5px rgba(0,123,255,0.2);">
                                            <i class="fas fa-check-circle mr-1"></i> Save AR
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
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
<<<<<<< HEAD

    {{-- CAMERA MODAL --}}
    <div id="cameraModal"
        style="display:none; position:fixed; inset:0; background:rgba(26, 32, 44, 0.9); z-index:9999; backdrop-filter: blur(4px);">
        <div
            style="background:#fff; max-width:500px; margin:5vh auto; padding:0; border-radius:20px; overflow:hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);">
            <div class="p-3 d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #eee;">
                <h5 class="m-0" style="font-weight: 700;">Camera View</h5>
                <button type="button" class="btn-close" id="closeCameraBtn"
                    style="border:none; background:none; font-size:1.5rem;">&times;</button>
            </div>
            <div class="p-3">
                <video id="cameraVideo" autoplay playsinline
                    style="width:100%; border-radius:12px; background:#000;"></video>
                <canvas id="cameraCanvas" style="display:none;"></canvas>
            </div>
            <div class="p-4 bg-light d-flex justify-content-center">
                <button type="button" class="btn btn-primary btn-lg" id="takePhotoBtn"
                    style="border-radius:50px; padding:12px 35px; background:#1D4FA1; font-weight:700;">
                    📸 Capture
                </button>
            </div>
        </div>
    </div>

    <style>
        .custom-select-line:focus,
        .custom-input-line:focus {
            border-bottom-color: #1D4FA1 !important;
            transition: border-color 0.3s;
        }

        #dropZone:hover {
            border-color: #1D4FA1 !important;
            background-color: #f0f7ff !important;
        }
    </style>

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

        // UI Helper
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

        // 1. Choose file manually
        chooseFileBtn.addEventListener('click', () => photoInput.click());

        photoInput.addEventListener('change', () => {
            if (photoInput.files && photoInput.files[0]) {
                const reader = new FileReader();
                reader.onload = e => showPreview(e.target.result);
                reader.readAsDataURL(photoInput.files[0]);
            }
        });

        // 2. Open camera
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
                alert('Cannot access camera. Please allow permission.');
            }
        });

        // 3. Take photo
        takePhotoBtn.addEventListener('click', () => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);

            canvas.toBlob(blob => {
                const file = new File([blob], "capture_" + Date.now() + ".jpg", {
                    type: "image/jpeg"
                });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                photoInput.files = dataTransfer.files;

                showPreview(URL.createObjectURL(blob));
                stopCamera();
            }, 'image/jpeg', 0.8);
        });

        // Close/Remove Logic
        function stopCamera() {
            if (stream) stream.getTracks().forEach(track => track.stop());
            cameraModal.style.display = 'none';
        }

        closeCameraBtn.addEventListener('click', stopCamera);
        removePhotoBtn.addEventListener('click', resetUpload);

        // Close modal on outside click
        window.onclick = (e) => {
            if (e.target == cameraModal) stopCamera();
        };
    </script>
=======
>>>>>>> cb4513ab89b796158e5690293771f2ef3a7e4f17
@endsection
