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
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @if ($cars->isEmpty())
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <h5 class="card-title">Tidak ada mobil tersedia</h5>
                        </div>
                    </div>
                </div>
            @else
                @foreach ($cars as $car)
                    <div class="col" style="cursor: pointer;">
                        <div class="card h-100">
                            @if ($car->carImages->isNotEmpty())
                                <img src="{{ Storage::url('cars/' . $car->carImages->first()->filename) }}"
                                    class="card-img-top" alt="Car Name">
                            @else
                                <img src="https://placehold.co/600x400" class="card-img-top" alt="Car Name">
                            @endif

                            <div class="card-body d-flex flex-column">
                                <p class="fs-4 fw-bold">@rupiah($car->price)</p>

                                <h5 class="card-title">{{ $car->car_name }} ({{ $car->year }})</h5>
                                <p class="card-title">{{ $car->brand_name }}</p>

                                <p class="card-text">{{ $car->description }}</p>

                                <div class="d-flex mt-auto justify-content-between">
                                    <a href="{{ route('share.show', $car->id) }}" class="btn flex-grow-1 me-2"
                                        style="background-color: #3876FF; color: #ffffff;">Lihat</a>
                                    <a href="@toWhatsapp($faq->value)" class="btn btn-secondary flex-grow-1"
                                        target="_blank">Hubungi</a>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
