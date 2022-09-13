<div>
  <x-content-header title="Inventories">
  </x-content-header>
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">

          <div class="d-flex justify-content-between mb-2">
            <button wire:click.prevent="add" class="bt btn-primary">
              <i class="fa fa-plus-circle"></i>
              Add new
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
                    <th scope="col">product</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Quantity</th>
                  </tr>
                </thead>
                <tbody>
                  <?php ?>
                  @forelse ($inventories as $in)
                    <tr>
                      <th scope="row">{{ $loop->iteration }}</th>
                      <td>
                        {{ $in->product->name }}
                      </td>
                      <td>{{ $in->stock->name }}</td>
                      <td>{{ $in->quantity }}</td>
                      <td>
                        <a href="" wire:click.prevent="edit({{ $in }})">
                          <i class="fa fa-edit mr-2"></i>
                        </a>
                        <a href="" wire:click.prevent="ConfirmationDelete({{ $in->id }})">
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
              {{ $inventories->links() }}
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
      <form wire:submit.prevent="{{ $editeState ? 'saveChanges' : 'create' }}" class="needs-validation" id="add-form">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">
              @if ($editeState)
                <span>Edit</span>
              @else
                <span>Add new</span>
              @endif
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          {{-- Add new user form --}}
          <div class="modal-body">
            <div class="row">
              <div class="form-group col-md-12 col-lg-12">
                <label>Select stock</label>
                <div class="@error('stock_id') is-invalid border border-danger rounded custom-error @enderror">
                  <x-select2 wire:model.defer="state.stock_id" id="stock_id" placeholder="Select Stock">
                    <option>select stock</option>
                    @foreach ($stocks as $stock)
                      <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                    @endforeach
                  </x-select2>
                </div>
                @error('stock_id')
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
            @if ($editeState)
              <div class="row">
                <div class="form-group col-md-12 col-lg-12">
                  <label for="quantity">Quantity</label>
                  <input type="number" class="form-control
                 @error('quantity') is-invalid @enderror"
                    id="quantity" aria-describedby="emailHelp" placeholder="Quantity"
                    wire:model.defer="state.quantity">
                  @error('quantity')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
            @endif
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-save pr-2"></i>
                @if ($editeState)
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
<div class="modal fade" id="deleteConfirmatinForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
  aria-hidden="true" wire:ignore.self>
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
@include('livewire.admin.product-inventory.js');
