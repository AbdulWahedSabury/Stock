<div>
  <x-content-header title="Customers">
  </x-content-header>

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">

          <div class="d-flex justify-content-between mb-2">
            @if (auth()->user()->hasAuthMinRole("CREATOR"))
            <button wire:click.prevent="add" class="bt btn-primary">
              <i class="fa fa-plus-circle"></i>
              Add new Customer
            </button>
            @endif
            <x-searchForm wire:model='search' />
          </div>
          <div class="card">
            <div class="card-body">
              {{-- user table --}}
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Number</th>
                    <th scope="col">Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">phone</th>
                    @if (auth()->user()->hasAuthMinRole("EDITOR"))
                    <th scope="col">Oprations</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  <?php ?>
                  @forelse ($customers as $customer)
                    <tr>
                      <th scope="row">{{ $loop->iteration }}</th>
                      <td>
                        {{ $customer->name }}
                      </td>
                      <td>{{ $customer->last_name }}</td>
                      <td>
                        {{ $customer->phone }}
                      </td>
                    @if (auth()->user()->hasAuthMinRole("EDITOR"))
                      @if (is_null($customer->deleted_at))
                        <td>
                        <a href="" wire:click.prevent="edit({{ $customer }})">
                          <i class="fa fa-edit mr-2"></i>
                        </a>
                        <a href="" wire:click.prevent="ConfirmationDelete({{ $customer->id }})">
                          <i class="fa fa-trash text-red"></i>
                        </a>
                    </td>
                      @else
                        <td>
                        <a href="" wire:click.prevent="restore({{ $customer->id }})">
                        <i class="fa fa-undo text-lime" aria-hidden="true"></i>
                        </a>
                    </td>
                      @endif
                    @endif
                    </tr>
                  @empty
                    <x-no-record>
                    </x-no-record>
                  @endforelse
                </tbody>
              </table>
            </div>
            <div class="card-footer d-flex justify-content-end">
              {{ $customers->links() }}
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
      <form wire:submit.prevent="{{ $editeCustomerState ? 'saveChanges' : 'create' }}" class="needs-validation">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">
              @if ($editeCustomerState)
                <span>Edit Customer</span>
              @else
                <span>Add new Customer</span>
              @endif
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          {{-- Add new user form --}}
          <div class="modal-body">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control
                    @error('name') is-invalid @enderror"
                id="name" aria-describedby="emailHelp" placeholder="Enter  Name" wire:model.defer="state.name">
              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="last_name">Last Name</label>
              <input type="text" class="form-control
                    @error('last_name') is-invalid @enderror"
                id="last_name" aria-describedby="emailHelp" placeholder="Enter Last Name"
                wire:model.defer="state.last_name">
              @error('last_name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="phone">phone</label>
              <input type="text" class="form-control
                    @error('phone') is-invalid @enderror"
                id="phone" aria-describedby="emailHelp" placeholder="Enter phone Number"
                wire:model.defer="state.phone">
              @error('phone')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save pr-2"></i>
              @if ($editeCustomerState)
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

  <!--Delete Modal -->
  <div class="modal fade" id="deleteConfirmatinForm" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">

            <span>Delete Customer</span>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        {{-- Add new user form --}}
        <div class="modal-body">
          <h6>Are you shure that you want to delete this customer?</h6>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
          <button type="button" class="btn btn-danger" wire:click.prevent="delete"><i
              class="fa fa-save pr-2"></i>
            Delete customer
          </button>
        </div>

      </div>

    </div>
  </div>

</div>
