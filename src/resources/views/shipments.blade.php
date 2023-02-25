@extends('layouts.app')
@section('content')
    @include('modals.create-shipment')
    @include('modals.buy-stamp')
    <div class="response-wrapper">
        <div class="response">
            <h2>Shipments</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createShipment">Create
                Shipment</button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#buyStamp">Buy a
                Stamp</button>
            <hr />
            @foreach ($json->shipments as $shipment)
                <a href="/shipments/{{ $shipment->id }}"><button
                        class="btn btn-primary btn-sm btn-shipment">{{ substr($shipment->id, 0, 10) }}...</button></a>
                <p>Created at: {{ $shipment->created_at }}</p>
                @if (isset($shipment->postage_label->label_url))
                    <div>
                        <a class="btn btn-primary btn-label btn-sm" href="{{ $shipment->postage_label->label_url }}"
                            download="{{ $shipment->id }}" target="_blank">
                            DOWNLOAD LABEL&nbsp;<i class="fas fa-download"></i>
                        </a>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-4">
                        <p>
                            <b>From Address:</b><br />
                            @if (isset($shipment->from_address))
                                {{ $shipment->from_address->id }}<br /><br />
                                {{ $shipment->from_address->company }}<br />
                                {{ $shipment->from_address->name }}<br />
                                {{ $shipment->from_address->street1 }}<br />
                                {{ $shipment->from_address->street2 }}<br />
                                {{ $shipment->from_address->city }}<br />
                                {{ $shipment->from_address->state }}<br />
                                {{ $shipment->from_address->zip }}<br />
                                {{ $shipment->from_address->country }}<br />
                                {{ $shipment->from_address->phone }}<br />
                                {{ $shipment->from_address->email }}
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p>
                            <b>To Address:</b><br />
                            @if (isset($shipment->to_address))
                                {{ $shipment->to_address->id }}<br /><br />
                                {{ $shipment->to_address->company }}<br />
                                {{ $shipment->to_address->name }}<br />
                                {{ $shipment->to_address->street1 }}<br />
                                {{ $shipment->to_address->street2 }}<br />
                                {{ $shipment->to_address->city }}<br />
                                {{ $shipment->to_address->state }}<br />
                                {{ $shipment->to_address->zip }}<br />
                                {{ $shipment->to_address->country }}<br />
                                {{ $shipment->to_address->phone }}<br />
                                {{ $shipment->to_address->email }}
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p>
                            <b>Parcel:</b><br />
                            @if (isset($shipment->parcel))
                                {{ $shipment->parcel->id }}<br /><br />
                                <b>Length:</b> {{ $shipment->parcel->length }} inches<br />
                                <b>Width:</b> {{ $shipment->parcel->width }} inches<br />
                                <b>Height:</b> {{ $shipment->parcel->height }} inches<br />
                                <b>Weight:</b> {{ $shipment->parcel->weight }} ounces<br />
                                <b>Predefined Package:</b> {{ $shipment->parcel->predefined_package }}
                            @endif
                        </p>
                    </div>
                </div>
                <hr />
            @endforeach
        </div>
    </div>
@endsection
