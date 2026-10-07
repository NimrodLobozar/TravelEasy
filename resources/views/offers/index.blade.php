<x-html-layout>
    <div class="container text-center mt-5">
        <h1>Aanbiedingen</h1>
        @if (count($offers) > 0)
            <ul>
                @foreach ($offers as $offer)
                    <li>
                        ------------------------------------<br>
                        {{ $offer->departure_id }} ->
                        {{ $offer->destination_id }} ->
                        {{ $offer->valid_until ?? 'Geen vervaldatum beschikbaar' }} ->
                        {{ $offer->discount_percentage ?? 'Geen korting beschikbaar' }} ->
                        {{ $offer->trip_id ?? 'Geen reis beschikbaar' }} ->
                        {{ $offer->price ?? 'Geen prijs beschikbaar' }} ->
                        {{ $offer->trip->departure_date ?? 'Geen vertrekdatum beschikbaar' }} ->
                        {{ $offer->trip->departure_time ?? 'Geen vertrektijd beschikbaar' }} ->
                        {{ $offer->trip->arrival_date ?? 'Geen aankomstdatum beschikbaar' }} ->
                        {{ $offer->trip->arrival_time ?? 'Geen aankomsttijd beschikbaar' }} ->
                        {{ $offer->trip->flight_number ?? 'Geen vlucht nummer beschikbaar' }} ->
                        {{ $offer->trip->trip_status ?? 'Geen reis status beschikbaar' }} ->
                        {{ $offer->trip->departure_airport ?? 'Geen vertrek luchthaven beschikbaar' }} ->
                        {{ $offer->trip->arrival_airport ?? 'Geen aankomst luchthaven beschikbaar' }} ->
                        {{ $offer->trip->departure_city ?? 'Geen vertrek stad beschikbaar' }} ->
                        {{ $offer->trip->arrival_city ?? 'Geen aankomst stad beschikbaar' }} ->
                        {{ $offer->trip->departure_country_code ?? 'Geen vertrekland code beschikbaar' }} ->
                        {{ $offer->trip->arrival_country_code ?? 'Geen aankomstland code beschikbaar' }} ->
                        {{ $offer->trip->departure_country_name ?? 'Geen vertrekland naam beschikbaar' }} ->
                        {{ $offer->trip->arrival_country_name ?? 'Geen aankomstland naam beschikbaar' }} ->
                        {{ $offer->trip->departure_country ?? 'Geen vertrekland beschikbaar' }} ->
                        {{ $offer->trip->destination_country ?? 'Geen bestemming beschikbaar' }}<br>
                        ------------------------------------<br>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Momenteel geen reisaanbiedingen beschikbaar</p>
        @endif
    </div>
</x-html-layout>
