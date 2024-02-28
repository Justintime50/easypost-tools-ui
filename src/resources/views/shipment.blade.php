@extends('layouts.app')
@section('content')
    <div class="response-wrapper">
        <div class="response">
            <a href="/shipments" class="btn btn-primary">Back to Shipments</a>
            @if (isset($shipment->messages))
                <div class="card rate-errors-card">
                    <div class="card-header">
                        Shipment Messages
                    </div>
                    <div class="card-body rate-errors-bg">
                        <button class="btn btn-primary mb-2" data-bs-toggle="collapse" data-bs-target="#messages"
                            aria-expanded="false" aria-controls="messages">Toggle Shipment Messages</button>
                        <div class="collapse" id="messages">
                            <code>
                                <pre>
@foreach ($shipment->messages as $item)
{{ $item }}
@endforeach
                                </pre>
                            </code>
                        </div>
                    </div>
                </div>
            @endif

            <h3>Shipment Details</h3>
            <p>Shipment:<br />{{ $shipment->id }}</p>

            <div class="row">
                <div class="col-md-4">
                    <p>
                        <b>From Address:</b><br />
                        {{ $shipment->from_address->id }}<br /><br />
                        {{ $shipment->from_address->street1 }}<br />
                        {{ $shipment->from_address->street2 }}<br />
                        {{ $shipment->from_address->city }}<br />
                        {{ $shipment->from_address->state }}<br />
                        {{ $shipment->from_address->zip }}<br />
                        {{ $shipment->from_address->country }}<br />
                        {{ $shipment->from_address->phone }}<br />
                        {{ $shipment->from_address->email }}
                    </p>
                </div>
                <div class="col-md-4">
                    <p><b>To Address:</b><br />
                        {{ $shipment->to_address->id }}<br /><br />
                        {{ $shipment->to_address->street1 }}<br />
                        {{ $shipment->to_address->street2 }}<br />
                        {{ $shipment->to_address->city }}<br />
                        {{ $shipment->to_address->state }}<br />
                        {{ $shipment->to_address->zip }}<br />
                        {{ $shipment->to_address->country }}<br />
                        {{ $shipment->to_address->phone }}<br />
                        {{ $shipment->to_address->email }}
                    </p>
                </div>
                <div class="col-md-4">
                    <p><b>Parcel:</b><br />
                        {{ $shipment->parcel->id }}<br /><br />
                        Length: {{ $shipment->parcel->length }} inches<br />
                        Width: {{ $shipment->parcel->width }} inches<br />
                        Height: {{ $shipment->parcel->height }} inches<br />
                        Weight: {{ $shipment->parcel->weight }} ounces<br />
                        Predefined Package: {{ $shipment->parcel->predefined_package }}
                    </p>
                </div>
            </div>

            @if (isset($shipment->postage_label->label_url))
                <div>
                    <a class="btn btn-primary" href="{{ $shipment->postage_label->label_url }}"
                        download="{{ $shipment->id }}" target="_blank">Download Label&nbsp;&nbsp;<i
                            class="fas fa-download"></i>
                    </a>
                </div>

                <form action="/shipments/{{ $shipment->id }}/refund" method="POST">
                    @csrf

                    <button class="btn btn-primary" type="submit"
                        @if ($shipment->status == 'delivered') {{ 'disabled' }} @endif>Refund Shipment</button>
                </form>

                <hr />
                <h4>Forms</h4>
                @if (isset($shipment->forms))
                    <form action="/shipments/{{ $shipment->id }}/qr-codes" method="POST">
                        @csrf

                        <button class="btn btn-primary mb-2" type="submit"
                            @if (isset($shipment->forms)) {{ 'disabled' }} @endif>Generate QR Codes</button>
                    </form>

                    @foreach ($shipment->forms as $form)
                        <a href="{{ $form->form_url }}" class="btn btn-primary" target="_blank">Download
                            {{ $form->form_type }}&nbsp;&nbsp;<i class="fas fa-download"></i></a>
                    @endforeach
                    <hr />
                @endif
            @endif

            <h3>Rates</h3>
            <div class="table-responsive">
                <table class="table">
                    <th>Carrier</th>
                    <th>Service</th>
                    <th>Rate</th>
                    <th>Currenty</th>
                    <th>Estimated Delivery Days</th>
                    @if (!isset($shipment->postage_label->label_url))
                        <th>Purchase Label</th>
                    @endif
                    @foreach ($rates as $rate)
                        @php
                            if (isset($shipment->selected_rate->id) && $shipment->selected_rate->id == $rate->id) {
                                $columnColor = 'bg-success';
                            } else {
                                $columnColor = '';
                            }
                        @endphp
                        <tr class="{{ $columnColor }}">
                            <td>{{ $rate->carrier }}</td>
                            <td>{{ $rate->service }}</td>
                            <td>
                                <?php if ($rate->currency == 'USD') {
                                    echo "$";
                                }
                                ?>{{ $rate->rate }}
                            </td>
                            <td>{{ $rate->currency }}</td>
                            <td>{{ $rate->est_delivery_days }}</td>
                            @if (!isset($shipment->postage_label->label_url))
                                <form action="/shipments/{{ $shipment->id }}/buy" method="POST">
                                    @csrf

                                    <input type="hidden" name="rate_id" value="{{ $rate->id }}">
                                    <td>
                                        <button class="btn btn-primary btn-small btn-table">Purchase Shipping
                                            Label&nbsp;&nbsp;<i class="fas fa-mail-bulk"></i></button>
                                    </td>
                                </form>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>

            <h3>Shipment JSON</h3>
            <pre>{{ $shipment }}</pre>
        </div>
    </div>
@endsection
