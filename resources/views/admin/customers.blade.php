@extends('admin')

@section('main')
    <div class="row grid-margin">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Customers</h4>
                    <div class="d-flex table-responsive">
                        <div class="btn-group mr-2">

                        </div>

                        <div class="btn-group ml-auto mr-2 border-0 d-none d-md-block">
                            {{Form::open(array('url'=>'customers/search', 'method'=>'get'))}}
                            <input type="text" name="query" class="form-control" placeholder="Search Customer">
                            {{Form::close()}}
                        </div>
                        <div class="btn-group">

                        </div>
                    </div>
                    <div class="table-responsive mt-2">
                        <?php $i = $customers->firstItem(); ?>
                        <table class="table mt-3 border-top">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>FullName</th>
                                <th>Email</th>
                                <th>Telephone</th>
                                <th>Gender</th>
                                <th>Date Joined</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customers as $customer)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$customer['name'].' '.$customer['last_name']}}</td>
                                    <td>{{$customer['email']}}</td>
                                    <td>{{$customer['telephone']}}</td>
                                    <td>
                                        @if($customer['gender']=='0')
                                            <span class="badge badge-outline-info"><i class="mdi mdi-gender-female"></i> Female</span>
                                        @elseif($customer['gender']=='1')
                                            <span class="badge badge-info"><i
                                                        class="mdi mdi-gender-male"></i> Male</span>
                                        @endif
                                    </td>
                                    <td>{{date('j F, Y', strtotime($customer['created_at']))}}</td>
                                    <td>
                                        @if($customer['flag']==0)
                                            <span class="badge badge-danger badge-fw">In-Active Account</span>
                                        @else
                                            <span class="badge badge-success badge-fw">Active</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex align-items-center justify-content-between flex-column flex-sm-row mt-4">
                        <p class="mb-3 mb-sm-0">{{$customers->total()}} Records</p>
                        <nav>
                            {{$customers->links()}}

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
