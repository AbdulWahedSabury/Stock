<div>
  <x-content-header title="Sales">
  </x-content-header>
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">

          <div class="d-flex justify-content-between mb-2">
            <button wire:click.prevent="add" class="bt btn-primary">
              <i class="fa fa-plus-circle"></i>
              Add Record
            </button>
            <x-searchForm wire:model='search' />
          </div>
          <div class="card">
            <div class="card-body">
              {{-- user table --}}
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Number</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Product</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total price</th>
                    <th scope="col">Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php ?>
                  @forelse ($sales as $sale)
                    <tr>
                      <th scope="row">{{ $loop->iteration }}</th>
                      <td>{{ $sale->customer->name }}</td>
                      <td>{{ $sale->stock->name }}</td>
                      <td>{{ $sale->product->title }}</td>
                      <td>{{ $sale->quantity }}M</td>
                      <td>{{ $sale->total_price }} AF</td>
                      <td>{{ $sale->created_at }}</td>
                      <td>
                        <a href="" wire:click.prevent="edit({{ $sale }})">
                          <i class="fa fa-edit mr-2"></i>
                        </a>
                        <a href="" wire:click.prevent="ConfirmationDelete({{ $sale->id }})">
                          <i class="fa fa-trash"></i>
                        </a>
                      </td>
                    </tr>
                  @empty
                    <x-no-record>
                    </x-no-record>
                  @endforelse
                </tbody>
              </table>
            </div>
            <div class="card-footer d-flex justify-content-end">
              {{ $sales->links() }}
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

  <!--Edit And Add new Modal -->
  <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
      <form wire:submit.prevent="{{ $editeSaleState ? 'saveChanges' : 'create' }}" class="needs-validation">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">
              @if ($editeSaleState)
                <span>Edit Sale Record</span>
              @else
                <span>Add new Sale Record</span>
              @endif
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          {{-- Add new form --}}
          <div class="modal-body">
            <div class="row">
              <div class="form-group col-md-12 col-lg-12">
                <label>Select Customer</label>
                <div class="@error('customer_id') is-invalid border border-danger rounded custom-error @enderror">
                  <x-select2 wire:model.defer="state.customer_id" id="customer_id" placeholder="Select Stock">
                    <option>select Provider</option>
                    @foreach ($customers as $customer)
                      <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                  </x-select2>
                </div>
                @error('customer_id')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-12 col-lg-12">
                <label>Select product</label>
                <div id="myModal"
                  class="@error('product_id') is-invalid border border-danger rounded custom-error @enderror">
                  <x-select2 wire:model="state.product_id" id="product_id" placeholder="Select product">
                    <option>select product</option>
                    @foreach ($products as $product)
                      <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                  </x-select2>
                </div>
                @error('product_id')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            @if (isset($productValidInventory) and count($productValidInventory) > 0)
              <div class="row">
                <div class="form-group col-md-12 col-lg-12">
                  <label>Select Inventory</label>
                  <div id="myModal"
                    class="@error('inventory_id') is-invalid border border-danger rounded custom-error @enderror">
                    <x-select2 wire:model="state.inventory_id" id="inventory_id" placeholder="Select product">
                      <option>select product</option>
                      @foreach ($productValidInventory as $inv)
                        <option value="{{ $inv->id }}">{{ $inv->product->name }}</option>
                      @endforeach
                    </x-select2>
                  </div>
                  @error('inventory_id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
            @endif
            <div class="row">
              <div class="form-group col-md-12 col-lg-12">
                <label for="quantity">Quantity</label>
                <input type="number"
                  class="form-control
                            @error('quantity') is-invalid @enderror"
                  id="quantity" aria-describedby="emailHelp" placeholder="Quantity" wire:model.defer="state.quantity">
                @error('quantity')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-12 col-lg-12">
                <label for="s_price">Sale Price</label>
                <input type="number"
                  class="form-control
                            @error('s_price') is-invalid @enderror" id="s_price"
                  aria-describedby="emailHelp" placeholder="Price" wire:model.defer="state.s_price">
                @error('s_price')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-save pr-2"></i>
                @if ($editeSaleState)
                  Save Changes
                @else
                  Save
                @endif
              </button>
            </div>
          </div>
      </form>

    </div>
  </div>
</div>
<!--Delete Modal -->
<div class="modal fade" id="deleteConfirmatinForm" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLongTitle" aria-hidden="true" wire:ignore.self>
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">

          <span>Delete product</span>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {{-- Add new user form --}}
      <div class="modal-body">
        <h5>Are you shure that you want to delete this product?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
        <button type="button" class="btn btn-danger" wire:click.prevent="delete"><i class="fa fa-save pr-2"></i>
          Delete product
        </button>
      </div>

    </div>

  </div>
</div>
</div>

@push('js')
  <script>
    $("#product_id").change(function() {
      let a = this.value;
      Livewire.emit('productSelected', a,true)
    });
  </script>
@endpush
@include('livewire.admin.sales.js');
