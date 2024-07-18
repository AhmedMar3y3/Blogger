@extends('layout.user-layout')
@section('main')
<div class="container">
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <img src="{{ asset('storage/images/' . $post_data->photo) }}" alt="" class="card-img-top">
                    <div class="row my-2">
                        <div class="col-xl-6">
                            <i class="bi bi-calendar"></i>
                            <span class="text-muted">{{ date('d-m-Y h:i', strtotime($post_data->created_at)) }}</span> <br>
                                <span class="text-muted mx-3 text-capitalize my-1"> {{ $post_data->name }}</span>
                            </a>
                        </div>
                    </div>
                    <h2 class="text-primary">{{ $post_data->post_title }}</h2>
                    <p>{{ $post_data->content }}</p>
                    <hr>
                    <h6 class="card-title">Leave a comment</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body pb-0">
                    <h5 class="card-title">More posts from {{ $post_data->name }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
