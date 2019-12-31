@extends('layouts.app')

@section('content')

    <!-- Import all modals -->
    @include('modals.create-address')
    @include('modals.retrieve-address')
    @include('modals.create-parcel')
    @include('modals.retrieve-parcel')
    @include('modals.create-shipment')
    @include('modals.retrieve-shipment')
    @include('modals.create-tracker')
    @include('modals.retrieve-tracker')
    @include('modals.retrieve-insurance')
    @include('modals.create-refund')

    <div class="response-wrapper">

        <div class="response">
          
            <!-- LARAVEL ERRORS -->
            <div class="container-fluid" style="padding:0px;">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session()->has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif

                @if(session()->has('error'))
                    <p class="alert alert-danger {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('error') }}</p>
                @endif
            </div>

            <pre>
            <h2>API Response</h2>
            <p class="clear-results-link"><a href="/">Clear Results</a></p>
                <?php
                $label = session()->get('label');
                $response = session()->get('response');
                $rates = session()->get('rates');
                if (isset($label)) {
                    echo "<div><a class='btn btn-primary btn-label' href='$label' download='$response->id' target='_blank'>DOWNLOAD LABEL&nbsp;<i class='fas fa-download'></i></a></div>";
                }
                if (!isset($response)) {
                    echo "<p>Run an action to return a response.</p>";
                }
                if (isset($rates)) {
                    $json = json_decode($response);
                    $my_rates = $json->rates;

                    usort(
                        $my_rates,
                        function ($a, $b) {
                            return $a->rate < $b->rate ? -1 : 1;
                        }
                    );

                    echo "<p>Shipment:<br />".$json->id."</p><br />";
                    echo "<div class='row'>";
                    echo "<div class='col-md-4'>";
                    echo "<p><b>From Address:</b><br />".$json->from_address->id."<br /><br />".$json->from_address->street1."<br />".$json->from_address->street2."<br />".$json->from_address->city."<br />".$json->from_address->state."<br />".$json->from_address->zip."<br />".$json->from_address->country."<br />".$json->from_address->phone."<br />".$json->from_address->email."</p>";
                    echo "</div>";
                    echo "<div class='col-md-4'>";
                    echo "<p><b>To Address:</b><br />".$json->to_address->id."<br /><br />".$json->to_address->street1."<br />".$json->to_address->street2."<br />".$json->to_address->city."<br />".$json->to_address->state."<br />".$json->to_address->zip."<br />".$json->to_address->country."<br />".$json->to_address->phone."<br />".$json->to_address->email."</p>";
                    echo "</div>";
                    echo "<div class='col-md-4'>";
                    echo "<p><b>Parcel:</b><br />".$json->parcel->id."<br /><br />Length: ".$json->parcel->length." inches<br />Width: ".$json->parcel->width." inches<br />Height: ".$json->parcel->height." inches<br />Weight: ".$json->parcel->weight." ounces</p>";
                    echo "</div></div>";

                    echo "<div class='table-responsive'><table class='table'><th>Carrier</th><th>Service</th><th>Rate</th><th>Currenty</th><th>Estimated Delivery Days</th><th>Purchase Label</th>";

                    foreach ($my_rates as $rate) {
                        $my_rate = $rate->rate;
                        $service = $rate->service;
                        $carrier = $rate->carrier;
                        $delivery = $rate->est_delivery_days;
                        $currency = $rate->currency;

                        echo "<tr>";
                        echo "<td>" . $carrier . "</td>";
                        echo "<td>" . $service . "</td>";
                        echo "<td>" . $my_rate . "</td>";
                        echo "<td>" . $currency . "</td>";
                        echo "<td>" . $delivery . "</td>";
                        echo "<form action='/buy-label' method='POST'>";
                        echo "<input type='hidden' name='_token' value='".csrf_token()."'>";
                        echo "<input type='hidden' name='shipment_id' value='$json->id'>";
                        echo "<input type='hidden' name='rate_id' value='$rate->id'>";
                        echo "<td><button class='btn btn-primary btn-small btn-table'>Purchase Shipping Label&nbsp;<i class='fas fa-mail-bulk'></i></button></td>";
                        echo "</tr></form>";
                    }
                    echo "</table></div>";
                    $response = null; # make null to not show twice
                }
                if (isset($response->shipments)) {
                    $json = json_decode($response);

                    foreach ($json->shipments as $shipment) {
                        echo "<form action='/retrieve-shipment' method='POST'>";
                        echo "<input type='hidden' name='_token' value='".csrf_token()."'>";
                        echo "<input type='hidden' name='id' value='".$shipment->id."'>";
                        echo "<div>Shipment:</div>";
                        echo "<button class='btn btn-primary btn-sm btn-shipment'>".$shipment->id."</button>";
                        echo "</form>";
                        echo "<div class='row'>";
                        echo "<div class='col-md-4'>";
                        echo "<p><b>From Address:</b><br />".$shipment->from_address->id."<br /><br />".$shipment->from_address->street1."<br />".$shipment->from_address->street2."<br />".$shipment->from_address->city."<br />".$shipment->from_address->state."<br />".$shipment->from_address->zip."<br />".$shipment->from_address->country."<br />".$shipment->from_address->phone."<br />".$shipment->from_address->email."</p>";
                        echo "</div>";
                        echo "<div class='col-md-4'>";
                        echo "<p><b>To Address:</b><br />".$shipment->to_address->id."<br /><br />".$shipment->to_address->street1."<br />".$shipment->to_address->street2."<br />".$shipment->to_address->city."<br />".$shipment->to_address->state."<br />".$shipment->to_address->zip."<br />".$shipment->to_address->country."<br />".$shipment->to_address->phone."<br />".$shipment->to_address->email."</p>";
                        echo "</div>";
                        echo "<div class='col-md-4'>";
                        echo "<p><b>Parcel:</b><br />".$shipment->parcel->id."<br /><br />Length: ".$shipment->parcel->length." inches<br />Width: ".$shipment->parcel->width." inches<br />Height: ".$shipment->parcel->height." inches<br />Weight: ".$shipment->parcel->weight." ounces</p>";
                        echo "</div></div>";
                        echo "<hr>";
                    }
                    $response = null; # make null to not show twice
                }
                if (isset($response->addresses)) {
                    $json = json_decode($response);

                    echo "<div class='table-responsive'><table class='table'><th>ID</th><th>Created At</th><th>Street1</th><th>Street2</th><th>City</th><th>State</th><th>Zip</th><th>Country</th>";
                    foreach ($json->addresses as $address) {
                        echo "<tr>";
                        echo "<form action='/retrieve-address' method='POST'>";
                        echo "<input type='hidden' name='_token' value='".csrf_token()."'>";
                        echo "<input type='hidden' name='id' value='".$address->id."'>";
                        echo "<td><button class='btn btn-primary btn-sm btn-table'>".substr($address->id, 0, 8)."...</button></td>";
                        echo "</form>";
                        echo "<td>".$address->created_at."</td>";
                        echo "<td>".$address->street1."</td>";
                        echo "<td>".$address->street2."</td>";
                        echo "<td>".$address->city."</td>";
                        echo "<td>".$address->state."</td>";
                        echo "<td>".$address->zip."</td>";
                        echo "<td>".$address->country."</td>";
                        echo "</tr>";
                    }
                    echo "</table></div>";
                    $response = null; # make null to not show twice
                }
                if (isset($response->trackers)) {
                    $json = json_decode($response);

                    echo "<div class='table-responsive'><table class='table'><th>ID</th><th>Created At</th><th>Tracking Code</th><th>Status</th><th>Details</th><th>Carrier</th>";
                    foreach ($json->trackers as $tracker) {
                        echo "<tr>";
                        echo "<form action='/retrieve-tracker' method='POST'>";
                        echo "<input type='hidden' name='_token' value='".csrf_token()."'>";
                        echo "<input type='hidden' name='id' value='".$tracker->id."'>";
                        echo "<td><button class='btn btn-primary btn-sm btn-table'>".substr($tracker->id, 0, 8)."...</button></td>";
                        echo "</form>";
                        echo "<td>".$tracker->created_at."</td>";
                        echo "<td>".$tracker->tracking_code."</td>";
                        echo "<td>".$tracker->status."</td>";
                        echo "<td>".$tracker->status_detail."</td>";
                        echo "<td>".$tracker->carrier."</td>";
                        echo "</tr>";
                    }
                    echo "</table></div>";
                    $response = null; # make null to not show twice
                }
                if (isset($response->insurances)) {
                    $json = json_decode($response);

                    echo "<div class='table-responsive'><table class='table'><th>ID</th><th>Created At</th><th>Amount</th><th>Provider</th><th>Street1</th><th>City</th><th>State</th>";
                    foreach ($json->insurances as $insurance) {
                        echo "<tr>";
                        echo "<form action='/retrieve-insurance' method='POST'>";
                        echo "<input type='hidden' name='_token' value='".csrf_token()."'>";
                        echo "<input type='hidden' name='id' value='".$insurance->id."'>";
                        echo "<td><button class='btn btn-primary btn-sm btn-table'>".substr($insurance->id, 0, 8)."...</button></td>";
                        echo "</form>";
                        echo "<td>".$insurance->created_at."</td>";
                        echo "<td>".$insurance->amount."</td>";
                        echo "<td>".$insurance->provider."</td>";
                        echo "<td>".$insurance->to_address->street1."</td>";
                        echo "<td>".$insurance->to_address->city."</td>";
                        echo "<td>".$insurance->to_address->state."</td>";
                        echo "</tr>";
                    }
                    echo "</table></div>";
                    $response = null; # make null to not show twice
                }
                // test if the response is an array (carriers object only) and return it
                if (is_array($response)) {
                    echo "<div class='table-responsive'><table class='table'><th>Type</th><th>Carrier Code</th>";
                    foreach ($response as $carrier) {
                        echo "<tr>";
                        echo "<td>".$carrier->type."</td>";
                        echo "<td>".$carrier->readable."</td>";
                        echo "</tr>";
                    }
                    echo "</table></div>";
                    $response = null; # make null to not show twice
                } else {
                    // return single items
                    echo "<div>".$response."</div>";
                }
                ?>
            </pre>
        </div>
    </div>

@endsection
