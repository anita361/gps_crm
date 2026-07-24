@extends('layouts.app')

@section('title', 'Lead Followup Today')

@section('content')

    <div class="container-fluid mt-3">

        <div class="card">

            <div class="card-header bg-primary text-center text-white">

                <h4 class="mb-0">

                    <i class="fa fa-desktop"></i>

                    Lead Followup Today

                </h4>

            </div>

        </div>

        <div class="row mt-3">

            <div class="col-lg-8">

                <div class="card">

                    <div class="card-header bg-primary text-center text-white">

                        <h3 class="mb-0">

                            Today Followup List

                        </h3>

                    </div>

                    <div class="card-body p-2">

                        @include('partials.table')

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="card">

                    <div class="card-header bg-primary text-center text-white">

                        <h3 class="mb-0">

                            Total Followups

                        </h3>

                    </div>

                    <div class="card-body">

                        <div class="alert alert-warning">

                            Today Followup -

                            {{ $todayFollowups }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
