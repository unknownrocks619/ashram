@extends('layouts.admin')

@section('page_css')

@endSection()

@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $user_detail->full_name() }}</h4>
                </div>
            </div>
        </div>
    </div>
</section>
@endSection()

@section('page_js')
   
@endSection()