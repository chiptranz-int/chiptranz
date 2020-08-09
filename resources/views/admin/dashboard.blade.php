@extends('admin')

@section('main')
    <div class="row">
        <div class="col-md-6 col-lg-3 grid-margin stretch-card">
            <div class="card bg-gradient-primary text-white text-center card-shadow-primary">
                <div class="card-body">
                    <h6 class="font-weight-normal">Total Youth Savings</h6>
                    <h2 class="mb-0">&#x20A6;{{number_format($totalYouthSavings)}}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 grid-margin stretch-card">
            <div class="card bg-gradient-danger text-white text-center card-shadow-danger">
                <div class="card-body">
                    <h6 class="font-weight-normal">Total Youth Withdrawals</h6>
                    <h2 class="mb-0">&#x20A6;{{number_format($totalYouthWithdrawal)}}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 grid-margin stretch-card">
            <div class="card bg-gradient-warning text-white text-center card-shadow-warning">
                <div class="card-body">
                    <h6 class="font-weight-normal">Total Steady Savings</h6>
                    <h2 class="mb-0">&#x20A6;{{number_format($totalSteadySavings)}}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 grid-margin stretch-card">
            <div class="card bg-gradient-info text-white text-center card-shadow-info">
                <div class="card-body">
                    <h6 class="font-weight-normal">Total Steady Withdrawals</h6>
                    <h2 class="mb-0">&#x20A6;{{number_format($totalSteadyWithdrawal)}}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row grid-margin">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Savings by Customers</h4>
                    <div class="d-flex table-responsive">
                        <div class="btn-group mr-2">

                        </div>


                        <div class="btn-group">

                        </div>
                    </div>
                    <div class="table-responsive mt-2">
                        <?php $i = 1; ?>
                        <table class="table mt-3 border-top">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Customer Name</th>
                                <th>Amount Deposited</th>
                                <th>Date</th>
                                <th>Reference</th>
                                <th>Deposit Type</th>
                                <th>Deposit For</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($savings as $saving)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$saving['name']}}</td>
                                    <td>&#x20A6;{{number_format($saving['amount_deposited'])}}</td>
                                    <td>{{date('j F, Y', strtotime($saving['updated_at']))}}</td>
                                    <td>{{$saving['ref_no']}}</td>
                                    <td>
                                        @if($saving['deposit_type']=='0')
                                            <span class="badge badge-success">Auto</span>
                                        @elseif($saving['deposit_type']=='1')
                                            <span class="badge badge-info">Manual</span>
                                        @endif
                                    </td>
                                    <td>{{date('j F, Y', strtotime($saving['date_deposited']))}}</td>

                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
