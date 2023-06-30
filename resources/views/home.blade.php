@extends('layout')
@section('title', 'Home')
@section('main_content')
    <main role="main">
        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">Item view</h1>
                <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don't simply skip over it entirely.</p>
                <p>
                    <a href="#" class="btn btn-primary my-2">Main call to action</a>
                    <a href="#" class="btn btn-secondary my-2">Secondary action</a>
                </p>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">

                <div class="row">
                    @foreach($items as $item)
                        @if($item->active == true)
                            <div class="col-md-4">
                                <div class="card mb-4 box-shadow">
                                    @foreach($images->where('item_id', $item->id) as $image)
                                        @if($image->image_type === 'image/png' || $image->image_type === 'image/jpeg')
                                            <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" style="height: 225px; object-fit: cover; width: 100%; display: block;" src="data:{{ $image->image_type }};base64,{{ base64_encode($image->image) }}" alt="{{ $image->image_name }}" data-holder-rendered="true">
                                            @break(true)
                                        @endif
                                    @endforeach
                                    <div class="card-body">
                                        <p class="card-text">{{ $item->item_name }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <form method="get" action="/item/view">
                                                    <input name="item_id" id="item_id" hidden="hidden" value="{{$item->id}}">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">View</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
        </div>
    </main>
@endsection
