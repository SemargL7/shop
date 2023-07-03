@extends('layouts.layout')
@section('title', 'Home')
@section('main_content')
    <main role="main">
        <section class="jumbotron">
            <div class="container">
                <h1 class="jumbotron-heading">Item view</h1>
                <p class="lead text-muted">Something short and leading about the collection below—its contents, the
                    creator, etc. Make it short and sweet, but not too short so folks don't simply skip over it
                    entirely.</p>
                <div class="row">
                    <div class="col-md-12">
                        <form action="/" method="get">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control rounded-0 w-100" name="filter"
                                               placeholder="Filter items">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-dark rounded-0 w-100">Filter</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">

                <div class="row">
                    @foreach($items as $item)
                        @if($item->active == true)
                            <div class="col-md-4">
                                <div class="card mb-4 box-shadow">
                                    @foreach($item->images as $image)
                                        @if($image->image_type === 'image/png' || $image->image_type === 'image/jpeg')
                                            <img class="card-img-top"
                                                 data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail"
                                                 style="height: 225px; object-fit: cover; width: 100%; display: block;"
                                                 src="data:{{ $image->image_type }};base64,{{ base64_encode($image->image) }}"
                                                 alt="{{ $image->image_name }}" data-holder-rendered="true">
                                            @break
                                        @endif
                                    @endforeach
                                    <div class="card-body">
                                        <p class="card-text">{{ $item->item_name }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <form method="get" action="/product/{{$item->item_number}}">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                        View
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{ $items->links() }}
            </div>
        </div>
    </main>
@endsection
