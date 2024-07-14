@extends('layouts.app')
@section('content')
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card shadow mt-5">
                        <form action="" method="post">
                            <div class="card-header">
                                <h3 class="card-title">İşletme Bilgilerinizi Giriniz</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <label class="form-label col-lg-3">İşletme Bilgileriniz</label>
                                    <div class="col-lg-9">
                                        <div>
                                            <label class="form-check form-check-inline">
                                                <input id="savedGoogle" class="form-check-input" type="radio"
                                                    name="isletmeType" value="1" checked>
                                                <span class="form-check-label">İşletmem Google Haritalara Kayıtlı</span>
                                            </label>
                                            <label class="form-check form-check-inline">
                                                <input id="createManual" class="form-check-input" type="radio"
                                                    name="isletmeType" value="2">
                                                <span class="form-check-label">Elle Bilgi Gireceğim</span>
                                            </label>
                                        </div>
                                        <div id="savedGooglePlace">
                                            <input id="autocomplete" class="form-control" type="text"
                                                placeholder="İşletmenizin Adını Giriniz..." />
                                            <small class="form-hint">İşletme adınızı girerek arama yapınız ve QR Menümü
                                                Oluştur butonuna basınız</small>
                                        </div>
                                        <div id="addManually" style="display: none;">
                                            <input class="form-control" type="text" name="title"
                                                placeholder="İşletmenizin Adını Giriniz..." />
                                            <small class="form-hint">İşletme adınızı giriniz ve QR Menümü Oluştur butonuna
                                                basınız</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-end">
                                    <button type="submit" id="continueButton" class="btn btn-outline-success">QR
                                        Menümü Oluştur</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_PLACES_API_KEY') }}&libraries=places&loading=async">
    </script>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const savedGoogle = document.getElementById('savedGoogle');
            const createManual = document.getElementById('createManual');
            const savedGooglePlace = document.getElementById('savedGooglePlace');
            const addManually = document.getElementById('addManually');

            function toggleVisibility() {
                if (savedGoogle.checked) {
                    savedGooglePlace.style.display = 'block';
                    addManually.style.display = 'none';
                } else if (createManual.checked) {
                    savedGooglePlace.style.display = 'none';
                    addManually.style.display = 'block';
                }
            }

            // Initial check
            toggleVisibility();

            // Event listeners for change
            savedGoogle.addEventListener('change', toggleVisibility);
            createManual.addEventListener('change', toggleVisibility);
        });

        google.maps.event.addDomListener(window, 'load', initialize);

        function initialize() {
            var input = document.getElementById('autocomplete');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('places_changed', function() {
                var place = autocomplete.getPlace();
            });
        }
    </script>
@endsection
