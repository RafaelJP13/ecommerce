@extends('layouts.app')

@section('content')

<div class="container-fluid">

  @include('flash-message')

  <center>
    <div class="row">

      @php $carousel = 0 @endphp

      @foreach($products as $product)

      <div class="col-12 col-md-12">

        <div class="card" style="width: 58rem;">

          <div id="carouselExampleControls-{{$carousel}}" class="carousel slide" data-ride="carousel">

            <div class="carousel-inner">
              @php $i = 0 @endphp

              @foreach($products[$carousel]['images'] as $image)

              @if($i == 0)
              <div class="carousel-item active">

                @else
                <div class="carousel-item ">

                  @endif

                  <img class="d-block w-100" name="image" id="image" style="cursor:pointer"
                    src="/images/products/{{$image->name}}" alt="First slide">

                </div>

                @php $i = $i + 1 @endphp

                @endforeach
              </div>
              <a class="carousel-control-prev" href="#carouselExampleControls-{{$carousel}}" role="button"
                data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>

              <a class="carousel-control-next" href="#carouselExampleControls-{{$carousel}}" role="button"
                data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>

            </div>

            @php $carousel = $carousel + 1 @endphp

            <div class="card-body">

              <h5 class="card-title">{{$product['name']}}</h5>
              <h5 class="card-title">{{$product['price']}}</h5>
              <p class="card-text">{{$product['description']}}</p>
              <a href="{{ route('product.details', $product['id']) }}" class="btn btn-success">Comprar</a>

            </div>

          </div>

        </div>

        @endforeach

      </div>

    </div>

  </center>

</div>

@endsection