<form method="POST" action="{{ route('cars.updateShare', $carId) }}">
    @csrf
    <input type="hidden" name="share" value="0">
    <input type="checkbox" name="share" id="share" value="1" {{ $share ? 'checked' : '' }}
        onchange="this.form.submit()">
</form>
