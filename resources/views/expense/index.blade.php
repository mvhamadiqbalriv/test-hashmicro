@extends('layouts.app')

@section('head')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    .select2{
      width: 100px;
      font-size: 15px;
    }
  </style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <div class="d-flex bd-highlight">
            <div class="p-2 flex-grow-1 bd-highlight">
             <h6>Expense table</h6>
            </div>
            <div class="p-2 bd-highlight">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fa fa-plus-circle"></i> Create
              </button>
            </div>
          </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Category</th>
                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Description</th>
                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Item</th>
                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Price</th>
                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Quantity</th>
                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Amount</th>
                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($expense as $item)
                <tr>
                    <td class=" text-center">
                      <span class="text-secondary text-xs font-weight-bold">{{$item->categories ? implode(', ', $item->categories->pluck('name')->toArray()) : '-'}}</span>
                    </td>
                    <td class=" text-center">
                      <span class="text-secondary text-xs font-weight-bold">{{$item->description ?: '-'}}</span>
                    </td>
                    <td class=" text-center">
                      <span class="text-secondary text-xs font-weight-bold">{{$item->item}}</span>
                    </td>
                    <td class=" text-center">
                      <span class="text-secondary text-xs font-weight-bold">{{$item->price}}</span>
                    </td>
                    <td class=" text-center">
                      <span class="text-secondary text-xs font-weight-bold">{{$item->quantity}}</span>
                    </td>
                    <td class=" text-center">
                      <span class="text-secondary text-xs font-weight-bold">{{$item->amount}}</span>
                    </td>
                    <td class="text-center">
                      <a href="javascript:;" onclick="editModal({{$item->id}})" class="text-secondary text-xs font-weight-bold" data-toggle="tooltip" data-original-title="Edit user">
                        <i class="fa fa-edit text-info"></i>
                      </a>
                      <a href="javascript:;" onclick="destroy({{$item->id}})" class="text-secondary text-xs font-weight-bold" data-toggle="tooltip" data-original-title="Edit user">
                        <i class="fa fa-trash text-danger"></i>
                      </a>
                    </td>
                </tr>
                @empty 
                <tr>
                  <td colspan="7" class="text-center text-xs">Expense Empty</td>
                </tr>
                @endforelse
                @if ($expense)
                  <tr>
                    <td class="px-5 text-center text-xs font-bold"><b>Total</b></td>
                    <td colspan="6" class="text-end text-xs px-5"><b>{{$total}}</b></td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Create</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="create">
              <div class="modal-body">
                <div class="form-group">
                  <label for="">Category <sup class="text-danger">*</sup> </label>
                  <select name="category_id[]" multiple="multiple" class="form-select select2" id="category_id_create">
                    @foreach ($categories as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                  </select>
                  <small class="text-danger" id="category_id_create_validation"></small>
                </div>
                <div class="form-group">
                  <label for="">Item Name <sup class="text-danger">*</sup> </label>
                  <input type="text" name="item" id="item_create" class="form-control">
                  <small class="text-danger" id="item_create_validation"></small>
                </div>
                <div class="form-group">
                  <label for="">Price <sup class="text-danger">*</sup> </label>
                  <input type="number" name="price" id="price_create" class="form-control">
                  <small class="text-danger" id="price_create_validation"></small>
                </div>
                <div class="form-group">
                  <label for="">Quantity <sup class="text-danger">*</sup> </label>
                  <input type="number" name="quantity" id="quantity_create" class="form-control">
                  <small class="text-danger" id="quantity_create_validation"></small>
                </div>
                <div class="form-group">
                  <label for="">Amount <sup class="text-danger">*</sup> </label>
                  <input type="number" name="amount" id="amount_create" class="form-control" readonly>
                  <small class="text-danger" id="amount_create_validation"></small>
                </div>
                <div class="form-group">
                  <label for="">Description</label>
                  <textarea name="description" id="description_create" cols="30" rows="5" class="form-control"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editModalLabel">Edit</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit">
              <input type="hidden" id="id_edit">
              <div class="modal-body">
                <div class="form-group">
                  <label for="">Category <sup class="text-danger">*</sup> </label>
                  <select name="category_id[]" multiple="multiple" class="form-select select2" id="category_id_edit">
                    @foreach ($categories as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                  </select>
                  <small class="text-danger" id="category_id_edit_validation"></small>
                </div>
                <div class="form-group">
                  <label for="">Item Name <sup class="text-danger">*</sup> </label>
                  <input type="text" name="item" id="item_edit" class="form-control">
                  <small class="text-danger" id="item_edit_validation"></small>
                </div>
                <div class="form-group">
                  <label for="">Price <sup class="text-danger">*</sup> </label>
                  <input type="number" name="price" id="price_edit" class="form-control">
                  <small class="text-danger" id="price_edit_validation"></small>
                </div>
                <div class="form-group">
                  <label for="">Quantity <sup class="text-danger">*</sup> </label>
                  <input type="number" name="quantity" id="quantity_edit" class="form-control">
                  <small class="text-danger" id="quantity_edit_validation"></small>
                </div>
                <div class="form-group">
                  <label for="">Amount <sup class="text-danger">*</sup> </label>
                  <input type="number" name="amount" id="amount_edit" class="form-control" readonly>
                  <small class="text-danger" id="amount_edit_validation"></small>
                </div>
                <div class="form-group">
                  <label for="">Description</label>
                  <textarea name="description" id="description_edit" cols="30" rows="5" class="form-control"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('body')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  function hideValidation() {
      const validation = document.querySelectorAll(`[id$="_validation"]`)
      for(var i = 0; i < validation.length; i++){
          
          validation[i].style.display = "none";
      }
  }

  let create = document.getElementById('create');

  create.addEventListener('submit', (e) => {
      e.preventDefault();
      
      var categoryOptions = $('#category_id_create').select2('data');
      var categoryValues = [];
      for (var i = 0; i < categoryOptions.length; i++) {
        categoryValues.push(categoryOptions[i].id);
      }

      let item = create.item.value ?? '';
      let price = create.price.value ?? '';
      let quantity = create.quantity.value ?? '';
      let amount = create.amount.value ?? '';
      let description = create.description.value ?? '';

      let formData = new FormData();
      formData.append('category_id', categoryValues);
      formData.append('item', item);
      formData.append('price', price);
      formData.append('quantity', quantity);
      formData.append('amount', amount);
      formData.append('description', description);

      fetch("{{route('expenses.store')}}", {
          method: "POST",
          body: formData,
          headers: {
              "X-CSRF-TOKEN": "{{csrf_token()}}"
          }
      })
      .then(response => response.json())
      .then(resp => {
          if (resp.status == true) {
            Swal.fire(
              'Good job!',
              'Expense Created!',
              'success'
            )
            setInterval(() => {
              location.reload(true)
            }, 1000);
          }else{
              if (resp.data) {
                  var error = Object.entries(resp.data);
                  hideValidation()
                  error.forEach((key,value) => {
                      document.getElementById(key[0]+'_create_validation').style.display = 'block';
                      document.getElementById(key[0]+'_create_validation').textContent = key[1];
                  });
              }
          }
      })

  })
  
  function editModal(id){
    var myModal = new bootstrap.Modal(document.getElementById("editModal"), {});
    
    fetch("{{url('expenses')}}/"+id)
    .then(response => response.json())
    .then(function (resp) {
      if (resp.status == true) {

          document.getElementById('id_edit').value = id;
          document.getElementById('description_edit').value = resp.data.description;
          document.getElementById('item_edit').value = resp.data.item;
          document.getElementById('price_edit').value = resp.data.price;
          document.getElementById('quantity_edit').value = resp.data.quantity;
          document.getElementById('amount_edit').value = resp.data.amount;

          $('#category_id_edit').val(resp.data.categoriesSelected).trigger('change');

          myModal.show();
      } 
    })
  }

  let edit = document.getElementById('edit');

  edit.addEventListener('submit', (e) => {
      e.preventDefault();

      var categoryOptions = $('#category_id_edit').select2('data');
      var categoryValues = [];
      for (var i = 0; i < categoryOptions.length; i++) {
        categoryValues.push(categoryOptions[i].id);
      }
      
      let id = edit.id_edit.value ?? '';
      let description = edit.description.value ?? '';
      let item = edit.item.value ?? '';
      let price = edit.price.value ?? '';
      let quantity = edit.quantity.value ?? '';
      let amount = edit.amount.value ?? '';

      let formData = new FormData();
      formData.append('id', id);
      formData.append('category_id', categoryValues);
      formData.append('description', description);
      formData.append('item', item);
      formData.append('price', price);
      formData.append('quantity', quantity);
      formData.append('amount', amount);

      fetch("{{route('expenses.update')}}", {
          method: "POST",
          body: formData,
          headers: {
              "X-CSRF-TOKEN": "{{csrf_token()}}"
          }
      })
      .then(response => response.json())
      .then(resp => {
          if (resp.status == true) {
            Swal.fire(
              'Good job!',
              'Expense Edited!',
              'success'
            )
            setInterval(() => {
              location.reload(true)
            }, 1000);
          }else{
              if (resp.data) {
                  var error = Object.entries(resp.data);
                  hideValidation()
                  error.forEach((key,value) => {
                      document.getElementById(key[0]+'_edit_validation').style.display = 'block';
                      document.getElementById(key[0]+'_edit_validation').textContent = key[1];
                  });
              }
          }
      })

  })

  function destroy(id){
    Swal.fire({
        icon: 'info',
        title: 'Are you sure to delete this Expense?',
        showCancelButton: true,
        confirmButtonColor: '#fc4b6c',
        confirmButtonText: 'Delete',
    }).then((result) => {
        if (result.isConfirmed) {
          fetch("{{url('expenses')}}/"+id+"/delete")
          .then(response => response.json())
          .then(function (resp) {
            if (resp.status == true) {
              Swal.fire(
                'Good job!',
                'Expense Deleted!',
                'success'
              )
              setInterval(() => {
                location.reload(true)
              }, 1000);
            } 
          })
        }
    })
  }

  const quantityInputCreate = document.getElementById('quantity_create');
  const priceInputCreate = document.getElementById('price_create');
  const amountInputCreate = document.getElementById('amount_create');

  function calculateAmountCreate() {
    const quantity = quantityInputCreate.value;
    const price = priceInputCreate.value;
    const amount = quantity * price;
    amountInputCreate.value = amount.toFixed(2);
  }

  quantityInputCreate.addEventListener('keyup', calculateAmountCreate);
  priceInputCreate.addEventListener('keyup', calculateAmountCreate);

  const quantityInputEdit = document.getElementById('quantity_edit');
  const priceInputEdit = document.getElementById('price_edit');
  const amountInputEdit = document.getElementById('amount_edit');

  function calculateAmountEdit() {
    const quantity = quantityInputEdit.value;
    const price = priceInputEdit.value;
    const amount = quantity * price;
    amountInputEdit.value = amount.toFixed(2);
  }

  quantityInputEdit.addEventListener('keyup', calculateAmountEdit);
  priceInputEdit.addEventListener('keyup', calculateAmountEdit);

  $(document).ready(function() {
      $('.select2').select2({
        width: '100%'
      });
  });

</script>
@endsection