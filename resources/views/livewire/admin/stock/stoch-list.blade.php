<div>
  <x-content-header title="Stocks">
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
              Add new
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
                    <th scope="col">Address</th>
                    @if (auth()->user()->hasAuthMinRole("EDITOR"))
                    <th scope="col">Oprations</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  <?php ?>
                  @forelse ($stocks as $stock)
                    <tr>
                      <th scope="row">{{ $loop->iteration }}</th>
                      <td>
                        {{ $stock->name }}
                      </td>
                      <td>{{ $stock->address }}</td>
                     @if (auth()->user()->hasAuthMinRole("EDITOR"))
                      @if (is_null($stock->deleted_at))
                        <td>
                        <a href="" wire:click.prevent="edit({{ $stock }})">
                          <i class="fa fa-edit mr-2"></i>
                        </a>
                        <a href="" wire:click.prevent="ConfirmationDelete({{ $stock->id }})">
                          <i class="fa fa-trash text-red"></i>
                        </a>
                    </td>
                      @else
                        <td>
                        <a href="" wire:click.prevent="restore({{ $stock->id }})">
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
              {{ $stocks->links() }}
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
      <form wire:submit.prevent="{{ $editeState ? 'saveChanges' : 'create' }}" class="needs-validation">
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
                <label for="name">Name</label>
                <input type="text" class="form-control
                @error('name') is-invalid @enderror"
                  id="name" aria-describedby="emailHelp" placeholder="Name" wire:model.defer="state.name">
                @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-12 col-lg-12">
                <label for="address">Address</label>
                <input type="text" class="form-control
                 @error('address') is-invalid @enderror"
                  id="address" aria-describedby="emailHelp" placeholder="Address"
                  wire:model.defer="state.address">
                @error('address')
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
        <h6>Are you shure that you want to delete this Stcok?</h6>
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

