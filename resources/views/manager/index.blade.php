@extends('layouts.main')
@section('contents')
    <div class="container">
        <h1>Dashboard Manager</h1>
        <div class="row">
            <div class="col-md-6">
                <canvas id="statusChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="typeChart"></canvas>
            </div>
        </div>
        <hr>
        <div class="mt-4">
            <div class="col-md-12">
                <canvas id="dailyRequestsChart"></canvas>
            </div>
        </div>
        <hr>
        <div class=" mt-4">
            <div class="col-md-12">
                <canvas id="weeklyRequestsChart"></canvas>
            </div>
        </div>
        <hr>
        <div class=" mt-4">
            <div class="col-md-12">
                <canvas id="monthlyRequestsChart"></canvas>
            </div>
        </div>
    </div>

@endsection

{{-- OK  --}}