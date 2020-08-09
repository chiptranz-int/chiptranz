@extends('admin')

@section('main')
    <div class="row grid-margin">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Youth Plans</h4>
                    <div class="d-flex table-responsive">
                        <div class="btn-group mr-2">
                            <a href="{{url('plans/youths?item=all')}}">
                                <button class="btn btn-sm btn-primary @if($type=='all')bg-light text-dark @endif">All
                                    Plans
                                </button>
                            </a>

                            <a href="{{url('plans/youths?item=active')}}">
                                <button class="btn btn-sm btn-primary @if($type=='active')bg-light text-dark @endif">
                                    Active
                                    Plans
                                </button>
                            </a>

                            <a href="{{url('plans/youths?item=expired')}}">
                                <button class="btn btn-sm btn-primary @if($type=='expired')bg-light text-dark @endif">
                                    Expired Plans
                                </button>
                            </a>

                        </div>

{{--                        <div class="btn-group ml-auto mr-2 border-0 d-none d-md-block">--}}
{{--                            {{Form::open(array('url'=>'youths/search', 'method'=>'get'))}}--}}
{{--                            <input type="text" name="query" class="form-control" placeholder="Search Customer">--}}
{{--                            {{Form::close()}}--}}
{{--                        </div>--}}
                        <div class="btn-group">

                        </div>
                    </div>
                    <div class="table-responsive mt-2">
                        <?php $i = $page->firstItem(); ?>
                        <table class="table mt-3 border-top">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Plan Name</th>
                                <th>Owner</th>
                                <th>Periodic Amount</th>
                                <th>Start Date</th>
                                <th>Withdrawal Date</th>
                                <th>Next Savings Date</th>
                                <th>Frequency</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($plans as $plan)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$plan['plan_name']}}</td>
                                    <td>{{$plan['name']}}</td>
                                    <td>&#x20A6;{{number_format($plan['amounts'])}}</td>
                                    <td>{{date('j F, Y',strtotime($plan['start_date']))}}</td>
                                    <td>{{date('j F, Y',strtotime($plan['withdrawal_date']))}}</td>
                                    <td>{{date('j F, Y',strtotime($plan['next_savings']))}}</td>
                                    <td>
                                        @if($plan['frequency']==1)
                                            <span class="badge badge-info">Daily</span>
                                        @elseif($plan['frequency']==2)
                                            <span class="badge badge-warning">Weekly</span>
                                        @elseif($plan['frequency']==3)
                                            <span class="badge badge-primary bg-gradient-primary">Monthly</span>
                                        @endif

                                    </td>
                                    <td>
                                        @if(date('Y-m-d',strtotime($plan['withdrawal_date'])) < date('Y-m-d'))
                                            <span class="badge badge-danger">Matured</span> <br/>
                                            <small class="text-muted">Matured {{abs($plan['expires'])}} day(s) ago
                                            </small>
                                        @elseif(date('Y-m-d',strtotime($plan['withdrawal_date'])) > date('Y-m-d'))
                                            <span class="badge badge-success">Active</span><br/>
                                            <small class="text-muted">Will mature in {{$plan['expires']}} day(s)</small>
                                        @elseif(date('Y-m-d',strtotime($plan['withdrawal_date'])) == date('Y-m-d'))
                                            <span class="badge badge-warning">Active</span><br/>
                                            <small class="text-muted">Will mature tomorrow</small>
                                        @endif
                                    </td>
                                    <td><a title="Plan Savings History" href="{{url('plans/youth-savings-history/'.$plan['id'].'/'.$plan['user_id'])}}" class="btn btn-info"><i class="mdi mdi-history"></i></a></td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex align-items-center justify-content-between flex-column flex-sm-row mt-4">
                        <p class="mb-3 mb-sm-0">{{$page->total()}} Records</p>
                        <nav>
                            {{$page->links()}}

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
