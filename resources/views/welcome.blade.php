@extends('layouts.app')
@include('layouts.header')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card shadow px-5">
                <div class="card-body">
                    <h1 class="h2 text-center">Paste the URL to be shortened</h1>
                    <form action="" method="POST" id="urlForm">
                        @csrf
                        <div class="input-group">
                            <input type="url" name="url" class="form-control" placeholder="Enter your URL here">
                            <button type="button" class="btn btn-primary" id="shortenBtn" onclick="shortenUrl()">
                                <div class="spinner-border spinner-border-sm d-none" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                Shorten
                            </button>
                        </div>
                        <div class="text-danger mt-2" id="urlError" style="display: none;">Please enter a valid URL.</div>
                    </form>
                    <div class="mt-4 text-center">
                        <p class="mb-2">ShortURL is a free tool to shorten URLs and generate short links. </p>
                        <p class="mb-2">URL shortener allows to create a shortened link making it easy to share.</p>
                    </div>
                    <div class="mt-4" id="shortUrlContainer" style="display: none;">
                        <h3 class="text-center">Your shortened URL</h3>
                        <div class="input-group">
                            <input type="text" id="shortUrl" class="form-control" readonly>
                            <button class="btn btn-secondary" onclick="copyToClipboard()">Copy</button>
                        </div>
                    </div>
                    <div class="text-success" id="successMessage"></div>
                </div>

                

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        async function shortenUrl() {
            const urlInput = document.querySelector('input[name="url"]');
            const urlError = document.getElementById('urlError');
            const shortUrlContainer = document.getElementById('shortUrlContainer');
            const shortUrlInput = document.getElementById('shortUrl');
            const successMessage = document.getElementById('successMessage');

            urlError.style.display = 'none';
            successMessage.textContent = '';
            shortUrlContainer.style.display = 'none';

            const url = urlInput.value.trim();
            if (!url) {
                urlError.style.display = 'block';
                urlError.textContent = 'Please enter a valid URL.';
                urlInput.focus();
                return;
            }
            const shortenBtn = document.getElementById('shortenBtn');
            shortenBtn.disabled = true;
            shortenBtn.querySelector('.spinner-border').classList.remove('d-none');

            try{
                const response = await fetch("{{ route('shorten') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ url: url })
                });

                const data = await response.json();
                shortenBtn.disabled = false;
                shortenBtn.querySelector('.spinner-border').classList.add('d-none');
                if (data.status === 'success') {
                    shortUrlInput.value = data.short_url;
                    shortUrlContainer.style.display = 'block';
                    successMessage.textContent = data.message || 'URL shortened successfully!';
                } else {
                    urlError.textContent = data.message || 'An error occurred. Please try again.';
                    urlError.style.display = 'block';
                }

            }catch(error){
                console.error('Error:', error);
                urlError.style.display = 'block';
                urlError.textContent = 'An error occurred. Please try again.';
            }finally{
                shortenBtn.disabled = false;
                shortenBtn.querySelector('.spinner-border').classList.add('d-none');
            }
        }

        function copyToClipboard() {
            const shortUrlInput = document.getElementById('shortUrl');
            const successMessage = document.getElementById('successMessage');
            shortUrlInput.select();
            shortUrlInput.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand('copy');
            if(successMessage) {
                successMessage.textContent = 'Short URL copied to clipboard!';
            }
        }

    </script>
@endsection

