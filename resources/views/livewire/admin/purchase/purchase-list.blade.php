<div>
  <x-content-header title="Purchase">
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
                    <th scope="col">Product</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">price</th>
                    <th scope="col">Total price</th>
                    <th scope="col">Provider</th>
                    <th scope="col">Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php ?>
                  @forelse ($lists as $li)
                    <tr>
                      <th scope="row">{{ $loop->iteration }}</th>
                      <td>{{ $li->inventory->product->name }}</td>
                      <td>{{ $li->inventory->stock->name }}</td>
                      <td>{{ $li->quantity }}</td>
                      <td>{{ $li->p_price }}</td>
                      <td>{{ $li->total_price }}</td>
                      <td>{{ $li->provider->name }}</td>
                      <td>{{ $li->created_at }}</td>
                      <td>
                        <a href="" wire:click.prevent="edit({{ $li }})">
                          <i class="fa fa-edit mr-2"></i>
                        </a>
                        <a href="" wire:click.prevent="ConfirmationDelete({{ $li->id }})">
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
              {{ $lists->links() }}
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
                <label>Select Provider</label>
                <div class="@error('provider_id') is-invalid border border-danger rounded custom-error @enderror">
                  <x-select2 wire:model.defer="state.provider_id" id="provider_id" placeholder="Select Stock">
                    @foreach ($providers as $provider)
                      <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                    @endforeach
                  </x-select2>
                </div>
                @error('provider_id')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-12 col-lg-12">
                <label>Select Inventiry</label>
                <div id="myModal"
                  class="@error('inventory_id') is-invalid border border-danger rounded custom-error @enderror">
                  <x-select2 wire:model="state.inventory_id" id="inventory_id" placeholder="Select product">
                    @foreach ($inventories as $inv)
                      <option value="{{ $inv->id }}">
                        {{ $inv->product->name }} |
                        {{ $inv->stock->name }}</option>
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
            <div class="row">
              <div class="form-group col-md-12 col-lg-12">
                <label for="quantity">Quantity</label>
                <input type="number" class="form-control
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
                <label for="p_price">Price</label>
                <input type="number" class="form-control
                 @error('p_price') is-invalid @enderror"
                  id="p_price" aria-describedby="emailHelp" placeholder="Price" wire:model.defer="state.p_price">
                @error('p_price')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>

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

          <span>Delete</span>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {{-- Add new user form --}}
      <div class="modal-body">
        <h6>Are you shure that you want to delete this List?</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
        <button type="button" class="btn btn-danger" wire:click.prevent="delete"><i class="fa fa-save pr-2"></i>
          Delete
        </button>
      </div>

    </div>

  </div>
</div>

</div>
@include('livewire.admin.purchase.js');
