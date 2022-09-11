<div>
  <x-content-header title="Providers">
  </x-content-header>

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">

          <div class="d-flex justify-content-between mb-2">
            <button wire:click.prevent="add" class="bt btn-primary">
              <i class="fa fa-plus-circle"></i>
              Add new Provider
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
                    <th scope="col">Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">responsible</th>
                    <th scope="col">phone</th>
                  </tr>
                </thead>
                <tbody>
                  <?php ?>
                  @forelse ($providers as $provider)
                    <tr>
                      <th scope="row">{{ $loop->iteration }}</th>
                      <td>
                        {{ $provider->name }}
                      </td>
                      <td>{{ $provider->address }}</td>
                      <td>{{ $provider->responsible }}</td>
                      <td>
                        {{ $provider->phone }}
                      </td>
                      <td>
                        <a href="" wire:click.prevent="edit({{ $provider }})">
                          <i class="fa fa-edit mr-2"></i>
                        </a>
                        <a href="" wire:click.prevent="ConfirmationDelete({{ $provider->id }})">
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
              {{ $providers->links() }}
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
      <form wire:submit.prevent="{{ $editeProvidersState ? 'saveChanges' : 'create' }}" class="needs-validation">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">
              @if ($editeProvidersState)
                <span>Edit Provider</span>
              @else
                <span>Add new Provider</span>
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
                id="name" aria-describedby="emailHelp" placeholder="Enter Name" wire:model.defer="state.name">
              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" class="form-control
                    @error('address') is-invalid @enderror"
                id="address" aria-describedby="emailHelp" placeholder="Enter Address"
                wire:model.defer="state.address">
              @error('address')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="responsible">Responsible</label>
              <input type="text" class="form-control
                    @error('responsible') is-invalid @enderror"
                id="responsible" aria-describedby="emailHelp" placeholder="Enter Responsible name"
                wire:model.defer="state.responsible">
              @error('responsible')
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
              @if ($editeProvidersState)
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

            <span>Delete Provider</span>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        {{-- Add new user form --}}
        <div class="modal-body">
          <h5>Are you shure that you want to delete this Provider?</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
          <button type="button" class="btn btn-danger" wire:click.prevent="delete"><i class="fa fa-save pr-2"></i>
            Delete Provider
          </button>
        </div>

      </div>

    </div>
  </div>

</div>
