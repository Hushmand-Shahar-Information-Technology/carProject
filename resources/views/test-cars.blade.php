<!DOCTYPE html>
<html>

<head>
    <title>Test Bargain Cars</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <h1>Bargain: {{ $bargain->name }}</h1>
        <p>Registration Status: {{ $bargain->registration_status ?? 'pending' }}</p>

        <h2>Cars ({{ $bargain->cars->count() }})</h2>

        @if ($bargain->cars->count() > 0)
            <div class="row">
                @foreach ($bargain->cars as $car)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $car->make }} {{ $car->model }}</h5>
                                <p class="card-text">
                                    <strong>Year:</strong> {{ $car->year }}<br>
                                    <strong>Transmission:</strong> {{ $car->transmission_type }}<br>
                                    <strong>Price:</strong> {{ $car->currency_type }}
                                    {{ number_format($car->regular_price) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                No cars found for this bargain.
            </div>
        @endif
    </div>
</body>

</html>
