<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Pusat Info Mobil</title>
</head>

<body>
    <div class="container my-5">
        <div class="justify-content-center align-self-center">
            <div class="row">
                <div class="col-12 col-xl-6 mx-xl-auto">
                    <div class="d-flex justify-content-between">
                        <button type="button" onClick="javascript:history.back()"
                            class="btn btn-secondary">Kembali</button>
                        @if ($car->video)
                            <a href="{{ $car->video }}" target="_blank" class="btn btn-primary">Lihat
                                Review Mobil
                            </a>
                        @endif
                    </div>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-6 mx-xl-auto">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($car->carImages as $key => $image)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ Storage::url('cars/' . $image->filename) }}"
                                        class="d-block w-100 img-fluid" alt="Mobil"
                                        style="height: 110%; width: auto; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                    <div class="w-100">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-baseline">
                            <h4 class="order-1 order-md-2 fw-bold mt-3">@rupiah($car->price)</h4>
                            <div class="order-2 order-md-1">
                                <h2 class="m-0">{{ $car->car_name }} ({{ $car->year }})</h2>
                                <p class="fw-bold">{{ $car->brand_name }} - Kota {{ $car->city->city_name }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="m-0 mb-2 fw-bold">Deskripsi</p>
                            <p>{{ $car->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
