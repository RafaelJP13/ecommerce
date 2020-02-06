@extends('layouts.app')

@section('content')

<div class="container">

  @include('flash-message')

  @if($products)

  <div class="row">

    @php $carousel = 0 @endphp

    @foreach($products as $product)

    <div class="col-12 col-md-4">

      <div class="card" style="width: 18rem;">

        <div id="carouselExampleControls-{{$carousel}}" class="carousel slide" data-ride="carousel">

          <div class="carousel-inner">
            @php $i = 0 @endphp

            @foreach($products[$carousel]['images'] as $image)

            @if($i == 0)
            <div class="carousel-item active">

              @else
              <div class="carousel-item ">

                @endif

                <img class="d-block w-100" onclick="upload('{{$image->name}}');" name="image" id="image"
                  style="cursor:pointer" src="/images/products/{{$image->name}}" alt="First slide">

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
            <input type="text" id="productName" onblur="edit({{$product['id']}}, this.value, 1)" class="form-control mb-2"
              value="{{$product['name']}}">
            <input type="text" onblur="edit({{$product['id']}}, this.value, 2)" class="form-control mb-2"
              value="{{$product['price']}}">
            <textarea style="resize:none;" onblur="edit({{$product['id']}}, this.value, 3)" class="form-control mb-2"
              aria-label="With textarea">{{$product['description']}}</textarea>
            <form id="imageForm" method="POST" action="{{route('product.editImage')}}" name="imageForm"
              enctype="multipart/form-data">

              @csrf
              <input type="hidden" id="imageName" name="imageName">
              <input id="imageUpload" type="file" accept="image/x-png,image/gif,image/jpeg" name="imageUpload"
                style="display: none;" />
              <input type="submit" class="btn btn-success" value="Enviar Imagem">

            </form>

            <button onclick="destroy({{$product['id']}})" class="btn btn-danger">Excluir Produto</a>

          </div>
          @if($product['userType'] == 1)

          @if($product['status'] == 0)
          <button type="button" onclick="edit({{$product['id']}}, this.value, 4)" value="1"
            class="btn btn-primary mb-2">Aprovar Produto</button>
          @else
          <button type="button" onclick="edit({{$product['id']}}, this.value, 4)" value="0"
            class="btn btn-primary mb-2">Desaprovar Produto</button>
          @endif

          @else
          @endif
        </div>

      </div>

      @endforeach

    </div>

  </div>

  @else

  <div class="row">
    <div class="col-12 d-flex justify-content-center">
      <h3>Nenhum produto cadastrado!</h3>
    </div>
  </div>

  @endif

</div>

@endsection

<script>
  let edit = (id, value, option) => {

        $.ajax({
            url : "{{route('product.edit')}}",
            type : 'post',
            data : {
                 id,
                 value,
                 option,
                 "_token": "{{ csrf_token() }}"
            },
       })
       .done(msg =>window.location.reload())
       .fail((jqXHR, textStatus, msg) => window.location.reload()); 

    }

    let upload = imageName => { 
     
      $('#imageUpload').trigger('click');
      $('#imageName').val(imageName);

    }

    let destroy = id => {

      $.ajax({
            url : "{{route('product.destroy')}}",
            type : 'post',
            data : {
                 id,
                 "_token": "{{ csrf_token() }}"
            },
       })
       .done(msg => window.location.reload())
       .fail((jqXHR, textStatus, msg) => window.location.reload()); 


    }

</script>