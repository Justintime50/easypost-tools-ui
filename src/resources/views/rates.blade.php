@extends("layouts.app")
@section("content")

    <div class="response-wrapper">
        <div class="response">
            <p>Shipment:<br />{{ $json->id }}</p><br />
            <div class="row">
                <div class="col-md-4">
                    <p>
                        <b>From Address:</b><br />
                        {{ $json->from_address->id }}<br /><br />
                        {{ $json->from_address->street1 }}<br />
                        {{ $json->from_address->street2 }}<br />
                        {{ $json->from_address->city }}<br />
                        {{ $json->from_address->state }}<br />
                        {{ $json->from_address->zip }}<br />
                        {{ $json->from_address->country }}<br />
                        {{ $json->from_address->phone }}<br />
                        {{ $json->from_address->email }}
                    </p>
                </div>
                <div class="col-md-4">
                    <p><b>To Address:</b><br />
                        {{ $json->to_address->id }}<br /><br />
                        {{ $json->to_address->street1 }}<br />
                        {{ $json->to_address->street2 }}<br />
                        {{ $json->to_address->city }}<br />
                        {{ $json->to_address->state }}<br />
                        {{ $json->to_address->zip }}<br />
                        {{ $json->to_address->country }}<br />
                        {{ $json->to_address->phone }}<br />
                        {{ $json->to_address->email }}
                    </p>
                </div>
                <div class="col-md-4">
                    <p><b>Parcel:</b><br />
                        {{ $json->parcel->id }}<br /><br />
                        Length: {{ $json->parcel->length }} inches<br />
                        Width: {{ $json->parcel->width }} inches<br />
                        Height: {{ $json->parcel->height }} inches<br />
                        Weight: {{ $json->parcel->weight }} ounces<br />
                        Predefined Package: {{ $json->parcel->predefined_package }} 
                    </p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <th>Carrier</th>
                    <th>Service</th>
                    <th>Rate</th>
                    <th>Currenty</th>
                    <th>Estimated Delivery Days</th>
                    <th>Purchase Label</th>
                    @foreach ($rates as $rate)
                    <tr>
                        <td>{{ $rate->carrier }}</td>
                        <td>{{ $rate->service }}</td>
                        <td><?php if ($rate->currency == "USD") echo "$"; ?>{{ $rate->rate }}</td>
                        <td>{{ $rate->currency }}</td>
                        <td>{{ $rate->est_delivery_days }}</td>
                        <form action="/buy-shipment" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="shipment_id" value="{{ $json->id }}">
                            <input type="hidden" name="rate_id" value="{{ $rate->id }}">
                            <td>
                                <button class="btn btn-primary btn-small btn-table">Purchase Shipping Label&nbsp;<i class="fas fa-mail-bulk"></i></button>
                            </td>
                        </form>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
