<div>
  <x-content-header title="Users">
  </x-content-header>

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex justify-content-between mb-2">
          @if (auth()->user()->hasAuthMinRole("CREATOR"))
            <button wire:click.prevent="AddNewUser" class="bt btn-primary">
              <i class="fa fa-plus-circle"></i>
              Add new user
            </button>
          @endif
            <x-searchForm wire:model='searchTerm' />
          </div>
          <div class="card">
            <div class="card-body">
              {{-- user table --}}
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Number</th>
                    <th scope="col">Full name</th>
                    <th scope="col">Email</th>
                    <th scope="col">role</th>
                    @if (auth()->user()->hasAuthMinRole("EDITOR"))
                    <th scope="col">Oprations</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @forelse ($users as $user)
                    <tr>
                      <th scope="row">{{ $loop->iteration }}</th>
                      <td>
                        @if ($user->avatar)
                          <img src="{{ asset('storage/avatars/' . $user->avatar) }}" style="width: 50px;"
                            class="img img-circle mr-1" alt="">
                        @else
                          <img src="{{ asset('deafult.png') }}" style="width: 50px;" class="img img-circle mr-1"
                            alt="">
                        @endif
                        {{ $user->name }}
                      </td>
                      <td>{{ $user->email }}</td>
                      <td>
                        @if (auth()->user()->hasAuthMinRole("ADMIN"))
                        <select class="form-control" wire:change="changeRole({{ $user }}, $event.target.value)">
                          <option {{ $user->role === '' ? 'selected' : '' }}>NOT DEFINE</option>
                          <option value="ADMIN" {{ $user->role === 'ADMIN' ? 'selected' : '' }}>ADMIN</option>
                          <option value="CREATOR" {{ $user->role === 'CREATOR' ? 'selected' : '' }}>CREATOR</option>
                          <option value="EDITOR" {{ $user->role === 'EDITOR' ? 'selected' : '' }}>EDITOR</option>
                          <option value="REPORTER" {{ $user->role === 'REPORTER' ? 'selected' : '' }}>REPORTER</option>
                        </select>
                        @else
                            {{$user->role}}
                        @endif
                      </td>
                      <td>
                        @if (auth()->user()->hasAuthMinRole("EDITOR"))
                        <a href="" wire:click.prevent="editUser({{ $user }})">
                          <i class="fa fa-edit mr-2"></i>
                        </a>
                        <a href="" wire:click.prevent="ConfirmationUserDelete({{ $user->id }})">
                          <i class="fa fa-trash"></i>
                        </a>
                      </td>
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
              {{ $users->links() }}
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  </div>
  <!-- /.content -->

  <!-- Modal -->
  <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
      <form wire:submit.prevent="{{ $editeUserState ? 'SaveUsersChanges' : 'createNewUser' }}" class="needs-validation">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">
              @if ($editeUserState)
                <span>Edit User</span>
              @else
                <span>Add new user</span>
              @endif
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                aria-describedby="emailHelp" placeholder="Enter Full Name" wire:model.defer="state.name">
              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="email"></label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                placeholder="Email Address" wire:model.defer="state.email">
              @error('email')
                <div class="invalid-feedback">
                  {{ $message }}!
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                placeholder="Password" wire:model.defer="state.password">
              @error('password')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="password_confirmation">Confirm Password</label>
              <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password"
                name="password_confirmation" wire:model.defer="state.password_confirmation">
            </div>

            <div class="form-group">
              <label for="customFile">Profile Photo</label>
              <div class="custom-file">
                <div x-data="{ isUploading: false, progress: 5 }" x-on:livewire-upload-start="isUploading = true"
                  x-on:livewire-upload-finish="isUploading = false; progress = 5"
                  x-on:livewire-upload-error="isUploading = false"
                  x-on:livewire-upload-progress="progress = $event.detail.progress">
                  <input wire:model="photo" type="file" class="custom-file-input" id="customFile">
                  <div x-show.transition="isUploading" class="progress progress-sm mt-2 rounded">
                    <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40"
                      aria-valuemin="0" aria-valuemax="100" x-bind:style="`width: ${progress}%`">
                      <span class="sr-only">40% Complete (success)</span>
                    </div>
                  </div>
                </div>
                <label class="custom-file-label" for="customFile">
                  @if ($photo)
                    {{ $photo->getClientOriginalName() }}
                  @else
                    Choose Image
                  @endif
                </label>
              </div>

              @if ($photo)
                <img src="{{ $photo->temporaryUrl() }}" class="img d-block mt-2 w-100 rounded">
              @else
                <img src="{{ $state['avatar_url'] ?? '' }}" class="img d-block mb-2 w-100 rounded">
              @endif
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save pr-2"></i>
              @if ($editeUserState)
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

            <span>Delete User</span>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        {{-- Add new user form --}}
        <div class="modal-body">
          <h5>Are you shure that you want to delete this user?</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
          <button type="button" class="btn btn-danger" wire:click.prevent="DeleteUser"><i
              class="fa fa-save pr-2"></i>
            Delete User
          </button>
        </div>

      </div>

    </div>
  </div>

</div>
